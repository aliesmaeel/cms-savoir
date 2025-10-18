<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DownloadedBrochureController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('downloaded_brochures')->orderBy('id', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('downloaded_brochures.index');
    }
    public function delete(Request $request){
        $data=DB::table('downloaded_brochures')->where('id',$request->id)->first();
        if($data){
            DB::table('downloaded_brochures')->where('id',$request->id)->delete();
            return response()->json(['success' => true, 'message' => 'Email has been deleted successfully']);
        }else{
            return response()->json(['success' => true, 'message' => 'Error while deleting Email']);
        }
    }

}
