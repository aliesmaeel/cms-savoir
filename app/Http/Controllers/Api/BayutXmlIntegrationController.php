<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

ini_set('memory_limit', '-1');

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\NewProperty;
use App\Models\SubCommunity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;

class BayutXmlIntegrationController extends Controller
{
    /**
     * Parse the local Bayut XML feed and upsert every property into the database.
     */
    public function import(): void
    {
        $path = $this->xmlPath();

        if (! is_file($path)) {
            Log::channel('fetching_properties')->error("Bayut XML feed not found: {$path}");

            return;
        }

        Log::channel('fetching_properties')->alert('Bayut XML import start');

        try {
            $xml = new SimpleXMLElement(file_get_contents($path));
        } catch (\Throwable $th) {
            Log::channel('fetching_properties')->error('Bayut XML parse error: ' . $th->getMessage());

            return;
        }

        $communities = Community::pluck('id', 'name')->toArray();
        $subCommunities = SubCommunity::pluck('id', 'name')->toArray();

        $referenceNumbers = [];

        // Disable per-row Scout (Meilisearch) syncing during import. The search
        // index is rebuilt in bulk afterwards, so a slow/unavailable Meilisearch
        // instance must not abort the database import row by row.
        NewProperty::withoutSyncingToSearch(function () use ($xml, $communities, $subCommunities, &$referenceNumbers) {
            foreach ($xml->Properties->Property as $node) {
                try {
                    $property = $this->normalize($node);

                    if ($property['reference_number'] === null || $property['reference_number'] === '') {
                        continue;
                    }

                    $referenceNumbers[] = $property['reference_number'];

                    $this->create_new_property($property, $communities, $subCommunities);
                } catch (\Throwable $th) {
                    Log::channel('fetching_properties')->alert($th->getMessage());
                }
            }
        });

        $this->cleanup($referenceNumbers);

        Log::channel('fetching_properties')->alert('Bayut XML import done; processed ' . count($referenceNumbers) . ' listings');
    }

    /**
     * Remove previously imported listings that are no longer present in the feed.
     * Scoped to externally imported rows so manually created listings are untouched.
     */
    private function cleanup(array $referenceNumbers): void
    {
        $query = NewProperty::where('goyzer', true);

        if (! empty($referenceNumbers)) {
            $query->whereNotIn('reference_number', $referenceNumbers);
        }

        $query->delete();
    }

    /**
     * Flatten a <Property> XML node into a plain associative array.
     */
    private function normalize(SimpleXMLElement $node): array
    {
        $images = [];
        if (isset($node->Images)) {
            foreach ($node->Images->Image as $image) {
                $url = trim((string) $image);
                if ($url !== '') {
                    $images[] = $url;
                }
            }
        }

        $videos = [];
        if (isset($node->Videos)) {
            foreach ($node->Videos->children() as $video) {
                $url = trim((string) $video);
                if ($url !== '') {
                    $videos[] = $url;
                }
            }
        }

        $floorPlans = [];
        if (isset($node->Floor_Plans)) {
            foreach ($node->Floor_Plans->children() as $plan) {
                $url = trim((string) $plan);
                if ($url !== '') {
                    $floorPlans[] = $url;
                }
            }
        }

        $features = [];
        if (isset($node->Features)) {
            foreach ($node->Features->Feature as $feature) {
                $name = trim((string) $feature);
                if ($name !== '') {
                    $features[] = $name;
                }
            }
        }

        return [
            'reference_number' => trim((string) $node->Property_Ref_No),
            'purpose' => trim((string) $node->Property_purpose),
            'property_type' => trim((string) $node->Property_Type),
            'city' => trim((string) $node->City),
            'locality' => trim((string) $node->Locality),
            'sub_locality' => trim((string) $node->Sub_Locality),
            'tower_name' => trim((string) $node->Tower_Name),
            'title_en' => trim((string) $node->Property_Title),
            'title_ar' => trim((string) $node->Property_Title_AR),
            'description_en' => trim((string) $node->Property_Description),
            'description_ar' => trim((string) $node->Property_Description_AR),
            'size' => trim((string) $node->Property_Size),
            'bedrooms' => trim((string) $node->Bedrooms),
            'bathroom' => trim((string) $node->Bathroom),
            'price' => trim((string) $node->Price),
            'furnished' => trim((string) $node->Furnished),
            'off_plan' => trim((string) $node->Off_Plan),
            'permit_number' => trim((string) $node->Permit_Number),
            'agent_name' => trim((string) $node->Listing_Agent),
            'agent_email' => trim((string) $node->Listing_Agent_Email),
            'agent_phone' => trim((string) $node->Listing_Agent_Phone),
            'agent_photo' => trim((string) $node->Listing_Agent_Photo),
            'images' => $images,
            'videos' => $videos,
            'floor_plans' => $floorPlans,
            'features' => $features,
        ];
    }

