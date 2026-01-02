<?php

namespace App\Http\Controllers;

use App\Models\HomepageSlider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomepageSliderController extends Controller
{
    public function homepage_slider_create(Request $request)
    {
        if ($request->ajax()) {
            $validator = $request->validate([
                'image' => 'required|image',
            ]);

            $slider = HomepageSlider::create(['image' => '']);

            $cloudName = "djd3y5gzw";
            $baseS3Url = "https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/";

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uploadFile($file, 'homepage_sliders');
                $originalUrl = $baseS3Url . $filename;
                $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                $slider->update([
                    'image' => $optimizedUrl
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Homepage slider created successfully'
            ]);
        }

        return view('admin.homepage_sliders.create');
    }

    public function homepage_slider_list(Request $request)
    {
        if ($request->ajax()) {
            $data = HomepageSlider::query()->orderBy('id', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return '<img src="' . $row->image . '" width="100" height="60" />';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('homepage_slider_update', $row->id) . '" class="edit btn btn-info btn-sm">Edit</a>
                    <a class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }

        return view('admin.homepage_sliders.list');
    }

    public function homepage_slider_update(Request $request, $id)
    {
        $slider = HomepageSlider::findOrFail($id);

        if ($request->ajax()) {
            $validator = $request->validate([
                'image' => 'nullable|image',
            ]);

            $cloudName = "djd3y5gzw";
            $baseS3Url = "https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/";

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = uploadFile($file, 'homepage_sliders');
                $originalUrl = $baseS3Url . $filename;
                $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                $slider->update([
                    'image' => $optimizedUrl
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Homepage slider updated successfully'
            ]);
        }

        return view('admin.homepage_sliders.update', compact('slider'));
    }

    public function homepage_slider_delete(Request $request)
    {
        $slider = HomepageSlider::find($request->id);
        if ($slider) {
            $slider->delete();
            return response()->json(['success' => true, 'message' => 'Homepage slider has been deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Error while deleting homepage slider']);
        }
    }
}
