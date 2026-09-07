<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handlePropertyFinderLead(Request $request)
    {
        $payload = $request->all();
        
        $lead = isset($payload['payload']) ? $payload['payload'] : $payload;

        // Extract listing ID & Ref from webhook payload
        $listingId = data_get($lead, 'listing.id') ?? data_get($lead, 'id');
        $webhookListingRef = data_get($lead, 'listing.reference') ?? data_get($lead, 'reference');

        // Lead Validation: Only proceed if listing.reference exists
        if (empty($webhookListingRef)) {
            Log::warning("Property Finder Webhook: Missing listing reference. Aborting sync.");
            return response()->json(['status' => 'success', 'message' => 'Acknowledged without action (Missing reference)'], 200);
        }

        // =====================================================================
        // Fetch Full Listing Details from Property Finder API
        // =====================================================================
        $apiListingData = null;
        $token = null;

        if ($listingId) {
            try {
                // Hardcoded API keys exactly as per XML controller
                $apiKey = 'oqwBE.kDdBGOU7HyocVo1CHDrOhYL7qGk17C6t7b';
                $apiSecret = 'DKkjTaTwwWdrrX7NHVfOwWadryr3HyY7';

                // Send POST to auth endpoint
                $authResponse = Http::post('https://atlas.propertyfinder.com/v1/auth/token', [
                    'apiKey' => $apiKey,
                    'apiSecret' => $apiSecret
                ]);

                // Extract token securely using exact array logic
                $token = $authResponse->json()['accessToken'] ?? null;
                    
                if (!empty($token)) {
                    // CRITICAL FIX: Fetch Listing Data using the collection endpoint and filter[ids]
                    $listingResponse = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/listings", [
                        'filter[ids]' => $listingId
                    ]);
                        
                    if ($listingResponse->successful()) {
                        // Extract listing data from the first result in the array
                        $apiListingData = $listingResponse->json()['results'][0] ?? null;
                        if ($apiListingData) {
                            Log::info("Successfully fetched full listing data from PF API for ID: {$listingId}");
                        } else {
                            Log::warning("Property Finder Listing API succeeded, but no results found for ID: {$listingId}");
                        }
                    } else {
                        Log::error("Property Finder Listing API failed.", ['status' => $listingResponse->status(), 'body' => $listingResponse->body()]);
                    }
                } else {
                    Log::error("Property Finder Auth API failed or accessToken was empty.", ['status' => $authResponse->status(), 'body' => $authResponse->body()]);
                }
            } catch (\Exception $e) {
                Log::error("Exception fetching Property Finder Listing: " . $e->getMessage());
            }
        }

        // =====================================================================
        // Data Extraction Helper
        // =====================================================================
        // Helper to extract listing details safely, prioritizing API data over webhook data
        $getListingData = function($key) use ($lead, $apiListingData) {
            if ($apiListingData) {
                $apiVal = data_get($apiListingData, $key);
                if ($apiVal !== null) {
                    return $apiVal;
                }
            }
            return data_get($lead, "listing.{$key}") ?? data_get($lead, $key);
        };

        $listingRef = $getListingData('reference') ?? $webhookListingRef;

        // Extract nested sender details safely from webhook
        $senderName = data_get($lead, 'sender.name', 'Unknown Sender');
        $senderPhone = data_get($lead, 'sender.contacts.0.value', '');

        $dealTitle = "PF Inquiry: {$senderName} " . $listingRef;

        $pipedriveToken = env('PIPEDRIVE_TOKEN');

        if (empty($pipedriveToken)) {
            Log::error("Pipedrive Sync Failed: PIPEDRIVE_TOKEN is missing in .env");
            return response()->json(['status' => 'error', 'message' => 'Configuration error'], 500);
        }

        // =====================================================================
        // 1. Create Person in Pipedrive
        // =====================================================================
        $personResponse = Http::post("https://api.pipedrive.com/v1/persons?api_token={$pipedriveToken}", [
            'name' => $senderName,
            'phone' => [['value' => $senderPhone, 'primary' => true]],
        ]);

        $personId = null;
        if ($personResponse->successful()) {
            $personId = $personResponse->json('data.id');
        } else {
            Log::warning("Pipedrive Person Creation Failed.", ['body' => $personResponse->body()]);
        }

        // =====================================================================
        // 2. Prepare and Create Deal in Pipedrive
        // =====================================================================
        
        // Base Data: Always created (Fallback scenario)
        $pipedriveData = [
            'title' => $dealTitle,
            'stage_id' => 14, // Set stage_id to 14 for the 'Published' pipeline
            'c7d4db817f241ce7c70ee06bf930314ef6e20e95' => $listingRef,
        ];

        // Attach person to deal if created successfully
        if ($personId) {
            $pipedriveData['person_id'] = $personId;
        }

        // If the Listing API was successful, populate the extensive custom fields
        if ($apiListingData) {
            // Fetch Location Tree (Hierarchy)
            $locationData = $this->getLocationTree($getListingData('location.id'), $token);
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

            // Product Type & Nested Fields
            $products = $getListingData('products');
            $listingProductRaw = (is_array($products) && !empty($products)) ? array_key_first($products) : null;
            
            $productMap = [
                'premium' => 1313,
                'featured' => 1312,
                'standard' => 1311
            ];
            
            $listingProduct = ($listingProductRaw && isset($productMap[$listingProductRaw])) ? $productMap[$listingProductRaw] : 1311;

            $productCreatedAt = $listingProductRaw ? $getListingData("products.{$listingProductRaw}.createdAt") : null;
            $productExpiresAt = $listingProductRaw ? $getListingData("products.{$listingProductRaw}.expiresAt") : null;
            $productRenewableRaw = $listingProductRaw ? $getListingData("products.{$listingProductRaw}.renewalEnabled") : null;
            $productRenewable = $productRenewableRaw === true ? 'Yes' : ($productRenewableRaw === false ? 'No' : null);

            // Amenities: Map PF slugs to exact Pipedrive labels
            $amenities = $getListingData('amenities');
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
                    } else {
                        Log::warning("Unmapped Property Finder amenity encountered: {$amenity}");
                    }
                }
            }

            // Images: Extract original.url and join with newlines
            $mediaImages = $getListingData('media.images');
            $imagesStr = null;
            if (is_array($mediaImages) && !empty($mediaImages)) {
                $urls = array_filter(array_map(function($img) {
                    return data_get($img, 'original.url', '');
                }, $mediaImages));
                if (!empty($urls)) {
                    $imagesStr = implode("\n", $urls);
                }
            }

            // Listing Price (Ensure numeric float, flexible for sale/rent)
            $rawPrice = $getListingData('price.amounts.sale') ?? $getListingData('price.amounts.yearly') ?? $getListingData('price.amounts.monthly') ?? 0;
            $numericPrice = (float) $rawPrice;

            // Formatting for Pipedrive Dropdowns
            $listingStatus = ucfirst($getListingData('state.stage'));
            $propertyType = ucfirst($getListingData('type'));
            
            $rawFurnishing = $getListingData('furnishingType');
            $furnishing = null;
            if ($rawFurnishing === 'furnished') $furnishing = 'Furnished';
            elseif ($rawFurnishing === 'unfurnished') $furnishing = 'Un-Furnished';
            elseif ($rawFurnishing === 'partly_furnished') $furnishing = 'Partly Furnished';

            $isVerified = ($getListingData('verificationStatus') === 'approved') ? 'Verified' : 'Un-Verified';
            
            $rawCategory = $getListingData('category');
            $priceType = $getListingData('price.type');
            $listingCategory = null;
            if ($rawCategory === 'residential') {
                if ($priceType === 'sale') $listingCategory = 'Residential Sale';
                elseif (in_array($priceType, ['yearly', 'monthly'])) $listingCategory = 'Residential Rent';
            } elseif ($rawCategory === 'commercial') {
                if ($priceType === 'sale') $listingCategory = 'Commercial Sale';
                elseif (in_array($priceType, ['yearly', 'monthly'])) $listingCategory = 'Commercial Rent';
            }
            
            $rawProjectStatus = $getListingData('projectStatus');
            $listingCompletion = null;
            if ($rawProjectStatus === 'completed') $listingCompletion = 'Ready';
            elseif ($rawProjectStatus === 'off_plan') $listingCompletion = 'Off-Plan';

            $enrichedData = [
                // 7 New Mapped Fields
                '228032f7dfd466da76d1067c32e3a19393c43849' => $getListingData('id'),
                'ab382a3a8713527be729a7dd0221cac825e48b76' => $community,
                '47bda94663941aafd85b98728f34e473cc86a01b' => $subCommunity,
                '7ec3f49c8f8443bed72620b6709df04b751ac504' => $subSubCommunity,
                '60c55699067ba00185deef9ee3454621a2fc797f' => $getListingData('portals.propertyfinder.publishedAt'),
                '0b222fb115cddffda32ea03a4331b1df00ce90f2' => $listingProduct,
                // End New Fields
                '3faea5620eacdbb42ce6fd4062204214edd08f35' => $getListingData('title.en'),
                '95327613fa6b2ddc2473aef1395f9626a5416b16' => $numericPrice,
                '90d285f55be47b4a173ea65f73406bcbec2366b5' => $getListingData('size'),
                'af1f61eb5b7dcb81884f97e42ea331041e44828e' => $getListingData('bedrooms'),
                '8abbf4a2a68242278a05332544e8a1c795f7b513' => $getListingData('bathrooms'),
                '1da5fc3b6713a605fa147077db49064ae9493df6' => $propertyType,
                '85da40fd76c93821a2cc452d26d94be931409de1' => $getListingData('unitNumber'),
                '115128d46c1e368dd0680524bc13b3f60c988ca6' => $listingCategory,
                'f5c3a84e2c36b5d09a83808a9b189c7d25b2424a' => $getListingData('description.en'),
                '445d6ba6312f20b9a2650a5447234bf4e242a3eb' => $furnishing,
                '0c984a8705f02d79cdf5bd20057c7232e9dd3fb7' => empty($mappedAmenities) ? null : $mappedAmenities,
                'bcd9ca9385431ef1eca4ff8be5bb75b2bf46511f' => $imagesStr,
                
                // Agent & Creation Info
                '99118d3985b1f300acd5fd772bf7f2b22c55def8' => $getListingData('assignedTo.name'),
                '25a5186deb6e4707dca6578f78db8df6515641d1' => $getListingData('assignedTo.id'),
                'caec8722296a1ba1d5cea25a537aa2e7a1d05aca' => $getListingData('createdBy.name'),
                '7f3c87b1c0f51a5c4e1f9ae1c380a8a5f911c3a1' => $getListingData('createdAt'),
                
                // Status & Additional Details
                '2f599a6e19906bba68213acf0bf242354a4628d6' => $getListingData('compliance.listingAdvertisementNumber'),
                '14eeb3dcbd41663cac17c3784ceb9bbdc58b2375' => $listingStatus,
                '279313aae531121cceb1c6b2d6c24bdfa61035be' => $isVerified,
                '3c63748054466d74046d22cf0f16f4137a5fdf91' => $getListingData('ownerName'),
                'c3be535744b2dd08a3e5b6f8fcc4864bd476c274' => $listingCompletion,
                
                // Total Quality Score
                'ef69929315bd1cbf3835cf8894979fee8e978c26' => $getListingData('qualityScore.value'),
                
                // Detailed Quality Scores
                'c8706db4d351eb1f8390e03d36a65834b0f719c4' => $getListingData('qualityScore.details.description.value'),
                '6aa75083721a6774366c6c83411c5de6ce115ffa' => $getListingData('qualityScore.details.image.value'),
                '7bf8ee26fe29b40482b302ba543e20baa5a11fad' => $getListingData('qualityScore.details.imageDiversity.value'),
                'c7c04e253a81617b1a6a502d57a743619c162637' => $getListingData('qualityScore.details.imageDuplicates.value'),
                '433f91578e4fb480c4855eb12ce9a3f5f524e3c3' => $getListingData('qualityScore.details.imagesDimensions.value'),
                'e7c6af0cc3d94fde198a3dee7b3e54b24704db93' => $getListingData('qualityScore.details.location.value'),
                'fb2d9f666cce5dfa4e4c970c07257dae7ca4c9cb' => $getListingData('qualityScore.details.verified.value'),
                '9c769a062605a72c90eff5e3469dd68e1e351b8e' => (int) $getListingData('qualityScore.details.additional.value'),
                
                // Product Info
                '8567970e4d27c099662f0af3415a2c1013edb583' => $productCreatedAt,
                '794178f5cedf7271b33e94a76578e4d733e630a9' => $productExpiresAt,
                '724ed6515a43497ca8686ca270d7d682e7dae32d' => $productRenewable,
            ];

            // Conditionally add QS Title to avoid 400 validation error if null
            $qsTitle = $getListingData('qualityScore.details.title.value');
            if ($qsTitle !== null) {
                $enrichedData['399867e65baacd267034a3c5f9d728cb8c66db79'] = $qsTitle;
            }

            // Build dynamic Deal Title
            $titleCommunity = $community ?: 'N/A';
            $titleSubCommunity = $subCommunity ?: 'N/A';
            $titlePrice = $numericPrice ? 'AED ' . number_format($numericPrice) : 'AED N/A';
            $titleAgent = $getListingData('assignedTo.name') ?: 'N/A';
            $pipedriveData['title'] = "{$titleCommunity} | {$titleSubCommunity} | {$titlePrice} | {$titleAgent}";

            // Merge enriched API data into Pipedrive payload
            $pipedriveData = array_merge($pipedriveData, $enrichedData);
        } else {
            Log::info("Proceeding with fallback basic deal creation since API listing data is unavailable.");
        }

        $response = Http::post("https://api.pipedrive.com/v1/deals?api_token={$pipedriveToken}", $pipedriveData);

        if ($response->successful()) {
            $dealId = $response->json('data.id');

            // Attach raw JSON response as a Note to the Deal
            if ($apiListingData && $dealId) {
                $noteContent = "<b>Full Property Finder API Response:</b><pre>" . json_encode($apiListingData, JSON_PRETTY_PRINT) . "</pre>";
                $noteResponse = Http::post("https://api.pipedrive.com/v1/notes?api_token={$pipedriveToken}", [
                    'content' => $noteContent,
                    'deal_id' => $dealId
                ]);

                if (!$noteResponse->successful()) {
                    Log::warning("Pipedrive Note Creation Failed.", ['body' => $noteResponse->body()]);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Deal successfully created'], 200);
        }

        if ($response->status() === 429) {
            Log::error("Pipedrive Daily Limit Exceeded.");
        } else {
            Log::error("Pipedrive Sync Failed.", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Pipedrive error'], 500);
    }

    private function getLocationTree($locationId, $token) {
        if (!$locationId || !$token) return null;
        $response = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/locations?filter[id]=$locationId");
        return $response->json()['data'][0] ?? null;
    }
}
