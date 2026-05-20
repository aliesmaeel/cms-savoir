<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class PropertyXmlController extends Controller
{
    public function generateXml()
    {
        // 1. Setup Limits
        set_time_limit(900);
        ini_set('memory_limit', '1024M');

        // 2. API Credentials
        $apiKey = 'oqwBE.kDdBGOU7HyocVo1CHDrOhYL7qGk17C6t7b';
        $apiSecret = 'DKkjTaTwwWdrrX7NHVfOwWadryr3HyY7';

        // 3. Get Token
        $authResponse = Http::post('https://atlas.propertyfinder.com/v1/auth/token', [
            'apiKey' => $apiKey,
            'apiSecret' => $apiSecret
        ]);

        $token = $authResponse->json()['accessToken'] ?? null;
        if (!$token) return "Auth Failed. Please check API keys.";

        // 4. Fetch Agents Map
        $agentsResp = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/users?pageSize=100");
        $agentsList = [];
        foreach (($agentsResp->json()['data'] ?? []) as $user) {
            $pId = $user['publicProfile']['id'] ?? null;
            if ($pId) {
                $agentsList[$pId] = [
                    'name' => trim(($user['firstName'] ?? '') . ' ' . ($user['lastName'] ?? '')),
                    'email' => $user['email'] ?? '',
                    'phone' => $user['mobile'] ?? '',
                    'photo' => $user['publicProfile']['imageVariants']['large']['default'] ?? ''
                ];
            }
        }

        // 5. Fetch All Listings (Pagination)
        $allResults = [];
        $page = 1;
        do {
            $listingResp = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/listings", [
                'page' => $page,
                'pageSize' => 100
            ]);
            $data = $listingResp->json();
            if (empty($data['results'])) break;
            $allResults = array_merge($allResults, $data['results']);
            $totalPages = $data['pagination']['totalPages'] ?? 1;
            $page++;
        } while ($page <= $totalPages);

        // 6. Build XML String
        $xml = '<?xml version="1.0" encoding="utf-8"?><rss><Properties>';
        
        foreach ($allResults as $item) {
            // Filters
            $stage = strtolower($item['state']['stage'] ?? '');
            $type = strtolower($item['state']['type'] ?? '');
            if ($stage !== 'live' || $type === 'live_changes_pending_approval') continue;

            // Fetch Location Tree (Hierarchy) - IMPORTANT FIX
            $locationData = $this->getLocationTree($item['location']['id'] ?? null, $token);
            $city = 'Dubai'; $locality = ''; $subLocality = ''; $tower = '';
            if ($locationData && isset($locationData['tree'])) {
                foreach ($locationData['tree'] as $node) {
                    if ($node['type'] === 'CITY') $city = $node['name'];
                    if ($node['type'] === 'COMMUNITY') $locality = $node['name'];
                    if ($node['type'] === 'SUBCOMMUNITY') $subLocality = $node['name'];
                    if ($node['type'] === 'TOWER') $tower = $node['name'];
                }
            }

            $agent = $agentsList[$item['assignedTo']['id'] ?? null] ?? ['name' => 'Savoir Team', 'phone' => '', 'email' => 'info@savoirproperties.com', 'photo' => ''];
            $purpose = (strtolower($item['price']['type'] ?? '') === 'sale') ? 'Buy' : 'Rent';
            $furn = (strtolower($item['furnishingType'] ?? '') === 'furnished') ? 'Yes' : 'No';

            $xml .= "<Property>";
            
            // 1. Reference & Status
            $xml .= "<Property_Ref_No><![CDATA[{$item['reference']}]]></Property_Ref_No>";
            $xml .= "<Property_purpose><![CDATA[$purpose]]></Property_purpose>";
            $xml .= "<Property_Type><![CDATA[" . ucfirst($item['type'] ?? '') . "]]></Property_Type>";
            $xml .= "<Property_Status><![CDATA[live]]></Property_Status>";

            // 2. Location Tree (Missing in previous Controller)
            $xml .= "<City><![CDATA[$city]]></City>";
            $xml .= "<Locality><![CDATA[$locality]]></Locality>";
            $xml .= "<Sub_Locality><![CDATA[$subLocality]]></Sub_Locality>";
            $xml .= "<Tower_Name><![CDATA[$tower]]></Tower_Name>";

            // 3. Multi-language Title & Description (Fixed Arabic)
            $xml .= "<Property_Title><![CDATA[" . ($item['title']['en'] ?? '') . "]]></Property_Title>";
            $xml .= "<Property_Title_AR><![CDATA[" . ($item['title']['ar'] ?? '') . "]]></Property_Title_AR>";
            $xml .= "<Property_Description><![CDATA[" . nl2br($item['description']['en'] ?? '') . "]]></Property_Description>";
            $xml .= "<Property_Description_AR><![CDATA[" . nl2br($item['description']['ar'] ?? '') . "]]></Property_Description_AR>";

            // 4. Specs & Prices
            $xml .= "<Property_Size>" . round($item['size'] ?? 0) . "</Property_Size>";
            $xml .= "<Property_Size_Unit><![CDATA[SQFT]]></Property_Size_Unit>";
            
            $beds = (strtolower($item['bedrooms'] ?? '') === 'studio') ? 'Studio' : ($item['bedrooms'] ?? 0);
            $xml .= "<Bedrooms>$beds</Bedrooms>";
            $xml .= "<Bathroom>" . ($item['bathrooms'] ?? 0) . "</Bathroom>"; // Singular fixed
            
            $xml .= "<Price><![CDATA[" . ($item['price']['amounts']['yearly'] ?? $item['price']['amounts']['sale'] ?? 0) . "]]></Price>";
            $xml .= "<Furnished><![CDATA[$furn]]></Furnished>";
            $xml .= "<Off_Plan><![CDATA[" . (strtolower($item['projectStatus'] ?? '') === 'off_plan' ? 'Yes' : 'No') . "]]></Off_Plan>";
            
            if ($purpose === 'Rent') {
                $xml .= "<Rent_Frequency><![CDATA[Yearly]]></Rent_Frequency>";
            }

            // 5. Images
            $xml .= "<Images>";
            foreach (($item['media']['images'] ?? []) as $img) {
                $xml .= "<Image><![CDATA[{$img['original']['url']}]]></Image>";
            }
            $xml .= "</Images>";

            // 6. Videos (Missing in previous Controller)
            $xml .= "<Videos>";
            if (!empty($item['media']['videos']['default'])) {
                $xml .= "<Video><![CDATA[" . $item['media']['videos']['default'] . "]]></Video>";
            }
            $xml .= "</Videos>";

            // 7. Floor Plans (Missing in previous Controller)
            $xml .= "<Floor_Plans>";
            foreach (($item['media']['floorPlans'] ?? []) as $fp) {
                $xml .= "<Floor_Plan><![CDATA[{$fp['url']}]]></Floor_Plan>";
            }
            $xml .= "</Floor_Plans>";

            // 8. Dates & Permit (Missing in previous Controller)
            $xml .= "<Last_Updated><![CDATA[" . date('Y-m-d H:i:s', strtotime($item['updatedAt'])) . "]]></Last_Updated>";
            $xml .= "<Permit_Number><![CDATA[" . ($item['compliance']['listingAdvertisementNumber'] ?? '') . "]]></Permit_Number>";

            // 9. Agent Info
            $xml .= "<Listing_Agent><![CDATA[{$agent['name']}]]></Listing_Agent>";
            $xml .= "<Listing_Agent_Phone><![CDATA[{$agent['phone']}]]></Listing_Agent_Phone>";
            $xml .= "<Listing_Agent_Email><![CDATA[{$agent['email']}]]></Listing_Agent_Email>";
            $xml .= "<Listing_Agent_Photo><![CDATA[{$agent['photo']}]]></Listing_Agent_Photo>";

            // 10. Portals & Amenities (Features)
            $xml .= "<Features>";
            foreach (($item['amenities'] ?? []) as $amenity) {
                $xml .= "<Feature><![CDATA[" . str_replace('-', ' ', ucfirst($amenity)) . "]]></Feature>";
            }
            $xml .= "</Features>";

            $xml .= "<Portals><Portal>Bayut</Portal><Portal>dubizzle</Portal></Portals>";
            
            $xml .= "</Property>";
        }
        $xml .= "</Properties></rss>";

        // 7. Save to Public Folder
        File::put(public_path('BayutProperties.xml'), $xml);

        return "<h2>SUCCESS: XML file updated with ALL fields!</h2><p><a href='/BayutProperties.xml' target='_blank'>View XML File</a></p>";
    }

    // Helper to fetch Location Tree Hierarchy
    private function getLocationTree($locationId, $token) {
        if (!$locationId) return null;
        $response = Http::withToken($token)->get("https://atlas.propertyfinder.com/v1/locations?filter[id]=$locationId");
        return $response->json()['data'][0] ?? null;
    }
}