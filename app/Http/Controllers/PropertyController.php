<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Country;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Building;
use App\Models\Community;
use App\Models\NewProperty;
use App\Models\SubCommunity;
use Illuminate\Http\Request;
use App\Models\BayutProperty;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use App\Models\FinderProperty;
use App\Models\DubizzleProperty;
use App\Models\EmiratesProperty;
use Yajra\DataTables\DataTables;
use App\Models\PropertyFloorPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function generateUniqueCode()
    {
        do {
            $reference_number = random_int(10000, 99999);
        } while (NewProperty::where("reference_number", "=", $reference_number)->first());

        return $reference_number;
    }
    public function listpropertiesindex()
    {
        $totalpropertiesamount = NewProperty::GetLive()->get()->count();
        $communities = Community::get();
        $countries=Country::get();
        $users = User::select('id', 'name')->where('role_id', '3')->orwhere('role_id', '1')->orwhere('role_id', '5')->get();
        $cities = NewProperty::GetLive()->select('city')->groupBy('city')->distinct()->get();
        return view('admin.listproperties', compact('countries','users', 'totalpropertiesamount', 'cities','communities'));
    }
    // live properties
    public function listproperties(Request $request)
    {

        $properties = NewProperty::GetLive();
        if (isset($request->portals)) {
            $properties->where('reference_number', 'like', '%' . $request->reference_number . '%')
                ->where('city', 'like', $request->city . '%')
                ->where('bedroom', 'like', $request->bedrooms . '%')
                ->where($request->portals, 1)
                ->orderBy('new_properties.created_at', 'DESC')->get();
        }
        if ($request->search) {
            $properties->where('price', 'like', '%' . $request->search . '%')
                ->orwhere('title_en', 'like', '%' . $request->search . '%')
                ->orwhere('size', 'like', '%' . $request->search . '%')
                ->orwhere('bathroom', 'like', '%' . $request->search . '%')
                ->orderBy('new_properties.created_at', 'DESC')->get();
        } else if ($request->user_id !== null) {
            $properties->where('reference_number', 'like', '%' . $request->reference_number . '%')
                ->where('community', 'like', $request->community . '%')
                ->where('user_id',  $request->user_id)
                ->where('city', 'like', $request->city . '%')
                ->where('bedroom', 'like', $request->bedrooms . '%')
                ->orderBy('new_properties.created_at', 'DESC')->get();
        } else {
            $properties->where('reference_number', 'like', '%' . $request->reference_number . '%')
                ->where('community', 'like', $request->community . '%')
                ->where('city', 'like', $request->city . '%')
                ->where('bedroom', 'like', $request->bedrooms . '%')
                ->orderBy('new_properties.created_at', 'DESC')->get();
        }

        return DataTables::of($properties)
            ->addColumn('user', function (NewProperty $property) {
                return $property->user?->name;
            })
            ->addColumn('property_type', function (NewProperty $property) {
                return $this->getPropertyType($property->property_type);
            })
            ->addColumn('offering_type', function (NewProperty $property) {
                return $this->getOfferingType($property->offering_type);
            })
            ->addColumn('community_name', function (NewProperty $property) {
                $communities = Community::find($property->community);
                if($communities){
                    return $communities->name;
                }else{
                    return '';
                }
            })

            ->addColumn('actions', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>' . " ";
                $actionBtn .= '<a class="Show btn btn-success btn-sm">Show</a>' . " ";
                $actionBtn .= '<a class="duplicate btn btn-info btn-sm">Duplicate</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns([ 'actions'])
            ->make(true);
    }
    // archived properties
    public function listarchpropertiesindex()
    {
        $totalpropertiesamount = NewProperty::GetArchived()->get()->count();
        $communities = Community::get();
        $countries=Country::get();
        $users = User::select('id', 'name')->where('role_id', '3')->orwhere('role_id', '1')->orwhere('role_id', '5')->get();
        $cities = NewProperty::GetArchived()->select('city')->groupBy('city')->distinct()->get();
        return view('admin.listarchproperties', compact('countries','users', 'totalpropertiesamount', 'cities','communities'));
    }
    // archived properties
    public function listarchproperties(Request $request)
    {
        $properties = NewProperty::GetArchived();
        if (isset($request->portals)) {
            $properties->where('reference_number', 'like', '%' . $request->reference_number . '%')
                ->where('city', 'like', $request->city . '%')
                ->where('bedroom', 'like', $request->bedrooms . '%')
                ->where($request->portals, 1)
                ->orderBy('created_at', 'DESC')->get();
        }
        if ($request->search) {
            $properties->where('price', 'like', '%' . $request->search . '%')
                ->orwhere('title_en', 'like', '%' . $request->search . '%')
                ->orwhere('size', 'like', '%' . $request->search . '%')
                ->orwhere('bathroom', 'like', '%' . $request->search . '%')
                ->orderBy('created_at', 'DESC')->get();
        } else if ($request->user_id !== null) {
            $properties->where('reference_number', 'like', '%' . $request->reference_number . '%')
                ->where('user_id',  $request->user_id)
                ->where('community', 'like', $request->community . '%')
                ->where('city', 'like', $request->city . '%')
                ->where('bedroom', 'like', $request->bedrooms . '%')
                ->orderBy('created_at', 'DESC')->get();
        } else {
            $properties->where('reference_number', 'like', '%' . $request->reference_number . '%')
                ->where('city', 'like', $request->city . '%')
                ->where('community', 'like', $request->community . '%')
                ->where('bedroom', 'like', $request->bedrooms . '%')
                ->orderBy('created_at', 'DESC')->get();
        }
        return DataTables::of($properties)

            ->addColumn('user', function (NewProperty $property) {
                return $property->user->name;
            })
            ->addColumn('property_type', function (NewProperty $property) {
                return $this->getPropertyType($property->property_type);
            })
            ->addColumn('offering_type', function (NewProperty $property) {
                return $this->getOfferingType($property->offering_type);
            })
            ->addColumn('community_name', function (NewProperty $property) {
                $communities = Community::find($property->community);
                if($communities){
                    return $communities->name;
                }else{
                    return '';
                }
            })
            ->addColumn('actions', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>' . " ";
                $actionBtn .= '<a class="Show btn btn-success btn-sm">Show</a>' . " ";
                $actionBtn .= '<a class="duplicate btn btn-info btn-sm">Duplicate</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns(['finder', 'bayut', 'emirates_estate', 'dubizzle', 'actions'])
            ->make(true);
    }
    public function deleteproperty(Request $request)
    {
        $property = NewProperty::find($request->id);
        $havepayments = Payment::where('property', $property->name)->where('buyer_id', $property->buyer_id)->exists();
        if ($havepayments)
            return response()->json(['success' => false, 'message' => 'This property has payments you should remove payments first']);

        $res = $property->delete();
        if ($res)
            return response()->json(['success' => true, 'message' => 'Property has been deleted successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error hapen while delete property']);
    }
    public function createpropertyindex()
    {

        $user = User::select('id', 'name')
            ->where('role_id', '1')
            ->orWhere('role_id', '2')
            ->orWhere('role_id', '2,3')
            ->orWhere('role_id', '5')
            ->orWhere('role_id', '3')
            ->get();

        $communities = Community::get();

        $city_uae = [
            'Dubai' => "Dubai",
            'Abu Dhabi' => "Abu Dhabi",
            'Umm Al Quwai' => "Umm Al Quwai",
            'Ajman' => "Ajman",
            'Ras Al-Khaimah' => "Ras Al-Khaimah",
            'Sharjah' => "Sharjah",
            'Fujairah' => "Fujairah",
            'Al Ain' => "Al Ain",
        ];
        $BulgariaCities = [
            'Sofia' => "Sofia",
            'Plovdiv' => "Plovdiv ",
            'Varna' => "Varna",
            'Burgas' => "Burgas",
            'Stara Zagora' => "Stara Zagora",
            'Rousse' => "Rousse",
            'Pleven' => "Pleven",
            'Sliven' => "Sliven",
            'Pernik' => "Pernik",
            'Dobrich' => "Dobrich",
            'Shumen' => "Shumen",
            'Blagoevgrad' => "Blagoevgrad",
        ];
        $GreekCities = [
            "Athens" => "Attica",
            "Thessaloniki" => "Thessaloniki",
            "Patras" => "Patras",
            "Heraklion" => "Heraklion",
            "Larissa" => "Larissa",
            "Volos" => "Volos",
            "Ioannina" => "Ioannina",
            "Kalamata" => "Kalamata",
            "Chania" => "Chania",
            "Rhodes" => "Rhodes",
            "Corfu" => "Corfu",
            "Chalkida" => "Chalkida",
            "Agrinio" => "Agrinio",
            "Tripoli" => "Tripoli",
             "Serres" => "Serres",
            "Zakynthos" => "Zakynthos",
            "Crete" => "Crete",
            "Agios Nikolaos" => "Agios Nikolaos"
        ];
        $CyprusCities = [
            'Nicosia' => 'Nicosia (Lefkosia)',
            'Limassol' => 'Limassol',
            'Larnaca' => 'Larnaca',
            'Paphos' => 'Paphos',
            'Famagusta' => 'Famagusta',
            'Kyrenia' => 'Kyrenia'
        ];
        $MaltaCities = [
            'Valletta' => 'Valletta',
            'Mosta' => 'Mosta',
            'Sliema' => 'Sliema',
            'Zabbar' => 'Zabbar',
            'Rabat (Victoria)' => 'Rabat (Victoria)',
            'Zebbug' => 'Zebbug'
        ];
        $countries=Country::get();

        return view('admin.createproperty', ['countries'=>$countries,'user' => $user, 'communities' => $communities, 'city_uae'=> $city_uae, 'MaltaCities'=>$MaltaCities, 'CyprusCities'=>$CyprusCities,'GreekCities' =>$GreekCities, 'BulgariaCities'=>$BulgariaCities]);
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
    public function createnewproperty(Request $request)
    {

        if ($request->RemaxWebsite == 'RemaxWebsite') {
            if ($request->private_amenities == "") {
                $private_amenities = "";
            } else {
                $all_private_amenities = [
                    'AC' => "Central A/C",
                    'BA' => "Balcony",
                    'BK' => "Build in Kitchen Appliances",
                    'BL' => "View of Landmark",
                    'BW' => "Built-in Wardrobes",
                    'CP' => "Covered Parking",
                    'CS' => "Concierge service",
                    'LB' => "Lobby in Building",
                    'MR' => "Maid's Room",
                    'MS' => "Maids Service",
                    'PA' => "Pets Allowed",
                    'PG' => "Private Garden",
                    'PY' => "Private GYM",
                    'PJ' => "Private Jacuzzi",
                    'PP' => "Private Pools",
                    'VC' => "Vastu compliant",
                    'SE' => "Security",
                    'SP' => "Shared Pool",
                    'SS' => "Shared Spa",
                    'ST' => "Study",
                    'SY' => "Shared Gym",
                    'VW' => "View of Water",
                    'WC' => "Walk in Closet",
                    'CO' => "Children's Pool",
                    'PR' => "Children's Play Area",
                    'PR' => "Barbecue Area"
                ];
                foreach ($all_private_amenities as $key => $value) {
                    if (in_array($key, $request->private_amenities)) {
                        $amenities[] = $value;
                    }
                }
                $furnished = [
                    'Yes' => 'Furnished',
                    'No' => 'Unfurnished',
                    'Partly' => 'semi-furnished',
                ];
                if ($request->furnished) {
                    foreach ($furnished as $key => $value) {
                        if ($key == $request->furnished) {
                            $amenities[] = $value;
                        }
                    }
                }
                $private_amenities = implode(',', $amenities);
            }
            if ($request->TotalFiles > 0) {
                $website_images_withfirst = [];
                $website_images = [];
                for ($x = 0; $x < $request->TotalFiles; $x++) {
                    if ($request->hasFile('files' . $x)) {
                        $file = $request->file('files' . $x);
                        $name = $file->getClientOriginalName();
                        $path = $file->storeAs('public/properties/images', $name);

                        // $setting = Setting::where('type', 'logo')->first();
                        // if ($setting) {
                        //     if(File::exists(public_path($setting->description['logo']))){
                        //         $img = Image::make(storage_path('app/public/properties/images') . '/' .  $name);
                        //         $watermark = Image::make(public_path($setting->description['logo']));

                        //         $watermark->opacity(40);
                        //         $watermark->resize($setting->description['watermark_width'], $setting->description['watermark_height']);
                        //         $img->insert($watermark, $setting->description['watermark_position']);
                        //         $img->save(storage_path('app/public/properties/images') . '/' .  $name);
                        //     }

                        // }
                    }

                    $website_images[] = asset('storage/properties/images/') . '/' . $name;
                    $website_images_withfirst[] = asset('storage/properties/images/') . '/' . $name;
                }
            }
            if (isset($website_images)) {
                if ($request->TotalFiles > 1) {
                    $del_o = array_shift($website_images);
                } else {
                    $website_images = '';
                }
            } else {
                $website_images = '';
                $website_images_withfirst[0] = '';
            }
            if (isset($request->geopoints)) {
                $latitude_longitude = explode(',', $request->geopoints);
                $longitude = $latitude_longitude[0];
                $latitude = $latitude_longitude[1];
            } else {
                $longitude = '';
                $latitude = '';
            }
            if (Auth::user()->isAgent()) {
                $agent_websiteId = auth()->user->websiteId;
            } else {
                $agent = User::where('id', $request->user_id)->first();
                $agent_websiteId = $agent->websiteId;
            }
            $property_type = [
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
            foreach ($property_type as $type_key => $type_value) {
                if ($request->property_type == $type_key) {
                    $property_type = $type_value;
                }
            }
            $offering_type = [
                'RR' => "For Rent",
                'RS' => "For Sale"
            ];
            foreach ($offering_type as $offering_key => $offering_value) {
                if ($request->offering_type == $offering_key) {
                    $offering_type = $offering_value;
                }
            }
            $data = [
                "secretKey" => "N2Y0459P#XMv",
                "post_title" => $request->title_en,
                "post_content" => $request->description_en,
                "thumbNailImage" => $website_images,
                "taxonomy" => [
                    "property_category" => $property_type,
                    "property_action_category" => $offering_type,
                    "property_city" => $request->city,
                    "property_area" => $request->community . "" . $request->sub_community,
                    "property_county_state" => "United Arab Emirates",
                    "property_features" => $private_amenities
                ],
                "property_details" => [
                    "property_price" => $request->price,
                    "property_hoa" => 123,
                    "property_label" => "property_label",
                    "property_label_before" => "property_label_before",
                    "property_lot_size" =>  $request->plot_size,
                    "property_rooms" => 123,
                    "property_bedrooms" => $request->bedroom,
                    "property_bathrooms" => $request->bathroom,
                    "energy_index" => 123,
                    "owner_notes" => "Notes",
                    "energy_class" => "A+",
                    "prop_featured" => 1,
                    "property_theme_slider" => 1
                ],
                "property_media" => [
                    "gallary" => $website_images_withfirst[0]
                ],
                "property_custom_fields" => [
                    "mls" => $request->reference_number
                ],
                "address_map_location" => [
                    "property_address" => $request->community . $request->sub_community,
                    "property_country" => "United Arab Emirates",
                    "property_latitude" => $latitude,
                    "property_longitude" => $longitude,
                    "page_custom_zoom" => 16,
                    "property_google_view" => 0,
                    "google_camera_angle" => 0
                ],
                "property_agent" => [
                    "property_agent" => $agent_websiteId
                ]
            ];
            $result = Http::withHeaders([
                'authorization' => 'SHJND9KDBG-JDKKMLHZJ2-WRW9LNBLWD',
            ])
                ->post('https://remaxnetworkhome.com/wp-json/api/v2/properties/eEyKhvXT59PKhmB9/set/new', $data);
        }
        // dd($request->all());
        if (Auth::user()->isAgent()) {
            $request->validate(
                [

                    'permit_number' => 'required',
                    'offering_type' => 'required',
                    'property_type' => 'required',
                    'price' => 'required|min:0',
                    'city' => 'required',
                    'community' => 'required',
                    'sub_community' => 'required',
                    'title_en' => 'required',
                    'description_en' => 'required',
                    'size' => 'required|min:0',
                    'bedroom' => 'required',
                    'bathroom' => 'nullable|numeric|min:0|max:10',
                    'parking' => 'nullable|numeric|min:0|max:999',
                    'slug' => 'required',
                    'completion_status'=>'required',
                    'project_name'=>'required',
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'bathroom.max' => 'The :attribute area should be less than 11.',
                    'parking.max' => 'The :attribute area should be less than 1000.',
                    'floor.min' => 'The :attribute area must be a positive value.',
                    'stories.min' => 'The :attribute area must be a positive value.',
                    'build_year.min' => 'The :attribute area must be a positive value.',
                    'price.min' => 'The :attribute area must be a positive value.',
                    'service_charge.min' => 'The :attribute area must be a positive value.',
                    'size.min' => 'The :attribute area must be a positive value.',
                    'plot_size.min' => 'The :attribute area must be a positive value.',
                ]
            );
        } else {
            $request->validate(
                [
                    'permit_number' => 'required',
                    'offering_type' => 'required',
                    'property_type' => 'required',
                    'price' => 'required|min:0',
                    'city' => 'required',
                    'community' => 'required',
                    'sub_community' => 'required',
                    'title_en' => 'required',
                    'description_en' => 'required',
                    'size' => 'required|min:0',
                    'bedroom' => 'required',
                    'bathroom' => 'nullable|numeric|min:0|max:10',
                    'parking' => 'nullable|numeric|min:0|max:999',
                    'user_id' => 'required',
                    'slug' => 'required',
                    'completion_status'=>'required',
                    'project_name'=>'required'
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'user_id.required' => 'The Agent field is required.',
                    'bathroom.max' => 'The :attribute area should be less than 11.',
                    'parking.max' => 'The :attribute area should be less than 1000.',
                    'floor.min' => 'The :attribute area must be a positive value.',
                    'stories.min' => 'The :attribute area must be a positive value.',
                    'build_year.min' => 'The :attribute area must be a positive value.',
                    'price.min' => 'The :attribute area must be a positive value.',
                    'service_charge.min' => 'The :attribute area must be a positive value.',
                    'size.min' => 'The :attribute area must be a positive value.',
                    'plot_size.min' => 'The :attribute area must be a positive value.',
                ]
            );
        }
        $slug=$this->slugify($request->slug);
        $property=NewProperty::where('slug',$slug)->first();
        if($property){
            return response()->json(['success' => false, 'message' => 'Slug is already taken. Please choose another slug']);
        }
        if ($request->private_amenities == "") {
            $private_amenities = "";
        } else {
            $private_amenities = implode(',', $request->private_amenities);
        }

        if (Auth::user()->isAgent()) {
            $newproperty = NewProperty::create([
                'reference_number' => $this->generateUniqueCode(),
                'permit_number' => $request->permit_number,
                'property_type' => $request->property_type,
                'offering_type' => $request->offering_type,
                'price' => str_replace(",", "", $request->price),
                'city' => $request->city,
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'size' => str_replace(",", "", $request->size),
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'community' => $request->community,
                'sub_community' => $request->sub_community,
                'private_amenities' => $private_amenities,
                'user_id' => auth()->user()->id,
                'slug' => $slug,
                'parking' => $request->parking,
                'property_name'=>$request->property_name,
                'property_status'=>$request->property_status,
                'completion_status'=>$request->completion_status,
                'lng'=>$request->search_longitude,
                'lat'=>$request->search_latitude,
                'country'=>$request->country,
                'project_name'=>$request->project_name,
                'featured'=>($request->featured) ? true : false,
                'price_name'=>$request->price_name,
                'has_tour'=>$request->has_tour,
            ]);
            if ($request->RemaxWebsite == 'RemaxWebsite') {
                $newproperty->update([
                    'websiteId' => $result['data'],
                ]);
            }
        } else {
            $newproperty = NewProperty::create([
                'reference_number' => $this->generateUniqueCode(),
                'permit_number' => $request->permit_number,
                'property_type' => $request->property_type,
                'offering_type' => $request->offering_type,
                'price' => str_replace(",", "", $request->price),
                'city' => $request->city,
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'size' => str_replace(",", "", $request->size),
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'community' => $request->community,
                'sub_community' => $request->sub_community,
                'private_amenities' => $private_amenities,
                'user_id' => $request->user_id,
                'slug' => $slug,
                'parking' => $request->parking,
                'property_name'=>$request->property_name,
                'property_status'=>$request->property_status,
                'completion_status'=>$request->completion_status,
                'lng'=>$request->search_longitude,
                'lat'=>$request->search_latitude,
                'country'=>$request->country,
                'project_name'=>$request->project_name,
                'featured'=>($request->featured) ? true : false,
                'has_tour'=>$request->has_tour,
            ]);
            if ($request->RemaxWebsite == 'RemaxWebsite') {
                $newproperty->update([
                    'websiteId' => $result['data'],
                ]);
            }
        }
        if ($request->TotalFiles > 0) {
            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $file = $request->file('files' . $x);
                    $name=uploadFile($file ,'properties/images/'. $newproperty->reference_number,false );
                    // $setting = Setting::where('type', 'logo')->first();
                    // if ($setting) {
                    //     if(FileExists($setting->description['logo'])){
                    //         $img = Image::make(config('services.cms_link').'/storage/properties/images/'.$newproperty->reference_number.'/'. $name);
                    //         $watermark = Image::make(config('services.cms_link').'/'.$setting->description['logo']);

                    //         $watermark->opacity(40);
                    //         $watermark->resize($setting->description['watermark_width'], $setting->description['watermark_height']);
                    //         $img->insert($watermark, $setting->description['watermark_position']);
                    //         $exten=pathinfo($name, PATHINFO_EXTENSION );
                    //         $storage_type = env('STORAGE_TYPE') ?? 's3';
                    //         Storage::disk($storage_type)->put('storage/properties/images/'.$newproperty->reference_number.'/'. $name, $img->encode($exten)->stream()->__toString(),'public');
                    //     }
                    // }
                }
                DB::table('property_images')->insert(
                    array(
                        'url' => $newproperty->reference_number . '/' . $name,
                        'newProperty_id' => $newproperty->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
            }
        }
        if ($request->FloorPlan > 0) {
            for ($x = 0; $x < $request->FloorPlan; $x++) {
                if ($request->hasFile('floorplans' . $x)) {
                    $file = $request->file('floorplans' . $x);
                    $name=uploadFile($file ,'properties/FloorPrperty/'. $newproperty->reference_number,false);

                }
                DB::table('property_floor_plans')->insert(
                    array(
                        'url' => $newproperty->reference_number . '/' . $name,
                        'newProperty_id' => $newproperty->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
            }
        }
        if($newproperty)
            return response()->json(['success' => true, 'message' => 'Property created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating Property']);
    }
    public function getsubcommunity($community_id)
    {
        $community = Community::where('id',$community_id)->first();
        $subCommunity = SubCommunity::where('community_id', $community->community_id)->get();
        if ($subCommunity) {
            return $subCommunity;
        }
    }
    public function gettowername($sub_community_id)
    {
        $subCommunity = SubCommunity::where('id',$sub_community_id)->first();
        $buildings = Building::where('subcommunity_id', $subCommunity->subcommunity_id)->get();
        if ($buildings) {
            return $buildings;
        }
    }
    public function upnewproperty($id)
    {
        $type = [
            'RR' => "Residential Rent",
            'RS' => "Residential Sale"
        ];
        $property_type_residential = [
            "AP" => "Apartment Flat",
            "DX" => "Duplex",
            "LP" => "Land/Plot",
            "PH" => "Penthouse",
            "TH" => "Townhouse",
            "VH" => "Villa/House",
            "VI" => "Villa"
        ];
        $property_type_Commercial = [
            "FA" => "Factory",
            "FF" => "Full Floor",
            "LC" => "Labor Camp",
            "OF" => "Office Space",
            "SH" => "Shop",
            "WB" => "Whole Building",
            "WH" => "Warehouse",
        ];
        $city_uae = [
            'Dubai' => "Dubai",
            'Abu Dhabi' => "Abu Dhabi",
            'Umm Al Quwai' => "Umm Al Quwai",
            'Ajman' => "Ajman",
            'Ras Al-Khaimah' => "Ras Al-Khaimah",
            'Sharjah' => "Sharjah",
            'Fujairah' => "Fujairah",
            'Al Ain' => "Al Ain",
        ];
        $BulgariaCities = [
            'Sofia' => "Sofia",
            'Plovdiv' => "Plovdiv ",
            'Varna' => "Varna",
            'Burgas' => "Burgas",
            'Stara Zagora' => "Stara Zagora",
            'Rousse' => "Rousse",
            'Pleven' => "Pleven",
            'Sliven' => "Sliven",
            'Pernik' => "Pernik",
            'Dobrich' => "Dobrich",
            'Shumen' => "Shumen",
            'Blagoevgrad' => "Blagoevgrad",
        ];
        $GreekCities = [
            "Athens" => "Attica",
            "Thessaloniki" => "Thessaloniki",
            "Patras" => "Patras",
            "Heraklion" => "Heraklion",
            "Larissa" => "Larissa",
            "Volos" => "Volos",
            "Ioannina" => "Ioannina",
            "Kalamata" => "Kalamata",
            "Chania" => "Chania",
            "Rhodes" => "Rhodes",
            "Corfu" => "Corfu",
            "Chalkida" => "Chalkida",
            "Agrinio" => "Agrinio",
            "Tripoli" => "Tripoli",
             "Serres" => "Serres",
            "Zakynthos" => "Zakynthos",
            "Crete" => "Crete",
            "Agios Nikolaos" => "Agios Nikolaos"
        ];
        $CyprusCities = [
            'Nicosia' => 'Nicosia (Lefkosia)',
            'Limassol' => 'Limassol',
            'Larnaca' => 'Larnaca',
            'Paphos' => 'Paphos',
            'Famagusta' => 'Famagusta',
            'Kyrenia' => 'Kyrenia'
        ];
        $MaltaCities = [
            'Valletta' => 'Valletta',
            'Mosta' => 'Mosta',
            'Sliema' => 'Sliema',
            'Zabbar' => 'Zabbar',
            'Rabat (Victoria)' => 'Rabat (Victoria)',
            'Zebbug' => 'Zebbug'
        ];

        $private_amenities = [
            'AC' => "CentralA/C&Heating",
            'BA' => "Balcony",
            'BK' => "Built in Kitchen Appliances",
            'BL' => "View of Landmark",
            'BW' => "Built in Wardrobes",
            'CP' => "Covered Parking",
            'CS' => "Concierge Service",
            'LB' => "Lobby in Building",
            'MR' => "Maid's Room",
            'MS' => "Maid Servicee",
            'PA' => "Pets Allowed",
            'PG' => "Private Garden",
            'PY' => "Private GYM",
            'PJ' => "Private Jacuzzi",
            'PP' => "Private Pool",
            'SE' => "Security",
            'SP' => "Shared Pool",
            'SS' => "Shared Spa",
            'ST' => "Study",
            'SY' => "Shared Gym",
            'VW' => "View of Water",
            'WC' => "Walk in Closet",
            'BR' => "Barbecue Area"
        ];
        $completion_status = [
            'completed' => "Completed",
            'off_plan' => "Off_Plan",
        ];
        $furnished = [
            'Yes' => "Furnished",
            'Partly' => "Semi-Furnished",
            'No' => "Unfurnished"

        ];
        $property_statuses = [
            'Live',
            'Archive'
        ];
        $off_plans = [
            'Yes',
            'No'
        ];
        $rent_Frequencies = [
            // 'Daily',
            // 'Weekly',
            // 'Monthly',
            'Yearly'
        ];
        $bedrooms = [
            '0' => "Studio",
            '1' => "1",
            '2' => "2",
            '3' => "3",
            '4' => "4",
            '5' => "5",
            '6' => "6",
            '7' => "7",
            '8' => "8",
            '9' => "9",
            '10' => "10",
            '11' => "11",
            '12' => "12",
            '13' => "13",
            '14' => "14",
            '15' => "15",
            '16' => "16",
            '17' => "17",
            '18' => "18",
            '19' => "19",
            '20' => "20",
        ];
        $cheques = [
            '1' => "1",
            '2' => "2",
            '3' => "3",
            '4' => "4",
            '5' => "5",
            '6' => "6",
            '7' => "7",
            '8' => "8",
            '9' => "9",
            '10' => "10",
            '11' => "11",
            '12' => "12",
        ];
        $newProperty = NewProperty::findOrFail($id);
        $users = User::select('id', 'name')
            ->where('role_id', '1')
            ->orWhere('role_id', '2')
            ->orWhere('role_id', '2,3')
            ->orWhere('role_id', '5')
            ->orWhere('role_id', '3')
            ->get();
        $property_images = PropertyImage::where('newProperty_id', $newProperty->id)->get();
        $property_floor = PropertyFloorPlan::where('newProperty_id', $newProperty->id)->get();
        $bayut_property = BayutProperty::where('newProperty_id', $newProperty->id)->first();
        $finder_property = FinderProperty::where('newProperty_id', $newProperty->id)->first();
        $emirates_property = EmiratesProperty::where('newProperty_id', $newProperty->id)->first();
        $dubizzle_property = DubizzleProperty::where('newProperty_id', $newProperty->id)->first();
        if ($bayut_property != null) {
            $bayut_checkbox = "Bayut";
            $bayutproperty_videos = PropertyVideo::where('newProperty_id', $newProperty->id)->get();
        } else {
            $bayut_checkbox = "no";
            $bayut_property = "";
            $bayutproperty_videos = "";
        }
        if ($finder_property != null) {
            $finder_checkbox = "finder";
        } else {
            $finder_checkbox = "no";
            $finder_property = "";
        }
        if ($emirates_property != null) {
            $emirates_checkbox = "emiratesEstate";
        } else {
            $emirates_checkbox = "no";
            $emirates_property = "";
        }
        if ($dubizzle_property != null) {
            $dubizzle_checkbox = "Dubizzle";
            $dubizzleproperty_videos = PropertyVideo::where('newProperty_id', $newProperty->id)->get();
        } else {
            $dubizzle_checkbox = "no";
            $dubizzle_property = "";
            $dubizzleproperty_videos = "";
        }

        $communities = Community::get();
        $subCommunities = SubCommunity::where('community_id', $newProperty->community)->get();
        $towersname = Building::where('subcommunity_id',$newProperty->sub_community)->get();
        $initial_pos=$newProperty->lat .',' .$newProperty->lng;
        if ($initial_pos == '') {
            $initial_pos = '25.168282,55.250286';
        }
        $countries=Country::get();
        $country=Country::where('name',$newProperty->country)->first();
        $cities=($country) ? City::where('country_id',$country->id)->get() : [];
        return view(
            'admin.updateproperty',
            [
                'cities'=>$cities,
                'countries'=>$countries,
                'private_amenities' => $private_amenities, 'newProperty' => $newProperty, 'type' => $type, 'property_type_residential' => $property_type_residential,
                'property_type_Commercial' => $property_type_Commercial, 'city_uae' => $city_uae,
                'GreekCities'=> $GreekCities,
                'MaltaCities'=> $MaltaCities,
                'CyprusCities'=> $CyprusCities,
                'BulgariaCities'=> $BulgariaCities,
                'completion_status' => $completion_status,
                'furnished' => $furnished, 'users' => $users, 'property_images' => $property_images, 'property_floor' => $property_floor,
                'bayut_property' => $bayut_property, 'finder_property' => $finder_property, 'emirates_property' => $emirates_property, 'dubizzle_property' => $dubizzle_property, 'off_plans' => $off_plans,
                'property_statuses' => $property_statuses, 'rent_Frequencies' => $rent_Frequencies, 'finder_checkbox' => $finder_checkbox,
                'bayut_checkbox' => $bayut_checkbox, 'emirates_checkbox' => $emirates_checkbox, 'dubizzle_checkbox' => $dubizzle_checkbox,
                'bayutproperty_videos' => $bayutproperty_videos, 'dubizzleproperty_videos' => $dubizzleproperty_videos, 'bedrooms' => $bedrooms,
                'cheques' => $cheques,
                'initial_pos' => $initial_pos,
                'communities' => $communities,
                'subCommunities' => $subCommunities,
                'towersname' => $towersname
            ]
        );
    }
    public function update_new_property(Request $request, $id)
    {

        $newproperty = NewProperty::find($id);
        if (Auth::user()->isAgent()) {
            $request->validate(
                [
                    'permit_number' => 'required',
                    'property_type' => 'required',
                    'offering_type' => 'required',
                    'price' => 'required|min:0',
                    'city' => 'required',
                    'community' => 'required',
                    'sub_community' => 'required',
                    'title_en' => 'required',
                    'description_en' => 'required',
                    'size' => 'required|min:0',
                    'bedroom' => 'required',
                    'bathroom' => 'nullable|numeric|min:0|max:10',
                    'slug' => 'required|unique:new_properties,slug,' . $id . ',id',
                    'project_name'=>'required',
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'bathroom.max' => 'The :attribute area should be less than 11.',
                    'size.min' => 'The :attribute area must be a positive value.',
                    'price.min' => 'The :attribute area must be a positive value.',
                ]
            );
        } else {
            $request->validate(
                [
                    'permit_number' => 'required',
                    'property_type' => 'required',
                    'offering_type' => 'required',
                    'price' => 'required|min:0',
                    'city' => 'required',
                    'community' => 'required',
                    'sub_community' => 'required',
                    'title_en' => 'required',
                    'description_en' => 'required',
                    'size' => 'required|min:0',
                    'bedroom' => 'required',
                    'bathroom' => 'nullable|numeric|min:0|max:10',
                    'user_id' => 'required',
                    'slug' => 'required|unique:new_properties,slug,' . $id . ',id',
                    'project_name'=>'required',
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'user_id.required' => 'The Agent field is required.',
                    'bathroom.max' => 'The :attribute area should be less than 11.',
                    'size.min' => 'The :attribute area must be a positive value.',
                    'price.min' => 'The :attribute area must be a positive value.',
                ]
            );
        }
        $slug=$this->slugify($request->slug);
        $property=NewProperty::whereNotIn('id',[$id])->where('slug',$slug)->first();
        if($property){
            return response()->json(['success' => false, 'message' => 'Slug is already taken. Please choose another slug']);
        }
        if ($request->private_amenities == "") {
            $private_amenities = "";
        } else {
            $private_amenities = implode(',', $request->private_amenities);
        }
        if (Auth::user()->isAgent()) {

            $newproperty->update([
                'permit_number' => $request->permit_number,
                'property_type' => $request->property_type,
                'offering_type' => $request->offering_type,
                'price' => str_replace(",", "", $request->price),
                'city' => $request->city,
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'size' => str_replace(",", "", $request->size),
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'community' => $request->community,
                'sub_community' => $request->sub_community,
                'private_amenities' => $private_amenities,
                'slug' => $slug,
                'parking'=>$request->parking,
                'property_name'=>$request->property_name,
                'property_status'=>$request->property_status,
                'completion_status'=>$request->completion_status,
                'lng'=>$request->search_longitude,
                'lat'=>$request->search_latitude,
                'country'=>$request->country,
                'project_name'=>$request->project_name,
                'featured'=>($request->featured) ? true : false,
                'price_name'=>$request->price_name,
                'has_tour'=>$request->has_tour,
            ]);

        } else {
            $newproperty->update([
                'permit_number' => $request->permit_number,
                'property_type' => $request->property_type,
                'offering_type' => $request->offering_type,
                'price' => str_replace(",", "", $request->price),
                'city' => $request->city,
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'size' => str_replace(",", "", $request->size),
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'community' => $request->community,
                'sub_community' => $request->sub_community,
                'private_amenities' => $private_amenities,
                'user_id' => $request->user_id,
                'slug' => $slug,
                'parking'=>$request->parking,
                'property_name'=>$request->property_name,
                'property_status'=>$request->property_status,
                'completion_status'=>$request->completion_status,
                'lng'=>$request->search_longitude,
                'lat'=>$request->search_latitude,
                'country'=>$request->country,
                'project_name'=>$request->project_name,
                'featured'=>($request->featured) ? true : false,
                'price_name'=>$request->price_name,
                'has_tour'=>$request->has_tour,
            ]);

        }
        $old_images = DB::table('property_images')->where('newProperty_id', $id)->pluck('url')->toArray();
        $new_images = [];
        foreach (json_decode($request->old_images) as $key => $value) {
            if(!str_contains($value, "https://images.goyzer.com")){
                if (!str_contains($value, "base64")) {
                    $temp = explode('/', $value);
                    $val = $temp[count($temp) - 2] . '/' . $temp[count($temp) - 1];
                    $new_images[] = $val;
                }
            }else{
                $new_images[] =$value;
            }

        }
        foreach ($old_images as $key => $image) {
            if (!in_array($image, $new_images)) {
                $is_deleted = DB::table('property_images')->where('newProperty_id', $id)->where('url', $image)->Delete();
            }
        }

        if ($request->TotalFiles > 0) {
            $setting = Setting::where('type', 'logo')->first();
            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $file = $request->file('files' . $x);
                    $name=uploadFile($file ,'properties/images/'. $newproperty->reference_number,false );

                    // if ($setting) {
                    //     if(FileExists($setting->description['logo'])){
                    //         $img = Image::make(config('services.cms_link').'/storage/properties/images/'.$newproperty->reference_number.'/'.$name);
                    //         $watermark = Image::make(config('services.cms_link').'/'.$setting->description['logo']);

                    //         $watermark->opacity(40);
                    //         $watermark->resize($setting->description['watermark_width'], $setting->description['watermark_height']);
                    //         $img->insert($watermark, $setting->description['watermark_position']);
                    //         $exten=pathinfo( $name, PATHINFO_EXTENSION );
                    //         $storage_type = env('STORAGE_TYPE') ?? 's3';
                    //         Storage::disk($storage_type)->put('storage/properties/images/'.$newproperty->reference_number.'/'. $name, $img->encode($exten)->stream()->__toString(),'public');


                    //     }
                    // }
                }
                DB::table('property_images')->insert(
                    array(
                        'url' =>  $newproperty->reference_number . '/' . $name,
                        'newProperty_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
            }
        }
        if ($request->FloorPlan > 0) {
            DB::table('property_floor_plans')->where('newProperty_id', $id)->delete();
            for ($x = 0; $x < $request->FloorPlan; $x++) {
                if ($request->hasFile('floorplans' . $x)) {
                    $file = $request->file('floorplans' . $x);
                    $name=uploadFile($file ,'properties/FloorPrperty/'. $newproperty->reference_number,false );

                }
                DB::table('property_floor_plans')->insert(
                    array(
                        'url' => $newproperty->reference_number . '/' . $name,
                        'newProperty_id' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
            }
        }

        if (
            $newproperty
        )
            return response()->json(['success' => true, 'message' => 'Property updated successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Property Not Found']);
    }
    public function shownewproperty($id)
    {
        $type = [
            'RR' => "Residential Rent",
            'RS' => "Residential Sale"
        ];
        $property_type = [
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
        $city = [
            'Dubai' => "Dubai",
            'Abu Dhabi' => "Abu Dhabi",
            'Umm Al Quwai' => "Umm Al Quwai",
            'Ajman' => "Ajman",
            'Ras Al-Khaimah' => "Ras Al-Khaimah",
            'Sharjah' => "Sharjah",
            'Fujairah' => "Fujairah",

        ];
        $private_amenities = [
            'AC' => "CentralA/C&Heating",
            'BA' => "Balcony",
            'BK' => "Built in Kitchen Appliances",
            'BL' => "View of Landmark",
            'BW' => "Built in Wardrobes",
            'CP' => "Covered Parking",
            'CS' => "Concierge Service",
            'LB' => "Lobby in Building",
            'MR' => "Maid's Room",
            'MS' => "Maid Servicee",
            'PA' => "Pets Allowed",
            'PG' => "Private Garden",
            'PY' => "Private GYM",
            'PJ' => "Private Jacuzzi",
            'PP' => "Private Pool",
            'SE' => "Security",
            'SP' => "Shared Pool",
            'SS' => "Shared Spa",
            'ST' => "Study",
            'SY' => "Shared Gym",
            'VW' => "View of Water",
            'WC' => "Walk in Closet",
            'BR' => "Barbecue Area"
        ];
        $completion_status = [
            'completed' => "completed",
            'off_plan' => "off_plan",
        ];
        $furnished = [
            'Yes' => "Yes",
            'No' => "No",
            'Partly' => "Partly"

        ];
        $property_statuses = [
            'Live',
            'Archive'
        ];
        $off_plans = [
            'Yes',
            'No'
        ];
        $rent_Frequencies = [
            // 'Daily',
            // 'Weekly',
            // 'Monthly',
            'Yearly'
        ];
        $newProperty = NewProperty::findOrFail($id);
        $users = User::select('id', 'name')->where('role_id', '3')->get();
        $property_images = PropertyImage::where('newProperty_id', $newProperty->id)->get();
        $property_floor = PropertyFloorPlan::where('newProperty_id', $newProperty->id)->get();
        $bayut_property = BayutProperty::where('newProperty_id', $newProperty->id)->first();
        $finder_property = FinderProperty::where('newProperty_id', $newProperty->id)->first();
        $emirates_property = EmiratesProperty::where('newProperty_id', $newProperty->id)->first();
        $dubizzle_property = DubizzleProperty::where('newProperty_id', $newProperty->id)->first();
        $community = Community::find($newProperty->community);
        if ($community)
            $community = $community->name;
        else
            $community = "";

        $subCommunity = SubCommunity::find($newProperty->sub_community);
        if ($subCommunity)
            $subCommunity = $subCommunity->name;
        else
            $subCommunity = "";

        if ($bayut_property != null) {
            $bayut_checkbox = "Bayut";
            $bayutproperty_videos = PropertyVideo::where('newProperty_id', $newProperty->id)->get();
        } else {
            $bayut_checkbox = "no";
            $bayut_property = "";
            $bayutproperty_videos = "";
        }
        if ($finder_property != null) {
            $finder_checkbox = "finder";
        } else {
            $finder_checkbox = "no";
            $finder_property = "";
        }
        if ($emirates_property != null) {
            $emirates_checkbox = "emiratesEstate";
        } else {
            $emirates_checkbox = "no";
            $emirates_property = "";
        }
        if ($dubizzle_property != null) {
            $dubizzle_checkbox = "Dubizzle";
            $dubizzleproperty_videos = PropertyVideo::where('newProperty_id', $newProperty->id)->get();
        } else {
            $dubizzle_checkbox = "no";
            $dubizzle_property = "";
            $dubizzleproperty_videos = "";
        }
        return view(
            'admin.shownewproperty',
            [
                'private_amenities' => $private_amenities, 'newProperty' => $newProperty, 'type' => $type, 'property_type' => $property_type,
                'city' => $city, 'completion_status' => $completion_status,
                'furnished' => $furnished, 'users' => $users, 'property_images' => $property_images, 'property_floor' => $property_floor,
                'bayut_property' => $bayut_property, 'finder_property' => $finder_property, 'emirates_property' => $emirates_property, 'dubizzle_property' => $dubizzle_property, 'off_plans' => $off_plans,
                'property_statuses' => $property_statuses, 'rent_Frequencies' => $rent_Frequencies, 'finder_checkbox' => $finder_checkbox,
                'bayut_checkbox' => $bayut_checkbox, 'emirates_checkbox' => $emirates_checkbox, 'dubizzle_checkbox' => $dubizzle_checkbox,
                'bayutproperty_videos' => $bayutproperty_videos, 'dubizzleproperty_videos' => $dubizzleproperty_videos, "community" => $community, "subCommunity" => $subCommunity
            ]
        );
    }
    public function getPropertyType($type)
    {
        $types = [
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
        return isset($types[$type])? $types[$type] : $type;
    }

    public function getOfferingType($type)
    {
        $types = [
            "RR" => "Residential Rent",
            "RS" => "Residential Sale",
            'RC' => "Residential Commercial",
            'CR' => "Commercial Rent",
            'CS' => "Commercial Sale",

        ];
        return $types[$type];
    }
    public function duplicateproperty($id)
    {
        $type = [
            'RR' => "Residential Rent",
            'RS' => "Residential Sale"
        ];
        $property_type_residential = [
            "AP" => "Apartment Flat",
            "DX" => "Duplex",
            "LP" => "Land/Plot",
            "PH" => "Penthouse",
            "TH" => "Townhouse",
            "VH" => "Villa/House",
            "VI" => "Villa"
        ];
        $property_type_Commercial = [
            "FA" => "Factory",
            "FF" => "Full Floor",
            "LC" => "Labor Camp",
            "OF" => "Office Space",
            "SH" => "Shop",
            "WB" => "Whole Building",
            "WH" => "Warehouse",
        ];
        $city_uae = [
            'Dubai' => "Dubai",
            'Abu Dhabi' => "Abu Dhabi",
            'Umm Al Quwai' => "Umm Al Quwai",
            'Ajman' => "Ajman",
            'Ras Al-Khaimah' => "Ras Al-Khaimah",
            'Sharjah' => "Sharjah",
            'Fujairah' => "Fujairah",
            'Al Ain' => "Al Ain",
        ];
        $city_iraq = [
            'Baghdad' => "Baghdad",
            'Mosul' => "Mosul",
            'Basra' => "Basra",
            'Najaf' => "Najaf",
            'Karbala' => "Karbala",
            'Erbil' => "Erbil",
            'Sulaymaniyah' => "Sulaymaniyah",
            'Anbar' => "Anbar",
            'Dohuk' => "Dohuk",
            'Kirkuk' => "Kirkuk",
            'Diwaniyah' => "Diwaniyah",
            'Hillah' => "Hillah",
            'Nasiriyah' => "Nasiriyah",
            'Wasit' => "Wasit",
            'Ramadi' => "Ramadi",
            'Maysan' => "Maysan",
            'Salahaddin' => "Salahaddin",
            'Dhi Qar' => "Dhi Qar",
            'Nineveh' => "Nineveh",
            'Kermanshah' => "Kermanshah",
        ];
        $private_amenities = [
            'AC' => "CentralA/C&Heating",
            'BA' => "Balcony",
            'BK' => "Built in Kitchen Appliances",
            'BL' => "View of Landmark",
            'BW' => "Built in Wardrobes",
            'CP' => "Covered Parking",
            'CS' => "Concierge Service",
            'LB' => "Lobby in Building",
            'MR' => "Maid's Room",
            'MS' => "Maid Servicee",
            'PA' => "Pets Allowed",
            'PG' => "Private Garden",
            'PY' => "Private GYM",
            'PJ' => "Private Jacuzzi",
            'PP' => "Private Pool",
            'SE' => "Security",
            'SP' => "Shared Pool",
            'SS' => "Shared Spa",
            'ST' => "Study",
            'SY' => "Shared Gym",
            'VW' => "View of Water",
            'WC' => "Walk in Closet",
            'BR' => "Barbecue Area"
        ];
        $completion_status = [
            'completed' => "Completed",
            'off_plan' => "Off_Plan",
        ];
        $furnished = [
            'Yes' => "Furnished",
            'Partly' => "Semi-Furnished",
            'No' => "Unfurnished"

        ];
        $property_statuses = [
            'Live',
            'Archive'
        ];
        $off_plans = [
            'Yes',
            'No'
        ];
        $rent_Frequencies = [
            // 'Daily',
            // 'Weekly',
            // 'Monthly',
            'Yearly'
        ];
        $bedrooms = [
            '0' => "Studio",
            '1' => "1",
            '2' => "2",
            '3' => "3",
            '4' => "4",
            '5' => "5",
            '6' => "6",
            '7' => "7",
            '8' => "8",
            '9' => "9",
            '10' => "10",
            '11' => "11",
            '12' => "12",
            '13' => "13",
            '14' => "14",
            '15' => "15",
            '16' => "16",
            '17' => "17",
            '18' => "18",
            '19' => "19",
            '20' => "20",
        ];
        $cheques = [
            '1' => "1",
            '2' => "2",
            '3' => "3",
            '4' => "4",
            '5' => "5",
            '6' => "6",
            '7' => "7",
            '8' => "8",
            '9' => "9",
            '10' => "10",
            '11' => "11",
            '12' => "12",
        ];
        $newProperty = NewProperty::findOrFail($id);
        $users = User::select('id', 'name')
            ->where('role_id', '1')
            ->orWhere('role_id', '2')
            ->orWhere('role_id', '2,3')
            ->orWhere('role_id', '5')
            ->orWhere('role_id', '3')
            ->get();
        $property_images = PropertyImage::where('newProperty_id', $newProperty->id)->get();
        $property_floor = PropertyFloorPlan::where('newProperty_id', $newProperty->id)->get();
        $bayut_property = BayutProperty::where('newProperty_id', $newProperty->id)->first();
        $finder_property = FinderProperty::where('newProperty_id', $newProperty->id)->first();
        $emirates_property = EmiratesProperty::where('newProperty_id', $newProperty->id)->first();
        $dubizzle_property = DubizzleProperty::where('newProperty_id', $newProperty->id)->first();
        if ($bayut_property != null) {
            $bayut_checkbox = "Bayut";
            $bayutproperty_videos = PropertyVideo::where('newProperty_id', $newProperty->id)->get();
        } else {
            $bayut_checkbox = "no";
            $bayut_property = "";
            $bayutproperty_videos = "";
        }
        if ($finder_property != null) {
            $finder_checkbox = "finder";
        } else {
            $finder_checkbox = "no";
            $finder_property = "";
        }
        if ($emirates_property != null) {
            $emirates_checkbox = "emiratesEstate";
        } else {
            $emirates_checkbox = "no";
            $emirates_property = "";
        }
        if ($dubizzle_property != null) {
            $dubizzle_checkbox = "Dubizzle";
            $dubizzleproperty_videos = PropertyVideo::where('newProperty_id', $newProperty->id)->get();
        } else {
            $dubizzle_checkbox = "no";
            $dubizzle_property = "";
            $dubizzleproperty_videos = "";
        }

        $communities = Community::get();
        $subCommunities = SubCommunity::where('community_id', $newProperty->community)->get();
        $towersname = Building::where('subcommunity_id',$newProperty->sub_community)->get();
        $initial_pos=$newProperty->lat .',' .$newProperty->lng;
        if($initial_pos == ''){
            $initial_pos = '25.168282,55.250286';
        }
        $countries=Country::get();
        $country=Country::where('name',$newProperty->country)->first();
        $cities=($country) ? City::where('country_id',$country->id)->get() : [];
        return view(
            'admin.duplicateproperty',
            [
                'countries'=>$countries,'cities'=>$cities,
                'private_amenities' => $private_amenities, 'newProperty' => $newProperty, 'type' => $type, 'property_type_residential' => $property_type_residential,
                'property_type_Commercial' => $property_type_Commercial, 'city_uae' => $city_uae,'city_iraq'=> $city_iraq, 'completion_status' => $completion_status,
                'furnished' => $furnished, 'users' => $users, 'property_images' => $property_images, 'property_floor' => $property_floor,
                'bayut_property' => $bayut_property, 'finder_property' => $finder_property, 'emirates_property' => $emirates_property, 'dubizzle_property' => $dubizzle_property, 'off_plans' => $off_plans,
                'property_statuses' => $property_statuses, 'rent_Frequencies' => $rent_Frequencies, 'finder_checkbox' => $finder_checkbox,
                'bayut_checkbox' => $bayut_checkbox, 'emirates_checkbox' => $emirates_checkbox, 'dubizzle_checkbox' => $dubizzle_checkbox,
                'bayutproperty_videos' => $bayutproperty_videos, 'dubizzleproperty_videos' => $dubizzleproperty_videos, 'bedrooms' => $bedrooms,
                'cheques' => $cheques,
                'initial_pos' => $initial_pos,
                'communities' => $communities,
                'subCommunities' => $subCommunities,
                'towersname' => $towersname,
                'has_tour'=>$newProperty->has_tour
            ]
        );
    }

    public function duplicate_property(Request $request)
    {
        if (Auth::user()->isAgent()) {
            $request->validate(
                [
                    'permit_number' => 'required',
                    'offering_type' => 'required',
                    'property_type' => 'required',
                    'price' => 'required|min:0',
                    'city' => 'required',
                    'community' => 'required',
                    'sub_community' => 'required',
                    'property_name' => 'required',
                    'title_en' => 'required',
                    'description_en' => 'required',
                    'size' => 'required|min:0',
                    'bedroom' => 'required',
                    'bathroom' => 'nullable|numeric|min:0|max:10',
                    'cheques' => 'nullable',
                    'parking' => 'nullable|numeric|min:0|max:999',
                    'floor' => 'nullable|numeric|min:0',
                    'stories' => 'nullable|numeric|min:0',
                    'build_year' => 'nullable|numeric|min:0',
                    'service_charge' => 'nullable|numeric|min:0',
                    'plot_size' => 'nullable|min:0',
                    'slug' => 'required',
                    'project_name'=>'required',
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'bathroom.max' => 'The :attribute area should be less than 11.',
                    'parking.max' => 'The :attribute area should be less than 1000.',
                    'floor.min' => 'The :attribute area must be a positive value.',
                    'stories.min' => 'The :attribute area must be a positive value.',
                    'build_year.min' => 'The :attribute area must be a positive value.',
                    'price.min' => 'The :attribute area must be a positive value.',
                    'service_charge.min' => 'The :attribute area must be a positive value.',
                    'size.min' => 'The :attribute area must be a positive value.',
                    'plot_size.min' => 'The :attribute area must be a positive value.',

                ]
            );
        } else {
            $request->validate(
                [
                    'permit_number' => 'required',
                    'offering_type' => 'required',
                    'property_type' => 'required',
                    'price' => 'required|min:0',
                    'city' => 'required',
                    'community' => 'required',
                    'sub_community' => 'required',
                    'property_name' => 'required',
                    'title_en' => 'required',
                    'description_en' => 'required',
                    'size' => 'required|min:0',
                    'bedroom' => 'required',
                    'bathroom' => 'nullable|numeric|min:0|max:10',
                    'cheques' => 'nullable',
                    'parking' => 'nullable|numeric|min:0|max:999',
                    'floor' => 'nullable|numeric|min:0',
                    'stories' => 'nullable|numeric|min:0',
                    'build_year' => 'nullable|numeric|min:0',
                    'service_charge' => 'nullable|numeric|min:0',
                    'plot_size' => 'nullable|min:0',
                    'user_id' => 'required',
                    'slug' => 'required',
                    'project_name'=>'required',
                ],
                [
                    'required' => 'The :attribute field is required.',
                    'user_id.required' => 'The Agent field is required.',
                    'bathroom.max' => 'The :attribute area should be less than 11.',
                    'parking.max' => 'The :attribute area should be less than 1000.',
                    'floor.min' => 'The :attribute area must be a positive value.',
                    'stories.min' => 'The :attribute area must be a positive value.',
                    'build_year.min' => 'The :attribute area must be a positive value.',
                    'price.min' => 'The :attribute area must be a positive value.',
                    'service_charge.min' => 'The :attribute area must be a positive value.',
                    'size.min' => 'The :attribute area must be a positive value.',
                    'plot_size.min' => 'The :attribute area must be a positive value.',
                ]
            );
        }
        if ($request->private_amenities == "") {
            $private_amenities = "";
        } else {
            $private_amenities = implode(',', $request->private_amenities);
        }
        $slug=$this->slugify($request->slug);
        $property=NewProperty::where('slug',$slug)->first();
        if($property){
            return response()->json(['success' => false, 'message' => 'Slug is already taken. Please choose another slug']);
        }
        if (Auth::user()->isAgent()) {
            $newproperty = NewProperty::create([
                'reference_number' => $this->generateUniqueCode(),
                'permit_number' => $request->permit_number,
                'property_type' => $request->property_type,
                'offering_type' => $request->offering_type,
                'price' => str_replace(",", "", $request->price),
                'city' => $request->city,
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'size' => str_replace(",", "", $request->size),
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'community' => $request->community,
                'sub_community' => $request->sub_community,
                'private_amenities' => $private_amenities,
                'finder' => 1,
                'user_id' => auth()->user()->id,
                'slug' => $slug,
                'parking' => $request->parking,
                'property_name'=>$request->property_name,
                'property_status'=>$request->property_status,
                'completion_status'=>$request->completion_status,
                'lng'=>$request->search_longitude,
                'lat'=>$request->search_latitude,
                'country'=>$request->country,
                'project_name'=>$request->project_name,
                'featured'=>($request->featured) ? true : false,
            ]);

        } else {
            $newproperty = NewProperty::create([
                'reference_number' => $this->generateUniqueCode(),
                'permit_number' => $request->permit_number,
                'property_type' => $request->property_type,
                'offering_type' => $request->offering_type,
                'price' => str_replace(",", "", $request->price),
                'city' => $request->city,
                'title_en' => $request->title_en,
                'title_ar' => $request->title_ar,
                'description_en' => $request->description_en,
                'description_ar' => $request->description_ar,
                'size' => str_replace(",", "", $request->size),
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'community' => $request->community,
                'sub_community' => $request->sub_community,
                'private_amenities' => $private_amenities,
                'finder' => 1,
                'user_id' => $request->user_id,
                'slug' => $slug,
                'parking' => $request->parking,
                'property_name'=>$request->property_name,
                'property_status'=>$request->property_status,
                'completion_status'=>$request->completion_status,
                'lng'=>$request->search_longitude,
                'lat'=>$request->search_latitude,
                'country'=>$request->country,
                'project_name'=>$request->project_name,
                'featured'=>($request->featured) ? true : false,
            ]);

        }
        $property_images = PropertyImage::where('newProperty_id', $request->property_id)->get();
        if($property_images){
            foreach($property_images as $image){
                DB::table('property_images')->insert(
                    array(
                        'url' => $image->url,
                        'newProperty_id' => $newproperty->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'is_external_image'=>$image->is_external_image
                    )
                );
            }
        }
        $property_floor = PropertyFloorPlan::where('newProperty_id', $request->property_id)->get();
        if($property_floor){
            foreach($property_floor as $floor){
                DB::table('property_floor_plans')->insert(
                    array(
                        'url' => $floor->url,
                        'newProperty_id' => $newproperty->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
            }
        }
        if ($request->TotalFiles > 0) {
            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $file = $request->file('files' . $x);
                    $name=uploadFile($file ,'properties/images/'.$newproperty->reference_number,false);
                    // $setting = Setting::where('type','logo')->first();
                    // if($setting){
                    //     if(FileExists($setting->description['logo'])){
                    //         $img = Image::make(config('services.cms_link').'/storage/properties/images/'.$newproperty->reference_number .'/'. $name);
                    //         $watermark = Image::make(config('services.cms_link').'/'.$setting->description['logo']);

                    //         $watermark->opacity(40);
                    //         $watermark->resize($setting->description['watermark_width'], $setting->description['watermark_height']);
                    //         $img->insert($watermark, $setting->description['watermark_position']);
                    //         $exten=pathinfo($name, PATHINFO_EXTENSION );
                    //         $storage_type = env('STORAGE_TYPE') ?? 's3';
                    //         Storage::disk($storage_type)->put('storage/properties/images/'.$newproperty->reference_number.'/'. $name, $img->encode($exten)->stream()->__toString(),'public');
                    //     }

                    // }
                }
                DB::table('property_images')->insert(
                    array(
                        'url' =>  $newproperty->reference_number .'/'.$name,
                        'newProperty_id' => $newproperty->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
            }
        }
        if ($request->FloorPlan > 0) {
            for ($x = 0; $x < $request->FloorPlan; $x++) {
                if ($request->hasFile('floorplans' . $x)) {
                    $file = $request->file('floorplans' . $x);
                    $name=uploadFile($file ,'properties/FloorPrperty/'.$newproperty->reference_number,false);
                }
                DB::table('property_floor_plans')->insert(
                    array(
                        'url' =>$newproperty->reference_number .'/'.$name,
                        'newProperty_id' => $newproperty->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    )
                );
            }
        }
        if (
            $newproperty
        )
            return response()->json(['success' => true, 'message' => 'Property created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in createing Property ']);
    }
    public function delete_property_images($id)
    {
        $image = DB::table('property_images')->where('newProperty_id', $id)->first();
        $image->delete();
        return response()->json([
            'message' => 'Data deleted successfully!'
        ]);
    }
    public function sync(Request $request)
    {

        return view('admin.sync');
    }
}
