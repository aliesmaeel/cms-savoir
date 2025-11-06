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

            // ✅ Validate only the fields that exist in the new DB
            $validator = $request->validate([
                'title' => 'required',
                'link' => 'required',
                'area' => 'required',
                'description' => 'required',
                'during_construction' => 'required',
                'on_handover' => 'required',
                'features' => 'required',
                'lat' => 'required',
                'lng' => 'required',
                'location' => 'required',
                'order' => 'required',
                'developer' => 'nullable',
                'starting_price' => 'nullable',
                'completion_date' => 'nullable',
                'project_size' => 'nullable',
                'lifestyle' => 'nullable',
                'title_type' => 'nullable',
                'first_installment' => 'nullable',
                'youtube_link' => 'nullable',
            ]);

            // ✅ Create the project
            $off_plan = OffPlanProject::create($validator);

            $cloudName = "djd3y5gzw";
            $baseS3Url = "https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/";

            // ✅ Handle multiple header images
            if ($request->hasFile('header_images')) {
                $filenames = [];
                foreach ($request->file('header_images') as $image) {
                    $filename = uploadFile($image, 'offplan');
                    $originalUrl = $baseS3Url . $filename;
                    $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                    $filenames[] = $optimizedUrl;
                }

                $off_plan->update([
                    'header_images' => $filenames
                ]);
            }

            // ✅ Handle main image
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uploadFile($file, 'offplan');
                $originalUrl = $baseS3Url . $filename;
                $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                $off_plan->update([
                    'image' => $optimizedUrl
                ]);
            }

            // ✅ Response
            return response()->json([
                'success' => true,
                'message' => 'Off-Plan Project created successfully'
            ]);
        }

        $off_plan_projects = OffPlanProject::pluck('id')->unique()->toArray();
        return view('offPlanProject.create', compact('off_plan_projects'));
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
    public function off_plan_project_update(Request $request, $id)
    {
        $off_plan = OffPlanProject::find($id);

        if ($request->ajax()) {

            if ($off_plan) {
                // ✅ Validate only existing fields
                $validator = $request->validate([
                    'title' => 'required',
                    'link' => 'required',
                    'area' => 'required',
                    'description' => 'required',
                    'during_construction' => 'required',
                    'on_handover' => 'required',
                    'features' => 'required',
                    'lat' => 'required',
                    'lng' => 'required',
                    'location' => 'required',
                    'order' => 'required',
                    'developer' => 'nullable',
                    'starting_price' => 'nullable',
                    'completion_date' => 'nullable',
                    'project_size' => 'nullable',
                    'lifestyle' => 'nullable',
                    'title_type' => 'nullable',
                    'first_installment' => 'nullable',
                    'youtube_link' => 'nullable',
                ]);

                // ✅ Update the project
                $off_plan->update($validator);

                $cloudName = "djd3y5gzw";
                $baseS3Url = "https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/";

                // ✅ Update header images
                if ($request->hasFile('header_images')) {
                    if ($off_plan->header_images) {
                        foreach ($off_plan->header_images as $key) {
                            deleteFile($key);
                        }
                    }

                    $filenames = [];
                    foreach ($request->file('header_images') as $image) {
                        $filename = uploadFile($image, 'offplan');
                        $originalUrl = $baseS3Url . $filename;
                        $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                        $filenames[] = $optimizedUrl;
                    }

                    $off_plan->update([
                        'header_images' => $filenames
                    ]);
                }

                // ✅ Update main image
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $filename = uploadFile($image, 'offplan');
                    $originalUrl = $baseS3Url . $filename;

                    $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                    $off_plan->update([
                        'image' => $optimizedUrl
                    ]);
                }

                return response()->json(['success' => true, 'message' => 'Off-Plan Project updated successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Off-Plan Project not found']);
            }
        }

        $off_plan_projects = OffPlanProject::pluck('id')->unique()->toArray();
        return view('offPlanProject.update', compact('off_plan', 'off_plan_projects'));
    }


}
