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

        $xml->startElement('Data');

        // --- 1. <Offices> ---
        $xml->startElement('Offices');
        $xml->startElement('Office');
        $xml->writeElement('OfficeKey', 'OFFICE-SAVOIR');
        $xml->writeElement('OfficeStatus', 'Active');
        $xml->writeElement('OfficeName', 'Savoir Privé Properties');
        $xml->writeElement('OfficeAddress1', 'Office 502 A, Building Emaar Business Park, Barsha Heights');
        $xml->writeElement('OfficeCity', 'Dubai');
        $xml->writeElement('OfficeCountry', 'ARE');
        $xml->writeElement('OfficePhone', '+971 4 568 9700');
        $xml->writeElement('OfficeEmail', 'info@savoirproperties.com');
        $xml->endElement(); // Office
        $xml->endElement(); // Offices

        // --- 2. <Members> ---
        $xml->startElement('Members');
        $agentsAdded = [];
        foreach ($deals as $deal) {
            $agentId = $deal['user_id']['id'] ?? '';
            if (empty($agentId) || isset($agentsAdded[$agentId])) {
                continue;
            }
            $agentName = $deal['user_id']['name'] ?? 'Unknown';
            $agentEmail = $deal['user_id']['email'] ?? '';
            $agentPhone = $deal['user_id']['phone'] ?? '';
            
            $nameParts = explode(' ', $agentName, 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            $xml->startElement('Member');
            $xml->writeElement('MemberKey', 'AGENT-' . $agentId);
            $xml->writeElement('OfficeKey', 'OFFICE-SAVOIR');
            $xml->writeElement('MemberLastName', $lastName);
            $xml->writeElement('MemberFirstName', $firstName);
            $xml->writeElement('MemberStatus', 'Active');
            $xml->writeElement('MemberMobilePhone', $agentPhone);
            $xml->writeElement('MemberEmail', $agentEmail);
            $xml->endElement(); // Member
            $agentsAdded[$agentId] = true;
        }
        $xml->endElement(); // Members

        // --- 3. <Properties> ---
        $xml->startElement('Properties');
        foreach ($deals as $deal) {
            $xml->startElement('Property');
            
            $listingId = $deal['id'];
            $refNo = $deal['c7d4db817f241ce7c70ee06bf930314ef6e20e95'] ?? $listingId;
            $agentId = $deal['user_id']['id'] ?? '';
            
            $categoryId = $deal['115128d46c1e368dd0680524bc13b3f60c988ca6'] ?? '';
            $isRent = in_array((string)$categoryId, ['1307', '1308']);
            $propertyType = $isRent ? 'Residential Lease' : 'Residential';
            
            $xml->writeElement('ListingKey', 'LISTING-' . $listingId);
            $xml->writeElement('ListAgentKey', empty($agentId) ? '' : 'AGENT-' . $agentId);
            $xml->writeElement('ListOfficeKey', 'OFFICE-SAVOIR');
            $xml->writeElement('ListingId', $refNo);
            $xml->writeElement('PropertyType', $propertyType);
            
            // PropertySubType
            $propertyTypeId = $deal['1da5fc3b6713a605fa147077db49064ae9493df6'] ?? '';
            $propertyTypeLabel = $this->fieldMappings['1da5fc3b6713a605fa147077db49064ae9493df6'][$propertyTypeId] ?? $propertyTypeId;
            $xml->writeElement('PropertySubType', $propertyTypeLabel);
            
            // Location
            $localityId = $deal['ab382a3a8713527be729a7dd0221cac825e48b76'] ?? '';
            $localityLabel = $this->fieldMappings['ab382a3a8713527be729a7dd0221cac825e48b76'][$localityId] ?? $localityId;
            $xml->writeElement('StreetName', $localityLabel);
            $xml->writeElement('City', 'Dubai');
            $xml->writeElement('Country', 'ARE');
            
            // Price & Currency
            $price = $deal['95327613fa6b2ddc2473aef1395f9626a5416b16'] ?? '';
            $xml->writeElement('ListPrice', $price);
            $xml->writeElement('Currency', 'AED');
            
            // Public Remarks
            $description = $deal['f5c3a84e2c36b5d09a83808a9b189c7d25b2424a'] ?? '';
            $xml->startElement('PublicRemarks');
            $xml->writeCdata($description);
            $xml->endElement();
            
            // Beds & Baths
            $bedId = $deal['af1f61eb5b7dcb81884f97e42ea331041e44828e'] ?? '';
            $bedLabel = $this->fieldMappings['af1f61eb5b7dcb81884f97e42ea331041e44828e'][$bedId] ?? '';
            $cleanBedLabel = trim(preg_replace('/[^0-9]/', '', $bedLabel));
            if ($bedLabel === 'Studio') $cleanBedLabel = '0';
            $xml->writeElement('BedroomsTotal', $cleanBedLabel);
            
            $bathId = $deal['8abbf4a2a68242278a05332544e8a1c795f7b513'] ?? '';
            $bathLabel = $this->fieldMappings['8abbf4a2a68242278a05332544e8a1c795f7b513'][$bathId] ?? '';
            $cleanBathLabel = trim(preg_replace('/[^0-9]/', '', $bathLabel));
            $xml->writeElement('BathroomsFull', $cleanBathLabel);
            
            // Status
            $xml->writeElement('StandardStatus', 'Active');
            
            // Size
            $size = $deal['90d285f55be47b4a173ea65f73406bcbec2366b5'] ?? '';
            $xml->writeElement('LivingArea', $size);
            $xml->writeElement('LivingAreaUnits', 'Square Feet');
            
            $xml->writeElement('InternetAddressDisplayYN', '1');
            $xml->writeElement('InternetPriceDisplayYN', '1');
            
            $xml->endElement(); // Property
        }
        $xml->endElement(); // Properties

        // --- 4. <Medias> ---
        $xml->startElement('Medias');
        foreach ($deals as $deal) {
            $listingId = $deal['id'];
            $mediaField = 'bcd9ca9385431ef1eca4ff8be5bb75b2bf46511f';
            $mediaUrls = $deal[$mediaField] ?? '';
            
            if (!empty($mediaUrls)) {
                $urls = preg_split('/\r\n|\r|\n/', $mediaUrls);
                $urls = array_filter(array_map('trim', $urls));
                $order = 1;
                foreach ($urls as $url) {
                    if (empty($url)) continue;
                    $xml->startElement('Media');
                    $xml->writeElement('MediaKey', 'LISTING-' . $listingId . '-PHOTO-' . $order);
                    $xml->writeElement('Order', $order);
                    $xml->writeElement('MediaCategory', 'Photo');
                    $xml->writeElement('MediaURL', $url);
                    $xml->writeElement('ResourceName', 'Property');
                    $xml->writeElement('ResourceRecordID', 'LISTING-' . $listingId);
                    $xml->endElement(); // Media
                    $order++;
                }
            }
        }
        $xml->endElement(); // Medias
        
        $xml->endDocument();
        $xml->flush();

        return [
            'file_path' => $fullPath,
            'total_deals' => count($deals)
        ];
    }
}
