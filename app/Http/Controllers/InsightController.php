<?php

namespace App\Http\Controllers;

use App\Models\Insight;
use App\Models\OffPlanProject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InsightController extends Controller
{
    public function insight_create(Request $request)
    {
        if ($request->ajax()) {

            // Validate required fields
            $validator = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'facebook' => 'required',
                'instagram' => 'required',
                'linkedin' => 'required',
                'shares' => 'required|integer',
                // Optionally validate description titles/texts
                'description_one_title' => 'required',
                'description_one' => 'required',
                'description_two_title' => 'required',
                'description_two' => 'required',
                'description_three_title' => 'required',
                'description_three' => 'required',
                'description_four_title' => 'required',
                'description_four' => 'required',
            ]);

            // Create Insight
            $insight = Insight::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'isfeatured' => $request->feature == 'on' ? 1 : 0,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'linkedin' => $request->linkedin,
                'shares' => $request->shares,
                'title_details' => $request->title_details ?? null,
                'description_one_title' => $request->description_one_title,
                'description_one' => $request->description_one,
                'description_two_title' => $request->description_two_title,
                'description_two' => $request->description_two,
                'description_three_title' => $request->description_three_title,
                'description_three' => $request->description_three,
                'description_four_title' => $request->description_four_title,
                'description_four' => $request->description_four,
            ]);

            $cloudName = "djd3y5gzw";

            $imageFields = ['image', 'first_image', 'second_image', 'third_image'];
            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = uploadFile($file, 'insights');
                    $originalUrl = 'https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/' . $filename;
                    $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                    $insight->update([$field => $store]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Insight Project created successfully'
            ]);
        }

        return view('admin.insights.create');
    }


    public function insight_list(Request $request)
    {

        if ($request->ajax()) {
            $data = Insight::select(['id', 'title', 'slug', 'image', 'isfeatured'])
                ->orderBy('id', 'DESC')
                ->get();


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = '<img src="'.$row->image.'" width="100px" height="100px">';
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

    public function insight_list_update(Request $request, $id)
    {
        $insight = Insight::findOrFail($id);
        if ($request->ajax()) {

            $validator = $request->validate([
                'title' => 'required',
                'slug' => 'required',
                'facebook' => 'required',
                'instagram' => 'required',
                'linkedin' => 'required',
                'shares' => 'required|integer',
                'description_one_title' => 'required',
                'description_one' => 'required',
                'description_two_title' => 'required',
                'description_two' => 'required',
                'description_three_title' => 'required',
                'description_three' => 'required',
                'description_four_title' => 'required',
                'description_four' => 'required',
            ]);



            $insight->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'isfeatured' => $request->feature == 'on' ? 1 : 0,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'linkedin' => $request->linkedin,
                'shares' => $request->shares,
                'title_details' => $request->title_details ?? null,
                'description_one_title' => $request->description_one_title,
                'description_one' => $request->description_one,
                'description_two_title' => $request->description_two_title,
                'description_two' => $request->description_two,
                'description_three_title' => $request->description_three_title,
                'description_three' => $request->description_three,
                'description_four_title' => $request->description_four_title,
                'description_four' => $request->description_four,
            ]);

            $cloudName = "djd3y5gzw";
            $imageFields = ['image', 'first_image', 'second_image', 'third_image'];

            foreach ($imageFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = uploadFile($file, 'insights');
                    $originalUrl = 'https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/' . $filename;
                    $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                    $insight->update([$field => $store]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Insight Project updated successfully'
            ]);
        }

        return view('admin.insights.update', compact('insight'));
    }



}
