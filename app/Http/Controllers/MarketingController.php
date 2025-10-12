<?php

namespace App\Http\Controllers;

use App\Models\ListingSyndication;
use App\Models\MarketingChannels;
use App\Models\OffPlanProject;
use App\Models\Testimonials;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MarketingController
{

    public function listing_create(Request $request)
    {
        if ($request->ajax()) {

            $validator= $request->validate(
                [
                    'image' =>'required'
                ]
            );

            $data= ListingSyndication::create($validator);

            $cloudName = "djd3y5gzw";
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'listing');
                $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/'.$filename;

                $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                $data->update([
                    'image' => $store,
                ]);
            }

            if ($data != null)
                return response()->json(['success' => true, 'message' => 'Testimonial created successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in creating Testimonial']);
        }
        $listing = ListingSyndication::pluck('id')->unique()->toArray();
        return view('Listing.create',compact('listing'));
    }

    public function listing_list(Request $request)
    {
        if ($request->ajax()) {
            $data=ListingSyndication::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'. route('update_listing', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->addColumn('image_col', function ($row) {
                    if ($row->image) {
                        return '<img src="' .$row->image . '" class="img-50" style="width: 100px;" />';
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

        return view('Listing.list');
    }
    public function marketing_create(Request $request)
    {
        if ($request->ajax()) {

            $validator= $request->validate(
                [
                    'image' =>'required'
                ]
            );

            $data= MarketingChannels::create($validator);

            $cloudName = "djd3y5gzw";
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'marketing');
                $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/'.$filename;

                $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                $data->update([
                    'image' => $store,
                ]);
            }

            if ($data != null)
                return response()->json(['success' => true, 'message' => 'Marketing  created successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in creating Marketing']);
        }
        $marketing = MarketingChannels::pluck('id')->unique()->toArray();
        return view('Marketing.create',compact('marketing'));
    }

    public function marketing_list(Request $request)
    {
        if ($request->ajax()) {
            $data=MarketingChannels::all();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a href="'. route('marketing_update', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->addColumn('image_col', function ($row) {
                    if ($row->image) {
                        return '<img src="' .$row->image . '" class="img-50" style="width: 100px;" />';
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

        return view('Marketing.list');
    }

    public function listing_delete(Request $request)
    {
        $data = ListingSyndication::find($request->id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Listing deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Listing not found']);
        }
    }

    public function listing_update(Request $request)
    {
        $data = ListingSyndication::find($request->id);
        if (!$data) {
            return redirect()->back()->with('error', 'Marketing not found');
        }

        if ($request->isMethod('post')) {

            $validator= $request->validate(
                [
                    'image' =>'required'
                ]
            );

            $data->update($validator);

            $cloudName = "djd3y5gzw";
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'listing');
                $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/'.$filename;

                $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                $data->update([
                    'image' => $store,
                ]);
            }

            return redirect()->route('list_listing')->with('success', 'Listing updated successfully');
        }

        return view('Listing.update', compact('data'));
    }
    public function marketing_delete(Request $request)
    {
        $data = MarketingChannels::find($request->id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Marketing deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Marketing not found']);
        }
    }

    public function marketing_update(Request $request)
    {
        $data = MarketingChannels::find($request->id);
        if (!$data) {
            return redirect()->back()->with('error', 'Marketing not found');
        }

        if ($request->isMethod('post')) {

            $validator= $request->validate(
                [
                    'image' =>'required'
                ]
            );

            $data->update($validator);

            $cloudName = "djd3y5gzw";
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename =uploadFile($file  ,'marketing');
                $originalUrl='https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/'.$filename;

                $store = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
                $data->update([
                    'image' => $store,
                ]);
            }

            return redirect()->route('list_marketing')->with('success', 'Marketing updated successfully');
        }

        return view('Marketing.update', compact('data'));
    }
}
