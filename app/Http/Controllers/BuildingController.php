<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Building;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class BuildingController extends Controller
{
    public function create_building(Request $request)
    {

        return  view('buildings.create_buildings');
    }

    public function create_new_building(Request $request)
    {
        $request->validate(
            [
                'building_name' => 'required',
            ]
        );

        $building = Building::create([
            'building_name' => $request->building_name,
        ]);

        if ($building != null)
            return response()->json(['success' => true, 'message' => 'Building created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new Building']);
    }

    public function listbuildingindex(Request $request)
    {
        return view('buildings.list_building');
    }

    public function list_building(Request $request)
    {
        if (Auth::user()->isadmin() || Auth::user()->issuperAdmin()) {
            $Building = Building::get();
            return DataTables::of($Building)
                ->addIndexColumn()
                ->addColumn('building_name', function ($row) {
                    return $row != null ? $row->building_name : "";
                })
                
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        } 
    }

    public function upnewbuilding($id)
    {
        $building = Building::find($id);
            return view('buildings.update_buildings', ['building' => $building]);
    }

    public function update_building(Request $request, $id)
    {
            $roles = [];
            $roles['building_name'] = 'required';
            $request->validate($roles);

            try {
                $building = Building::where('id', $id)->first();
                $building->building_name = $request->building_name;
               
                $building->save();


                if ($building)
                    return response()->json(['success' => true, 'message' => 'Building updated successfully']);
                else
                    return response()->json(['success' => false, 'message' => 'Error in updating Building data']);
            } catch (Exception $ex) {
                dd($ex->getMessage());
            }
        
    }

    public function delete_building(Request $request)
    {
        $building = Building::destroy($request->id);
        if ($building)
            return response()->json(['success' => true, 'message' => 'Building has been deleted successfully']);
        else
            return response()->json(['success' => true, 'message' => 'Error while deleting Building']);
    }
}