    /**
     * Upsert a single listing (and its media) into new_properties.
     */
    public function create_new_property(array $property, array $communities, array $subCommunities): void
    {
        $offeringType = $this->offering_type($property['purpose']);
        $propertyType = $this->property_types($property['property_type']);
        $completionStatus = strtolower($property['off_plan']) === 'yes' ? 'off_plan' : 'completed';

        $communityId = $this->get_community($property['locality'], $communities);
        $subCommunityId = $this->get_sub_community($property['sub_locality'], $communityId, $subCommunities);

        $userId = $this->get_user(
            $this->map_agent_email($property['agent_email']),
            $property['agent_name'],
            $property['agent_photo'],
            $property['agent_phone']
        );

        $propertyName = $property['tower_name'] !== '' ? $property['tower_name'] : $property['sub_locality'];
        $slug = $this->slugify($property['title_en'] . '-' . $property['reference_number']);

        $firstImage = count($property['images']) > 0 ? $property['images'][0] : null;

        $data = [
            'permit_number' => $property['permit_number'] !== '' ? $property['permit_number'] : '_',
            'property_type' => $propertyType,
            'price' => $this->toInt($property['price']),
            'city' => $property['city'] !== '' ? $property['city'] : null,
            'title_en' => $property['title_en'] !== '' ? $property['title_en'] : null,
            'title_ar' => $property['title_ar'] !== '' ? $property['title_ar'] : null,
            'description_en' => $property['description_en'] !== '' ? $property['description_en'] : null,
            'description_ar' => $property['description_ar'] !== '' ? $property['description_ar'] : null,
            'size' => $this->toInt($property['size']),
            'bedroom' => $this->bedrooms($property['bedrooms']),
            'bathroom' => $this->toInt($property['bathroom']),
            'community' => $communityId,
            'sub_community' => $subCommunityId,
            'slug' => $slug,
            'property_name' => $propertyName !== '' ? $propertyName : null,
            'property_status' => 'Live',
            'completion_status' => $completionStatus,
            'currency' => 'AED',
            'country' => 'United Arab Emirates',
            'user_id' => $userId,
            'goyzer' => true,
            'featured' => 0,
            'features' => $property['features'],
            'photo' => $firstImage,
        ];

        $newProperty = NewProperty::firstOrCreate(
            [
                'reference_number' => $property['reference_number'],
                'offering_type' => $offeringType,
            ],
            array_merge($data, [
                'reference_number' => $property['reference_number'],
                'offering_type' => $offeringType,
            ])
        );

        $newProperty->update($data);

        $this->sync_images($newProperty, $property['images']);
        $this->sync_media($newProperty, 'property_videos', $property['videos']);
        $this->sync_media($newProperty, 'property_floor_plans', $property['floor_plans']);
    }

