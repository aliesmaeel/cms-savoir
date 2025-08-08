<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\OffPlanProject;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SignatureController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){

        return view('Signature.form');
    }

    public function update(Request $request)
    {
        $imageUrl = null;

        if ($request->file('image')) {
            $file = $request->file('image');
            $originalFilename = $file->getClientOriginalName();
            $imagePath = $file->storeAs('public/images/signatures', $originalFilename);
            $imageUrl = asset('storage/images/signatures/' . $originalFilename);
        }

        $name = $request->input('name', 'Default Name');
        $email = $request->input('email', 'default@example.com');
        $phone = $request->input('phone', '0000000000');
        $position = $request->input('position', '0000000000');
        $brm = $request->input('brm', null);

        // Load and modify the HTML content
        $htmlTemplate = file_get_contents(resource_path('views/html_template.html'));

        // Conditional BRN block
        $brmHtml = "";
        if (!empty($brm)) {
            $brmHtml = '

                        <td style="font-size: 13px; color: #061a3a; text-align: left; line-height: 1.5">
                            <a style="color: #061a3a; text-decoration: none; margin-left: 0px;"
                               target="_self" href="#">/ BRN ' . htmlspecialchars($brm) . '
                            </a>
                        </td>
                    ';
        }

        $updatedHtml = str_replace([
            'https://savoirproperties.com/images/diana.jpg',
            'Diana Aribariho',
            'diana@savoirproperties.com',
            '547123953',
            'Real Estate Administrator',
            '{{brm_placeholder}}'
        ], [
            $imageUrl ?? 'https://savoirproperties.com/images/default.jpg',
            $name,
            $email,
            $phone,
            $position,
            $brmHtml
        ], $htmlTemplate);

        $downloadPath = public_path('updated_signature.html');
        file_put_contents($downloadPath, $updatedHtml);

        return response()->download($downloadPath)->deleteFileAfterSend(true);
    }



    public function showEmails()
    {
        // Render the view for the emails list
        return view('Email.list');
    }

    public function processEmails(Request $request)
    {
        if ($request->ajax()) {
            // Fetch the data
            $data = Email::query()->select(['id', 'name', 'email', 'phone', 'company', 'message']);

            // Use DataTables to process the response
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                })
                ->rawColumns(['action']) // Allow raw HTML for the action buttons
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }


    public function delete(Request $request)
    {
        $email = Email::find($request->id);

        if ($email) {
            $email->delete();

            return response()->json([
                'success' => true,
                'message' => 'Email deleted successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email not found!'
        ]);
    }



}
