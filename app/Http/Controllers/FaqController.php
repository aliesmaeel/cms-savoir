<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\GlobalProject;
use App\Models\Insight;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function faq_create(Request $request)
    {
        if ($request->ajax()) {

            // Validate required fields
            $validator = $request->validate([
                'question' => 'required',
                'answer' => 'required',
                'type' => 'required',
            ]);


            $insight = FAQ::create($validator);

            return response()->json([
                'success' => true,
                'message' => 'FAQ created successfully'
            ]);
        }

        return view('admin.faqs.create');
    }


    public function faq_list(Request $request)
    {

        if ($request->ajax()) {

            $data = FAQ::query()->orderBy('id', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('question', function ($row) {
                    return strip_tags($row->question);
                })
                ->editColumn('answer', function ($row) {
                    return strip_tags($row->answer);
                })
                ->addColumn('action', function ($row) {
                    return '
                    <a class="delete btn btn-danger btn-sm">Delete</a>
                    <a href="'.route('faq_update', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.faqs.list');
    }


    public function faq_delete(Request $request)
    {
        $faq = FAQ::find($request->id);
        if($faq->delete()){
            return response()->json(['success' => true, 'message' => 'FAQ has been deleted successfully']);
        }else{
            return response()->json(['success' => false, 'message' => 'Error while deleting FAQ']);
        }
    }

    public function faq_list_update(Request $request, $id)
    {

        $faq = FAQ::findOrFail($id);
        if ($request->ajax()) {

            $validator = $request->validate([
                'answer' => 'required',
                'question' => 'required',
                'type' => 'required',
            ]);
           $x= $faq->update($validator);

            return response()->json([
                'success' => true,
                'message' => 'FAQ updated successfully'
            ]);
        }

        return view('admin.faqs.update', compact('faq'));
    }

    public function global_project_create(Request $request)
    {
        if ($request->ajax()) {

            $validator = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'image' => 'nullable|image',
                'user_id' => 'required|exists:users,id',
            ]);
            $global = GlobalProject::create($validator);

            $cloudName = "djd3y5gzw";
            $baseS3Url = "https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/";

            if ($request->hasFile('image')) {
                deleteFile($global->image);

                $file = $request->file('image');
                $filename = uploadFile($file, 'global_projects');
                $originalUrl = $baseS3Url . $filename;
                $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                $global->update([
                    'image' => $optimizedUrl
                ]);
            }


            return response()->json([
                'success' => true,
                'message' => 'FAQ created successfully'
            ]);
        }
        $users = User::all();
        return view('admin.globalprojects.create', compact('users'));
    }

    public function global_project_list(Request $request)
    {
        if ($request->ajax()) {

            $data = GlobalProject::query()->orderBy('id', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    return '<img src="' . $row->image . '" width="50" height="50" />';
                })
                ->editColumn('name', function ($row) {
                    return strip_tags($row->name);
                })
                ->editColumn('description', function ($row) {
                    return strip_tags($row->description);
                })
                ->addColumn('action', function ($row) {
                    return '
                    <a class="delete btn btn-danger btn-sm">Delete</a>
                    <a href="'.route('global_project_update', $row->id).'" class="edit btn btn-info btn-sm">Edit</a>';
                })
                ->rawColumns(['action','image','name','description'])
                ->make(true);
        }

        return view('admin.globalprojects.list');
    }

    public function global_project_update(Request $request, $id)
    {

        $data = GlobalProject::with('user')->findOrFail($id);
        $users = User::all();
        if ($request->ajax()) {

            $validator = $request->validate([
                'description' => 'required',
                'name' => 'required',
                'image' => 'nullable|image',
                'user_id' => 'required|exists:users,id',
            ]);
           $x= $data->update($validator);

            $cloudName = "djd3y5gzw";
            $baseS3Url = "https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/";
            if ($request->hasFile('image')) {
                deleteFile($data->image);

                $file = $request->file('image');
                $filename = uploadFile($file, 'global_projects');
                $originalUrl = $baseS3Url . $filename;
                $optimizedUrl = "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);

                $data->update([
                    'image' => $optimizedUrl
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Global Project updated successfully'
            ]);
        }

        return view('admin.globalprojects.update', compact('data','users'));
    }

    public function global_project_delete(Request $request)
    {
        $global = GlobalProject::find($request->id);
        if($global->delete()){
            return response()->json(['success' => true, 'message' => 'Global Project has been deleted successfully']);
        }else{
            return response()->json(['success' => false, 'message' => 'Error while deleting Global Project']);
        }
    }

}
