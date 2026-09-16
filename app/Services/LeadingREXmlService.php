<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use XMLWriter;

class LeadingREXmlService
{
    protected $apiToken;
    protected $apiUrl = 'https://api.pipedrive.com/v1/';
    protected $fieldMappings = [];

    public function __construct()
    {
        $this->apiToken = env('PIPEDRIVE_TOKEN');
    }

    /**
     * Generate the XML feed for LeadingRE
     */
    public function generateFeed()
    {
        $this->fetchFieldMappings();
        $deals = $this->fetchDeals();

        if (empty($deals)) {
            Log::info("LeadingRE Sync: No eligible deals found to sync.");
            return false;
        }

        return $this->createXmlFile($deals);
    }

    /**
     * Fetch dealFields from Pipedrive to build dropdown option maps
     */
    protected function fetchFieldMappings()
    {
        try {
            $response = Http::get("{$this->apiUrl}dealFields", [
                'api_token' => $this->apiToken,
            ]);

            if ($response->successful()) {
                $fields = $response->json()['data'] ?? [];
                $targetKeys = [
                    '1da5fc3b6713a605fa147077db49064ae9493df6', // Property Type
                    'af1f61eb5b7dcb81884f97e42ea331041e44828e', // Beds
                    '8abbf4a2a68242278a05332544e8a1c795f7b513', // Baths
                    'ab382a3a8713527be729a7dd0221cac825e48b76', // City/Community (Locality)
                    '47bda94663941aafd85b98728f34e473cc86a01b', // Sub Community (Sub_Locality)
                    '115128d46c1e368dd0680524bc13b3f60c988ca6', // Listing Category (Rent/Buy)
                    '7ec3f49c8f8443bed72620b6709df04b751ac504', // Sub Sub Community
                    '445d6ba6312f20b9a2650a5447234bf4e242a3eb', // Furnishing
                    '0c984a8705f02d79cdf5bd20057c7232e9dd3fb7', // Amenities
                    '14eeb3dcbd41663cac17c3784ceb9bbdc58b2375', // Listing Status
                    '279313aae531121cceb1c6b2d6c24bdfa61035be', // Is Verified
                    'c3be535744b2dd08a3e5b6f8fcc4864bd476c274', // Project Status
                    '0b222fb115cddffda32ea03a4331b1df00ce90f2'  // Listing Product
                ];

                foreach ($fields as $field) {
                    if (in_array($field['key'], $targetKeys) && isset($field['options'])) {
                        foreach ($field['options'] as $option) {
                            $this->fieldMappings[$field['key']][$option['id']] = $option['label'];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error("LeadingRE Sync: Exception when fetching dealFields", ['error' => $e->getMessage()]);
        }
    }

    /**
     * Fetch open deals matching the specific filter (Published Pipeline, Open, Leading RE)
     */
    protected function fetchDeals()
    {
        $deals = [];
        $start = 0;
        $limit = 100; // Safely set to 100 since filter ensures small dataset
        $filterId = 39063; // Client-provided filter ID
        $moreItemsInCollection = true;

        while ($moreItemsInCollection) {
            $attempt = 1;
            $maxAttempts = 3;
            $success = false;

            while ($attempt <= $maxAttempts && !$success) {
                try {
                    $response = Http::timeout(120)->get("{$this->apiUrl}deals", [
                        'api_token' => $this->apiToken,
                        'filter_id' => $filterId,
                        'start' => $start,
                        'limit' => $limit,
                    ]);

                    if ($response->successful()) {
                        $success = true;
                        $data = $response->json();
                        
                        // All returned deals are already filtered correctly by Pipedrive!
                        if (!empty($data['data'])) {
                            foreach ($data['data'] as $deal) {
                                $deals[] = $deal;
                            }
                        }

                        $moreItemsInCollection = $data['additional_data']['pagination']['more_items_in_collection'] ?? false;
                        $start = $data['additional_data']['pagination']['next_start'] ?? ($start + $limit);
                    } elseif ($response->status() === 429) {
                        Log::warning("LeadingRE Sync: Pipedrive Rate Limit hit. Retrying (Attempt $attempt)...");
                        sleep(2);
                        $attempt++;
                    } else {
                        Log::error("LeadingRE Sync: Failed to fetch deals from Pipedrive", ['response' => $response->body()]);
                        sleep(2);
                        $attempt++;
                    }
                } catch (\Exception $e) {
                    Log::warning("LeadingRE Sync: Exception when fetching deals (Attempt $attempt)", ['error' => $e->getMessage()]);
                    sleep(2);
                    $attempt++;
                }
            }

            // If it failed 3 times, break out to avoid infinite loops
            if (!$success) {
                Log::error("LeadingRE Sync: Halting fetch. Max attempts reached at start={$start}.");
                break;
            }
        }

        return $deals;
    }

    /**
     * Generate the XML file using XMLWriter in the RSS format requested by the client
     */
    protected function createXmlFile($deals)
    {
        $directory = 'public/feeds';
        $exchangeId = env('LEADINGRE_EXCHANGE_ID', '173920');
        $fileName = $exchangeId . '.xml';
        
        // Ensure directory exists in storage/app/public/feeds
        if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory);
        }

        $fullPath = storage_path('app/' . $directory . '/' . $fileName);

        $xml = new XMLWriter();
        $xml->openURI($fullPath);
        $xml->startDocument('1.0', 'UTF-8');
        $xml->setIndent(true);

        $xml->startElement('rss');
        $xml->startElement('Properties');

        foreach ($deals as $deal) {
            $xml->startElement('Property');
            
            // <Property_Ref_No>
            $refNo = $deal['c7d4db817f241ce7c70ee06bf930314ef6e20e95'] ?? $deal['id'];
            $xml->writeElement('Property_Ref_No', $refNo);
            
            // <Property_purpose>
            $categoryId = $deal['115128d46c1e368dd0680524bc13b3f60c988ca6'] ?? '';
            $purpose = 'Buy';
            if (in_array((string)$categoryId, ['1307', '1308'])) {
                $purpose = 'Rent';
            }
            $xml->writeElement('Property_purpose', $purpose);
            
            // <Property_Type>
            $propertyTypeId = $deal['1da5fc3b6713a605fa147077db49064ae9493df6'] ?? '';
            $propertyTypeLabel = $this->fieldMappings['1da5fc3b6713a605fa147077db49064ae9493df6'][$propertyTypeId] ?? $propertyTypeId;
            $xml->writeElement('Property_Type', $propertyTypeLabel);
            
            // <City>
            $xml->writeElement('City', 'Dubai');
            
            // <Locality>
            $localityId = $deal['ab382a3a8713527be729a7dd0221cac825e48b76'] ?? '';
            $localityLabel = $this->fieldMappings['ab382a3a8713527be729a7dd0221cac825e48b76'][$localityId] ?? $localityId;
            $xml->writeElement('Locality', $localityLabel);
            
            // <Sub_Locality>
            $subLocalityId = $deal['47bda94663941aafd85b98728f34e473cc86a01b'] ?? '';
            if (!empty($subLocalityId)) {
                $subLocalityLabel = $this->fieldMappings['47bda94663941aafd85b98728f34e473cc86a01b'][$subLocalityId] ?? $subLocalityId;
                $xml->writeElement('Sub_Locality', $subLocalityLabel);
            }
            
            // <Property_Title>
            $title = $deal['3faea5620eacdbb42ce6fd4062204214edd08f35'] ?? $deal['title'] ?? '';
            $xml->startElement('Property_Title');
            $xml->writeCdata($title);
            $xml->endElement(); // Property_Title
            
            // <Property_Description>
            $description = $deal['f5c3a84e2c36b5d09a83808a9b189c7d25b2424a'] ?? '';
            $xml->startElement('Property_Description');
            $xml->writeCdata($description);
            $xml->endElement(); // Property_Description
            
            // <Property_Size>
            $size = $deal['90d285f55be47b4a173ea65f73406bcbec2366b5'] ?? '';
            $xml->writeElement('Property_Size', $size);
            
            // <Bedrooms>
            $bedId = $deal['af1f61eb5b7dcb81884f97e42ea331041e44828e'] ?? '';
            $bedLabel = $this->fieldMappings['af1f61eb5b7dcb81884f97e42ea331041e44828e'][$bedId] ?? '';
            $cleanBedLabel = trim(preg_replace('/[^0-9]/', '', $bedLabel));
            if ($bedLabel === 'Studio' || $cleanBedLabel === '') {
                $cleanBedLabel = '0';
            }
            $xml->writeElement('Bedrooms', $cleanBedLabel);
            
            // <Bathroom>
            $bathId = $deal['8abbf4a2a68242278a05332544e8a1c795f7b513'] ?? '';
            $bathLabel = $this->fieldMappings['8abbf4a2a68242278a05332544e8a1c795f7b513'][$bathId] ?? '';
            $cleanBathLabel = trim(preg_replace('/[^0-9]/', '', $bathLabel));
            if ($cleanBathLabel === '') {
                $cleanBathLabel = '0';
            }
            $xml->writeElement('Bathroom', $cleanBathLabel);
            
            // <Price>
            $price = $deal['95327613fa6b2ddc2473aef1395f9626a5416b16'] ?? '';
            $xml->writeElement('Price', $price);
            
            // <Images>
            $mediaField = 'bcd9ca9385431ef1eca4ff8be5bb75b2bf46511f';
            $mediaUrls = $deal[$mediaField] ?? '';
            $xml->startElement('Images');
            if (!empty($mediaUrls)) {
                $urls = preg_split('/\r\n|\r|\n/', $mediaUrls);
                $urls = array_filter(array_map('trim', $urls));
                foreach ($urls as $url) {
                    if (empty($url)) continue;
                    $xml->writeElement('Image', $url);
                }
            }
            $xml->endElement(); // Images
            
            // <Listing_Agent>
            $agentName = $deal['user_id']['name'] ?? 'Unknown Agent';
            $xml->writeElement('Listing_Agent', $agentName);
            
            // <Sub_Sub_Locality>
            $subSubLocalityId = $deal['7ec3f49c8f8443bed72620b6709df04b751ac504'] ?? '';
            if (!empty($subSubLocalityId)) {
                $subSubLocalityLabel = $this->fieldMappings['7ec3f49c8f8443bed72620b6709df04b751ac504'][$subSubLocalityId] ?? $subSubLocalityId;
                $xml->writeElement('Sub_Sub_Locality', $subSubLocalityLabel);
            }
            
            // <Unit_Number>
            $xml->writeElement('Unit_Number', $deal['85da40fd76c93821a2cc452d26d94be931409de1'] ?? '');
            
            // <Furnishing>
            $furnishingId = $deal['445d6ba6312f20b9a2650a5447234bf4e242a3eb'] ?? '';
            $furnishingLabel = $this->fieldMappings['445d6ba6312f20b9a2650a5447234bf4e242a3eb'][$furnishingId] ?? $furnishingId;
            $xml->writeElement('Furnishing', $furnishingLabel);
            
            // <Amenities>
            $amenitiesRaw = $deal['0c984a8705f02d79cdf5bd20057c7232e9dd3fb7'] ?? '';
            $xml->startElement('Amenities');
            if (!empty($amenitiesRaw)) {
                $amenityIds = explode(',', $amenitiesRaw);
                foreach ($amenityIds as $amenityId) {
                    $amenityId = trim($amenityId);
                    if (empty($amenityId)) continue;
                    $amenityLabel = $this->fieldMappings['0c984a8705f02d79cdf5bd20057c7232e9dd3fb7'][$amenityId] ?? $amenityId;
                    $xml->writeElement('Amenity', $amenityLabel);
                }
            }
            $xml->endElement(); // Amenities
            
            // <RERA_Permit_Number>
            $xml->writeElement('RERA_Permit_Number', $deal['2f599a6e19906bba68213acf0bf242354a4628d6'] ?? '');
            
            // <Project_Status>
            $projectStatusId = $deal['c3be535744b2dd08a3e5b6f8fcc4864bd476c274'] ?? '';
            $projectStatusLabel = $this->fieldMappings['c3be535744b2dd08a3e5b6f8fcc4864bd476c274'][$projectStatusId] ?? $projectStatusId;
            $xml->writeElement('Project_Status', $projectStatusLabel);
            
            // <Listing_Status>
            $listingStatusId = $deal['14eeb3dcbd41663cac17c3784ceb9bbdc58b2375'] ?? '';
            $listingStatusLabel = $this->fieldMappings['14eeb3dcbd41663cac17c3784ceb9bbdc58b2375'][$listingStatusId] ?? $listingStatusId;
            $xml->writeElement('Listing_Status', $listingStatusLabel);
            
            // <Is_Verified>
            $isVerifiedId = $deal['279313aae531121cceb1c6b2d6c24bdfa61035be'] ?? '';
            $isVerifiedLabel = $this->fieldMappings['279313aae531121cceb1c6b2d6c24bdfa61035be'][$isVerifiedId] ?? $isVerifiedId;
            $xml->writeElement('Is_Verified', $isVerifiedLabel);
            
            // <Listing_Product>
            $listingProductId = $deal['0b222fb115cddffda32ea03a4331b1df00ce90f2'] ?? '';
            $listingProductLabel = $this->fieldMappings['0b222fb115cddffda32ea03a4331b1df00ce90f2'][$listingProductId] ?? $listingProductId;
            $xml->writeElement('Listing_Product', $listingProductLabel);
            
            // <PF_Listing_ID>
            $xml->writeElement('PF_Listing_ID', $deal['228032f7dfd466da76d1067c32e3a19393c43849'] ?? '');
            
            // <PF_Published_At>
            $xml->writeElement('PF_Published_At', $deal['60c55699067ba00185deef9ee3454621a2fc797f'] ?? '');
            
            // <Owner_Name>
            $xml->writeElement('Owner_Name', $deal['3c63748054466d74046d22cf0f16f4137a5fdf91'] ?? '');
            
            // <Agent_Name> (Custom Field)
            $customAgentName = $deal['99118d3985b1f300acd5fd772bf7f2b22c55def8'] ?? '';
            $xml->writeElement('Agent_Name', $customAgentName);
            
            // <Agent_ID>
            $xml->writeElement('Agent_ID', $deal['25a5186deb6e4707dca6578f78db8df6515641d1'] ?? '');
            
            // <Created_By_Name>
            $xml->writeElement('Created_By_Name', $deal['caec8722296a1ba1d5cea25a537aa2e7a1d05aca'] ?? '');
            
            // <Created_At>
            $xml->writeElement('Created_At', $deal['7f3c87b1c0f51a5c4e1f9ae1c380a8a5f911c3a1'] ?? '');
            
            // <Quality_Score>
            $xml->writeElement('Quality_Score', $deal['ef69929315bd1cbf3835cf8894979fee8e978c26'] ?? '');
            
            $xml->endElement(); // Property
        }

        $xml->endElement(); // Properties
        $xml->endElement(); // rss
        
        $xml->endDocument();
        $xml->flush();

        return [
            'file_path' => $fullPath,
            'total_deals' => count($deals)
        ];
    }
}
