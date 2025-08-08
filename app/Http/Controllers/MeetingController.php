<?php

namespace App\Http\Controllers;

use App\Models\calender;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MeetingController extends Controller
{
    use SendEmailT;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'datetime' => 'required',
                'agents' => 'required|array'
            ]);
            if ($validator->fails())
                return response()->json(['success' => false, 'message' => $validator->getMessageBag()]);

            $validDate = Carbon::parse(str_replace("/", "-", $request->datetime))->greaterThanOrEqualTo(now()->toDateTime()->format('d-m-Y H:m'));
            if (!$validDate)
                return response()->json(['success' => false, 'message' => ["DateTime value must be greater than " . date('d/m/Y H:m')]]);

            $meeting =  Meeting::Create([
                'title' => $request->title,
                'description' => $request->description,
                'datetime' => $request->datetime,
                'created_by' => Auth::user()->id
            ]);

            $meeting->users()->attach($request->agents, ['is_user_attend' => 0]);

            calender::create([
                'event_title' => $meeting->title,
                'start_time' => $meeting->datetime,
                'end_time' => $meeting->datetime,
                'event_id' => $meeting->id,
                'user_id' => Auth::user()->id,
                'event_type' => 'full day',
                'event_source' => 'meeting',
            ]);

            $details = [
                'id' => $meeting->id,
                'title' => $meeting->title,
                'description' => $meeting->description,
                'datetime' => $meeting->datetime
            ];

            $users_list = [];
            foreach ($meeting->users as $key => $user) {
                $users_list[] = ["email" => $user->email];
            }
            $this->sendEmailMeetingCreated($users_list, $details);
            return response()->json(['success' => true, 'message' => "Meeting created successfully"]);
        }

        $agents = User::where('role_id', 3)->get();
        return view('meeting.index', ['agents' => $agents]);
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $meetings = Meeting::orderBy('created_at','desc')->get();
            return Datatables::of($meetings)
                ->addIndexColumn()
                ->addColumn('agents', function ($row) {
                    $agents = $row->users;
                    $btn = '<ul class="ml-5">';
                    foreach ($agents as $key => $agent) {
                        $btn .= '<li> ' . $agent->name . ' </li>';
                    }
                    $btn .= '</ul>';
                    return $btn;
                })
                ->addColumn('absent_agents', function ($row) {
                    $agents = $row->users()->wherePivot('is_user_attend', 2)->get();
                    $btn = '<ul class="ml-5">';
                    foreach ($agents as $key => $agent) {
                        $btn .= '<li> ' . $agent->name . ' </li>';
                    }
                    $btn .= '</ul>';
                    return $btn;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary" href="' . route("attend.meeting", $row->id) . '"> Edit </a>';
                    $btn .= '<a class="btn btn-danger ml-2" onclick="deleteMeeting(' . $row->id . ')"> Delete </a>';
                    return $btn;
                })
                ->rawColumns(['agents', 'action', 'absent_agents'])
                ->make(true);
        }
        return view('meeting.list');
    }

    public function attend(Request $request, $id)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'datetime' => 'required'
            ]);
            if ($validator->fails())
                return response()->json(['success' => false, 'message' => $validator->getMessageBag()]);

            $meeting =  Meeting::find($id);


            if ($request->agents) {
                foreach ($meeting->users as $key => $agent) {
                    if (in_array($agent->id, $request->agents)) {
                        $meeting->users()->updateExistingPivot($agent, ['is_user_attend' => 1]);
                    } else {
                        $meeting->users()->updateExistingPivot($agent, ['is_user_attend' => 2]);
                    }
                }
            } else {
                foreach ($meeting->users as $key => $agent) {
                    $dd = $meeting->users()->updateExistingPivot($agent->id, ['is_user_attend' => 2]);
                }
            }
            return response()->json(['success' => true, 'message' => "Meeting attended successfully"]);
        }

        $meeting = Meeting::where('id', $id)->first();
        return view('meeting.update', ['meeting' => $meeting]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'datetime' => 'required',
            'agents' => 'required|array'
        ]);
        if ($validator->fails())
            return response()->json(['success' => false, 'message' => $validator->getMessageBag()]);

        $validDate = Carbon::parse(str_replace("/", "-", $request->datetime))->greaterThanOrEqualTo(now()->toDateTime()->format('d-m-Y H:m'));
        if (!$validDate)
            return response()->json(['success' => false, 'message' => ["DateTime value must be greater than " . date('d/m/Y H:m')]]);

        $meeting =  Meeting::find($request->id);
        $meeting->title = $request->title;
        $meeting->description = $request->description;
        $meeting->datetime = $request->datetime;
        $meeting->Save();
        $meeting->users()->detach();
        $meeting->users()->attach($request->agents);
        return response()->json(['success' => true, 'message' => "Meeting updated successfully"]);
    }

    public function delete(Request $request)
    {
        $meeting = Meeting::find($request->id);
        $meeting->users()->detach();
        $meeting->delete();
        return response()->json(['success' => true, 'message' => "Meeting deleted successfully"]);
    }

    public function add_meeting_to_calendar($id)
    {
        $meeting = Meeting::find($id);
        $meeting->date = Carbon::parse($meeting->date)->format('d-m-Y');
        return view('meeting.add_meeting_to_calendar', ['meeting' => $meeting]);
    }
}
