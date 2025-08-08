<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\User;
use App\Models\calender;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\PhotosheetType;
use Yajra\DataTables\DataTables;
use App\Mail\SendConfirmedReport;
use App\Mail\SendRejectionReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailToPhotographer;

class AppointmentController extends Controller
{
    use SendEmailT;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function createappointmentindex()
    {
        $agentnames = User::where('role_id', '3')->get();
        $photographers = User::where('role_id', '6')->get();
        $photoshoottypes = PhotosheetType::all();
        return view('admin.createappointment', ['agentnames' => $agentnames, 'photographers' => $photographers, 'photoshoottypes' => $photoshoottypes]);
    }

    public function createnewappointment(Request $request)
    {
        $request->validate(
            [
                'date' => 'required',
                'time' => 'required',
                'location' => 'required',
                'photoshoottype' => 'required',
                'photographer' => 'required',
            ],
            [
                'required'  => 'The :attribute field is required.',
            ]
        );
        $appointment = Appointment::create([
            'date' => $request->date,
            'time' => $request->time,
            'agent_id' => Auth::user()->id,
            'location' => $request->location,
            'building_name' => $request->buildingname,
            'apartment_no' => $request->apartmentnumber,
            'status' => "Pending",
            'comment' => $request->comment,
            'photoshoot_type_id' => $request->photoshoottype,
            'user_id' => $request->photographer,
        ]);
        $photographer = User::find($request->photographer);
        $agent_name = User::find($appointment->agent_id);
        $photoshoot = PhotosheetType::find($request->photoshoottype);
        $photographer_email = $photographer->email;
        $details = [
            'photographer_name' => $photographer->name,
            'appointment_id' => $appointment->id,
            'agent_id' => $appointment->agent_id,
            'date' => $request->date,
            'time' => $request->time,
            'building_name' => $appointment->building_name,
            'apartment_number' => $appointment->apartment_no,
            'comment' => $appointment->comment,
            'photoshoot' => $photoshoot->name,
            'title' => "You have a new request from " . ucfirst($agent_name->name) . " to book an appointment with the following details:"
        ];

        $this->sendEmailAppointmentRequest([["email" => $photographer_email]], $details);
        // Mail::to($photographer_email)->send(new SendMailToPhotographer($details));

        if ($appointment != null)
            return response()->json(['success' => true, 'message' => 'Appointment created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new Appointment']);
    }
    public function confirmappointment($appointment_id, $agent_id)
    {
        $appointment = Appointment::find($appointment_id);
        if ($appointment) {
            if ($appointment->status == 'Rejected' || $appointment->status == 'Passed' || $appointment->status == 'Confirmed') {
                return 'invalid link';
            } else {
                $appointment->status = 'Confirmed';
                $appointment->save();
                calender::create([
                    'event_title' => $appointment->building_name,
                    'start_time' => $appointment->date,
                    'end_time' => $appointment->date,
                    'event_id' => $appointment_id,
                    'user_id' => $agent_id,
                    'event_type' => 'full day',
                    'event_source' => 'photo_session',
                ]);
                $usermail = User::find($agent_id);
                $photographer_name = User::find($appointment->user_id);
                $photoshoot = PhotosheetType::find($appointment->photoshoot_type_id);
                $date_format = new DateTime($appointment->date);
                $details = [
                    'id' => $appointment->id,
                    'name' => $usermail->name,
                    'date' => $date_format->format('d-m-Y'),
                    'time' => $appointment->time,
                    'photographer_name' => $photographer_name->name,
                    'location' => $appointment->location,
                    'photoshoot' => $photoshoot->name
                ];
                $this->sendEmailAppointmentApproved([["email" => $usermail->email]], $details, 1);
                // Mail::to($usermail->email)->send(new SendConfirmedReport($details));
                return redirect()->route('show_appointment_index');
            }
        } else {
            return 'invalid link';
        }
    }
    public function rejectappointment($appointment_id, $agent_id)
    {
        $appointment = Appointment::find($appointment_id);
        if ($appointment) {
            if ($appointment->status == 'Rejected' || $appointment->status == 'Passed' || $appointment->status == 'Confirmed') {
                return 'invalid link';
            } else {
                $appointment->status = 'Rejected';
                $appointment->save();
                $usermail = User::find($agent_id);
                $photographer_name = User::find($appointment->user_id);
                $photoshoot = PhotosheetType::find($appointment->photoshoot_type_id);
                $date_format = new DateTime($appointment->date);
                $details = [
                    'id' => $appointment->id,
                    'name' => $usermail->name,
                    'date' => $date_format->format('d-m-Y'),
                    'time' => $appointment->time,
                    'photographer_name' => $photographer_name->name,
                    'photoshoot' => $photoshoot->name,
                    'location' => $appointment->location
                ];
                $this->sendEmailAppointmentRejected([["email" => $usermail->email]], $details, 0);
                // Mail::to($usermail->email)->send(new SendRejectionReport($details));
                return redirect()->route('show_appointment_index');
            }
        } else {
            return 'invalid link';
        }
    }
    public function confirmappointmentcrm(Request $request)
    {
        $appointment = Appointment::find($request->id);
        if ($appointment) {
            if ($appointment->status == "Pending") {
                $appointment->status = 'Confirmed';
                $appointment->save();
                $usermail = User::find($appointment->agent_id);
                $photographer_name = User::find($appointment->user_id);
                $date_format = new DateTime($appointment->date);
                $details = [
                    'name' => $usermail->name,
                    'date' => $date_format->format('d-m-Y'),
                    'time' => $appointment->time,
                    'photographer_name' => $photographer_name->name,
                    'location' => $appointment->location,
                    'message' => 'your appointment has been confirmed.'
                ];
                calender::create([
                    'event_title' => $appointment->building_name,
                    'start_time' => $appointment->date,
                    'end_time' => $appointment->date,
                    'event_id' => $request->id,
                    'user_id' => $appointment->agent_id,
                    'event_type' => 'full day',
                    'event_source' => 'photo_session',
                ]);
                Mail::to($usermail->email)->send(new SendConfirmedReport($details));
                return response()->json(['success' => true, 'message' => 'Appointment is confirmed']);
            } else {
                return response()->json(['success' => false, 'message' => 'Unable to confirmed the appointment']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'appointment not found']);
        }
    }
    public function rejectappointmentcrm(Request $request)
    {
        $appointment = Appointment::find($request->id);
        if ($appointment) {
            if ($appointment->status == "Pending") {
                $appointment->status = 'Rejected';
                $appointment->save();

                $usermail = User::find($appointment->agent_id);
                $details = [
                    'name' => $usermail->name,
                    'message' => 'your appointment has been rejected.'
                ];
                Mail::to($usermail->email)->send(new SendRejectionReport($details));
                return response()->json(['success' => true, 'message' => 'Appointment rejected']);
            } else {
                return response()->json(['success' => false, 'message' => 'Unable to rejected the appointment']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'appointment not found']);
        }
    }
    public function updateappointmentindex($id)
    {
        // dd($id);
        $appointments = Appointment::join('users', function ($join) {
            $join->on('users.id', '=', 'appointments.agent_id');
        })
            ->join('photoshoot_types', 'appointments.photoshoot_type_id', '=', 'photoshoot_types.id')
            ->select(
                'appointments.*',
                'users.name as agentname',
                'photoshoot_types.name as photoshoot_type'
            )
            ->where('appointments.id', $id)->where('appointments.status', 'Pending')->first();
        $agentnames = User::where('role_id', '3')->get();
        $photographers = User::where('role_id', '6')->get();
        $photoshoottypes = PhotosheetType::all();
        if ($appointments != null) {
            return view('admin.updateappointment', ['appointments' => $appointments, 'agentnames' => $agentnames, 'photographers' => $photographers, 'photoshoottypes' => $photoshoottypes]);
        } else {
            return redirect()->route('show_appointment_index')->with(['message' => 'Unable to update the appointment']);
        }
    }

