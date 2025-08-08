<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\SubCommunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CommunityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createnewcommunity(Request $request)
    {

        if ($request->ajax()) {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:communities,name',
                'slug' =>'required|unique:communities,slug',
                'image'=>'required',
                'inner_image'=>'required',
                'youtube'=>'required',
                'location'=>'required',
                'description'=>'required',
                'Order'=>'required|unique:communities,name'
            ]);
            if ($validator->fails())
                return ["success" => false, "message" => $validator->getMessageBag()->first()];
           $community= Community::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'Order' => $request->Order,
               'youtube'=>$request->youtube,
               'location'=>$request->location,

            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename=uploadFile($file ,'areas');
                $community->update([
                    'image' => $filename
                ]);
            }

            if ($request->hasFile('inner_image')) {
                $file = $request->file('inner_image');
                $filename=uploadFile($file ,'areas');
                $community->update([
                    'inner_image' => $filename
                ]);
            }


            return ["success" => true, "message" => "Community added successfully"];
        }
        return view('admin.createnewcommunity');
    }

    public function createnewsubcommunity(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'community' => 'required|exists:communities,id',
                'name' => 'required|unique:communities,name'
            ]);
            if ($validator->fails())
                return ["success" => false, "message" => $validator->getMessageBag()->first()];

            SubCommunity::create([
                'community_id' => $request->community,
                'name' => $request->name
            ]);

            return ["success" => true, "message" => "SubCommunity added successfully"];
        }
        $communities = Community::get();
        return view('admin.createnewsubcommunity', ['communities' => $communities]);
    }

    public function listcommunities(Request $request)
    {
        if ($request->ajax()) {
            $communities = Community::get();
            return Datatables::of($communities)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<a href=" . route('update_community_index', $row->id) . " class='btn btn-primary'>Edit</a>";
                    $btn .= "<a href='#' class='btn btn-danger delete ml-2'>Delete</a>";
                    return $btn;
                }) ->addColumn('image', function ($row) {
                    if ($row->image) {
                        return '<img src="' .config('services.cms_link').'/storage/'.$row->image . '" class="img-50" style="width: 100px;" />';
                    } else {
                        return '';
                    }
                })->addColumn('inner_image', function ($row) {
                    if ($row->inner_image) {
                        return '<img src="' .config('services.cms_link').'/storage/'.$row->inner_image . '" class="img-50" style="width: 100px;" />';
                    } else {
                        return '';
                    }
                })
                ->rawColumns(['action','image','inner_image'])
                ->make(true);
        }
        return view('admin.listcommunities');
    }

    public function listsubcommunities(Request $request)
    {
        if ($request->ajax()) {
            $subCommunities = SubCommunity::get();
            return Datatables::of($subCommunities)
                ->addIndexColumn()
                ->addColumn('community', function ($row) {
                    $community = Community::find($row->community_id);
                    return $community != null ? $community->name : "";
                })
                ->addColumn('action', function ($row) {
                    $btn = "<a href=" . route('update_subcommunity_index', $row->id) . " class='btn btn-primary'>Edit</a>";
                    $btn .= "<a href='#' class='btn btn-danger delete ml-2'>Delete</a>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.listsubcommunities');
    }

    public function deletecommunity(Request $request)
    {
        $community_id =  $request->community_id;
        Community::where('id', $community_id)->delete();
        return ['success' => true, 'message' => "Community deleted successfully"];
    }

    public function deletesubcommunity(Request $request)
    {
        $subcommunity_id =  $request->subcommunity_id;
        SubCommunity::where('id', $subcommunity_id)->delete();
        return ['success' => true, 'message' => "SubCommunity deleted successfully"];
    }

    public function updatecommunityindex($id)
    {
        $community = Community::find($id);
        return view('admin.updatenewcommunity', ['community' => $community]);
    }

    public function updatesubcommunityindex($id)
    {
        $communities = Community::get();
        $subCommunity = SubCommunity::find($id);
        return view('admin.updatenewsubcommunity', ['subCommunity' => $subCommunity, 'communities' => $communities]);
    }

    public function updatecommunity(Request $request)
    {

        $community_id =  $request->community_id;
        $validator =  Validator::make($request->all(), [
            'name' => ['required',Rule::unique('communities')->ignore($community_id)],
            'slug' =>['required',Rule::unique('communities')->ignore($community_id)],
            'description'=>'required',
            'Order'=>['required',Rule::unique('communities')->ignore($community_id)],
            'youtube'=>'required',
            'location'=>'required',
        ]);
        if ($validator->fails())
            return ["success" => false, "message" => $validator->getMessageBag()->first()];


       $community= Community::where('id', $community_id)->first();
       $community->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'Order' => $request->Order,
           'youtube'=>$request->youtube,
           'location'=>$request->location,
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            deleteFile($community->image);
            $filename=uploadFile($file ,'areas');
            $community->update([
                'image' => $filename
            ]);
        }

        if ($request->hasFile('inner_image')) {
            $file = $request->file('inner_image');
            deleteFile($community->image);
            $filename=uploadFile($file ,'areas');
            $community->update([
                'inner_image' => $filename
            ]);
        }

        return ["success" => true, "message" => "Community updated succssfully"];
    }

    public function updatesubcommunity(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'community' => 'required|exists:communities,id',
            'name' => 'required'
        ]);
        if ($validator->fails())
            return ["success" => false, "message" => $validator->getMessageBag()->first()];

        $subcommunity_id =  $request->subcommunity_id;
        SubCommunity::where('id', $subcommunity_id)->update([
            'community_id' => $request->community,
            'name' => $request->name,
        ]);
        return ["success" => true, "message" => "SubCommunity updated succssfully"];
    }
    public function synccommunities(Request $request)
    {

        return view('admin.synccommunity');
    }
    public function syncsubcommunities(Request $request)
    {

        return view('admin.syncsubcommunity');
    }
    public function syncbuildings(Request $request)
    {

        return view('admin.syncbuilding');
    }
}
