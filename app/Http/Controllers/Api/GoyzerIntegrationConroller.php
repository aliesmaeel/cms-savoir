<?php

namespace App\Http\Controllers\Api;
ini_set('memory_limit', '-1');

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\GoyzerProperty;
use App\Models\NewProperty;
use App\Models\SubCommunity;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use SimpleXMLElement;

class GoyzerIntegrationConroller extends Controller
{
    public function get_goyzer_properties_for_sale()
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/soap+xml; charset=utf-8',
            'SOAPAction' => 'http://webapi.goyzer.com/SalesListings'
        ];
        $body = '<?xml version="1.0" encoding="utf-8"?>
        <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
            <soap12:Body>
                <SalesListings xmlns="http://webapi.goyzer.com/">
                    <AccessCode>S@voir_5023</AccessCode>
                    <GroupCode>5023</GroupCode>
                    <Bedrooms></Bedrooms>
                    <StartPriceRange></StartPriceRange>
                    <EndPriceRange></EndPriceRange>
                    <CategoryID></CategoryID>
                    <SpecialProjects></SpecialProjects>
                    <CountryID></CountryID>
                    <StateID></StateID>
                    <GoogleCoordinates>string</GoogleCoordinates>
                    <CommunityID></CommunityID>
                    <DistrictID></DistrictID>
                    <FloorAreaMin></FloorAreaMin>
                    <FloorAreaMax></FloorAreaMax>
                    <UnitCategory></UnitCategory>
                    <UnitID></UnitID>
                    <BedroomsMax></BedroomsMax>
                    <PropertyID></PropertyID>
                    <ReadyNow></ReadyNow>
                    <PageIndex></PageIndex>
                </SalesListings>
            </soap12:Body>
        </soap12:Envelope>';
        $request = new Psr7Request('POST', 'https://webapi.goyzer.com/Company.asmx', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $res->getBody()->getContents());
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soapBody')[0];
        $array = json_decode(json_encode((array)$body), TRUE);

        $properties = $array["SalesListingsResponse"]["SalesListingsResult"]["ArrayOfUnitDTO"]['UnitDTO'];



        $communities = Community::pluck('name', 'id')->toArray();
        $sub_communities = SubCommunity::pluck('name', 'id')->toArray();
        $propertiesExistsInOurDb=NewProperty::where('offering_type','RS')->get();

        $apiReferenceNumbers =collect($properties)->pluck('RefNo')->toArray();

        foreach ($propertiesExistsInOurDb as $property) {
            if (!in_array($property->reference_number, $apiReferenceNumbers)) {
                $property->delete();
            }
        }

        foreach ($properties as $key => $property) {
            $isNew = $this->create_new_property($property, $communities, $sub_communities);
            if ($isNew) {
                $goyzer_property = $this->create_goyzer_property($property);
            }
        }

    }
    public function create_goyzer_property($property)
    {
        try {
            if (array_key_exists('DocumentWeb', $property) && $property['DocumentWeb']) {
                $DocumentWeb = $property['DocumentWeb'];
            } else {
                $DocumentWeb = null;
            }
            if (array_key_exists('SellPrice', $property) && $property['SellPrice']) {
                $price = $property['SellPrice'];
            } elseif (array_key_exists('Rent', $property) && $property['Rent']) {
                $price = $property['Rent'];
            } else {
                $price = null;
            }
            if (array_key_exists('ListingType', $property) && $property['ListingType']) {
                $ListingType = $property['ListingType'];
            } else {
                $ListingType = null;
            }
            if ($property['ProGooglecoordinates']) {

                $location = explode(',', $property['ProGooglecoordinates']);
                $lat = $location ? $location[0] : '';
                $lng = $location ? $location[1] : '';
            } else {
                $lat = '';
                $lng = '';
            }

            GoyzerProperty::create([
                'category' => $property['Category'] ? $property['Category'] : null,
                'code' => $property['code'] ? $property['code'] : null,
                'status' => $property['Status']  ? $property['Status'] : null,
                'ref_no' => $property['RefNo']  ? $property['RefNo'] : null,
                'community' => $property['Community'] ? $property['Community'] : null,
                'property_name' => $property['PropertyName'] ? $property['PropertyName'] : null,
                'built_up_area' => $property['BuiltupArea'] ? $property['BuiltupArea'] : null,
                'no_of_floors' => $property['FloorNo'] ? $property['FloorNo'] : null,
                'handover_date' => $property['HandoverDate'] ? $property['HandoverDate'] : null,
                'agent' => $property['Agent']  ? $property['Agent'] : null,
                'contact_number' => $property['ContactNumber'] ? $property['ContactNumber'] : null,
                'description_en' => $this->transform_description($property['Remarks']),
                'sub_community' => $property['SubCommunity'] ? $property['SubCommunity'] : null,
                'property_over_view' => $property['PropertyOverview'] ? $property['PropertyOverview'] : null,
                'locala_area_amenities_desc' => $property['LocalAreaAmenitiesDesc'] ? $property['LocalAreaAmenitiesDesc'] : null,
                'country_id' => $property['CountryID'] ? $property['CountryID'] : null,
                'state_id' => $property['StateID'] ? $property['StateID'] : null,
                'city_id' => $property['CityID'] ? $property['CityID'] : null,
                'district_id' => $property['DistrictID'] ? $property['DistrictID'] : null,
                'community_id' => $property['CommunityID'] ? $property['CommunityID'] : null,
                'sub_community_id' => $property['SubCommunityID'] ? $property['SubCommunityID'] : null,
                'agent_id' => $property['AgentID'] ? $property['AgentID'] : null,
                'city_name' => $property['CityName'] ? $property['CityName'] : null,
                'lat' => $lat,
                'lng' => $lng,
                'Images' => $property['Images'] ? json_encode($property['Images']) : null,
                'page_index' => $property['PageIndex'] ? $property['PageIndex'] : null,
                'count' => $property['Count'] ? $property['Count'] : null,
                'bedrooms' => $property['Bedrooms'] ? $property['Bedrooms'] : 0,
                'primary_unit_view' => $property['PrimaryUnitView'] ? $property['PrimaryUnitView'] : null,
                'secondary_unit_view' => $property['SecondaryUnitView'] ? $property['SecondaryUnitView'] : null,
                'unitmodel' => $property['UnitModel'] ? $property['UnitModel'] : null,
                'country_name' => $property['CountryName'] ? $property['CountryName'] : null,
                'state_name' => $property['StateName'] ? $property['StateName'] : null,
                'district_name' => $property['DistrictName'] ? $property['DistrictName'] : null,
                'bathrooms' => $property['NoOfBathrooms'] ? $property['NoOfBathrooms'] : null,
                'document_web' => $DocumentWeb,
                'sell_price' => $price,
                'subtype' => $property['SubType'] ? $property['SubType'] : null,
                'parking' => $property['Parking'] ? $property['Parking'] : null,
                'financing_company' => $property['FinancingCompany'] ? $property['FinancingCompany'] : null,
                'marketing_usp' => $property['MarketingUsp'] ? $property['MarketingUsp'] : null,
                'property_ownership_desc' => $property['PropertyOwnershipDesc'] ? $property['PropertyOwnershipDesc'] : null,
                'retunit_category' => $property['RetUnitCategory'] ? $property['RetUnitCategory'] : null,
                'property_id' => $property['PropertyID'] ? $property['PropertyID'] : null,
                'PDF_brochure_link' => $property['PDFBrochureLink'] ? $property['PDFBrochureLink'] : null,
                'agent_rera_no' => $property['AgentReraNo'] ? $property['AgentReraNo'] : null,
                'BdmPkg' => $property['BdmPkg'] ? $property['BdmPkg'] : null,
                'salesman_email' => $property['SalesmanEmail'] ? $property['SalesmanEmail'] : null,
                'last_updated' => $property['LastUpdated'] ? $property['LastUpdated'] : null,
                'Listing_date' => $property['ListingDate'] ? $property['ListingDate'] : null,
                'expiry_date' => $property['ExpiryDate'] ? $property['ExpiryDate'] : null,
                'recommended_propertie' => $property['RecommendedProperties'] ? $property['RecommendedProperties'] : null,
                'marketing_title' => $property['MarketingTitle'] ? $property['MarketingTitle'] : null,
                'marketing_options' => $property['MarketingOptions'] ? $property['MarketingOptions'] : null,
                'agent_photo' => $property['AgentPhoto'] ? $property['AgentPhoto'] : null,
                'arabic_title' => $property['ArabicTitle'] ? $property['ArabicTitle'] : null,
                'arabic_description' => $property['ArabicDescription'] ? $property['ArabicDescription'] : null,
                'mandate' => $property['Mandate'] ? $property['Mandate'] : null,
                'currency_abr' => $property['CurrencyAbr'] ? $property['CurrencyAbr'] : null,
                'area_measurement' => $property['AreaMeasurement'] ? $property['AreaMeasurement'] : null,
                'rera_str_no' => $property['ReraStrNo'] ? $property['ReraStrNo'] : null,
                'furnish_status' => $property['Furnish_status'] ? $property['Furnish_status'] : null,
                'listing_type' => $ListingType,
                'fitting_fixtures' => $property['FittingFixtures'] ? json_encode($property['FittingFixtures']) : null,
                'documents' => $property['Documents'] ? $property['Documents'] : null,
                'offering_type' => $property['OfferingType'] ? $property['OfferingType'] : null,
                'custom_fields' => $property['CustomFields'] ? $property['CustomFields'] : null,
                'featured' => 0 ,
                'photo' => (array_key_exists('Images', $property) && array_key_exists('Image', $property['Images']) && count($property['Images']['Image']) > 0) ? $property['Images']['Image'][0]['ImageURL'] : null,

            ]);
        } catch (\Throwable $th) {
            Log::channel('fetching_properties')->alert($th->getMessage());
        }
    }

    public function transform_description($description)
    {
        $data = preg_replace('/<!\[CDATA\[(.*?)\]\]>/s', '$1', $description);

// Convert line breaks to `<br>` for HTML formatting
        $data = nl2br($data);

// Convert property details into an unordered list
        $data = preg_replace('/- (.*?)(<br\s*\/?>)/', '<li>$1</li>$2', $data);

// Wrap property details in `<ul>`
        $data = preg_replace('/Property Details:<br\s*\/?>/', 'Property Details:<ul>', $data);
        $data .= '</ul>';

// Wrap entire content in `<p>` tags
        $data = "<div>$data</div>";
        return $data;
    }


    public function create_new_property($property, $communities, $sub_communities)
    {
        $transofrmedDesc=$this->transform_description($property['Remarks']);



        try {
            if (array_key_exists('ListingType', $property) && $property['ListingType']) {
                if ($property['ListingType'] == 'Off Plan') {
                    $completion_status = 'off_plan';
                } else {
                    $completion_status = 'completed';
                }
            } else {
                $completion_status = 'completed';
            }
            $user_id = $this->get_user($property['SalesmanEmail'], $property['Agent']);
            $community_id = $this->get_community($property, $communities);
            $sub_community_id = $this->get_sub_community($property, $communities, $sub_communities);
            $slug = $this->slugify($property['PropertyName']);
            if ($property['ProGooglecoordinates']) {

                $location = explode(',', $property['ProGooglecoordinates']);
                $lat = $location ? $location[0] : '';
                $lng = $location ? $location[1] : '';
            } else {
                $lat = '';
                $lng = '';
            }

            $property_type = $this->property_types($property['Category']);

            if (array_key_exists('SellPrice', $property) && $property['SellPrice']) {
                $price = $property['SellPrice'];
            } elseif (array_key_exists('Rent', $property) && $property['Rent']) {
                $price = $property['Rent'];
            } else {
                $price = null;
            }

            $newproperty = NewProperty::firstOrCreate([
                'reference_number' => $property['RefNo'] ? $property['RefNo'] : null,
                'offering_type' => $property['OfferingType'] ? $property['OfferingType'] : null,
            ], [
                'reference_number' => $property['RefNo'] ? $property['RefNo'] : null,
                'permit_number' => '_',
                'property_type' => $property_type,
                'offering_type' => $property['OfferingType'] ? $property['OfferingType'] : null,
                'price' => $price,
                'city' => $property['CityName'] ? $property['CityName'] : null,
                'title_en' => $property['MarketingTitle'] ? $property['MarketingTitle'] : null,
                'description_en' => $this->transform_description($property['Remarks']),
                'size' => $property['BuiltupArea'] ? $property['BuiltupArea'] : null,
                'currency' => $property['CurrencyAbr'] ? $property['CurrencyAbr'] : null,
                'bedroom' => $property['Bedrooms']  ? $property['Bedrooms'] : 0,
                'bathroom' => $property['NoOfBathrooms'] ? $property['NoOfBathrooms'] : null,
                'community' => ($community_id) ? $community_id : null,
                'sub_community' => ($sub_community_id) ? $sub_community_id : null,
                'slug' => $slug,
                'parking' => $property['Parking'] ? $property['Parking'] : null,
                'property_name' => $property['PropertyName'] ? $property['PropertyName'] : null,
                'property_status' => 'Live',
                'completion_status' => $completion_status,
                'lng' => $lat,
                'lat' => $lng,
                'country' => $property['CountryName'] ? $property['CountryName'] : null,
                'user_id' => $user_id,
                'goyzer' => true,
                'featured' => 0,
                'photo' => (array_key_exists('Images', $property) && array_key_exists('Image', $property['Images']) && count($property['Images']['Image']) > 0) ? $property['Images']['Image'][0]['ImageURL'] : null,
            ]);

            $newproperty->update([
                'offering_type' => $property['OfferingType'] ? $property['OfferingType'] : null,
                'reference_number' => $property['RefNo'] ? $property['RefNo'] : null,
                'permit_number' => '_',
                'property_type' => $property_type,
                'price' => $price,
                'city' => $property['CityName'] ? $property['CityName'] : null,
                'title_en' => $property['MarketingTitle'] ? $property['MarketingTitle'] : null,
                'size' => $property['BuiltupArea'] ? $property['BuiltupArea'] : null,
                'currency' => $property['CurrencyAbr'] ? $property['CurrencyAbr'] : null,
                'description_en' =>$this->transform_description($property['Remarks']),
                'bedroom' => $property['Bedrooms']  ? $property['Bedrooms'] : 0,
                'bathroom' => $property['NoOfBathrooms'] ? $property['NoOfBathrooms'] : null,
                'community' => ($community_id) ? $community_id : null,
                'sub_community' => ($sub_community_id) ? $sub_community_id : null,
                'slug' => $slug,
                'parking' => $property['Parking'] ? $property['Parking'] : null,
                'property_name' => $property['PropertyName'] ? $property['PropertyName'] : null,
                'property_status' => 'Live',
                'completion_status' => $completion_status,
                'country' => $property['CountryName'] ? $property['CountryName'] : null,
                'goyzer' => true,
                'photo' => (array_key_exists('Images', $property) && array_key_exists('Image', $property['Images']) && count($property['Images']['Image']) > 0) ? $property['Images']['Image'][0]['ImageURL'] : null,

            ]);

            $fixtures = $property['FittingFixtures']['FittingFixture'];
            $amenityNames = array_column($fixtures, 'Name');

            $amenities = implode(', ', $amenityNames);

            $newproperty->update([
                'features' => $amenities,
            ]);

            $cloudName = "djd3y5gzw";

                $property_images = is_array($property['Images']) ? $property['Images'] : json_decode($property['Images']);
                if (array_key_exists('Image', $property_images) && count($property_images['Image']) > 0) {
                    foreach ($property_images['Image'] as $link) {
                        $originalUrl = $link['ImageURL'];
                        $webpUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                        DB::table('property_images')->updateOrInsert(
                            [
                                'url' => $webpUrl,
                                'newProperty_id' => $newproperty->id,
                            ],
                            [
                                'is_external_image' => true,
                                'updated_at' => Carbon::now(),
                                'created_at' => Carbon::now(),
                            ]
                        );
                    }
                }
                $photo =$newproperty->photo;
                $webpUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($photo);
                $newproperty->update([
                    'photo' => $webpUrl,
                ]);


        } catch (\Throwable $th) {
            Log::channel('fetching_properties')->alert($th->getMessage());
        }
    }

    public function slugify($text)
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'utf-8//IGNORE', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate divider
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }


    public function get_user($email, $name)
    {
        $user = User::firstOrCreate(
            [
                'email' => $email
            ],
            [
                'name' => $name,
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Hash::make('123456'),
                'role_id' => '3',
                'is_external_agent' => true,
            ]
        );
        return $user->id;
    }
    public function get_community($property, $communities)
    {
        $id = array_search($property['Community'], $communities);
        if (!$id) {
            $community = Community::firstOrCreate(
                [
                    'name' => $property['Community'],
                    'community_id' => $property['CommunityID'],
                ],
                [
                    'name' => $property['Community'],
                    'community_id' => $property['CommunityID'],
                ]
            );
            $id = $community->id;
        }
        return $id;
    }
    public function get_sub_community($property, $communities, $sub_communities)
    {
        $id = array_search($property['SubCommunity'], $sub_communities);
        if (!$id) {
            $community = $this->get_community($property, $communities);
            $subcommunity = SubCommunity::firstOrCreate(
                [
                    'name' => $property['Community'],
                    'community_id' => $community,
                ],
                [
                    'name' => $property['Community'],
                    'community_id' => $community,
                ]
            );
            $id = $subcommunity->id;
        }
        return $id;
    }

    public function property_types($value)
    {
        $property_types = [
            "AP" => "Apartment",
            "BU" => "Bulk Units",
            "BW" => "Bungalow",
            "CD" => "Compound",
            "DX" => "Duplex",
            "FA" => "Factory",
            "FM" => "Farm",
            "FF" => "Full Floor",
            "HA" => "Hotel Apartment",
            "HF" => "Half Floor",
            "LC" => "Labor Camp",
            "LP" => "Land/Plot",
            "OF" => "Office Space",
            "BC" => "Business Centre",
            "PH" => "Penthouse",
            "RE" => "Retail",
            "RT" => "Restaurant",
            "SA" => "Staff Accommodation",
            "SH" => "Shop",
            "SR" => "Showroom",
            "CW" => "Co-working Space",
            "ST" => "Storage",
            "TH" => "Townhouse",
            "VH" => "Villa/House",
            "WB" => "Whole Building",
            "WH" => "Warehouse",
            "VI" => "Villa"
        ];
        $key = array_search($value, $property_types);
        return  is_string($key) ? $key : $value;
    }
     public function get_goyzer_properties_for_rent()
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'text/xml',
            'SOAPAction' => 'http://webapi.goyzer.com/RentListings'
        ];
        $body = '<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <RentListings xmlns="http://webapi.goyzer.com/">
              <AccessCode>S@voir_5023</AccessCode>
              <GroupCode>5023</GroupCode>
              <PropertyType></PropertyType>
              <Bedrooms></Bedrooms>
              <StartPriceRange></StartPriceRange>
              <EndPriceRange></EndPriceRange>
              <categoryID></categoryID>
              <CountryID></CountryID>
              <StateID></StateID>
              <CommunityID></CommunityID>
              <FloorAreaMin></FloorAreaMin>
              <FloorAreaMax></FloorAreaMax>
              <UnitCategory></UnitCategory>
              <UnitID></UnitID>
              <BedroomsMax></BedroomsMax>
              <PropertyID></PropertyID>
              <ReadyNow></ReadyNow>
              <PageIndex></PageIndex>
            </RentListings>
          </soap:Body>
        </soap:Envelope>';
        $request = new Psr7Request('POST', 'https://webapi.goyzer.com/Company.asmx', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $res->getBody()->getContents());
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//soapBody')[0];
        $array = json_decode(json_encode((array)$body), TRUE);
        $properties = $array["RentListingsResponse"]["RentListingsResult"]["ArrayOfUnitDTO"]['UnitDTO'];
        $communities = Community::pluck('name', 'id')->toArray();
        $sub_communities = SubCommunity::pluck('name', 'id')->toArray();

        $propertiesExistsInOurDb=NewProperty::where('offering_type','RR')->get();
        $apiReferenceNumbers =collect($properties)->pluck('RefNo')->toArray();

        foreach ($propertiesExistsInOurDb as $property) {
            if (!in_array($property->reference_number, $apiReferenceNumbers)) {
                $property->delete();
            }
        }

        foreach ($properties as $key => $property) {
            $isNew = $this->create_new_property($property, $communities, $sub_communities);
            if ($isNew) {
                $goyzer_property = $this->create_goyzer_property($property);
            }
        }
    }
}
