<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RepairMetadata extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repair-metadata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repairs fallback deals missing metadata (Price is null/0) by pulling full data from Property Finder.';

    private $apiKey = 'oqwBE.kDdBGOU7HyocVo1CHDrOhYL7qGk17C6t7b';
    private $apiSecret = 'DKkjTaTwwWdrrX7NHVfOwWadryr3HyY7';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Metadata Repair Process for Fallback Deals...');

        $pipedriveToken = env('PIPEDRIVE_TOKEN');
        if (empty($pipedriveToken)) {
            $this->error('PIPEDRIVE_TOKEN is missing from .env');
            return 1;
        }

        // 1. Authenticate with Property Finder
        $authResponse = Http::post('https://atlas.propertyfinder.com/v1/auth/token', [
            'apiKey' => $this->apiKey,
            'apiSecret' => $this->apiSecret
        ]);
        $pfToken = $authResponse->json()['accessToken'] ?? null;
        if (!$pfToken) {
            $this->error('Failed to authenticate with Property Finder.');
            return 1;
        }
        
        $this->info('Authenticated with Property Finder. Searching for deals...');

        $start = 0;
        $limit = 100;
        $processed = 0;
        $repaired = 0;
        $failed = 0;

        do {
            $response = Http::get("https://api.pipedrive.com/v1/deals", [
                'api_token' => $pipedriveToken,
                'start' => $start,
                'limit' => $limit
            ]);

            if (!$response->successful()) {
                $this->error('Failed to fetch deals from Pipedrive: ' . $response->body());
                break;
            }

            $data = $response->json();
            $deals = $data['data'] ?? [];

            if (empty($deals)) {
                break;
            }

            foreach ($deals as $deal) {
                // Only process Pipeline ID 3 (Published)
                if (isset($deal['pipeline_id']) && $deal['pipeline_id'] == 3) {
                    
                    // Listing Price (PF) Field
                    $listingPrice = $deal['95327613fa6b2ddc2473aef1395f9626a5416b16'] ?? null;
                    
                    if (empty($listingPrice) || $listingPrice == 0 || $listingPrice == '0') {
                        $dealId = $deal['id'];
                        $listingIdPF = $deal['228032f7dfd466da76d1067c32e3a19393c43849'] ?? null;

                        if (!$listingIdPF) {
                            $this->warn("Deal ID {$dealId} is missing Price AND Listing ID (PF). Skipping.");
                            continue;
                        }

                        $this->line("Found Fallback Deal ID {$dealId}. Fetching PF Listing ID {$listingIdPF}...");

                        // Fetch from Property Finder
                        $listingResponse = Http::withToken($pfToken)->get("https://atlas.propertyfinder.com/v1/listings", [
                            'filter[ids]' => $listingIdPF
                        ]);
                        
                        if ($listingResponse->successful()) {
                            $apiListingData = $listingResponse->json()['results'][0] ?? null;
                            if ($apiListingData) {
                                // MAPPING LOGIC
                                $pipedriveData = $this->mapListingData($apiListingData, $pfToken);
                                
                                // Safely Update Deal
                                unset($pipedriveData['user_id']); // DO NOT overwrite owner
                                unset($pipedriveData['stage_id']); // DO NOT overwrite stage

                                $updateResponse = Http::put("https://api.pipedrive.com/v1/deals/{$dealId}?api_token={$pipedriveToken}", $pipedriveData);

                                if ($updateResponse->successful()) {
                                    $this->info("SUCCESS: Repaired Deal ID {$dealId} metadata.");
                                    $repaired++;
                                } else {
                                    $this->error("FAILED to repair Deal ID {$dealId}: " . $updateResponse->body());
                                    $failed++;
                                }

                                // Avoid Pipedrive rate limits
                                sleep(1);
                            } else {
                                $this->warn("Listing ID {$listingIdPF} not found in Property Finder anymore.");
                            }
                        } else {
                            $this->error("API Error fetching Listing ID {$listingIdPF} from PF.");
                        }
                    }
                }
                $processed++;
            }

            $pagination = $data['additional_data']['pagination'] ?? [];
            $moreItems = $pagination['more_items_in_collection'] ?? false;
            $start = $pagination['next_start'] ?? ($start + $limit);

        } while ($moreItems);

        $this->info("Repair Process Complete! Scanned {$processed} total deals. Repaired: {$repaired} | Failed: {$failed}");
        return 0;
    }

    private function mapListingData($apiListingData, $token)
    {
        $listingRef = data_get($apiListingData, 'reference');

        // Fetch Location Tree (Hierarchy)
        $locationData = $this->getLocationTree(data_get($apiListingData, 'location.id'), $token);
        $community = null; 
        $subCommunity = null; 
        $subSubCommunity = null;
        if ($locationData && isset($locationData['tree'])) {
            foreach ($locationData['tree'] as $node) {
                if ($node['type'] === 'COMMUNITY') $community = $node['name'];
                if ($node['type'] === 'SUBCOMMUNITY') $subCommunity = $node['name'];
                if ($node['type'] === 'TOWER' || $node['type'] === 'SUB_SUBCOMMUNITY') $subSubCommunity = $node['name'];
            }
        }

        // Products
        $products = data_get($apiListingData, 'products');
        $listingProductRaw = (is_array($products) && !empty($products)) ? array_key_first($products) : null;
        $listingProduct = $listingProductRaw ? ucfirst($listingProductRaw) : null;

        // Amenities
        $amenities = data_get($apiListingData, 'amenities');
        $amenityMap = [
            'central-ac' => 'Central A/C', 'maids-room' => 'Maids Room', 'balcony' => 'Balcony',
            'shared-pool' => 'Shared Pool', 'shared-spa' => 'Shared Spa', 'shared-gym' => 'Shared Gym',
            'concierge-service' => 'Concierge Service', 'covered-parking' => 'Covered Parking',
            'view-of-water' => 'View of Water', 'view-of-landmark' => 'View of Landmark',
            'pets-allowed' => 'Pets Allowed', 'study' => 'Study', 'private-garden' => 'Private Garden',
            'private-pool' => 'Private Pool', 'private-gym' => 'Private Gym', 'private-jacuzzi' => 'Private Jacuzzi',
            'built-in-wardrobes' => 'Built in Wardrobes', 'walk-in-closet' => 'Walk-in Closet',
            'kitchen-appliances' => 'Built in Kitchen Appliances', 'maids-service' => 'Maids Service',
            'childrens-play-area' => 'Children\'s Play Area', 'childrens-pool' => 'Children\'s Pool',
            'bbq-area' => 'BBQ Area'
        ];
        $mappedAmenities = [];
        if (is_array($amenities)) {
            foreach ($amenities as $amenity) {
                if (isset($amenityMap[$amenity])) {
                    $mappedAmenities[] = $amenityMap[$amenity];
                }
            }
        }

        // Images
        $mediaImages = data_get($apiListingData, 'media.images');
        $imagesStr = null;
        if (is_array($mediaImages) && !empty($mediaImages)) {
            $urls = array_filter(array_map(function($img) {
                return data_get($img, 'original.url', '');
            }, $mediaImages));
            if (!empty($urls)) $imagesStr = implode("\n", $urls);
        }

        // Price
        $rawPrice = data_get($apiListingData, 'price.amounts.sale') ?? data_get($apiListingData, 'price.amounts.yearly') ?? data_get($apiListingData, 'price.amounts.monthly') ?? 0;
        $numericPrice = (float) $rawPrice;

        // Formats
        $listingStatus = ucfirst(data_get($apiListingData, 'state.stage'));
        $propertyType = ucfirst(data_get($apiListingData, 'type'));
        
        $rawFurnishing = data_get($apiListingData, 'furnishingType');
        $furnishing = null;
        if ($rawFurnishing === 'furnished') $furnishing = 'Furnished';
        elseif ($rawFurnishing === 'unfurnished') $furnishing = 'Un-Furnished';
        elseif ($rawFurnishing === 'partly_furnished') $furnishing = 'Partly Furnished';

        $isVerified = (data_get($apiListingData, 'verificationStatus') === 'approved') ? 'Verified' : 'Un-Verified';
        
        $rawCategory = data_get($apiListingData, 'category');
        $priceType = data_get($apiListingData, 'price.type');
        $listingCategory = null;
        if ($rawCategory === 'residential') {
            if ($priceType === 'sale') $listingCategory = 'Residential Sale';
            elseif (in_array($priceType, ['yearly', 'monthly'])) $listingCategory = 'Residential Rent';
        } elseif ($rawCategory === 'commercial') {
            if ($priceType === 'sale') $listingCategory = 'Commercial Sale';
            elseif (in_array($priceType, ['yearly', 'monthly'])) $listingCategory = 'Commercial Rent';
        }
        
        $rawProjectStatus = data_get($apiListingData, 'projectStatus');
        $listingCompletion = null;
        if ($rawProjectStatus === 'completed') $listingCompletion = 'Ready';
        elseif ($rawProjectStatus === 'off_plan') $listingCompletion = 'Off-Plan';

        // Deal Title
        $titleCommunity = $community ?: 'N/A';
        $titleSubCommunity = $subCommunity ?: 'N/A';
        $titlePrice = $numericPrice ? 'AED ' . number_format($numericPrice) : 'AED N/A';
        $titleAgent = data_get($apiListingData, 'assignedTo.name') ?: 'N/A';
        $dealTitle = "{$titleCommunity} | {$titleSubCommunity} | {$titlePrice} | {$titleAgent}";

        $pipedriveData = [
            'title' => $dealTitle,
            
            // 7 New Mapped Fields
            '228032f7dfd466da76d1067c32e3a19393c43849' => data_get($apiListingData, 'id'),
            'ab382a3a8713527be729a7dd0221cac825e48b76' => $community,
            '47bda94663941aafd85b98728f34e473cc86a01b' => $subCommunity,
            '7ec3f49c8f8443bed72620b6709df04b751ac504' => $subSubCommunity,
            '60c55699067ba00185deef9ee3454621a2fc797f' => data_get($apiListingData, 'portals.propertyfinder.publishedAt'),
            '0b222fb115cddffda32ea03a4331b1df00ce90f2' => $listingProduct,
            
            // Core
            'c7d4db817f241ce7c70ee06bf930314ef6e20e95' => $listingRef,
            '3faea5620eacdbb42ce6fd4062204214edd08f35' => data_get($apiListingData, 'title.en'),
            '95327613fa6b2ddc2473aef1395f9626a5416b16' => $numericPrice,
            '90d285f55be47b4a173ea65f73406bcbec2366b5' => data_get($apiListingData, 'size'),
            'af1f61eb5b7dcb81884f97e42ea331041e44828e' => data_get($apiListingData, 'bedrooms'),
            '8abbf4a2a68242278a05332544e8a1c795f7b513' => data_get($apiListingData, 'bathrooms'),
            '1da5fc3b6713a605fa147077db49064ae9493df6' => $propertyType,
            '85da40fd76c93821a2cc452d26d94be931409de1' => data_get($apiListingData, 'unitNumber'),
            '115128d46c1e368dd0680524bc13b3f60c988ca6' => $listingCategory,
            'f5c3a84e2c36b5d09a83808a9b189c7d25b2424a' => data_get($apiListingData, 'description.en'),
            '445d6ba6312f20b9a2650a5447234bf4e242a3eb' => $furnishing,
            '0c984a8705f02d79cdf5bd20057c7232e9dd3fb7' => empty($mappedAmenities) ? null : $mappedAmenities,
            'bcd9ca9385431ef1eca4ff8be5bb75b2bf46511f' => $imagesStr,
            
            // Agent & Creation Info
            '99118d3985b1f300acd5fd772bf7f2b22c55def8' => data_get($apiListingData, 'assignedTo.name'),
            '25a5186deb6e4707dca6578f78db8df6515641d1' => data_get($apiListingData, 'assignedTo.id'),
            'caec8722296a1ba1d5cea25a537aa2e7a1d05aca' => data_get($apiListingData, 'createdBy.name'),
            '7f3c87b1c0f51a5c4e1f9ae1c380a8a5f911c3a1' => data_get($apiListingData, 'createdAt'),
            
            // Status & Additional Details
            '2f599a6e19906bba68213acf0bf242354a4628d6' => data_get($apiListingData, 'compliance.listingAdvertisementNumber'),
            '14eeb3dcbd41663cac17c3784ceb9bbdc58b2375' => $listingStatus,
            '279313aae531121cceb1c6b2d6c24bdfa61035be' => $isVerified,
            '3c63748054466d74046d22cf0f16f4137a5fdf91' => data_get($apiListingData, 'ownerName'),
            'c3be535744b2dd08a3e5b6f8fcc4864bd476c274' => $listingCompletion,
            
            // Total Quality Score
            'ef69929315bd1cbf3835cf8894979fee8e978c26' => data_get($apiListingData, 'qualityScore.value'),
            
            // Detailed Quality Scores
            'c8706db4d351eb1f8390e03d36a65834b0f719c4' => data_get($apiListingData, 'qualityScore.details.description.value'),
            '6aa75083721a6774366c6c83411c5de6ce115ffa' => data_get($apiListingData, 'qualityScore.details.image.value'),
            '7bf8ee26fe29b40482b302ba543e20baa5a11fad' => data_get($apiListingData, 'qualityScore.details.imageDiversity.value'),
            'c7c04e253a81617b1a6a502d57a743619c162637' => data_get($apiListingData, 'qualityScore.details.imageDuplicates.value'),
            '433f91578e4fb480c4855eb12ce9a3f5f524e3c3' => data_get($apiListingData, 'qualityScore.details.imagesDimensions.value'),
            'e7c6af0cc3d94fde198a3dee7b3e54b24704db93' => data_get($apiListingData, 'qualityScore.details.location.value'),
            'fb2d9f666cce5dfa4e4c970c07257dae7ca4c9cb' => data_get($apiListingData, 'qualityScore.details.verified.value'),
            '9c769a062605a72c90eff5e3469dd68e1e351b8e' => (int) data_get($apiListingData, 'qualityScore.details.additional.value'),
        ];

        $qsTitle = data_get($apiListingData, 'qualityScore.details.title.value');
        if ($qsTitle !== null) {
            $pipedriveData['399867e65baacd267034a3c5f9d728cb8c66db79'] = $qsTitle;
        }

        return $pipedriveData;
    }

    private function getLocationTree($locationId, $token) {
        if (!$locationId || !$token) return null;
        $response = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/locations?filter[id]=$locationId");
        return $response->json()['data'][0] ?? null;
    }
}
