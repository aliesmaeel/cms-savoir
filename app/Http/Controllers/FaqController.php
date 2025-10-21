<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\Insight;
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
}
