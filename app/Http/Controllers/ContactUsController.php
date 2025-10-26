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
                ->addColumn('download', function ($row) {
                    if ($row->cv) {
                        $fileUrl = url('storage/' . $row->cv);
                        return '<a href="' . $fileUrl . '" class="btn btn-sm btn-primary" target="_blank" download>Download CV</a>';
                    }
                    return '-';
                })
                ->addColumn('delete', function ($row) {
                    $deleteUrl = route('contact_us_delete', 'contact='.$row->id);
                    return '<a href="' . $deleteUrl . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure you want to delete this entry?\')">Delete</a>';
                })
                ->rawColumns(['download','delete'])
                ->make(true);
        }

        return view('contact_us.list');
    }

    public function contact_us_delete(Request $request)
    {
        $id=$request->contact;
        $contactUsEntry = ContactUs::findOrFail($id);
        $contactUsEntry->delete();

        return redirect()->route('contact_us_list')->with('success', 'Contact Us entry deleted successfully.');
    }


}
