<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {

            $data=Subscription::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('subscription.index');
    }
    public function delete(Request $request){
        $data=Subscription::find($request->id);
        if($data){
            $data->delete();
            return response()->json(['success' => true, 'message' => 'Subscription has been deleted successfully']);
        }else{
            return response()->json(['success' => true, 'message' => 'Error while deleting Subscription']);
        }
    }
}
