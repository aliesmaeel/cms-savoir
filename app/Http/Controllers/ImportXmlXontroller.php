<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewProperty;
use App\Models\FinderProperty;
use App\Models\EmiratesProperty;
use App\Models\PropertyImage;
use Exception;
use Throwable;

class ImportXmlXontroller extends Controller
{
    public function index(Request $req)
    {
        if ($req->isMethod("POST")) {

            $newPropertyString = file_get_contents(public_path('new7_matheo.xml'));
            $xmlObject = simplexml_load_string($newPropertyString);

            $json = json_encode($xmlObject);
            $phpDataArray = json_decode($json, true);

            if (count($phpDataArray['property'])) {

                $dataArray = array();
                foreach ($phpDataArray['property'] as $index => $data) {
                    if ($data['offering_type'] == 'RR') {
                        $price = $data['price']['yearly'];
                    } elseif ($data['offering_type'] == 'RS') {
                        $price = $data['price'];
                    }
                    $property = NewProperty::create([
                        "reference_number" => $data['reference_number']  ? $data['reference_number'] : "",
                        "permit_number" =>  $data['permit_number']  ? $data['permit_number'] : "",
                        "offering_type" => $data['offering_type']  ? $data['offering_type'] : "",
                        "property_type" => $data['property_type'] ? $data['property_type'] : "",
                        "price" => ($price)  ? $price : "",
                        "city" => $data['city'] ? $data['city'] : "",
                        "community" => $data['community']  ? $data['community'] : "",
                        "sub_community" => $data['sub_community'] ? $data['sub_community'] : "",
                        "title_en" =>  $data['title_en'] ? $data['title_en'] : "",
                        "title_ar" => empty(!$data['title_ar'])  ? $data['title_ar'] : "",
                        "description_en" => $data['description_en']  ? $data['description_en'] : "",
                        "description_ar" => empty(!$data['description_ar'])  ? $data['description_ar'] : "",
                        "private_amenities" => empty(!$data['private_amenities'])  ? $data['private_amenities'] : "",
                        "size" =>  $data['size']  ? $data['size'] : "",
                        "bedroom" =>  $data['bedroom']  ? $data['bedroom'] : "",
                        "bathroom" =>  $data['bathroom']  ? $data['bathroom'] : "",
                        "user_id" => empty(!$data['agent']['id'])  ? (int) $data['agent']['id'] : null,
                        "floor_plan" =>  $data['floor_plan']['url']['@attributes']['last_updated'] ? $data['floor_plan']['url']['@attributes']['last_updated'] : "",
                        "finder" => '1',
                        "emirates_estate" => '1',
                    ]);
                    $finder = FinderProperty::create([
                        "service_charge" => empty(!$data['service_charge'])  ? $data['service_charge'] : "",
                        "cheques" =>  $data['cheques']  ? $data['cheques'] : "",
                        "plot_size" => empty(!$data['plot_size']) ? $data['plot_size'] : "",
                        "developer" => empty(!$data['developer'])  ? $data['developer'] : "",
                        "build_year" => empty(!$data['build_year'])  ? $data['build_year'] : "",
                        "completion_status" => $data['completion_status']  ? $data['completion_status'] : "",
                        "floor" =>  $data['floor'] ? $data['floor'] : "",
                        "stories" => empty(!$data['stories'])  ? $data['stories'] : "",
                        "parking" => $data['parking']  ? $data['parking'] : "",
                        "furnished" => empty(!$data['furnished']) ? $data['furnished'] : "",
                        "view360" => empty(!$data['view360']) ? $data['view360'] : "",
                        "geopoints" => empty(!$data['geopoints'])  ? $data['geopoints'] : "",
                        "title_deed" => $data['title_deed'] ? $data['title_deed'] : "",
                        "availability_date" => empty(!$data['availability_date'])  ? $data['availability_date'] : "",
                        "property_name" =>  $data['property_name']  ? $data['property_name'] : "",
                        "newProperty_id" =>  $property->id,

                    ]);
                    $emirates = EmiratesProperty::create([
                        "service_charge" => empty(!$data['service_charge'])  ? $data['service_charge'] : "",
                        "cheques" =>  $data['cheques']  ? $data['cheques'] : "",
                        "plot_size" => empty(!$data['plot_size']) ? $data['plot_size'] : "",
                        "developer" => empty(!$data['developer'])  ? $data['developer'] : "",
                        "build_year" => empty(!$data['build_year'])  ? $data['build_year'] : "",
                        "completion_status" => $data['completion_status']  ? $data['completion_status'] : "",
                        "floor" =>  $data['floor'] ? $data['floor'] : "",
                        "stories" => empty(!$data['stories'])  ? $data['stories'] : "",
                        "parking" => $data['parking']  ? $data['parking'] : "",
                        "furnished" => empty(!$data['furnished']) ? $data['furnished'] : "",
                        "view360" => empty(!$data['view360']) ? $data['view360'] : "",
                        "geopoints" => empty(!$data['geopoints'])  ? $data['geopoints'] : "",
                        "title_deed" => $data['title_deed'] ? $data['title_deed'] : "",
                        "availability_date" => empty(!$data['availability_date'])  ? $data['availability_date'] : "",
                        "property_name" =>  $data['property_name']  ? $data['property_name'] : "",
                        "newProperty_id" =>  $property->id,

                    ]);
                    try {
                        if (isset($data['photo']) && is_array($data['photo'])) {
                            foreach ($data['photo']['url'] as  $index => $url) {
                                if(is_string($url)){
                                    $image = PropertyImage::create([
                                        'url' => $url,
                                        'newProperty_id' => $property->id,
                                    ]);
                                }
                            }
                        }
                    } catch (Throwable $th) {
                        dd($data, $th->getMessage());
                    }
                }
                return back()->with('success', 'Data saved successfully!');
            }
        }

        return view("xml-data");
    }
}
