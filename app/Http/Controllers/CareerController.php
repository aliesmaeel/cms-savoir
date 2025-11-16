<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CareerController extends Controller
{
    public function career_create(Request $request)
    {
        if ($request->ajax()) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
            ]);

            Career::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Career created successfully',
            ]);
        }

        return view('admin.careers.create');
    }

    public function career_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Career::query()->withCount('applicants')->orderByDesc('id');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('applicants_count', function (Career $career) {
                    return $career->applicants_count;
                })
                ->addColumn('action', function (Career $career) {
                    $applicantsUrl = route('career_applicants', $career->id);
                    $editUrl = route('career_update', $career->id);

                    return '
                        <a href="' .
                        $applicantsUrl .
                        '" class="btn btn-secondary btn-sm">Applicants</a>
                        <a href="' .
                        $editUrl .
                        '" class="edit btn btn-info btn-sm">Edit</a>
                        <a class="delete btn btn-danger btn-sm">Delete</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.careers.list');
    }

    public function career_update(Request $request, int $id)
    {
        $career = Career::findOrFail($id);

        if ($request->ajax()) {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'location' => 'nullable|string|max:255',
            ]);

            $career->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Career updated successfully',
            ]);
        }

        return view('admin.careers.update', compact('career'));
    }

    public function career_delete(Request $request)
    {
        $career = Career::find($request->id);

        if (!$career) {
            return response()->json([
                'success' => false,
                'message' => 'Career not found',
            ]);
        }

        $career->delete();

        return response()->json([
            'success' => true,
            'message' => 'Career has been deleted successfully',
        ]);
    }

    public function career_applicants(Request $request, int $careerId)
    {
        $career = Career::findOrFail($careerId);

        if ($request->ajax()) {
            $storageType = env('STORAGE_TYPE') ?? 's3';

            $query = Applicant::query()->where('career_id', $career->id)->orderByDesc('id');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('title', function (Applicant $applicant) {
                    return $applicant->career->title;
                })
                ->addColumn('cv_link', function (Applicant $applicant) use ($storageType) {
                    if (!$applicant->cv) {
                        return '';
                    }

                    if ($storageType === 'public') {
                        $url = asset($applicant->cv);
                    } else {
                        $path = 'storage/' . ltrim($applicant->cv, '/');
                        $url = Storage::disk($storageType)->url($path);
                    }

                    return '<a href="' . $url . '" target="_blank" download class="btn btn-sm btn-primary">Download CV</a>';
                })
                ->addColumn('action', function (Applicant $applicant) {
                    return '';
                })
                ->rawColumns(['cv_link', 'action'])
                ->make(true);
        }

        return view('admin.careers.applicants', compact('career'));
    }

    public function apply(Request $request, int $careerId)
    {
        $career = Career::findOrFail($careerId);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $cvPath = null;

        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $cvPath = uploadFile($file, 'careers/cv');
        }

        Applicant::create([
            'career_id' => $career->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cv' => $cvPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully',
        ]);
    }
}
