<?php

namespace App\Http\Controllers;

use App\Models\NewProperty;
use App\Models\OffPlanProject;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class OffPlanProjectController extends Controller
{

    public function popUpUpdate (Request  $request)
    {
        $popup=Popup::query()->first();
        if ($request->ajax()) {
            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $store= $file->storeAs('img','popup.png','public');
                $popup->update([
                    'image' => $store
                ]);

                if ($popup != null)
                    return response()->json(['success' => true, 'message' => 'popup Project created successfully']);
                else
                    return response()->json(['success' => false, 'message' => 'Error in creating popup Project']);
            }

        }
        return view('offPlanProject.popupUpdate',compact('popup'));

    }
    public function off_plan_project_list(Request $request)
    {
        if ($request->ajax()) {
            $data=OffPlanProject::query()->orderBy('order','ASC')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'. route('off_plan_project_update', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->addColumn('image_col', function ($row) {
                    if ($row->image) {
                        return '<img src="' .config('services.cms_link').'/storage/'.$row->image . '" class="img-50" style="width: 100px;" />';
                    } else {
                        return '';
                    }
                })
                ->addColumn('property_name', function ($row) {
                    if ($row->property) {
                        return $row->property->title_en;
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['action','image_col','property_name'])
                ->make(true);
        }
        return view('offPlanProject.list');
    }
    public function off_plan_project_create(Request $request)
    {

        if ($request->ajax()) {

           $validator= $request->validate(
                [
                    'title' => 'required',
                    'link' => 'required',
                    'details' => 'required',
                    'area'=>'required',
                    'description'=>'required',
                    'during_construction'=>'required',
                    'on_handover'=>'required',
                    'area_guide_description'=>'required',
                    'lat'=>'required',
                    'lng'=>'required',
                    'features'=>'required',
                    'location'=>'required',
                    'order'=>'required'
                ]
            );

            $off_plan= OffPlanProject::create($validator);

            if ($request->hasFile('header_images')) {
                $filenames = [];
                foreach ($request->file('header_images') as $image) {
                    $filename =uploadFile($image ,'offplan');
                    $filenames[] = $filename;
                }
                $off_plan->update([
                    'header_images' => $filenames
                ]);
            }


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'offplan');
                $off_plan->update([
                    'image' => $filename
                ]);
            }

            if ($request->hasFile('last_image')) {
                $file = $request->file('last_image');
                $filename =uploadFile($file  ,'offplan');
                $off_plan->update([
                    'last_image' => $filename
                ]);
            }

            if ($request->hasFile('description_image')) {
                $file = $request->file('description_image');
                $filename =uploadFile($file  ,'offplan');
                $off_plan->update([
                    'description_image' => $filename
                ]);
            }

            if ($request->hasFile('area_guide_image')) {
                $file = $request->file('area_guide_image');
                $filename =uploadFile($file  ,'offplan');
                $off_plan->update([
                    'area_guide_image' => $filename
                ]);
            }




            if ($off_plan != null)
                return response()->json(['success' => true, 'message' => 'Off-Plan Project created successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in creating Off-Plan Project']);
        }
        $off_plan_projects = OffPlanProject::pluck('id')->unique()->toArray();
        return view('offPlanProject.create',compact('off_plan_projects'));
    }
    public function off_plan_project_delete(Request $request)
    {
        $off_plan = OffPlanProject::find($request->id);
        if ($off_plan){
            deleteFile($off_plan->image);
            deleteFile($off_plan->area_guide_image);
            deleteFile($off_plan->description_image);
            deleteFile($off_plan->last_image);
            if($off_plan->header_images){
                foreach($off_plan->header_images as $key){
                    deleteFile($key);
                }
            }
            $off_plan->delete();
            return response()->json(['success' => true, 'message' => 'Off-Plan Project has been deleted successfully']);
        }else{
            return response()->json(['success' => false, 'message' => 'Error while deleting Off-Plan Project']);
        }
    }
    public function off_plan_project_update(Request $request,$id)
    {

        $off_plan = OffPlanProject::find($id);

        if ($request->ajax()) {

            // dd($request->all());
            if($off_plan){
                $validator= $request->validate(
                    [
                        'title' => 'required',
                        'link' => 'required',
                        'details' => 'required',
                        'area'=>'required',
                        'description'=>'required',
                        'during_construction'=>'required',
                        'on_handover'=>'required',
                        'area_guide_description'=>'required',
                        'lat'=>'required',
                        'lng'=>'required',
                        'features'=>'required',
                         'location'=>'required',
                        'order'=>'required'
                    ]
                );

                $off_plan->update($validator);

                if ($request->hasFile('header_images')) {
                    if($off_plan->header_images){
                        foreach($off_plan->header_images as $key){
                            deleteFile($key);
                        }
                    }
                    $filenames = [];
                    foreach ($request->file('header_images') as $image) {
                        $filename=uploadFile($image ,'offplan');
                        $filenames[] = $filename;
                    }
                    $off_plan->update([
                        'header_images' => $filenames
                    ]);
                }


                if ($request->hasFile('image')) {
                    deleteFile($off_plan->image);
                    $file = $request->file('image');
                    $filename=uploadFile($file ,'offplan');
                    $off_plan->update([
                        'image' => $filename
                    ]);
                }

                if ($request->hasFile('last_image')) {
                    deleteFile($off_plan->last_image);
                    $file = $request->file('last_image');
                    $filename=uploadFile($file ,'offplan');
                    $off_plan->update([
                        'last_image' => $filename
                    ]);
                }

                if ($request->hasFile('description_image')) {
                    deleteFile($off_plan->description_image);
                    $file = $request->file('description_image');
                    $filename=uploadFile($file ,'offplan');
                    $off_plan->update([
                        'description_image' => $filename
                    ]);
                }

                if ($request->hasFile('area_guide_image')) {
                    deleteFile($off_plan->area_guide_image);
                    $file = $request->file('area_guide_image');
                    $filename=uploadFile($file ,'offplan');
                    $off_plan->update([
                        'area_guide_image' => $filename
                    ]);
                }

                return response()->json(['success' => true, 'message' => 'Off-Plan Project updated successfully']);

            }else{
                return response()->json(['success' => false, 'message' => 'Off-Plan Project not found']);
            }
        }
        $off_plan_projects = OffPlanProject::pluck('id')->unique()->toArray();
        return view('offPlanProject.update',compact('off_plan','off_plan_projects'));
    }
}
