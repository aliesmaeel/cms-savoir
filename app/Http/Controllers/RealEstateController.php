<?php

namespace App\Http\Controllers;

use App\Models\OffPlanProject;
use App\Models\RealEstate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class RealEstateController extends Controller
{

    public function download($filename)
    {
        $filePath = public_path('/storage/realestatepdf/' . $filename); // Adjust the path as needed
      ;
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function real_estate_guides_update(Request $request,$id){
        $off_plan = RealEstate::find($id);

        if ($request->ajax()) {

            if($off_plan){

                $off_plan->update(['title'=>$request->title]);

                if ($request->hasFile('image')) {

                    $file = $request->file('image');
                    $randomFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                    $store= $file->storeAs('realestateimage',$randomFileName,'public');
                    $off_plan->update([
                        'image' => $store
                    ]);

                }

                if ($request->hasFile('pdf')) {
                    $file = $request->file('pdf');
                    $originalFileName = $file->getClientOriginalName(); // Get the original file name
                    $fileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME); // Get the filename without extension
                    $extension = $file->getClientOriginalExtension(); // Get the file extension
                    $slugifiedFileName = Str::slug($fileNameWithoutExtension) . '.' . $extension; // Slugify the filename and append the extension
                    $store = $file->storeAs('realestatepdf', $slugifiedFileName, 'public'); // Save with the slugified name
                    $off_plan->update([
                        'pdf' => $slugifiedFileName
                    ]);
                }


                return response()->json(['success' => true, 'message' => 'real estate successfully']);

            }else{
                return response()->json(['success' => false, 'message' => 'real estate not found']);
            }
        }
        $off_plan_projects = RealEstate::pluck('id')->unique()->toArray();
        $filename=$cleanedString = preg_replace('/^pdf\//', '', $off_plan->pdf);

        return view('realEstate.update',compact('off_plan','off_plan_projects','filename'));

    }
    public function real_estate_guides_delete(Request  $request)
    {

        $off_plan = RealEstate::find($request->id);
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $randomFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $store= $file->storeAs('realestateimage',$randomFileName,'public');
            $off_plan->update([
                'image' => $store
            ]);

        }

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $originalFileName = $file->getClientOriginalName(); // Get the original file name
            $fileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME); // Get the filename without extension
            $extension = $file->getClientOriginalExtension(); // Get the file extension
            $slugifiedFileName = Str::slug($fileNameWithoutExtension) . '.' . $extension; // Slugify the filename and append the extension
            $store = $file->storeAs('realestatepdf', $slugifiedFileName, 'public'); // Save with the slugified name
            $off_plan->update([
                'pdf' => $slugifiedFileName
            ]);
        }

        if ($off_plan){
            $off_plan->delete();
            return response()->json(['success' => true, 'message' => 'Real Estate has been deleted successfully']);
        }else{
            return response()->json(['success' => false, 'message' => 'Error while deleting Real Estate']);
        }

    }

    public function real_estate_guides_create (Request $request)
    {
        if ($request->ajax()) {

            $validator= $request->validate(
                ['title' => 'required', 'image'=>'required', 'pdf'=>'required']
            );

            $off_plan= RealEstate::create(['title'=>$request->title,'image'=>'e','pdf'=>'e']);

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $randomFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
                $store= $file->storeAs('realestateimage',$randomFileName,'public');

                $off_plan->update([
                    'image' => $store
                ]);

            }

            if ($request->hasFile('pdf')) {
                $file = $request->file('pdf');
                $originalFileName = $file->getClientOriginalName(); // Get the original file name
                $fileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME); // Get the filename without extension
                $extension = $file->getClientOriginalExtension(); // Get the file extension
                $slugifiedFileName = Str::slug($fileNameWithoutExtension) . '.' . $extension; // Slugify the filename and append the extension
                $store = $file->storeAs('realestatepdf', $slugifiedFileName, 'public'); // Save with the slugified name
                $off_plan->update([
                    'pdf' => $slugifiedFileName
                ]);
            }

            if ($off_plan != null)
                return response()->json(['success' => true, 'message' => 'real estate Project created successfully']);
            else
                return response()->json(['success' => false, 'message' => 'real estate in creating Off-Plan Project']);
        }
        $off_plan_projects = RealEstate::pluck('id')->unique()->toArray();

        return view('realEstate.create',compact('off_plan_projects'));
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
    public function real_estate_list (Request $request)
    {

        if ($request->ajax()) {
            $data=RealEstate::query()->orderBy('id','ASC')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'. route('real_estate_guides_update', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->addColumn('image_col', function ($row) {
                    if ($row->image) {
                        return '<img src="'.asset('/storage/'.$row->image).'" class="img-50" style="width: 100px;" />';
                    } else {
                        return '';
                    }
                })
                ->addColumn('property_name', function ($row) {
                    if ($row->property) {
                        return $row->property->title;
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['action','image_col','property_name'])
                ->make(true);
        }

        return view('realEstate.list');

    }
}
