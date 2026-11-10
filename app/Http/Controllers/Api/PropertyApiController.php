<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Community;
use App\Models\SubCommunity;
use App\Models\Building;
use App\Models\NewProperty;
use App\Models\FinderProperty;
use App\Models\BayutProperty;
use App\Models\EmiratesProperty;
use App\Models\DubizzleProperty;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

ini_set('max_execution_time', -1);

class PropertyApiController extends Controller
{
    public function propertywebsite(Request $request)
    {
        // if ($request->private_amenities == "") {
        //     $private_amenities = "";
        // } else {
        //     $private_amenities = implode(',', $request->private_amenities);
        // }
        $website_images_withfirst = [];
        $website_images = [];
        $images = $request->file('images');
        foreach ($images as $image) {
            $name = $image->getClientOriginalName();
            $path = $image->storeAs('public/properties/images', $name);
            $website_images[] = $path;
            $website_images_withfirst[] = $path;
        }
        if (isset($website_images)) {
            $del_o = array_shift($website_images);
        }
        if (isset($request->geopoints)) {
            $latitude_longitude = explode(',', $request->geopoints);
            $longitude = $latitude_longitude[0];
            $latitude = $latitude_longitude[1];
        } else {
            $longitude = '';
            $latitude = '';
        }
        // if(Auth::user()->isAgent()){
        //     $agent_websiteId = auth()->user->websiteId;
        // }else{
        $agent = User::where('id', $request->user_id)->first();
        $agent_websiteId = $agent->websiteId;
        // }
        $data = [
            "secretKey" => "N2Y0459P#XMv",
            "post_title" => $request->title_en,
            "post_content" => $request->description_en,
            "thumbNailImage" => $website_images,
            "taxonomy" => [
                "property_category" => $request->property_type,
                "property_action_category" => $request->offering_type,
                "property_city" => $request->city,
                "property_area" => $request->community . $request->sub_community,
                "property_county_state" => "United Arab Emirates",
                "property_features" => $request->private_amenities
            ],
            "property_details" => [
                "property_price" => $request->price,
                "property_hoa" => 123,
                "property_label" => "property_label",
                "property_label_before" => "property_label_before",
                "property_lot_size" =>  $request->plot_size,
                "property_rooms" => 123,
                "property_bedrooms" => $request->bedroom,
                "property_bathrooms" => $request->bathroom,
                "energy_index" => 123,
                "owner_notes" => "Notes",
                "energy_class" => "A+",
                "prop_featured" => 1,
                "property_theme_slider" => 1
            ],
            "property_media" => [
                "gallary" => [$website_images_withfirst[0]]
            ],
            "property_custom_fields" => [
                "mls" => $request->reference_number
            ],
            "address_map_location" => [
                "property_address" => $request->community . $request->sub_community,
                "property_country" => "United Arab Emirates",
                "property_latitude" => $latitude,
                "property_longitude" => $longitude,
                "page_custom_zoom" => 16,
                "property_google_view" => 0,
                "google_camera_angle" => 0
            ],
            "property_agent" => [
                "property_agent" => "26506"
            ]
        ];
        $result = Http::withHeaders([
            'authorization' => 'SHJND9KDBG-JDKKMLHZJ2-WRW9LNBLWD',
        ])
            ->post('https://remaxnetworkhome.com/wp-json/api/v2/properties/eEyKhvXT59PKhmB9/set/new', $data);
        return $result['data'];
    }

    public function getProperties()
    {
        try {
            $summary = app(\App\Services\WebsiteFeedSyncService::class)->sync();
        } catch (\Throwable $exception) {
            Log::error('Website feed sync failed: ' . $exception->getMessage());

            return response()->json([
                'message' => $exception->getMessage(),
            ], 400);
        }

        if (!empty($summary['skipped'])) {
            return response()->json([
                'message' => $summary['message'],
            ]);
        }

        return response()->json([
            'message' => 'Properties synced successfully',
            'total' => $summary['total'],
            'created' => $summary['created'],
            'updated' => $summary['updated'],
            'unchanged' => $summary['unchanged'],
            'images_updated' => $summary['images_updated'],
            'sub_communities_created' => $summary['sub_communities_created'],
            'deleted' => $summary['deleted'],
            'failed' => $summary['failed'],
        ]);
    }

    public function getCommunities()
    {
        $api_communities =  Http::retry(6,10000)->acceptJson()
        ->get('https://crm.remaxroyalproperties.com/api/data/get_communities?key=xFJaNdRgUjXn2r5u&region_id=1');
        if($api_communities->successful()){
            $communities_json = $api_communities->json();
            foreach ($communities_json as $community_json) {
                Community::firstOrCreate([
                    'name' => $community_json['name'],
                    'community_id' => $community_json['id'],
                ],[
                    'name' => $community_json['name'],
                    'community_id' => $community_json['id'],
                    'created_at' => $community_json['created_at'],
                    'updated_at' => $community_json['updated_at'],
                ]);
            }

        }else{
            Log::warning('Communities with id ' . $community_json['id'] . ' was not imported, please review');
        }
    }

    public function getSubCommunities()
    {
        $communities = Community::get();
        foreach ($communities as $community) {
            $api_sub_communities =  Http::retry(6,10000)->acceptJson()
                ->get('https://crm.remaxroyalproperties.com/api/data/get_sub_communities?key=xFJaNdRgUjXn2r5u&community_id=' . $community->community_id);
            if($api_sub_communities->successful()){
                $sub_communities_json = $api_sub_communities->json();
                foreach ($sub_communities_json as $sub_community_json) {
                    SubCommunity::firstOrCreate([
                        'name' => $sub_community_json['name'],
                        'community_id' => $community->community_id,
                    ],[
                        'name' => $sub_community_json['name'],
                        'community_id' => $community->community_id,
                        'subcommunity_id' => $sub_community_json['id'],
                        'created_at' => $sub_community_json['created_at'],
                        'updated_at' => $sub_community_json['updated_at'],
                    ]);
                }

            }else{
                Log::warning('SubCommunities belongs to comunity with id ' . $community->community_id . ' was not imported, please review');
            }
        }
    }

    public function getBuildings()
    {
        $subcommunities = SubCommunity::pluck('subcommunity_id');

        foreach ($subcommunities as $subcommunity) {
            $api_buildings =  Http::retry(6, 10000)->acceptJson()
                ->get('https://crm.remaxroyalproperties.com/api/data/get_community_properties?key=xFJaNdRgUjXn2r5u&sub_community_id=' . $subcommunity);

            if ($api_buildings->successful()) {
                $api_buildings = $api_buildings->json();
                foreach ($api_buildings as $building_json) {
                    Building::firstOrCreate([
                        'building_name' => $building_json['name'],
                        'subcommunity_id' => $subcommunity
                    ], [
                        'building_name' => $building_json['name'],
                        'subcommunity_id' => $subcommunity,
                        'lat' => $building_json['latitude'],
                        'lng' => $building_json['longitude'],
                        'created_at' => $building_json['created_at'],
                        'updated_at' => $building_json['updated_at'],
                    ]);
                }

            } else {
                Log::warning('Buildings belongs to subcomunity with id ' . $subcommunity . ' was not imported, please review');
            }
        }
    }

    public function generateUniqueslug()
    {
        do {
            $i = random_int(2, 20);
        } while (NewProperty::where("slug", "=", $i)->first());
        return $i;
    }
}