    public function updateappointment(Request $request)
    {
        $request->validate(
            [
                'date' => 'required',
                'time' => 'required',
                'location' => 'required',
                'photoshoottype' => 'required',
                'photographer' => 'required',
            ],
            [
                'required'  => 'The :attribute field is required.',
            ]
        );
        $appointment = Appointment::find($request->id);
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->agent_id = Auth::user()->id;
        $appointment->location = $request->location;
        $appointment->building_name = $request->buildingname;
        $appointment->apartment_no = $request->apartmentnumber;
        $appointment->status = "Pending";
        $appointment->comment = $request->comment;
        $appointment->photoshoot_type_id = $request->photoshoottype;
        $appointment->user_id = $request->photographer;
        $appointment->save();

        if ($appointment != null)
            return response()->json(['success' => true, 'message' => 'Appointment created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new Appointment']);
    }
    public function showappointmentindex()
    {
        return view('admin.listappointment');
    }

    public function showappointment(Request $request)
    {
        $appointments = Appointment::join('users', function ($join) {
            $join->on('users.id', '=', 'appointments.agent_id');
        })
            ->join('photoshoot_types', 'appointments.photoshoot_type_id', '=', 'photoshoot_types.id')
            ->select(
                'appointments.*',
                'users.name as agentname',
                'photoshoot_types.name as photoshoot_type'
            )->orderBy('appointments.date', 'DESC')->get();

        return DataTables::of($appointments)
            ->addcolumn('check', function () {
                return null;
            })
            ->addColumn('agentname', function ($row) {
                $agentname = $row->agentname;
                return $agentname;
            })
            ->addColumn('photoshoot_type', function ($row) {
                $photoshoot_type = $row->photoshoot_type;
                return $photoshoot_type;
            })
            ->addColumn('photographer', function ($row) {
                $photographer = User::where('id', $row->user_id)->first();
                if ($photographer != null) {
                    return $photographer->name;
                }
            })
            ->rawColumns(['check', 'action'])
            ->make(true);
    }
    public function deleteappointment(Request $request)
    {
        $data = json_decode($request->data);
        foreach ($data as $key => $item) {
            $appointment = Appointment::find($item);
            if ($appointment->status == 'Pending') {
                $appointment->delete();
                $calenders = calender::where('event_id', $request->id)->where('event_source', 'photo_session')->get();
                foreach ($calenders as $calender) {
                    $calender->delete();
                }
                return response()->json(['success' => true, 'message' => 'Appointment deleted successfully']);
            } else {
                unset($data[$key]);
                return response()->json(['success' => false, 'message' => 'Unable to delete the appointment']);
            }
        }
    }
    public function bookappointment(Request $request)
    {
        // dd($request->all());
        $data = json_decode($request->data);
        $users = User::where('role_id', '6')->get()->toArray();
        foreach ($data as $key => $item) {
            $appointments[] = Appointment::join('users', function ($join) {
                $join->on('users.id', '=', 'appointments.agent_id');
            })
                ->join('photoshoot_types', 'appointments.photoshoot_type_id', '=', 'photoshoot_types.id')
                ->select(
                    'appointments.*',
                    'users.name as agentname',
                    'photoshoot_types.name as photoshoot_type'
                )
                ->where('appointments.id', $item)->get()->toArray();
        }
        return response()->json([
            'data' => $appointments,
            'users' => $users,
            'success' => true
        ]);
    }
    public function requestapponitment(Request $request)
    {
        // dd($request->all());
        $appointment = Appointment::find($request->id);
        $photographer = User::find($appointment->user_id);
        $agentname = User::find($appointment->agent_id);
        $details = [
            'photographer_name' => $photographer->name,
            'appointment_id' => $request->id,
            'agent_id' => $agentname->id
        ];

        Mail::to($photographer->email)->send(new SendMailToPhotographer($details));

        if ($appointment != null)
            return response()->json(['success' => true, 'message' => 'Appointment requested successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in request Appointment']);
    }
}
