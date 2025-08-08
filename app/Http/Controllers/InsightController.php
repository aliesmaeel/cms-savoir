<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\OffPlanProject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InsightController extends Controller
{
    public function insight_create(Request  $request)
    {
        if ($request->ajax()) {

            $validator= $request->validate(
                [
                    'title' => 'required',
                    'description'=>'required',
                ]
            );

            $insight= Insight::create([
                'title' => $request->title,
                'description' => $request->description,
                'youtube' => $request->link,
                'isfeatured' => $request->feature == 'on' ? 1 : 0,
                'slug' => $request->slug,
            ]);


            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'insights');
                $insight->update([
                    'image' => $filename
                ]);
            }

            if ($insight != null)
                return response()->json(['success' => true, 'message' => 'insight Project created successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in creating insight Project']);
        }

        return view('admin.insights.create');

    }

    public function insight_list(Request $request)
    {

        if ($request->ajax()) {
            $data = Insight::select(['id', 'title', 'slug', 'image', 'youtube', 'isfeatured'])
                ->orderBy('id', 'DESC')
                ->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = '<img src="'.config('services.cms_link').'/storage/'.$row->image.'" width="100px" height="100px">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'. route('insight_update', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['title','image','slug','isfeatured','action'])
                ->make(true);
        }

        return view('admin.insights.list');
    }

    public function insight_delete(Request $request)
    {
        $insight = Insight::find($request->id);
        if($insight->delete()){
            return response()->json(['success' => true, 'message' => 'Insight has been deleted successfully']);
        }else{
            return response()->json(['success' => false, 'message' => 'Error while deleting Insight']);
        }
    }

    public function insight_list_update(Request $request,$id)
    {
        $insight = Insight::find($id);

        if ($request->ajax()) {

            if($insight){
                $validator= $request->validate(
                    [
                        'title' => 'required',
                        'description'=>'required',
                    ]
                );
                $insight->update(
                    [
                        'title' => $request->title,
                        'description' => $request->description,
                        'youtube' => $request->link,
                        'isfeatured' => $request->feature == 'on' ? 1 : 0,
                        'slug' => $request->slug,
                    ]
                );

                if ($request->hasFile('image')) {
                    deleteFile($insight->image);
                    $file = $request->file('image');
                    $filename=uploadFile($file ,'insights');
                    $insight->update([
                        'image' => $filename
                    ]);
                }
                return response()->json(['success' => true, 'message' => 'Insight Project updated successfully']);

            }else{
                return response()->json(['success' => false, 'message' => 'Insight Project not found']);
            }
        }
        return view('admin.insights.update',compact('insight'));
    }

}
