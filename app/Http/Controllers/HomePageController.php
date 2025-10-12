<?php

namespace App\Http\Controllers;

use App\Models\OffPlanProject;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomePageController
{

    public function testimonial_project_create(Request $request)
    {

        if ($request->ajax()) {

            $validator= $request->validate(
                [
                    'name' => 'required',
                    'position' => 'required',
                    'message' => 'required',
                    'image' =>'required'
                ]
            );

            $data= Testimonials::create($validator);

            $cloudName = "djd3y5gzw";
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'testimonials');
                $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/'.$filename;

                $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                $data->update([
                    'image' => $store,
                ]);
            }

            if ($data != null)
                return response()->json(['success' => true, 'message' => 'Testimonial  created successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in creating Testimonial']);
        }
        $testimonials = Testimonials::pluck('id')->unique()->toArray();
        return view('Testimonials.create',compact('testimonials'));
    }


    public function testimonial_project_list(Request $request)
    {
        if ($request->ajax()) {
            $data=Testimonials::query()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'. route('testimonial_project_update', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->addColumn('image_col', function ($row) {
                    if ($row->image) {
                        return '<img src="' . $row->image . '" class="img-50" style="width: 100px;" />';
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
                ->rawColumns(['action','image_col'])
                ->make(true);
        }
        return view('Testimonials.list');
    }


    public function testimonial_project_update(Request $request, $id)
    {
        $data = Testimonials::find($id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found']);
        }

        if ($request->ajax()) {
            $validator = $request->validate([
                'name' => 'required',
                'position' => 'required',
                'message' => 'required',
            ]);

            // Update the basic fields first
            $data->update($validator);

            $cloudName = "djd3y5gzw";

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uploadFile($file, 'testimonials');
                $originalUrl = 'https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/' . $filename;

                $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                $data->update([
                    'image' => $store,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Testimonial updated successfully']);
        }

        // For non-AJAX requests (e.g., when viewing the update page)
        return view('Testimonials.update', compact('data'));
    }

    public function testimonial_project_delete(Request $request)
    {
        $data = Testimonials::find($request->id);

        if (!$data) {
            return response()->json(['success' => false, 'message' => 'Testimonial not found']);
        }

        $data->delete();

        return response()->json(['success' => true, 'message' => 'Testimonial deleted successfully']);
    }



}
