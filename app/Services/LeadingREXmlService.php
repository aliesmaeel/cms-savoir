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
                    '8abbf4a2a68242278a05332544e8a1c795f7b513'  // Baths
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
     * Fetch open deals containing the 'Leading RE' option in the 'Additional Portals' custom field
     */
    protected function fetchDeals()
    {
        $deals = [];
        $start = 0;
        $limit = 100;
        $moreItemsInCollection = true;

        while ($moreItemsInCollection) {
            try {
                $response = Http::get("{$this->apiUrl}deals", [
                    'api_token' => $this->apiToken,
                    'status' => 'open',
                    'start' => $start,
                    'limit' => $limit,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (!empty($data['data'])) {
                        foreach ($data['data'] as $deal) {
                            $portalsField = '7d9713733d04c47f3562ddb95ffb73c79411d6f2'; // Additional Portals
                            
                            // Check if the custom field contains the option ID 1343 (Leading RE)
                            if (isset($deal[$portalsField])) {
                                $selectedPortals = explode(',', $deal[$portalsField]);
                                if (in_array('1343', $selectedPortals)) {
                                    $deals[] = $deal;
                                }
                            }
                        }
                    }

                    $moreItemsInCollection = $data['additional_data']['pagination']['more_items_in_collection'] ?? false;
                    $start = $data['additional_data']['pagination']['next_start'] ?? ($start + $limit);
                } else {
                    Log::error("LeadingRE Sync: Failed to fetch deals from Pipedrive", ['response' => $response->body()]);
                    $moreItemsInCollection = false;
                }
            } catch (\Exception $e) {
                Log::error("LeadingRE Sync: Exception when fetching deals", ['error' => $e->getMessage()]);
                $moreItemsInCollection = false;
            }
        }

        return $deals;
    }

    /**
     * Generate the XML file using XMLWriter
     */
    protected function createXmlFile($deals)
    {
        $directory = 'public/feeds';
        $fileName = 'test_leadingre.xml';
        
        // Ensure directory exists in storage/app/public/feeds
        if (!Storage::disk('local')->exists($directory)) {
            Storage::disk('local')->makeDirectory($directory);
        }

        $fullPath = storage_path('app/' . $directory . '/' . $fileName);

        $xml = new XMLWriter();
        $xml->openURI($fullPath);
        $xml->startDocument('1.0', 'UTF-8');
        $xml->setIndent(true);

        $xml->startElement('Data');

        // Offices Section
        $xml->startElement('Offices');
            $xml->startElement('Office');
                $xml->writeElement('OfficeKey', 'OFFICE-1');
                $xml->writeElement('OfficeId', 'OFFICE-1');
                $xml->writeElement('Name', 'Savoir Prive Properties');
                $xml->writeElement('OfficeAddress1', 'Office 502 A, Building Emaar Business Park');
                $xml->writeElement('OfficeCity', 'Dubai');
                $xml->writeElement('OfficeCountry', 'ARE');
            $xml->endElement(); // Office
        $xml->endElement(); // Offices

        // Prepare unique agents from deals
        $uniqueAgents = [];
        foreach ($deals as $deal) {
            $agentId = $deal['user_id']['id'] ?? 'UNKNOWN';
            if (!isset($uniqueAgents[$agentId])) {
                $agentName = $deal['user_id']['name'] ?? 'Unknown Agent';
                $nameParts = explode(' ', $agentName, 2);
                $uniqueAgents[$agentId] = [
                    'id' => $agentId,
                    'first_name' => $nameParts[0],
                    'last_name' => $nameParts[1] ?? '',
                ];
            }
        }

        // Members Section
        $xml->startElement('Members');
        foreach ($uniqueAgents as $agent) {
            $xml->startElement('Member');
                $xml->writeElement('MemberKey', $agent['id']);
                $xml->writeElement('MemberId', $agent['id']);
                $xml->writeElement('FirstName', $agent['first_name']);
                $xml->writeElement('LastName', $agent['last_name']);
                $xml->writeElement('OfficeKey', 'OFFICE-1');
            $xml->endElement(); // Member
        }
        $xml->endElement(); // Members

        // Properties Section
        $xml->startElement('Properties');
        foreach ($deals as $deal) {
            $xml->startElement('Property');
            
                $xml->writeElement('ListingKey', $deal['id']);
                $xml->writeElement('ListingId', $deal['id']);
                
                $listPrice = $deal['95327613fa6b2ddc2473aef1395f9626a5416b16'] ?? '';
                $xml->writeElement('ListPrice', $listPrice);
                
                $xml->writeElement('Currency', 'AED');
                $xml->writeElement('Country', 'ARE');
                
                $propertyTypeId = $deal['1da5fc3b6713a605fa147077db49064ae9493df6'] ?? '';
                $propertyTypeLabel = $this->fieldMappings['1da5fc3b6713a605fa147077db49064ae9493df6'][$propertyTypeId] ?? $propertyTypeId;
                $xml->writeElement('PropertyType', $propertyTypeLabel);
                
                $bedId = $deal['af1f61eb5b7dcb81884f97e42ea331041e44828e'] ?? '';
                $bedLabel = $this->fieldMappings['af1f61eb5b7dcb81884f97e42ea331041e44828e'][$bedId] ?? '';
                $cleanBedLabel = trim(preg_replace('/[^0-9]/', '', $bedLabel));
                if ($bedLabel === 'Studio' || $cleanBedLabel === '') {
                    $cleanBedLabel = '0';
                }
                $xml->writeElement('BedroomsTotal', $cleanBedLabel);
                
                $bathId = $deal['8abbf4a2a68242278a05332544e8a1c795f7b513'] ?? '';
                $bathLabel = $this->fieldMappings['8abbf4a2a68242278a05332544e8a1c795f7b513'][$bathId] ?? '';
                $cleanBathLabel = trim(preg_replace('/[^0-9]/', '', $bathLabel));
                if ($cleanBathLabel === '') {
                    $cleanBathLabel = '0';
                }
                $xml->writeElement('BathroomsFull', $cleanBathLabel);
                
                $remarks = $deal['f5c3a84e2c36b5d09a83808a9b189c7d25b2424a'] ?? '';
                $xml->startElement('PublicRemarks');
                $xml->writeCdata($remarks);
                $xml->endElement(); // PublicRemarks
                
                $xml->writeElement('StandardStatus', 'Active');
                
                // Link to the dummy office and dynamic member
                $xml->writeElement('OfficeKey', 'OFFICE-1');
                $xml->writeElement('MemberKey', $deal['user_id']['id'] ?? 'UNKNOWN');

            $xml->endElement(); // Property
        }
        $xml->endElement(); // Properties

        // Medias Section
        $xml->startElement('Medias');
        foreach ($deals as $deal) {
            $mediaField = 'bcd9ca9385431ef1eca4ff8be5bb75b2bf46511f';
            $mediaUrls = $deal[$mediaField] ?? '';
            
            if (!empty($mediaUrls)) {
                $urls = preg_split('/\r\n|\r|\n/', $mediaUrls);
                $urls = array_filter(array_map('trim', $urls));
                
                $order = 1;
                foreach ($urls as $url) {
                    if (empty($url)) continue;

                    $xml->startElement('Media');
                        $xml->writeElement('ResourceRecordID', $deal['id']); 
                        $xml->writeElement('MediaURL', $url);
                        $xml->writeElement('Order', $order);
                    $xml->endElement(); // Media
                    
                    $order++;
                }
            }
        }
        $xml->endElement(); // Medias

        $xml->endElement(); // Data
        
        $xml->endDocument();
        $xml->flush();

        return $fullPath;
    }
}
