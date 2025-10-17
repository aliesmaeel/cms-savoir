<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Mail\reject;
use App\Models\Blog;
use App\Models\Blog_image;
use App\Models\User;
use App\Models\event;
use App\Mail\eventemail;
use App\Models\calender;
use App\Models\eventType;
use App\Mail\aprovedevent;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\event_attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\eventmailaproveorreject;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    use SendEmailT;

    public function add_event_to_calendar($id, $type)
    {
        if ($type == 1) {
            $event = event::find($id);
            $event->date = Carbon::parse($event->date)->format('d-m-Y');
            return view('events.add_event_to_calendar', ['event' => $event, 'type' => $type]);
        } else if ($type == 2) {
            $event = Appointment::find($id);
            $photographer_name = User::find($event->user_id)->name;
            $event->date = Carbon::parse($event->date)->format('d-m-Y');
            return view('events.add_event_to_calendar', ['event' => $event, 'type' => $type, 'photographer_name' => $photographer_name]);
        }
    }

    //
    public function eventindex()
    {
        $event_type = eventType::get();
        return view('events.index', compact('event_type'));
    }
    public function eventstory(Request $request)
    {

        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'date' => 'required',
            'address' => 'required',
            'description' => 'required',
            'type' => 'required'
        ], [
            'type.required' => 'please select event type'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
                'state' => false
            ]);
        }
        if (Auth::user()->isadmin()) {
            if ($request->hasfile('image')) {
                $imageName=uploadFile($request->image,'event');
            }
            $event = event::create([
                'name' => $request->name,
                'date' => $request->date,
                'address' => $request->address,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
                'path' => ($request->image) ? 'storage/'.$imageName : null,
                'event_type_id' => $request->type,
                'status' => 'coming'
            ]);
            $users = User::whereNotIn('role_id', ['1', '5', '8'])->get();
            $date_format = explode(' ', $event->date)[0];
            $deteals = [
                'id' => $event->id,
                'name' => $event->name,
                'date_format' => $date_format,
                'address' => $event->address,
                'description' => $event->description,
                'date' => $event->date,
                'status' => $event->status,
                'event_image' => $event->path,
                'event_type' => eventType::find($event->event_type_id)->name,
                'attend_link' => url('/') . "/attend/" . $event->id
            ];

            $users_list = [];
            foreach ($users as $user) {
                $users_list[] = ["email" => $user->email];
                // Mail::to($user->email)->send(new eventemail($deteals));
            }
            $this->sendEmailEventCreated($users_list, $deteals);

            if ($event) {
                return response()->json([
                    'message' => 'Event Has Been Created Successfully',
                    'state' => true
                ]);
            } else {
                return response()->json([
                    'message' => 'Error In Creating Event',
                    'state' => false
                ]);
            }
        } else {
            if ($request->hasfile('image')) {
                $imageName=uploadFile($request->image,'event');
            }
            $event = event::create([
                'name' => $request->name,
                'date' => $request->date,
                'address' => $request->address,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
                'path' => ($request->image) ?   'storage/'.$imageName : null,
                'event_type_id' => $request->type,
                'status' => 'pending'
            ]);
            $users = User::where('role_id', '1')->get();
            $date_format = new DateTime($event->date);
            $deteals = [
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'date_format' => $date_format->format('d-m-Y'),
                'address' => $event->address,
                'description' => $event->description,
                'status' => $event->status,
                'event_image' => $event->path,
                'event_type' => eventType::find($event->event_type_id)->name,
                'requested_from' => User::find($event->created_by)->name,
                'attend_link' => ''
            ];

            $users_list = [];
            foreach ($users as $user) {
                $users_list[] = ["email" => $user->email];
                // Mail::to($user->email)->send(new eventmailaproveorreject($deteals));
            }
            $this->sendEmailEventRequest($users_list, $deteals);
            return response()->json([
                'message' => 'Event is on waiting',
                'state' => true
            ]);
        }
    }
    public function showevent()
    {
        $users = User::whereNotIn('role_id', ['5'])->get();
        return view('events.list', compact('users'));
    }
    public function events(Request $request)
    {
        $data = event::join('users', 'users.id', "=", "events.created_by");

        if ($request->status != null && $request->status  != "ALL") {
            $data = $data->where('status', $request->status);
        }
        if ($request->user != null && $request->user  != "ALL") {
            $data = $data->where('created_by', $request->user);
        }
        if ($request->date != null && $request->date != "ALL") {
            if ($request->date == "today") {
                $data = $data->whereDate(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), Carbon::now()->format('y-m-d'));
            } elseif ($request->date == "tomorrow") {
                $data = $data->whereDate(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), Carbon::now()->addDay(1)->format('y-m-d'));
            } elseif ($request->date == "thismonth") {
                $FROM = now()->startOfMonth();
                $end = now()->endOfMonth();
                $data = $data->WhereBetween(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), [$FROM, $end]);
            } elseif ($request->date == "thisweek") {
                $data = $data->WhereBetween(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), [Carbon::now()->startOfWeek()->format('y-m-d'), Carbon::now()->endOfWeek()->format('y-m-d')]);
            } elseif ($request->date == "yesterday") {
                $data = $data->whereDate(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), Carbon::now()->subDay(1)->format('y-m-d'));
            } elseif ($request->date == "lastweek") {
                $FROM = now()->subWeek()->startOfWeek();
                $end = now()->subWeek()->endOfWeek();
                $data = $data->whereDate(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), '>=', $FROM->format('y-m-d'))->whereDate(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), '<=', $end->format('y-m-d'));
            } elseif ($request->date == "lastmonth") {
                $FROM = now()->subMonth()->startOfMonth();
                $end = now()->subMonth()->endOfMonth();
                $data = $data->WhereBetween(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), [$FROM, $end]);
            }
        }
        if ($request->SpecificData != null) {
            $SpecificData = Carbon::parse($request->SpecificData)->format('Y-m-d');

            $data = $data->whereDate(DB::raw("STR_TO_DATE(REPLACE(SUBSTRING(date,1,10),'/',','),'%d,%m,%Y')"), $SpecificData);
        }
        $data = $data->select('events.*', 'users.role_id', 'users.name as username')
            ->orderBy('events.date', 'DESC')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            })
            ->addColumn('check', function ($row) {
                return null;
            })
            ->rawColumns(['action', 'check'])
            ->make(true);
    }
    public function deleteevent(Request $request)
    {
        // dd($request->all());
        $event = event::find($request->id);
        if ($event) {
            deleteFile($event->path);
            deleteFile($event->attendance_proof);
            $event->delete();
            $event_attendance = event_attendance::where('event_id', $request->id)->get();
            foreach ($event_attendance as $key) {
                $key->delete();
            }
            $calenders = calender::where('event_id', $request->id)->where('event_source', 'normal')->get();
            foreach ($calenders as $calender) {
                $calender->delete();
            }
            return response()->json([
                'message' => 'Event Has Been Deleted Successfully',
                'state' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Error In Deleting  Event',
                'state' => false
            ]);
        }
    }
    public function editevent($id)
    {
        $event = event::find($id);
        $event_type = eventType::get();
        return view('events.edit', compact('event', 'event_type'));
    }
    public function eventupdate(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->toArray(), [
            'name' => 'required',
            'date' => 'required',
            'address' => 'required',
            'description' => 'required',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
                'state' => false
            ]);
        }
        $event = event::find($request->id);
        if ($event) {
            if ($request->hasfile('image')) {
                deleteFile($event->path);
                $imageName=uploadFile($request->image,'event');
                $event->path = 'storage/'.$imageName;
            }
            $event->name = $request->name;
            $event->date = $request->date;
            $event->address = $request->address;
            $event->description = $request->description;
            $event->event_type_id = $request->type;
            $event->save();
            return response()->json([
                'message' => 'Event Has Been Updated Successfully',
                'state' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Error In Updating  Event',
                'state' => false
            ]);
        }
    }
    public function eventdetalis(Request $request)
    {
        $event = event::find($request->id);
        $atten_list = event_attendance::join('users', 'users.id', '=', 'event_attendances.user_id')->where('event_id', $request->id)->get()->toArray();
        if ($event->status == 'pending' || $event->status == 'rejected') {
            $attend = '';
            $form = '';
        } else {
            $attend = '<button  class="attend btn btn-danger btn-sm" onclick="Attend(' . $request->id . ')">Attend</button> ';
            $form = '<form id="upload">' .
                '<input name="upload_atten_poof"  type="file" id="upload_atten_poof' . $request->id . '"/>' .
                '<input name="id"  type="text" hidden value="' . $request->id . '"/>' .
                '<button type="button" class="attend btn btn-danger btn-sm upload" >upload</button>' .
                '</form>';
            foreach ($atten_list as $key) {
                if ($key['user_id'] == Auth::user()->id) {
                    $attend = '';
                }
            }
        }
        return response()->json([
            'event' => $event,
            'image' => ($event->path != NULL) ? config('services.cms_link').'/'.$event->path : "",
            'atten_list' => $atten_list,
            'attend' => $attend,
            'form' => $form,
            'state' => true
        ]);
    }
    public function Attend(Request $request)
    {
        $event = event::find($request->id);
        if ($event) {
            calender::create([
                'event_title' => $event->name,
                'start_time' => $event->date,
                'end_time' => $event->date,
                'event_id' => $request->id,
                'user_id' => Auth::user()->id,
                'event_type' => 'full day',
                'event_source' => 'normal',
            ]);
            event_attendance::create([
                'user_id' => Auth::user()->id,
                'event_id' => $request->id,
            ]);
            return response()->json([
                'message' => 'Attendance is registered',
                'name' => Auth::user()->name,
                'state' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Event Not Found',
                'state' => false
            ]);
        }
    }

    public function attendLink($event_id, $user_id = null)
    {
        $event = event::find($event_id);
        if ($user_id == null) {
            if (Auth::user()) {
                $user_id = Auth::user()->id;
            } else {
                return "You have to be logged in!";
            }
        }

        $tmp = event_attendance::where('user_id', $user_id)->where('event_id', $event_id)->count();
        if ($tmp > 0) {
            return 'You are already in the attender list!';
        }
        if ($event) {
            calender::create([
                'event_title' => $event->name,
                'start_time' => $event->date,
                'end_time' => $event->date,
                'event_id' => $event_id,
                'user_id' => $user_id,
                'event_type' => 'full day',
                'event_source' => 'normal',
            ]);
            event_attendance::create([
                'user_id' => $user_id,
                'event_id' => $event_id,
            ]);

            return redirect()->route('list_event');
        } else {
            echo 'Event Not Found';
            exit();
        }
    }
    public function uploadattendpoof(Request $request)
    {
        $event = event::find($request->id);
        if ($event) {
            if ($request->hasfile('upload_atten_poof')) {
                deleteFile($event->attendance_proof);
                $imageName=uploadFile($request->upload_atten_poof,'event');
                $event->attendance_proof = 'storage/'.$imageName;
            }
            $event->save();
            return response()->json([
                'message' => 'Attendance Proof Has Been Updload Successfully',
                'state' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Error In Updload  Attendance Proof ',
                'state' => false
            ]);
        }
    }
    public function addtocalendar($id)
    {
        return  redirect()->route('calender', $id);
    }
    public function aproved($id)
    {
        $event = event::find($id);
        if ($event) {
            if ($event->status == 'coming' || $event->status == 'Passed' || $event->status == 'rejected') {
                return 'invalid link';
            } else {
                $event->status = "coming";
                $event->save();
                $users = User::whereNotIn('role_id', ['1', '5', '6'])->whereNotIn('id', [$event->created_by])->get();
                $date_format = new DateTime($event->date);
                $deteals = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'date' => $event->date,
                    'date_format' => $date_format->format('d-m-Y'),
                    'address' => $event->address,
                    'description' => $event->description,
                    'event_image' => $event->path,
                    'event_type' => eventType::find($event->event_type_id)->name,
                    'attend_link' => url('/') . "/attend/" . $event->id . '/' . Auth::user()->id
                ];

                $user_list = [];
                foreach ($users as $user) {
                    $user_list[] = ["email" => $user->email];
                    // Mail::to($key->email)->send(new eventemail($deteals));
                }
                $this->sendEmailEventCreated($user_list, $deteals);

                $user = User::find($event->created_by);
                $this->sendEmailEventApproved([["email" => $user->email]], $deteals);
                // Mail::to($user->email)->send(new aprovedevent($deteals));
                event_attendance::create([
                    'event_id' => $id,
                    'user_id' => $event->created_by
                ]);
                return redirect()->route('list_event');
            }
        } else {
            return redirect()->back();
        }
    }
    public function reject($id)
    {
        $event = event::find($id);
        if ($event) {
            if ($event->status == 'coming' || $event->status == 'Passed' || $event->status == 'rejected') {
                return 'invalid link';
            } else {
                $event->status = "rejected";
                $event->save();
                $user = User::find($event->created_by);

                $date_format = new DateTime($event->date);
                $deteals = [
                    'id' => $event->id,
                    'name' => $event->name,
                    'date' => $event->date,
                    'date_format' => $date_format->format('d-m-Y'),
                    'address' => $event->address,
                    'description' => $event->description,
                    'event_image' => $event->path,
                    'event_type' => eventType::find($event->event_type_id)->name
                ];
                $deteals["title"] = "Your Event Request has been rejected";
                $this->sendEmailEventRejection([["email" => $user->email]], $deteals);
                // Mail::to($user->email)->send(new reject());
                return redirect()->route('list_event');
            }
        } else {
            return redirect()->back();
        }
    }
    public function calender($id)
    {
        return  view('events.addtocalender', compact('id'));
    }
    public function storecalender(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->toArray(), [
            'event_title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'event_source' => 'required',
            'event_type' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
                'state' => false
            ]);
        }
        $calender = calender::create([
            'event_title' => $request->event_title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'event_id' => $request->event_id,
            'user_id' => Auth::user()->id,
            'event_title' => $request->event_title,
            'event_type' => $request->event_type,
            'event_source' => $request->event_source
        ]);
        if ($calender) {
            return response()->json([
                'message' => 'Calender Has Been Created Successfully',
                'state' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Error In Creating Calender',
                'state' => false
            ]);
        }
    }
    public function approvedcrm(Request $request)
    {
        $event = event::find($request->id);
        if ($event) {
            $event->status = "coming";
            $event->save();
            $users = User::whereNotIn('role_id', ['1', '5', '6'])->whereNotIn('id', [$event->created_by])->get();
            $date_format = new DateTime($event->date);
            $deteals = [
                'id' => $event->id,
                'name' => $event->name,
                'date' => $event->date,
                'date_format' => $date_format->format('d-m-Y'),
                'address' => $event->address,
                'description' => $event->description,
            ];
            foreach ($users as $key) {
                Mail::to($key->email)->send(new eventemail($deteals));
            }
            $user = User::find($event->created_by);
            Mail::to($user->email)->send(new aprovedevent($deteals));
            event_attendance::create([
                'event_id' => $event->id,
                'user_id' => $event->created_by
            ]);
            return response()->json([
                'message' => 'Event approved Successfully',
                'state' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Event not fund',
                'state' => false
            ]);
        }
    }
    public function rejectcrm(Request $request)
    {
        $event = event::find($request->id);
        if ($event) {
            $event->status = "rejected";
            $event->save();
            $user = User::find($event->created_by);
            Mail::to($user->email)->send(new reject());
            return response()->json([
                'message' => 'Event rejected Successfully',
                'state' => true
            ]);
        } else {
            return response()->json([
                'message' => 'Event not fund',
                'state' => false
            ]);
        }
    }
    public function create_blog(Request $request)
    {

        return  view('blogs.creat_blogs');
    }

    public function create_new_blog(Request $request)
    {

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'title_details' => 'required|string',
            'slug' => 'required|string|max:255',
            'posted_by' => 'required|string|max:255',
            'date' => 'required|date',
            'description_one_title' => 'nullable|string',
            'description_one' => 'nullable|string',
            'description_two_title' => 'nullable|string',
            'description_two' => 'nullable|string',
            'description_three_title' => 'nullable|string',
            'description_three' => 'nullable|string',
            'description_four_title' => 'nullable|string',
            'description_four' => 'nullable|string',
            'first_image' => 'nullable|image',
            'second_image' => 'nullable|image',
            'third_image' => 'nullable|image',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Sanitize slug
        $slug = preg_replace('~[^\pL\d]+~u', '-', $request->slug);
        $slug = iconv('utf-8', 'utf-8//IGNORE', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('~-+~', '-', $slug);
        $slug = strtolower($slug);

        if (empty($slug)) {
            $slug = 'n-a';
        } elseif (Blog::where('slug', $slug)->exists()) {
            return response()->json(['success' => false, 'message' => 'This slug already exists']);
        }

        // Create the blog
        $blog = Blog::create([
            'title' => $request->title,
            'title_details' => $request->title_details,
            'slug' => $slug,
            'posted_by' => $request->posted_by,
            'date' => $request->date,
            'description_one_title' => $request->description_one_title,
            'description_one' => $request->description_one,
            'description_two_title' => $request->description_two_title,
            'description_two' => $request->description_two,
            'description_three_title' => $request->description_three_title,
            'description_three' => $request->description_three,
            'description_four_title' => $request->description_four_title,
            'description_four' => $request->description_four,
            'user_id' => auth()->user()->id,
        ]);

        $cloudName = "djd3y5gzw"; // Replace with your Cloudinary cloud name
        $uploadedImages = [];

        // Helper function to upload and optimize images
        $uploadAndOptimize = function($file) use ($cloudName) {
            $filename = uploadFile($file, 'blog'); // Upload to S3
            $originalUrl = 'https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/' . $filename;
            return "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
        };

        // Handle main image
        if ($request->hasFile('image')) {
            $optimizedUrl = $uploadAndOptimize($request->file('image'));
            $uploadedImages['image'] = $optimizedUrl;

            Blog_image::create([
                'blog_id' => $blog->id,
                'url' => $optimizedUrl,
            ]);
        }

        // Handle additional images
        $imageFields = ['first_image', 'second_image', 'third_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $optimizedUrl = $uploadAndOptimize($request->file($field));
                $uploadedImages2[$field] = $optimizedUrl;
            }
        }

        // Update blog with image URLs
        if (!empty($uploadedImages2)) {
            $blog->update($uploadedImages2);
        }

        return response()->json(['success' => true, 'message' => 'Blog created successfully']);
    }



    public function listblogindex(Request $request)
    {
        return view('blogs.list_blog');
    }

    public function list_blog(Request $request)
    {

        if (Auth::user()->isadmin() || Auth::user()->issuperAdmin()) {
            $Blog = Blog::get();
            return DataTables::of($Blog)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    // $Blog = Blog::find($row->title);
                    return $row != null ? $row->title : "";
                })
                ->addColumn('posted_by', function ($row) {
                    // $Blog = Blog::find($row->posted_by);
                    return $row != null ? $row->posted_by : "";
                })
                ->addColumn('date', function ($row) {
                    // $Blog = Blog::find($row->date);
                    return $row != null ? $row->date : "";
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                    $actionBtn .= '<a class="edit btn btn-info btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function upnewblog($id)
    {
        $blogs = Blog::find($id);
        $blog_image = Blog_image::where('blog_id', $blogs->id)->first();

        return view('blogs.update_blogs', ['blog' => $blogs, 'blog_image' => $blog_image]);
    }
    public function update_blog(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);


        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'title_details' => 'required|string',
            'slug' => 'required|string|max:255',
            'posted_by' => 'required|string|max:255',
            'date' => 'required|date',
            'description_one_title' => 'nullable|string',
            'description_one' => 'nullable|string',
            'description_two_title' => 'nullable|string',
            'description_two' => 'nullable|string',
            'description_three_title' => 'nullable|string',
            'description_three' => 'nullable|string',
            'description_four_title' => 'nullable|string',
            'description_four' => 'nullable|string',
            'first_image' => 'nullable|image',
            'second_image' => 'nullable|image',
            'third_image' => 'nullable|image',
        ]);

        // Sanitize slug
        $slug = preg_replace('~[^\pL\d]+~u', '-', $request->slug);
        $slug = iconv('utf-8', 'utf-8//IGNORE', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('~-+~', '-', $slug);
        $slug = strtolower($slug);

        if (empty($slug)) {
            $slug = 'n-a';
        } elseif (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'This slug already exists']);
        }

        // Update blog fields
        $blog->update([
            'title' => $request->title,
            'title_details' => $request->title_details,
            'slug' => $slug,
            'posted_by' => $request->posted_by,
            'date' => $request->date,
            'description_one_title' => $request->description_one_title,
            'description_one' => $request->description_one,
            'description_two_title' => $request->description_two_title,
            'description_two' => $request->description_two,
            'description_three_title' => $request->description_three_title,
            'description_three' => $request->description_three,
            'description_four_title' => $request->description_four_title,
            'description_four' => $request->description_four,
        ]);

        $cloudName = "djd3y5gzw"; // Replace with your Cloudinary cloud name
        $uploadedImages = [];

        // Helper function to upload and optimize images
        $uploadAndOptimize = function($file) use ($cloudName) {
            $filename = uploadFile($file, 'blog'); // Upload to S3
            $originalUrl = 'https://savoirbucket.s3.eu-north-1.amazonaws.com/storage/' . $filename;
            return "https://res.cloudinary.com/{$cloudName}/image/fetch/f_auto,q_auto,fl_lossy/" . urlencode($originalUrl);
        };

        // Update main image if provided
        if ($request->hasFile('image')) {
            $optimizedUrl = $uploadAndOptimize($request->file('image'));
            $uploadedImages['image'] = $optimizedUrl;

            // Update main Blog_image entry
            $blogImage = Blog_image::where('blog_id', $blog->id)->first();
            if ($blogImage) {
                $blogImage->update(['url' => $optimizedUrl]);
            } else {
                Blog_image::create(['blog_id' => $blog->id, 'url' => $optimizedUrl]);
            }
        }

        // Update additional images
        $imageFields = ['first_image', 'second_image', 'third_image'];
        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $optimizedUrl = $uploadAndOptimize($request->file($field));
                $uploadedImages2[$field] = $optimizedUrl;
            }
        }

        if (!empty($uploadedImages2)) {
            $blog->update($uploadedImages2);
        }

        return response()->json(['success' => true, 'message' => 'Blog updated successfully']);
    }




    public function delete_blog(Request $request)
    {

        $blog = Blog::find($request->id);
        if ($blog){
            $blog_images= Blog_image::where('blog_id', $request->id)->get();
            foreach($blog_images as $img){
                deleteFile($img->url);
                $img->delete();
            }
            $blog->delete();
            return response()->json(['success' => true, 'message' => 'Blog has been deleted successfully']);
        }
        else{
            return response()->json(['success' => true, 'message' => 'Error while deleting Blog']);
        }

    }
}
