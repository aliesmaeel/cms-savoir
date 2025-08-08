<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Imports\InventoryImport;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class inventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createinventoryindex()
    {
        // developers
        $developers = [
            "EMAAR", "DAMAC", "NAKHEEL", "DUBAI PROPERTIES", "MERAAS", "MEYDAN", "SOBHA", "DEYAAR", "OMNIYAT", "MAG",
            "Select Group", "The First Group", "Wasl Properties", "Dubai Investments Real Estate",
            "Binghatti Developers", "Azizi Developments", "Danube", "Ellington Properties", "Tilal Properties",
            "Al Futtaim Real Estate", "Majid al Futtaim Real Estate", "Diamond Developers", "Nshama",
            "Al Habtoor Group", "Bloom Properties", "Seven Tides International", "Cayan Group", "Al Barari",
            "Time Properties", "G&Co Properties"
        ];
        sort($developers);

        // dubai locations
        $locations = [
            "Abu Hail",
            "Al Awir First",
            "Al Awir Second",
            "Al Bada",
            "Al Baraha",
            "Al Barsha First",
            "Al Barsha Second",
            "Al Barsha South First",
            "Al Barsha South Second",
            "Al Barsha South Third",
            "Al Barsha Third",
            "Al Buteen",
            "Al Dhagaya",
            "Al Garhoud",
            "Al Guoz Fourth",
            "Al Hamriya, Dubai",
            "Al Hamriya Port",
            "Al Hudaiba",
            "Al Jaddaf",
            "Al Jafiliya",
            "Al Karama",
            "Al Khabisi",
            "Al Khwaneej First",
            "Al Khwaneej Second",
            "Al Kifaf",
            "Al Mamzar",
            "Al Manara",
            "Al Mankhool",
            "Al Merkad",
            "Al Mina",
            "Al Mizhar First",
            "Al Mizhar Second",
            "Al Muraqqabat",
            "Al Murar",
            "Al Mushrif",
            "Al Muteena",
            "Al Nahda First",
            "Al Nahda Second",
            "Al Nasr, Dubai",
            "Al Quoz First",
            "Al Quoz Industrial First",
            "Al Quoz Industrial Fourth",
            "Al Quoz Industrial Second",
            "Al Quoz Industrial Third",
            "Al Quoz Second",
            "Al Quoz Third",
            "Al Qusais First",
            "Al Qusais Industrial Fifth",
            "Al Qusais Industrial First",
            "Al Qusais Industrial Fourth",
            "Al Qusais Industrial Second",
            "Al Qusais Industrial Third",
            "Al Qusais Second",
            "Al Qusais Third",
            "Al Raffa",
            "Al Ras",
            "Al Rashidiya",
            "Al Rigga",
            "Al Sabkha",
            "Al Safa First",
            "Al Safa Second",
            "Al Safouh First",
            "Al Safouh Second",
            "Al Satwa",
            "Al Shindagha",
            "Al Souq Al Kabeer",
            "Al Twar First",
            "Al Twar Second",
            "Al Twar Third",
            "Al Warqa'a Fifth",
            "Al Warqa'a First",
            "Al Warqa'a Fourth",
            "Al Warqa'a Second",
            "Al Warqa'a Third",
            "Al Wasl",
            "Al Waheda",
            "Ayal Nasir",
            "Aleyas",
            "Business Bay",
            "Bu Kadra",
            "Dubai Investment park First",
            "Dubai Investment Park Second",
            "Emirates Hill First",
            "Emirates Hill Second",
            "Emirates Hill Third",
            "Hatta",
            "Hor Al Anz",
            "Hor Al Anz East",
            "Jebel Ali 1",
            "Jebel Ali 2",
            "Jebel Ali Industrial",
            "Jebel Ali Palm",
            "Jumeira First",
            "Palm Jumeira",
            "Jumeira Second",
            "Jumeira Third",
            "Marsa Dubai",
            "Mirdif",
            "Muhaisanah Fourth",
            "Muhaisanah Second",
            "Muhaisanah Third",
            "Muhaisnah First",
            "Nad Al Hammar",
            "Nadd Al Shiba Fourth",
            "Nadd Al Shiba Second",
            "Nadd Al Shiba Third",
            "Nad Shamma",
            "Naif",
            "Port Saeed",
            "Arabian Ranches",
            "Oud Al Muteena Third",
            "Ras Al Khor",
            "Ras Al Khor Industrial First",
            "Ras Al Khor Industrial Second",
            "Ras Al Khor Industrial Third",
            "Rigga Al Buteen",
            "Trade Centre 1",
            "Trade Centre 2",
            "Umm Al Sheif",
            "Umm Hurair First",
            "Umm Hurair Second",
            "Umm Ramool",
            "Umm Suqeim First",
            "Umm Suqeim Second",
            "Umm Suqeim Third",
            "Wadi Alamardi",
            "Warsan First",
            "Warsan Second",
            "Za'abeel First",
            "Za'abeel Second"

        ];
        sort($locations);

        $propertytype = ["Apartment", "Townhouse", "Villa Compound", "Residential Plot", "Residential Building", "Villa", "Penthouse", "Hotel Apartment", "Residential Floor"];
        sort($propertytype);

        $status = config('app.user_status');
        return view('adminagent.inventory.createinventory', ['developers' => $developers, 'locations' => $locations, 'status' => $status, 'propertytype' => $propertytype]);
    }
    public function createnewinventory(Request $request)
    {
        //save floor plan/view image
        if ($request->floor_plans_view != null && $request->floor_plans_view != "undefined") {
            $fileName = rand(0, 10000) . time() . '.' . $request->floor_plans_view->extension();
            $request->floor_plans_view->move(public_path('images/'), $fileName);
        }

        $inventory = Inventory::create([
            'source_of_lead' => $request->source_of_lead,
            'remarks' => $request->remarks,
            'unit_for_sales' => $request->unit_for_sales,
            'client_name' => Auth::user()->isagent() ? Auth::user()->name : $request->client_name,
            'building_status' => $request->building_status,
            'category' => $request->category,
            'agent_name' => $request->agent_name,
            'date_listed' => $request->date_listed,
            'serial_num' => $request->serial_num,
            'developer' => $request->developer,
            'community_location' => $request->community_location,
            'building_name' => $request->building_name,
            'property_name' => $request->property_name,
            'unit_number' => $request->unit_number,
            'plot_area' => $request->plot_area,
            'customer_name' => $request->customer_name,
            'email_address' => $request->email_address,
            'mobile' => $request->mobile,
            'comments' => $request->comments,
            'status' => $request->status,
            'nationality' => $request->nationality,
            'property_type' => $request->property_type,
            'furniture' => $request->furniture,
            'floor_plans_View' => $request->floor_plans_view != 'undefined' ? ('/images/' . $fileName) : null,
            'bedrooms' => $request->bedrooms,
            'customer_type' => $request->customer_type,
            'can_add' => $request->can_add,
            'unite_price' => $request->unite_price,
            'roi' => $request->roi,
            'telephone_number' => $request->telephone_number,
            'telephone_residence' => $request->telephone_residence,
            'telephone_office' => $request->telephone_office,
            'general' => $request->general,
            'property_finder_link' => $request->property_finder_link,
            'buyut_link' => $request->buyut_link,
            'dubizzle_link' => $request->dubizzle_link,
            'wow_propties_link' => $request->wow_propties_link,
            'other_links' => $request->other_links,
            'type_of_apt' => $request->type_of_apt,
            'property_size' => $request->property_size,
            'floors' => $request->floors,
            'service_charge' => $request->service_charge,
            'payment_plan' => $request->payment_plan,
            'rent' => $request->rent,
            'ready_off' => $request->ready_off,
            'handover' => $request->handover,
            'price_aed' => $request->price_aed,
            'bathrooms' => $request->bathrooms,
            'completion' => $request->completion
        ]);

        if ($inventory != null)
            return response()->json(['success' => true, 'message' => 'Inventory created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new inventory']);
    }
    public function getinventoriesindex()
    {
        $customer_type = ['Seller', 'Buyer', 'Rent'];
        $bedrooms = Inventory::select('bedrooms')->groupBy('bedrooms')->pluck('bedrooms');
        $floors = Inventory::select('floors')->groupBy('floors')->pluck('floors');
        $propertiessize = Inventory::select('property_size')->groupBy('property_size')->pluck('property_size');
        return view('adminagent.inventory.inventories', ['customertype' => $customer_type, 'bedrooms' => $bedrooms, 'propertiessize' => $propertiessize, 'floors' => $floors]);
    }
    public function importinventory(Request $request)
    {
        if ($request->file == 'undefined')
            return response()->json(['success' => false, 'message' => 'You should select file first']);
        $validator = Validator::make(
            [
                'file' => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:csv',
            ]
        );

        $validator->validate();
        Excel::import(new InventoryImport, $request->file('file'));
        return response()->json(['success' => true, 'message' => 'File imported successfully']);
    }
    public function getinventories(Request $request)
    {

        $data = Inventory::get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                // $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
                return $actionBtn;
            })
            ->addColumn('image', function ($row) {
                return '<img src=' . $row->floor_plans_view . ' alt="" style="width: 150px;">';
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }
    public function deleteinventory(Request $request)
    {
        try {
            $data = Inventory::where('id', $request->id)->first();
            if ($data) {
                try {
                    $data->delete();
                } catch (Exception $ex) {
                    return response()->json(['success' => false, 'message' => "Inventory cannot be deleted"]);
                }
                return response()->json(['success' => true, 'message' => "Inventory has been deleted successfully"]);
            } else
                return response()->json(['success' => false, 'message' => "Inventory not found"]);
        } catch (Exception $ex) {
        }
    }
}
