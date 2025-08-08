<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    public function contact_us_list(Request $request)
    {
        if ($request->ajax()) {
            $data = ContactUs::orderBy('created_at','DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()               
                ->rawColumns([])
                ->make(true);
        }
        return view('contact_us.list');
    }

}
