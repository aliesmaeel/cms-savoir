<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ListingSyncController extends Controller
{
    private $apiKey = 'oqwBE.kDdBGOU7HyocVo1CHDrOhYL7qGk17C6t7b';
    private $apiSecret = 'DKkjTaTwwWdrrX7NHVfOwWadryr3HyY7';

    // 1. Handle Webhook Events (published, action, unpublished)
    public function handlePFListingWebhook(Request $request)
    {
        Log::info('WEBHOOK HIT RECEIVED:', $request->all());
    
        $payload = $request->all();
        $event = data_get($payload, 'type');
        $listingDataPayload = data_get($payload, 'payload');
        
        $listingId = data_get($listingDataPayload, 'id');
        if (!$listingId) {
            Log::warning("PF Listing Webhook: Missing listing ID.");
            return response()->json(['status' => 'ignored'], 200);
        }

        if (in_array($event, ['listing.published', 'listing.action', 'listing.unpublished'])) {
            try {
                // Get Token
                $authResponse = Http::post('https://atlas.propertyfinder.com/v1/auth/token', [
                    'apiKey' => $this->apiKey,
                    'apiSecret' => $this->apiSecret
                ]);
                $token = $authResponse->json()['accessToken'] ?? null;
                
                if ($token) {
                    // Fetch full data
                    $listingResponse = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/listings", [
                        'filter[ids]' => $listingId,
                        'draft' => 'true'
                    ]);
                    
                    if ($listingResponse->successful()) {
                        $apiListingData = $listingResponse->json()['results'][0] ?? null;
                        if ($apiListingData) {
                            $this->syncToPipedrive($apiListingData, $event, $token);
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error("PF Listing Webhook Exception: " . $e->getMessage());
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    // 2. Manual Bulk Sync
    public function syncAllListings()
    {
        set_time_limit(0);
        ignore_user_abort(true);
        ini_set('memory_limit', '512M');

        $authResponse = Http::post('https://atlas.propertyfinder.com/v1/auth/token', [
            'apiKey' => $this->apiKey,
            'apiSecret' => $this->apiSecret
        ]);
        $token = $authResponse->json()['accessToken'] ?? null;
        if (!$token) return "Auth Failed.";

        $states = ['draft', 'live', 'takendown', 'archived', 'unpublished', 'pending_approval', 'rejected', 'approved', 'failed'];
        $processed = 0;

        foreach ($states as $state) {
            $page = 1;
            Log::info("Bulk Sync: Starting fetch for state [{$state}]");

            $queryParams = [
                'pageSize' => 100,
                'filter[state]' => $state
            ];
            
            if (in_array($state, ['draft', 'unpublished', 'pending_approval'])) {
                $queryParams['draft'] = 'true';
            }

            do {
                $queryParams['page'] = $page;
                $listingResp = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/listings", $queryParams);
                $data = $listingResp->json();
                
                if ($page === 1) {
                    $totalFound = $data['pagination']['totalElements'] ?? 0;
                    Log::info("Bulk Sync: Found {$totalFound} total results for state [{$state}]");
                }

                if (empty($data['results'])) break;
                
                foreach ($data['results'] as $item) {
                    $this->syncToPipedrive($item, 'bulk.sync', $token);
                    $processed++;
                    // Avoid Pipedrive rate limits
                    sleep(1); // 1 second
                }

                $totalPages = $data['pagination']['totalPages'] ?? 1;
                Log::info("Bulk Sync: Finished processing state [{$state}] - page {$page} of {$totalPages}");
                $page++;
            } while ($page <= $totalPages);
        }

        return "Successfully synced {$processed} listings to Pipedrive.";
    }

    // 3. Core Sync Logic
    private function syncToPipedrive($apiListingData, $event, $token)
    {
        $pipedriveToken = env('PIPEDRIVE_TOKEN');
        if (empty($pipedriveToken)) return;

        $listingRef = data_get($apiListingData, 'reference');
        if (!$listingRef) return;

        Log::info("Syncing Ref: {$listingRef}");

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
            
            // SubCommunity Fallback Logic
            if (empty($subCommunity) && !empty($subSubCommunity)) {
                $subCommunity = $subSubCommunity;
            }
        }

        // --- All the mapping logic from WebhookController ---
        $products = data_get($apiListingData, 'products');
        $listingProductRaw = (is_array($products) && !empty($products)) ? array_key_first($products) : null;
        
        $productMap = [
            'premium' => 1313,
            'featured' => 1312,
            'standard' => 1311
        ];
        
        $listingProduct = ($listingProductRaw && isset($productMap[$listingProductRaw])) ? $productMap[$listingProductRaw] : 1311;

        $productCreatedAt = $listingProductRaw ? data_get($apiListingData, "products.{$listingProductRaw}.createdAt") : null;
        $productExpiresAt = $listingProductRaw ? data_get($apiListingData, "products.{$listingProductRaw}.expiresAt") : null;
        $productRenewableRaw = $listingProductRaw ? data_get($apiListingData, "products.{$listingProductRaw}.renewalEnabled") : null;
        $productRenewable = $productRenewableRaw === true ? 'Yes' : ($productRenewableRaw === false ? 'No' : null);

        // Amenities
        $amenities = data_get($apiListingData, 'amenities');
        $amenityMap = [
            'central-ac' => 'Central A/C',
            'maids-room' => 'Maids Room',
            'balcony' => 'Balcony',
            'shared-pool' => 'Shared Pool',
            'shared-spa' => 'Shared Spa',
            'shared-gym' => 'Shared Gym',
            'concierge-service' => 'Concierge Service',
            'covered-parking' => 'Covered Parking',
            'view-of-water' => 'View of Water',
            'view-of-landmark' => 'View of Landmark',
            'pets-allowed' => 'Pets Allowed',
            'study' => 'Study',
            'private-garden' => 'Private Garden',
            'private-pool' => 'Private Pool',
            'private-gym' => 'Private Gym',
            'private-jacuzzi' => 'Private Jacuzzi',
            'built-in-wardrobes' => 'Built in Wardrobes',
            'walk-in-closet' => 'Walk-in Closet',
            'kitchen-appliances' => 'Built in Kitchen Appliances',
            'maids-service' => 'Maids Service',
            'childrens-play-area' => 'Children\'s Play Area',
            'childrens-pool' => 'Children\'s Pool',
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
            if (!empty($urls)) {
                $imagesStr = implode("\n", $urls);
            }
        }

        // Price
        $rawPrice = data_get($apiListingData, 'price.amounts.sale') ?? data_get($apiListingData, 'price.amounts.yearly') ?? data_get($apiListingData, 'price.amounts.monthly') ?? 0;
        $numericPrice = (float) $rawPrice;

        // Formats
        $rawState = data_get($apiListingData, 'state.stage');
        if ($rawState === 'live') {
            $listingStatus = 1282; // Verified Option ID for Live
        } elseif ($rawState === 'draft') {
            $listingStatus = 1283; // Verified Option ID for Draft
        } else {
            $statusMap = [
                'unpublished' => 'Unpublished',
                'archived' => 'Archived',
                'takendown' => 'Expired'
            ];
            $listingStatus = isset($statusMap[$rawState]) ? $statusMap[$rawState] : ($rawState ? ucwords(str_replace('_', ' ', $rawState)) : null);
        }
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

        // Map Category to verified Numeric IDs
        $categoryLabelToId = [
            'Residential Rent' => 1307,
            'Commercial Rent' => 1308,
            'Residential Sale' => 1309,
            'Commercial Sale' => 1310
        ];
        $mappedCategory = isset($categoryLabelToId[$listingCategory]) ? $categoryLabelToId[$listingCategory] : $listingCategory;
        
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

        // Contact Person Logic (OwnerName with Deal Title Fallback)
        $ownerName = data_get($apiListingData, 'ownerName');
        $targetPersonName = !empty($ownerName) ? $ownerName : $dealTitle;
        
        $personId = null;
        
        // Search for existing person
        $personSearch = Http::get("https://api.pipedrive.com/v1/persons/search", [
            'api_token' => $pipedriveToken,
            'term' => $targetPersonName,
            'exact_match' => true
        ]);
        
        if ($personSearch->successful()) {
            $personResults = $personSearch->json('data.items');
            if (!empty($personResults)) {
                $personId = $personResults[0]['item']['id'] ?? null;
            }
        }
        
        if (!$personId) {
            $personResponse = Http::post("https://api.pipedrive.com/v1/persons?api_token={$pipedriveToken}", [
                'name' => $targetPersonName
            ]);
            $personId = $personResponse->successful() ? $personResponse->json('data.id') : null;
        }

        $pipedriveData = [
            'title' => $dealTitle,
            'status' => 'open',
            'person_id' => $personId,
            
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
            // 'c8706db4d351eb1f8390e03d36a65834b0f719c4' => data_get($apiListingData, 'qualityScore.details.description.value'),
            // '6aa75083721a6774366c6c83411c5de6ce115ffa' => data_get($apiListingData, 'qualityScore.details.image.value'),
            // '7bf8ee26fe29b40482b302ba543e20baa5a11fad' => data_get($apiListingData, 'qualityScore.details.imageDiversity.value'),
            // 'c7c04e253a81617b1a6a502d57a743619c162637' => data_get($apiListingData, 'qualityScore.details.imageDuplicates.value'),
            // '433f91578e4fb480c4855eb12ce9a3f5f524e3c3' => data_get($apiListingData, 'qualityScore.details.imagesDimensions.value'),
            // 'e7c6af0cc3d94fde198a3dee7b3e54b24704db93' => data_get($apiListingData, 'qualityScore.details.location.value'),
            // 'fb2d9f666cce5dfa4e4c970c07257dae7ca4c9cb' => data_get($apiListingData, 'qualityScore.details.verified.value'),
            // '9c769a062605a72c90eff5e3469dd68e1e351b8e' => (int) data_get($apiListingData, 'qualityScore.details.additional.value'),
        ];

        // $qsTitle = data_get($apiListingData, 'qualityScore.details.title.value');
        // if ($qsTitle !== null) {
        //     $pipedriveData['399867e65baacd267034a3c5f9d728cb8c66db79'] = $qsTitle;
        // }

        // Deal Stage & Status Logic
        if ($event === 'listing.unpublished' || $rawState === 'unpublished') {
            $pipedriveData['stage_id'] = 91; // Rejected
            $pipedriveData['status'] = 'lost';
        } elseif ($rawState === 'draft') {
            $pipedriveData['stage_id'] = 14; // Draft Stage
            $pipedriveData['status'] = 'open';
        } else {
            $pipedriveData['stage_id'] = 14; // Published Pipeline (ID 3), Stage 14
            $pipedriveData['status'] = 'open';
        }

        $permitNumber = data_get($apiListingData, 'compliance.listingAdvertisementNumber');
        $listingIdStr = data_get($apiListingData, 'id');

        $dealId = null;
        $existingDealData = null;

        // Step 1 (By Permit): IF Permit Number is NOT empty, search strictly in Pipeline 3 where RERA Permit and Category match exactly
        if (!empty($permitNumber)) {
            $cleanPermit = str_replace([',', ' '], '', (string)$permitNumber);
            if (!empty($cleanPermit)) {
                $searchResponse = Http::get("https://api.pipedrive.com/v1/deals/search", [
                    'api_token' => $pipedriveToken,
                    'term' => $cleanPermit,
                    'fields' => 'custom_fields',
                    'exact_match' => true
                ]);

                if ($searchResponse->successful()) {
                    $searchResults = $searchResponse->json('data.items');
                    if (!empty($searchResults)) {
                        foreach ($searchResults as $result) {
                            $possibleDealId = $result['item']['id'] ?? null;
                            if ($possibleDealId) {
                                $dealResponse = Http::get("https://api.pipedrive.com/v1/deals/{$possibleDealId}", [
                                    'api_token' => $pipedriveToken
                                ]);
                                if ($dealResponse->successful()) {
                                    $dealData = $dealResponse->json('data');
                                    $dealPermit = $dealData['2f599a6e19906bba68213acf0bf242354a4628d6'] ?? null;
                                    $dealCategoryID = $dealData['115128d46c1e368dd0680524bc13b3f60c988ca6'] ?? null;
                                    
                                    $categoryMap = [
                                        '1307' => 'Residential Rent',
                                        '1308' => 'Commercial Rent',
                                        '1309' => 'Residential Sale',
                                        '1310' => 'Commercial Sale'
                                    ];
                                    
                                    $dealCategoryLabel = isset($categoryMap[$dealCategoryID]) ? $categoryMap[$dealCategoryID] : $dealCategoryID;

                                    $cleanDealPermit = str_replace([',', ' '], '', (string)$dealPermit);
                                    if ($cleanDealPermit === $cleanPermit && ($dealCategoryLabel === $listingCategory || (string)$dealCategoryID === (string)$mappedCategory)) {
                                        if (($dealData['pipeline_id'] ?? null) == 3) {
                                            $dealId = $possibleDealId;
                                            $existingDealData = $dealData;
                                            break;
                                        } else {
                                            Log::warning("Deal found by Permit+Category in another pipeline (ID: " . ($dealData['pipeline_id'] ?? 'none') . "), treating as Not Found for Published sync.", ['deal_id' => $possibleDealId]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Step 2 (By Listing ID): If Step 1 finds nothing, search in Pipeline 3 where custom field Listing ID (PF) (228032f7dfd466da76d1067c32e3a19393c43849) matches
        if (!$dealId && !empty($listingIdStr)) {
            $idSearchResponse = Http::get("https://api.pipedrive.com/v1/deals/search", [
                'api_token' => $pipedriveToken,
                'term' => trim((string)$listingIdStr),
                'fields' => 'custom_fields',
                'exact_match' => true
            ]);

            if ($idSearchResponse->successful()) {
                $searchResults = $idSearchResponse->json('data.items');
                if (!empty($searchResults)) {
                    foreach ($searchResults as $result) {
                        $possibleDealId = $result['item']['id'] ?? null;
                        if ($possibleDealId) {
                            $dealResponse = Http::get("https://api.pipedrive.com/v1/deals/{$possibleDealId}", [
                                'api_token' => $pipedriveToken
                            ]);
                            if ($dealResponse->successful()) {
                                $dealData = $dealResponse->json('data');
                                $dealInternalId = $dealData['228032f7dfd466da76d1067c32e3a19393c43849'] ?? null;
                                if (trim((string)$dealInternalId) === trim((string)$listingIdStr)) {
                                    if (($dealData['pipeline_id'] ?? null) == 3) {
                                        $dealId = $possibleDealId;
                                        $existingDealData = $dealData;
                                        break;
                                    } else {
                                        Log::warning("Deal found by Listing ID in another pipeline (ID: " . ($dealData['pipeline_id'] ?? 'none') . "), treating as Not Found for Published sync.", ['deal_id' => $possibleDealId]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Step 3 (By Listing Reference): If Step 2 finds nothing, search in Pipeline 3 where Listing Reference (PF) (c7d4db817f241ce7c70ee06bf930314ef6e20e95) matches
        if (!$dealId && !empty($listingRef)) {
            $refSearchResponse = Http::get("https://api.pipedrive.com/v1/deals/search", [
                'api_token' => $pipedriveToken,
                'term' => trim((string)$listingRef),
                'fields' => 'custom_fields',
                'exact_match' => true
            ]);

            if ($refSearchResponse->successful()) {
                $searchResults = $refSearchResponse->json('data.items');
                if (!empty($searchResults)) {
                    foreach ($searchResults as $result) {
                        $possibleDealId = $result['item']['id'] ?? null;
                        if ($possibleDealId) {
                            $dealResponse = Http::get("https://api.pipedrive.com/v1/deals/{$possibleDealId}", [
                                'api_token' => $pipedriveToken
                            ]);
                            if ($dealResponse->successful()) {
                                $dealData = $dealResponse->json('data');
                                $dealRef = $dealData['c7d4db817f241ce7c70ee06bf930314ef6e20e95'] ?? null;
                                if (trim((string)$dealRef) === trim((string)$listingRef)) {
                                    if (($dealData['pipeline_id'] ?? null) == 3) {
                                        $dealId = $possibleDealId;
                                        $existingDealData = $dealData;
                                        break;
                                    } else {
                                        Log::warning("Deal found by Listing Reference in another pipeline (ID: " . ($dealData['pipeline_id'] ?? 'none') . "), treating as Not Found for Published sync.", ['deal_id' => $possibleDealId]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Create or Update
        if ($dealId) {
            $actualChanges = [];
            
            if ($existingDealData) {
                foreach ($pipedriveData as $key => $newValue) {
                    // Shielding person_id, user_id, stage_id, status strictly prevents any redundant logs on updates and preserves manual CRM settings/stage
                    if (in_array($key, ['user_id', 'status', 'person_id', 'stage_id'])) {
                        continue;
                    }

                    $currentValue = $existingDealData[$key] ?? null;

                    // Pre-trim strings to avoid trailing space false positives
                    if (is_string($newValue)) {
                        $newValue = trim($newValue);
                    }
                    if (is_string($currentValue)) {
                        $currentValue = trim($currentValue);
                    }

                    // Special Rule for Owner's Name and Unit: Only update if currently empty
                    if (in_array($key, ['3c63748054466d74046d22cf0f16f4137a5fdf91', '85da40fd76c93821a2cc452d26d94be931409de1'])) {
                        if ($currentValue !== null && $currentValue !== '' && $currentValue !== '-') {
                            continue;
                        }
                    }

                    // Handle Array Comparison (Amenities)
                    if (is_array($newValue)) {
                        $currentArray = is_array($currentValue) ? $currentValue : (is_string($currentValue) ? explode(',', $currentValue) : []);
                        
                        // Trim and remove any empty elements (like from explode on empty string)
                        $newValueTrimmed = array_filter(array_map('trim', $newValue), 'strlen');
                        $currentArrayTrimmed = array_filter(array_map('trim', $currentArray), 'strlen');
                        
                        // Reindex and sort alphabetically
                        $newValueTrimmed = array_values($newValueTrimmed);
                        $currentArrayTrimmed = array_values($currentArrayTrimmed);
                        sort($newValueTrimmed);
                        sort($currentArrayTrimmed);
                        
                        if (implode(',', $newValueTrimmed) !== implode(',', $currentArrayTrimmed)) {
                            $actualChanges[$key] = $newValue;
                            Log::info("Sync: Field [{$key}] changed.", ['old' => $currentArrayTrimmed, 'new' => $newValueTrimmed]);
                        }
                    } else {
                        // Normalize empty strings and nulls
                        $normalizedNew = $newValue === "" ? null : $newValue;
                        $normalizedCurrent = $currentValue === "" ? null : $currentValue;

                        // Date Normalization (YYYY-MM-DD)
                        if (in_array($key, ['60c55699067ba00185deef9ee3454621a2fc797f', '7f3c87b1c0f51a5c4e1f9ae1c380a8a5f911c3a1'])) {
                            if ($normalizedNew && $normalizedCurrent) {
                                if (substr((string)$normalizedNew, 0, 10) === substr((string)$normalizedCurrent, 0, 10)) {
                                    continue;
                                }
                            }
                        }

                        // Option Field ID vs Label mismatch
                        if ($normalizedCurrent !== null && is_numeric($normalizedCurrent) && is_string($normalizedNew) && !is_numeric($normalizedNew)) {
                            continue; // Skip triggering an update for Label vs numeric ID mismatch
                        }
                        
                        // String cast comparison to avoid `null == 0` (true) but strictly handle numeric strings `100` vs `"100"`
                        if ((string)$normalizedNew !== (string)$normalizedCurrent) {
                            $actualChanges[$key] = $normalizedNew;
                            Log::info("Sync: Field [{$key}] changed from [" . json_encode($normalizedCurrent) . "] to [" . json_encode($normalizedNew) . "]");
                        }
                    }
                }
            } else {
                Log::error("Sync: Could not fetch existing data for Deal ID {$dealId}. Skipping update to prevent false history logs.");
                return; // Abort further execution for this listing
            }

            if (!empty($actualChanges)) {
                // Safety: Ensure these fields are NEVER updated in an existing deal
                unset($actualChanges['user_id'], $actualChanges['status'], $actualChanges['person_id'], $actualChanges['stage_id']);

                if (!empty($actualChanges)) {
                    Log::info("Action: UPDATING existing deal ID {$dealId} with " . count($actualChanges) . " fields.");
                    $response = Http::put("https://api.pipedrive.com/v1/deals/{$dealId}?api_token={$pipedriveToken}", $actualChanges);
                } else {
                    Log::info("Sync: No net changes for {$listingRef} after unsetting restricted fields.");
                    return;
                }
            } else {
                Log::info("Sync: No changes detected for {$listingRef}, skipping Pipedrive update.");
                return; // Abort further execution for this listing
            }
        } else {
            if (in_array($rawState, ['live', 'draft'])) {
                Log::info("Action: CREATING new deal (State: {$rawState})");
                $pipedriveData['user_id'] = 25366837; // Edward Paul (Only for new deals)
                $response = Http::post("https://api.pipedrive.com/v1/deals?api_token={$pipedriveToken}", $pipedriveData);
                if ($response->successful()) {
                    // Start Logging Logic
                    try {
                        $createdDealId = $response->json('data.id');
                        $logDir = storage_path('app/public/creation_logs');
                        if (!\Illuminate\Support\Facades\File::exists($logDir)) {
                            \Illuminate\Support\Facades\File::makeDirectory($logDir, 0755, true);
                        }
                        $timestamp = now()->format('Y_m_d_His');
                        $safeRef = preg_replace('/[^A-Za-z0-9\-]/', '_', $listingRef);
                        $logFilename = "created_{$createdDealId}_{$safeRef}_{$timestamp}.json";
                        
                        $logData = [
                            'property_finder_raw_data' => $apiListingData,
                            'pipedrive_final_payload' => $pipedriveData,
                            'pipedrive_response' => $response->json(),
                            'timestamp' => now()->toDateTimeString(),
                        ];
                        
                        \Illuminate\Support\Facades\File::put($logDir . '/' . $logFilename, json_encode($logData, JSON_PRETTY_PRINT));
                    } catch (\Exception $e) {
                        Log::error("Creation Logging Failed: " . $e->getMessage());
                    }
                    // End Logging Logic

                    sleep(2); // Prevent indexing delay issues by allowing Pipedrive time to index the new deal
                }
            } else {
                Log::info("Action: SKIPPED deal creation because status is '{$rawState}' and deal does not exist.");
                return; // Abort further execution for this listing
            }
        }

        if ($response->status() === 429) {
            Log::error("Pipedrive Daily Limit Exceeded during Sync.", ['ref' => $listingRef]);
        } elseif (!$response->successful()) {
            Log::error("Pipedrive Deal Sync Failed for {$listingRef}.", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        } else {
            Log::info("Successfully synced {$listingRef} to Pipedrive.");
        }
    }

    private function getLocationTree($locationId, $token) {
        if (!$locationId || !$token) return null;
        $response = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/locations?filter[id]=$locationId");
        return $response->json()['data'][0] ?? null;
    }

    // 4. View Creation Logs
    public function viewCreationLogs(Request $request)
    {
        $logDir = storage_path('app/public/creation_logs');
        
        if ($request->has('file')) {
            $filename = basename($request->query('file'));
            $filePath = $logDir . '/' . $filename;
            if (\Illuminate\Support\Facades\File::exists($filePath)) {
                return response(\Illuminate\Support\Facades\File::get($filePath))->header('Content-Type', 'application/json');
            }
            return abort(404, 'File not found.');
        }

        $files = [];
        if (\Illuminate\Support\Facades\File::exists($logDir)) {
            $files = \Illuminate\Support\Facades\File::files($logDir);
        }
        
        usort($files, function($a, $b) {
            return $b->getMTime() <=> $a->getMTime();
        });

        $html = "<html><head><title>Creation Logs</title><style>
            body { font-family: sans-serif; padding: 20px; }
            table { border-collapse: collapse; width: 100%; max-width: 800px; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            a { color: blue; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style></head><body>";
        $html .= "<h2>Newly Created Deal Logs</h2>";
        
        if (empty($files)) {
            $html .= "<p>No logs found.</p>";
        } else {
            $html .= "<table><tr><th>Filename</th><th>Date Modified</th><th>Action</th></tr>";
            foreach ($files as $file) {
                $filename = $file->getFilename();
                $url = url('/creation-logs?file=' . urlencode($filename));
                $date = date('Y-m-d H:i:s', $file->getMTime());
                $html .= "<tr>
                    <td>{$filename}</td>
                    <td>{$date}</td>
                    <td><a href='{$url}' target='_blank'>View</a></td>
                </tr>";
            }
            $html .= "</table>";
        }
        $html .= "</body></html>";
        
        return response($html);
    }
}