    private function sync_images(NewProperty $newProperty, array $images): void
    {
        DB::table('property_images')->where('newProperty_id', $newProperty->id)->delete();

        foreach ($images as $url) {
            DB::table('property_images')->insert([
                'url' => $url,
                'newProperty_id' => $newProperty->id,
                'is_external_image' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function sync_media(NewProperty $newProperty, string $table, array $urls): void
    {
        DB::table($table)->where('newProperty_id', $newProperty->id)->delete();

        foreach ($urls as $url) {
            DB::table($table)->insert([
                'url' => $url,
                'newProperty_id' => $newProperty->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    private function offering_type(string $purpose): string
    {
        return strtolower($purpose) === 'rent' ? 'RR' : 'RS';
    }

    private function toInt(string $value): int
    {
        return (int) preg_replace('/[^0-9]/', '', $value);
    }

    private function bedrooms(string $value): int
    {
        if (strtolower(trim($value)) === 'studio') {
            return 0;
        }

        return $this->toInt($value);
    }

    public function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'utf-8//IGNORE', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        return empty($text) ? 'n-a' : $text;
    }

    /**
     * The feed routes several different agents through shared inbox accounts.
     * Reassign those to the agent who actually handles them so the public
     * listing shows the correct name/photo/phone.
     */
    private const AGENT_EMAIL_MAP = [
        'admin@savoirproperties.com' => 'eva@savoirproperties.com',
    ];

    private function map_agent_email(string $email): string
    {
        return self::AGENT_EMAIL_MAP[strtolower($email)] ?? $email;
    }

    public function get_user(string $email, string $name, string $photo = '', string $phone = ''): ?int
    {
        if ($email === '') {
            return null;
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name !== '' ? $name : $email,
                'email' => $email,
                'phone' => $phone !== '' ? $phone : null,
                'image' => $photo !== '' ? $photo : null,
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role_id' => '3',
                'is_external_agent' => true,
            ]
        );

        // Keep external agents' photo/phone in sync with the feed; never touch internal agents.
        if ($user->is_external_agent && $photo !== '' && $user->image !== $photo) {
            $user->update(['image' => $photo]);
        }

        return $user->id;
    }

    public function get_community(string $name, array &$communities): ?int
    {
        if ($name === '') {
            return null;
        }

        if (isset($communities[$name])) {
            return (int) $communities[$name];
        }

        $community = Community::firstOrCreate(['name' => $name], ['name' => $name]);
        $communities[$name] = $community->id;

        return $community->id;
    }

    public function get_sub_community(string $name, ?int $communityId, array &$subCommunities): ?int
    {
        if ($name === '') {
            return null;
        }

        if (isset($subCommunities[$name])) {
            return (int) $subCommunities[$name];
        }

        $subCommunity = SubCommunity::firstOrCreate(
            ['name' => $name, 'community_id' => $communityId],
            ['name' => $name, 'community_id' => $communityId]
        );
        $subCommunities[$name] = $subCommunity->id;

        return $subCommunity->id;
    }

    /**
     * Map a readable property type to the internal code (e.g. "Apartment" => "AP").
     */
    public function property_types(string $value): string
    {
        $propertyTypes = [
            'AP' => 'Apartment',
            'BU' => 'Bulk Units',
            'BW' => 'Bungalow',
            'CD' => 'Compound',
            'DX' => 'Duplex',
            'FA' => 'Factory',
            'FM' => 'Farm',
            'FF' => 'Full Floor',
            'HA' => 'Hotel Apartment',
            'HF' => 'Half Floor',
            'LC' => 'Labor Camp',
            'LP' => 'Land/Plot',
            'OF' => 'Office Space',
            'BC' => 'Business Centre',
            'PH' => 'Penthouse',
            'RE' => 'Retail',
            'RT' => 'Restaurant',
            'SA' => 'Staff Accommodation',
            'SH' => 'Shop',
            'SR' => 'Showroom',
            'CW' => 'Co-working Space',
            'ST' => 'Storage',
            'TH' => 'Townhouse',
            'VH' => 'Villa/House',
            'WB' => 'Whole Building',
            'WH' => 'Warehouse',
            'VI' => 'Villa',
        ];

        $key = array_search($value, $propertyTypes, true);

        return is_string($key) ? $key : $value;
    }

    private function xmlPath(): string
    {
        $configured = config('services.bayut.xml_path') ?? env('BAYUT_XML_PATH');

        return $configured ?: public_path('BayutProperties.xml');
    }
}
