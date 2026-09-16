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
            $xml->startElement('Property_Ref_No');
            $xml->writeCdata($refNo);
            $xml->endElement();
            
            // <Property_purpose>
            $categoryId = $deal['115128d46c1e368dd0680524bc13b3f60c988ca6'] ?? '';
            $purpose = 'Buy';
            if (in_array((string)$categoryId, ['1307', '1308'])) {
                $purpose = 'Rent';
            }
            $xml->startElement('Property_purpose');
            $xml->writeCdata($purpose);
            $xml->endElement();
            
            // <Property_Type>
            $propertyTypeId = $deal['1da5fc3b6713a605fa147077db49064ae9493df6'] ?? '';
            $propertyTypeLabel = $this->fieldMappings['1da5fc3b6713a605fa147077db49064ae9493df6'][$propertyTypeId] ?? $propertyTypeId;
            $xml->startElement('Property_Type');
            $xml->writeCdata($propertyTypeLabel);
            $xml->endElement();
            
            // <Property_Status>
            $listingStatusId = $deal['14eeb3dcbd41663cac17c3784ceb9bbdc58b2375'] ?? '';
            $listingStatusLabel = $this->fieldMappings['14eeb3dcbd41663cac17c3784ceb9bbdc58b2375'][$listingStatusId] ?? $listingStatusId;
            if (empty($listingStatusLabel)) $listingStatusLabel = 'live'; // fallback
            $xml->startElement('Property_Status');
            $xml->writeCdata(strtolower($listingStatusLabel) === 'live' ? 'live' : $listingStatusLabel);
            $xml->endElement();
            
            // <City>
            $xml->startElement('City');
            $xml->writeCdata('Dubai');
            $xml->endElement();
            
            // <Locality>
            $localityId = $deal['ab382a3a8713527be729a7dd0221cac825e48b76'] ?? '';
            $localityLabel = $this->fieldMappings['ab382a3a8713527be729a7dd0221cac825e48b76'][$localityId] ?? $localityId;
            $xml->startElement('Locality');
            $xml->writeCdata($localityLabel);
            $xml->endElement();
            
            // <Sub_Locality>
            $subLocalityId = $deal['47bda94663941aafd85b98728f34e473cc86a01b'] ?? '';
            $subLocalityLabel = $this->fieldMappings['47bda94663941aafd85b98728f34e473cc86a01b'][$subLocalityId] ?? $subLocalityId;
            $xml->startElement('Sub_Locality');
            $xml->writeCdata($subLocalityLabel);
            $xml->endElement();
            
            // <Tower_Name>
            $subSubLocalityId = $deal['7ec3f49c8f8443bed72620b6709df04b751ac504'] ?? '';
            $subSubLocalityLabel = $this->fieldMappings['7ec3f49c8f8443bed72620b6709df04b751ac504'][$subSubLocalityId] ?? $subSubLocalityId;
            $xml->startElement('Tower_Name');
            $xml->writeCdata($subSubLocalityLabel);
            $xml->endElement();
            
            // <Property_Title>
            $title = $deal['3faea5620eacdbb42ce6fd4062204214edd08f35'] ?? $deal['title'] ?? '';
            $xml->startElement('Property_Title');
            $xml->writeCdata($title);
            $xml->endElement();
            
            $xml->startElement('Property_Title_AR');
            $xml->writeCdata('');
            $xml->endElement();
            
            // <Property_Description>
            $description = $deal['f5c3a84e2c36b5d09a83808a9b189c7d25b2424a'] ?? '';
            $xml->startElement('Property_Description');
            $xml->writeCdata($description);
            $xml->endElement();
            
            $xml->startElement('Property_Description_AR');
            $xml->writeCdata('');
            $xml->endElement();
            
            // <Property_Size> & <Property_Size_Unit>
            $size = $deal['90d285f55be47b4a173ea65f73406bcbec2366b5'] ?? '';
            $xml->writeElement('Property_Size', $size);
            $xml->startElement('Property_Size_Unit');
            $xml->writeCdata('SQFT');
            $xml->endElement();
            
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
            $xml->startElement('Price');
            $xml->writeCdata($price);
            $xml->endElement();
            
            // <Furnished>
            $furnishingId = $deal['445d6ba6312f20b9a2650a5447234bf4e242a3eb'] ?? '';
            $furnishingLabel = $this->fieldMappings['445d6ba6312f20b9a2650a5447234bf4e242a3eb'][$furnishingId] ?? $furnishingId;
            $furnishedVal = 'No';
            if (stripos($furnishingLabel, 'Partly') !== false) {
                $furnishedVal = 'Partly';
            } elseif (stripos($furnishingLabel, 'Un-Furnished') !== false || stripos($furnishingLabel, 'Unfurnished') !== false) {
                $furnishedVal = 'No';
            } elseif (stripos($furnishingLabel, 'Furnished') !== false) {
                $furnishedVal = 'Yes';
            }
            $xml->startElement('Furnished');
            $xml->writeCdata($furnishedVal);
            $xml->endElement();
            
            // <Off_Plan>
            $projectStatusId = $deal['c3be535744b2dd08a3e5b6f8fcc4864bd476c274'] ?? '';
            $projectStatusLabel = $this->fieldMappings['c3be535744b2dd08a3e5b6f8fcc4864bd476c274'][$projectStatusId] ?? $projectStatusId;
            $offPlanVal = 'No';
            if (stripos($projectStatusLabel, 'Off-Plan') !== false) {
                $offPlanVal = 'Yes';
            }
            $xml->startElement('Off_Plan');
            $xml->writeCdata($offPlanVal);
            $xml->endElement();
            
            // <Rent_Frequency>
            $xml->startElement('Rent_Frequency');
            $xml->writeCdata('Yearly'); // Only needed for rent, safe to output 'Yearly' as default.
            $xml->endElement();
            
            // <Permit_Number>
            $permit = $deal['2f599a6e19906bba68213acf0bf242354a4628d6'] ?? '';
            $xml->startElement('Permit_Number');
            $xml->writeCdata($permit);
            $xml->endElement();
            
            // <Images>
            $mediaField = 'bcd9ca9385431ef1eca4ff8be5bb75b2bf46511f';
            $mediaUrls = $deal[$mediaField] ?? '';
            $xml->startElement('Images');
            if (!empty($mediaUrls)) {
                $urls = preg_split('/\r\n|\r|\n/', $mediaUrls);
                $urls = array_filter(array_map('trim', $urls));
                foreach ($urls as $url) {
                    if (empty($url)) continue;
                    $xml->startElement('Image');
                    $xml->writeCdata($url);
                    $xml->endElement();
                }
            }
            $xml->endElement(); // Images
            
            // <Videos>
            $xml->startElement('Videos');
            $xml->endElement();
            
            // <Floor_Plans>
            $xml->startElement('Floor_Plans');
            $xml->endElement();
            
            // <Features>
            $amenitiesRaw = $deal['0c984a8705f02d79cdf5bd20057c7232e9dd3fb7'] ?? '';
            $xml->startElement('Features');
            if (!empty($amenitiesRaw)) {
                $amenityIds = explode(',', $amenitiesRaw);
                foreach ($amenityIds as $amenityId) {
                    $amenityId = trim($amenityId);
                    if (empty($amenityId)) continue;
                    $amenityLabel = $this->fieldMappings['0c984a8705f02d79cdf5bd20057c7232e9dd3fb7'][$amenityId] ?? $amenityId;
                    
                    $xml->startElement('Feature');
                    $xml->writeCdata($amenityLabel);
                    $xml->endElement();
                }
            }
            $xml->endElement(); // Features
            
            // <Listing_Agent>
            $customAgentName = $deal['99118d3985b1f300acd5fd772bf7f2b22c55def8'] ?? '';
            $agentName = !empty($customAgentName) ? $customAgentName : ($deal['user_id']['name'] ?? 'Unknown Agent');
            $xml->startElement('Listing_Agent');
            $xml->writeCdata($agentName);
            $xml->endElement();
            
            // <Listing_Agent_Email>
            $agentEmail = $deal['user_id']['email'] ?? '';
            $xml->startElement('Listing_Agent_Email');
            $xml->writeCdata($agentEmail);
            $xml->endElement();
            
            // <Listing_Agent_Phone>
            $agentPhone = $deal['user_id']['phone'] ?? '';
            $xml->startElement('Listing_Agent_Phone');
            $xml->writeCdata($agentPhone);
            $xml->endElement();
            
            // <Listing_Agent_Photo>
            $agentPhoto = $deal['user_id']['icon_url'] ?? ''; // Pipedrive avatar
            $xml->startElement('Listing_Agent_Photo');
            $xml->writeCdata($agentPhoto);
            $xml->endElement();
            
            // <Last_Updated>
            $lastUpdated = $deal['update_time'] ?? '';
            $xml->startElement('Last_Updated');
            $xml->writeCdata($lastUpdated);
            $xml->endElement();
            
            // <Portals>
            $xml->startElement('Portals');
            $xml->startElement('Portal');
            $xml->text('LeadingRE');
            $xml->endElement();
            $xml->endElement();
            
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
