<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        if($request->ajax()){
            $countries=Country::get();
            return DataTables::of($countries)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'.route('update_country',$row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                }) ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' .asset('/storage/'.$row->image). '" class="img-50" style="width: 100px;" />';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('countries.index');
    }
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'name' => 'required',
                'code' => 'required|unique:countries,code',
                'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            // Create country without image
            $country = Country::create($request->except(['_token', 'image', 'show_in_home_page']));
            $cloudName = "djd3y5gzw"; // ⚠️ Replace with your actual Cloudinary cloud name
            // Handle file upload
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'countries');
                $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/'.$filename;
                // Generate optimized Cloudinary URL
                $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                // Handle checkbox value
                $show = $request->show_in_home_page == 'on' ? 1 : 0;

                // Update country record
                $country->update([
                    'image' => $store,
                    'show_in_home_page' => $show,
                ]);
            }

            if ($country) {
                return response()->json([
                    'success' => true,
                    'message' => 'Country created successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating new Country',
                ]);
            }
        }

        return view('countries.create');
    }

    public function update(Request $request, $id)
    {
        $country = Country::find($id);

        if ($request->ajax()) {
            $request->validate([
                'name' => 'required',
                'code' => 'required|unique:countries,code,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($country) {
                // Update basic fields except image
                $country->update($request->except(['_token', 'image', 'show_in_home_page']));

                $show = $request->show_in_home_page == 'on' ? 1 : 0;
                $cloudName = "djd3y5gzw"; // ⚠️ Replace with your actual Cloudinary cloud name
                $store = $country->image; // Default: existing image stays the same

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename =uploadFile($file  ,'countries');
                    $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/'.$filename;
                    // Generate optimized Cloudinary URL
                    $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                }

                // Update the record
                $country->update([
                    'image' => $store,
                    'show_in_home_page' => $show,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Country updated successfully',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Country not found',
            ]);
        }

        // Normal (non-AJAX) request → return view
        if ($country) {
            return view('countries.update', compact('country'));
        }

        return back();
    }

    public function delete(Request $request){
        $country=Country::find($request->id);
        if($country){
            $country->delete();
            return response()->json(['success' => true, 'message' => 'Country deleted successfully']);
        }else{
            return response()->json(['success' => false, 'message' => 'Country not found']);
        }
    }

    ////cities
    public function list_cities(Request $request){
        if($request->ajax()){
            $cities=City::get();
            return DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('country', function ($row) {
                    return ($row->country) ? $row->country->name : null;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'.route('update_city',$row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cities.index');
    }
    public function create_city(Request $request){
        if($request->ajax()){
            $request->validate(
                [
                    'name' => 'required',
                    'country_id' => 'required',
                ]
            );
            $city=City::create($request->except('_token'));
            if($city){
                return response()->json(['success' => true, 'message' => 'City created successfully']);
            }else{
                return response()->json(['success' => false, 'message' => 'Error in creating new City']);
            }
        }
        $country=Country::get();
        return view('cities.create',compact('country'));

    }
    public function update_city(Request $request,$id){
        $city=City::find($id);
        if($request->ajax()){
            $request->validate(
                [
                    'name' => 'required',
                    'country_id' => 'required',
                ]
            );
            if($city){
                $city->update($request->except('_token'));
                return response()->json(['success' => true, 'message' => 'City updated successfully']);
            }else{
                return response()->json(['success' => false, 'message' => 'City not found']);
            }
        }
        if($city){
            $country=Country::get();
            return view('cities.update',compact('city','country'));
        }else{
            return back();
        }
    }
    public function delete_city(Request $request){
        $city=City::find($request->id);
        if($city){
            $city->delete();
            return response()->json(['success' => true, 'message' => 'City deleted successfully']);
        }else{
            return response()->json(['success' => false, 'message' => 'City not found']);
        }
    }
    public function get_cities($country_id){
        $cities=City::where('country_id',$country_id)->get();
        return $cities;
    }

    public function showEmails()
    {
        return view('Email.list');
    }

    public function processEmails(Request $request)
    {
        if ($request->ajax()) {
            // Fetch data for the DataTables
            $data = Email::query()->orderBy('order', 'ASC')->get();

            // Use DataTables to format the response
            return \Yajra\DataTables\Facades\DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="' . route('off_plan_project_update', $row->id) . '" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'image_col', 'property_name'])
                ->make(true);
        }

        // Return a response in case the request is not AJAX
        return response()->json(['message' => 'Invalid request'], 400);
    }

}
