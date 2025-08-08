<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Exceptions\Exception;

class DeveloperController extends Controller
{
    public function create_developer(Request $request)
    {

        return  view('developer.create_developer');
    }

    public function create_new_developer(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' =>'required|unique:developers,slug,'.$request->slug,
                // 'image' => 'required',
                // 'photo' => 'required',
                'description' => 'required',
                // 'description_image' => 'required',
                // 'user_id' => 'user_id',
            ]
        );
        $developer = Developer::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'image' => $request->image,
            'photo' => $request->photo,
            'description' => $request->description,
            'description_image' => $request->description_image,
            'user_id' => auth()->user()->id,

        ]);

        if ($request->FloorPlan > 0) {
            for ($x = 0; $x < $request->FloorPlan; $x++) {
                if ($request->hasFile('floorplans' . $x)) {
                    $file = $request->file('floorplans' . $x);
                    $imageName=uploadFile($file ,'image/logo_image',false);
                }
                $developer->update([
                    'image' =>$imageName,
                ]);
            }
        }
        if ($request->TotalFiles > 0) {
            for ($x = 0; $x < $request->TotalFiles; $x++) {
                if ($request->hasFile('files' . $x)) {
                    $file = $request->file('files' . $x);
                    $imageName=uploadFile($file ,'image/banner_image',false);
                }
                $developer->update([
                    'photo' => $imageName,
                ]);
            }
        }

        if ($request->TotalDescription > 0) {
            for ($x = 0; $x < $request->TotalDescription; $x++) {
                if ($request->hasFile('files_image' . $x)) {
                    $file = $request->file('files_image' . $x);
                    $imageName=uploadFile($file ,'image/description_image',false);
                }
                $developer->update([
                    'description_image' => $imageName,
                ]);
            }
        }

        if ($developer != null)
            return response()->json(['success' => true, 'message' => 'developer created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new developer']);
    }

    public function listdeveloperindex(Request $request)
    {
        return view('developer.list_developer');
    }

    public function list_developer(Request $request)
    {
        if (Auth::user()->isadmin() || Auth::user()->issuperAdmin()) {
            $developer = Developer::get();
            return DataTables::of($developer)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    // $Blog = Blog::find($row->title);
                    return $row != null ? $row->name : "";
                })
                ->addColumn('image', function ($row) {
                    return '<img src="' . config('services.cms_link').'/storage/image/logo_image/'. $row->image . '" class="img-50" style="width: 100px;" />';
                })
                ->addColumn('photo', function ($row) {
                    // return $row != null ? $row->photo : "";
                    return '<img src="' .config('services.cms_link').'/storage/image/banner_image/'.$row->photo . '" class="img-50" style="width: 100px;" />';
                })
                ->addColumn('description', function ($row) {
                    // $Blog = Blog::find($row->date);
                    return $row != null ? $row->description : "";
                })
                ->addColumn('description_image', function ($row) {
                    // return $row != null ? $row->description_image : "";
                    return '<img src="' . config('services.cms_link').'/storage/image/description_image/'.$row->description_image . '" class="img-50" style="width: 100px;" />';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'image', 'photo', 'description_image'])
                ->make(true);
        }
    }

    public function upnewdeveloper($id)
    {
        $Developers = Developer::find($id);
        // $blog_images= Blog_image::where('blog_id',$blogs->id)->get();

        return view('developer.update_developer', ['Developers' => $Developers]);
    }

    public function update_developer(Request $request, $id)
    {
        $developer = [];
        $developer['name'] = 'required';
        $developer['slug'] = 'required|unique:developers,slug,'.$id;
        // $developer['image'] = 'required';
        // $developer['photo'] = 'required';
        $developer['description'] = 'required';
        // $developer['description_image'] = 'required';

        $request->validate($developer);

        try {
            $developer_update = Developer::where('id', $id)->first();
            $name2 = $developer_update->image;
            $photo2 = $developer_update->photo;
            $description_image2 = $developer_update->description_image;
            // dd( $id);
            $developer_update->name = $request->name;
            $developer_update->slug = $request->slug;
            $developer_update->image = $request->image;
            $developer_update->photo = $request->photo;
            $developer_update->description = $request->description;
            $developer_update->description_image = $request->description_image;
            $developer_update->user_id = $developer_update->user_id;
            // dd($developer_update);
            if ($request->FloorPlan > 0) {
                deleteFile($developer_update->image);
                for ($x = 0; $x < $request->FloorPlan; $x++) {
                    if ($request->hasFile('floorplans' . $x)) {
                        $file = $request->file('floorplans' . $x);
                        $imageName=uploadFile($file ,'image/logo_image',false);
                    }
                    $developer_update->update([
                        'image' =>$imageName,
                    ]);
                }
            } else {
                $developer_update->update([
                    'image' => $name2,
                ]);
            }


            if ($request->TotalFiles > 0) {
                deleteFile($developer_update->photo);
                for ($x = 0; $x < $request->TotalFiles; $x++) {
                    if ($request->hasFile('files' . $x)) {
                        $file = $request->file('files' . $x);
                        $imageName=uploadFile($file ,'image/banner_image',false);
                    }
                    $developer_update->update([
                        'photo' => $imageName,
                    ]);
                }
            } else {
                $developer_update->update([
                    'photo' => $photo2,
                ]);
            }

            if ($request->TotalDescription > 0) {
                deleteFile($developer_update->description_image);
                for ($x = 0; $x < $request->TotalDescription; $x++) {
                    if ($request->hasFile('files_image' . $x)) {
                        $file = $request->file('files_image' . $x);
                        $imageName=uploadFile($file ,'image/description_image',false);
                    }
                    $developer_update->update([
                        'description_image' => $imageName,
                    ]);
                }
            } else {
                $developer_update->update([
                    'description_image' => $description_image2,
                ]);
            }
            $developer_update->save();


            if ($developer_update)
                return response()->json(['success' => true, 'message' => 'Developer updated successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error in updating Developer data']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }

    public function delete_developer(Request $request)
    {
        $developer = Developer::find($request->id);
        if ($developer){
            deleteFile($developer->image);
            deleteFile($developer->photo);
            deleteFile($developer->description_image);
            return response()->json(['success' => true, 'message' => 'Developer has been deleted successfully']);
        }
        else{
            return response()->json(['success' => true, 'message' => 'Error while deleting Developer']);
        }
    }
}
