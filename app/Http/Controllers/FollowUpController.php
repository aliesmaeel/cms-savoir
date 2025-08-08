<?php

namespace App\Http\Controllers;

use App\Mail\leadesemail;
use App\Models\booktable;
use App\Models\Comment;
use App\Models\Data;
use App\Models\DeadLeads;
use App\Models\FollowUpLeads;
use App\Models\followupstatuscommentshistory;
use App\Models\QualifiedLeads;
use App\Models\sendinblue_templates;
use App\Models\sendinbluewhatsapptemplate;
use App\Models\User;
use App\Models\UserFollowUpLeads;
use App\Models\UserFollowUpLeadsComment;
use App\Models\UserQualifiedLeads;
use App\Models\WonLeads;
use Carbon\Carbon;
use Exception;
use PHPUnit\Util\Json;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class FollowUpController extends Controller
{
    use SendEmailT;
    public function __construct()
    {
        $this->middleware('auth');
    }

    //////////////////////////// show followup leads index for admin
    public function followupindex()
    {

        $datasource = FollowUpLeads::select('source')->groupBy('source')->pluck('source');
        $projects = FollowUpLeads::select('project')->groupBy('project')->pluck('project');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $templet_name = sendinblue_templates::get();
        $template_whatsapps=sendinbluewhatsapptemplate::get();
        // $projects = FollowUpLeads::where('project', '!=', '')->select('project')->groupBy('project')->pluck('project');
        return view('admin.followup.followup', ['projects' => $projects, 'datasource' => $datasource, 'templetname' => $templet_name, 'agentnames' => $agentnames,'templatewhatsapps'=>$template_whatsapps]);
    }

    //////////////////////////// show followup leads for admin
    public function followup(Request $request)
    {
        $agentname = $request->agentname;
        $datasource = $request->datasource;
        $projects = $request->projects;
        $commenteddata = UserFollowUpLeadsComment::select('follow_up_id')->pluck('follow_up_id')->toArray();
        $data = FollowUpLeads::join('users', 'users.id', '=', 'follow_up_leads.created_by')->whereNotIn('follow_up_leads.id', $commenteddata)->orderBy('created_at','DESC');
        if ($agentname != null) {
            $data = $data->where('created_by', $agentname);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        if ($projects != null) {
            $data = $data->where('project', $projects);
        }
        $data = $data->select('follow_up_leads.*', 'users.name as agentname')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                if ($row->is_enquiry_customer) {
                    $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                    $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
                    return $actionBtn;
                } else if ($row->created_by == 0) {
                    $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                    return $actionBtn;
                }
            })->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check','action'])
            ->make(true);
    }
    public function sendemailtofollowUpleads(Request $request)
    {
        $id = array_map('intval', explode(',', $request->id));
        // $validator = Validator::make($request->toArray(), [
        //     'body' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'errors'=>$validator->errors()->all(),
        //         'status'=>false
        //         ]);
        // }
        $to = [];
        $option = $request->option;
        $body = $request->body;
        $templet_id = $request->templet_id;
        foreach ($id as $key) {
            $data_followUp_leads = FollowUpLeads::find($key);
            if ($data_followUp_leads) {
                $details = [
                    'name' => $data_followUp_leads->name,
                    'email' => $data_followUp_leads->email,
                    'body' => $body
                ];
                $to[] = [
                    'email' => $data_followUp_leads->email,
                    'name' => $data_followUp_leads->name,
                ];
            }

            $data = [
                'to' => $to,
                'body' => $body,
                'template_id' => $templet_id
            ];

            return $this->SendEmail($data, $option);
        };
        return response()->json(['status' => true, 'message' => 'Email has been sent successfully']);
    }

    //////////////////////////// assigne agent to followup leads data index for admin
    public function assignagentfollowupindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = FollowUpLeads::select('source')->groupBy('source')->get();
        return view('admin.followup.assignagentfollowupdata', ['agentnames' => $agentnames, 'datasources' => $datasources]);
    }

    //////////////////////////// assign agent to followup leads data for admin
    public function assignagentfollowupdata(Request $request)
    {
        $request->validate(
            [
                'userid' => 'required|exists:users,id',
                'data' => 'required|json'
            ],
            [
                'data.required' => 'please select data you want to assign !!'
            ]
        );

        try {
            $userdata = [];
            $data = json_decode($request->data);
            foreach ($data as $key => $item) {
                $userdata[] = new UserFollowUpLeads([
                    'user_id' => $request->userid,
                    'follow_up_id' => $item
                ]);
            }
            $user = User::find($request->userid);
            $user->userfollowupdata()->saveMany($userdata);
            // update data status
            $status = FollowUpLeads::whereIn('id', $data)->update(['assigned' => true]);
            return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error while assign data for user']);
        }
    }
    //////////////////////////// unassign followup leads data
    public function unassignagentfollowupdata(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'userid' => 'required|exists:users,id',
                'data' => 'required|json'
            ],
            [
                'data.required' => 'please select data you want to Unassign !!'
            ]
        );
        try {
            $data = json_decode($request->data);
            $comments = UserFollowUpLeadsComment::join('user_follow_up_leads', function ($join) {
                $join->on('user_follow_up_leads_comments.follow_up_id', '=', 'user_follow_up_leads.follow_up_id')
                    ->on('user_follow_up_leads_comments.user_id', '=', 'user_follow_up_leads.user_id');
            })->where('user_follow_up_leads_comments.user_id', $request->userid)->pluck('user_follow_up_leads_comments.follow_up_id')->toArray();
            foreach ($data as $key => $item) {
                if (in_array($item, $comments)) {
                    unset($data[$key]);
                }
            }
            if ($data != null) {
                UserFollowUpLeads::where('user_id', $request->userid)->whereIn('follow_up_id', $data)->delete();
                Data::whereIn('id', $data)->update(['assigned' => false]);
                return response()->json(['success' => true, 'message' => 'User data has been unassigned successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Unable to unassign this data']);
            }
        } catch (Exception $ex) {
            return response()->json(['success' => false, 'message' => 'Error while unassign data for user']);
        }
    }

    //////////////////////////// return list of unassigned data for followup leads data table for admin
    public function searchforagentfollowupdata(Request $request)
    {
        $data = [];
        $user = User::find($request->userid);
        if ($user) {
            $data = FollowUpLeads::join('users', 'users.id', '=', 'follow_up_leads.created_by')->where('assigned', 0);
            $data =$data->select('follow_up_leads.*', 'users.name as agentname')->get();
        }
        $datasource = $request->project;
            if ($datasource != null && $user)
                $data = $data->where('source', $datasource);
            return DataTables::of($data)
                ->addcolumn('check', function () {
                    return null;
                })
                ->rawColumns(['check'])
                ->make(true);

    }

    //////////////////////////// add comments on followup leads data for agent
    public function addfollowupcomment(Request $request)
    {
        // if user status is interested from data then we add user to leads pool and set source as customer enquiry
        // if user status is interested from leads pool then add
        // if user status is not interseted then add to dead pools
        // if user status is set appointment then after appointment we save it in won deal

        // data_status:
        // 0 non qualified
        // 1 qualified
        // 2 intersted
        // 3 set apponitment
        // 4 not not interested
        // 5 won leads
        // 6 dead leads
        // 7 qualified leads
        // 8 leads pool
        // 9 follow up leads
        // dd($request->all());

        $request->validate([
            'comment' => 'required'
        ]);

        try {
            if ($request->appointment_date != null && $request->userstatus == "Appointment is set") {
                // add comment
                $comment=UserFollowUpLeadsComment::where('follow_up_id',$request->checkedrow)->where('user_id',Auth::user()->id)->first();
                if($comment){
                    $comment->update([
                        'comment' => $request->comment,
                        'userstatus' => $request->userstatus
                    ]);
                }else{
                    $comment=UserFollowUpLeadsComment::create([
                    'userstatus'=> $request->userstatus,
                    'follow_up_id' => $request->checkedrow,
                    'user_id'=> Auth::user()->id,
                    'comment'=> $request->comment,
                    'appointment_date' => $request->appointment_date
                    ]);
                }
                // change data status to won leads
                $data = FollowUpLeads::find($request->checkedrow);
                $qualifieddata = QualifiedLeads::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'mobile' => $data->mobile,
                    'phone_whatsapp' => $data->phone_whatsup,
                    'number_of_beds' => $data->number_of_beds,
                    'source' => $data->source,
                    'project' => $data->project,
                    'title' => $data->title,
                    'data_id' => $data->data_id,
                    'previous_state' => '9',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true
                ]);
                $userdata = new UserQualifiedLeads([
                    'user_id' => Auth::user()->id,
                    'qualified_leads_id' => $qualifieddata->id
                ]);
                $userdata->save();
                Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 7]);
            }else{
               $comment=UserFollowUpLeadsComment::where('follow_up_id',$request->checkedrow)->where('user_id',Auth::user()->id)->first();
                if($comment){
                    $comment->update([
                        'comment' => $request->comment,
                        'userstatus' => $request->userstatus
                    ]);
                }else{
                    $comment=UserFollowUpLeadsComment::create([
                    'userstatus'=> $request->userstatus,
                    'follow_up_id' => $request->checkedrow,
                    'user_id'=> Auth::user()->id,
                    'comment'=> $request->comment,
                    ]);
                }

                // add data to own leads
                $data = FollowUpLeads::find($request->checkedrow);
                DeadLeads::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'mobile' => $data->mobile,
                    'phone_whatsapp' => $data->phone_whatsup,
                    'number_of_beds' => $data->number_of_beds,
                    'source' => $data->source,
                    'project' => $data->project,
                    'title' => $data->title,
                    'data_id' => $data->data_id,
                    'previous_state' => '9',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);

                // $data->delete();
                // change data status to dead leads
                Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 6]);
            }

            return response()->json(['success' => true, 'message' => 'Comment entered successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error happen call system admin']);
        }
    }

    //////////////////////////// show assigned followup leads data index for agent
    public function followupuserhomeindex()
    {
        $projects = FollowUpLeads::select('project')->groupBy('project')->get();
        $datasource = FollowUpLeads::select('source')->groupBy('source')->get();
        $templet_name = sendinblue_templates::get();
        $template_whatsapps=sendinbluewhatsapptemplate::get();
        return view('agent.followup.followupuserhome', ['projects' => $projects, 'datasource' => $datasource,'templetname'=>$templet_name,'templatewhatsapps'=>$template_whatsapps]);
    }

    //////////////////////////// show assigned followup leads data for agent
    public function followupuserhomedata(Request $request)
    {
        $project = $request->project;
        $datasource = $request->datasource;

        $data = FollowUpLeads::query();
        if ($project != null) {
            $data = $data->where('project', $project);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }

        $temp0 = Auth::user()->userfollowupdata()->pluck('follow_up_id');
        $data = $data->whereIn('follow_up_leads.id', $temp0);
        $temp = Auth::user()->userfollowupdatacomment()->whereNotIn('userstatus',['Interested','Not answer','Mobile Switched off','Line Busy','Contacted Via Email'])->pluck('follow_up_id');
        $data = $data->whereNotIn('follow_up_leads.id', $temp);
        $data = $data->join('users', 'users.id', '=', 'follow_up_leads.created_by');
        $data = $data->select('follow_up_leads.*', 'users.name as agentname');
        return DataTables::of($data)
            ->addColumn('comments', function ($row) {
                return '<div class="col-md-12"><input type="text" class="form-control w-75" id="comment' . $row->id . '" name=""></div>' .
                '<div class="row">' .
                '<div class="col-md-3 ml-1 mt-1 btn-group btn-group-sm"><button onclick="btnaddcomment(' . $row->id . ')" type="button" id="' . $row->data_id . '" class="add btn btn-primary btn-sm mr-2">Add</button><button data-id="' . $row->id . '" type="button"  class="calender1 btn btn-danger btn-sm mr-2">Calendar</button>' .
                '<button onclick="show_comments(' . $row->data_id . ')" type="button" id="showcomments' . $row->data_id . '" class="btn btn-warning btn-sm show-com">Show Comments</button></div>' .
                '</div>' .
                '<div id="calendar-date' . $row->id . '" style="text-align:center;color:red;width:250px"></div>';
        })
            ->addColumn('userstatus', function ($row) {
                return '<div class="row">' .
                    '<div class="col-md-7"><select name="userstatus" class="form-control w-100" id="userstatus' . $row->id . '" onchange="user_status_change_event(' . $row->id . ')">' .
                    '<option selected value="">User status</option>' .
                    '<optgroup label="Dead">'.
                        '<option value="Others">Others</option>'.
                        '<option value="Invalid Number & Email">Invalid Number & Email</option>'.
                        '<option value="Wrong Number & Email">Wrong Number & Email</option>'.
                        '<option value="Number & Email Unavailable">Number & Email Unavailable</option>'.
                        '<option value="Not interested">Not interested</option>'.
                    '</optgroup>'.
                    '<optgroup label="Qualified">'.
                        '<option value="Appointment is set">Appointment is set</option>'.
                    '</optgroup>'.
                    '</select></div>'.
                    '<div class="col-md-2 ml-3 mt-1"><button onclick="btn_click_add_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="btn btn-primary btn-sm">Set</button></div>'.
                    '</div>';
            })
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['comments', 'userstatus','check'])
            ->make(true);
    }

    //////////////////////////// show comments on followup leads data index for admin
    public function showuserfollowupdatacommentsindex()
    {
        $userstatus = config('app.follow_up_user_status');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = FollowUpLeads::select('source')->groupBy('source')->get();
        return view('admin.followup.showuserfollowupdatacomment', ['userstatus' => $userstatus, 'datasources' => $datasources, 'agentnames' => $agentnames]);
    }

    //////////////////////////// show comments on followup leads data index for agent
    public function showfollowupdatacommentsindex()
    {
        $userstatus = config('app.follow_up_user_status');
        $datasources = FollowUpLeads::select('source')->groupBy('source')->get();
        return view('agent.followup.showfollowupdatacomment', ['userstatus' => $userstatus, 'datasources' => $datasources]);
    }

    //////////////////////////// show comments on followup leads data for agent and admin
    public function showfollowupdatacomments(Request $request)
    {
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->agentname;
        } else {
            $userid = Auth::user()->id;
        }
        $userstatus = $request->userstatus;
        $datasource = $request->datasource;
        $project = $request->project;
        $filtertext = $request->searchday;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $searchdaytext = null;
        $monthfiltertext = null;

        if (!is_null($filtertext)) {
            $filtertext = explode('-', $filtertext);
            $monthfiltertext = $filtertext[1];
            $searchdaytext = $filtertext[0];
            if ($searchdaytext == "" || $searchdaytext == "00")
                $searchdaytext = null;

            if ($monthfiltertext == "" || $monthfiltertext == "00")
                $monthfiltertext = null;
        }

        $filtertype = $request->filtertype;

        $sdate = null;
        $edate = null;
        // date range filteration
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
            // $sdate = $sdate->toDateString();
            $edate = $edate->addDay();
        }

        // specific date filteration
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        $data = UserFollowUpLeads::join('user_follow_up_leads_comments', function ($join) {
            $join->on('user_follow_up_leads.follow_up_id', '=', 'user_follow_up_leads_comments.follow_up_id')
                ->on('user_follow_up_leads.user_id', '=', 'user_follow_up_leads_comments.user_id');
        })
            ->join('follow_up_leads', 'follow_up_leads.id', '=', 'user_follow_up_leads.follow_up_id')
            ->join('users', 'users.id', '=', 'user_follow_up_leads_comments.user_id')
            ->select(
                'follow_up_leads.*',
                'follow_up_leads.phone',
                'follow_up_leads.email',
                'follow_up_leads.name',
                'follow_up_leads.project',
                // 'follow_up_leads.MOBILE',
                'follow_up_leads.source',
                'user_follow_up_leads.follow_up_id',
                'user_follow_up_leads.user_id',
                'users.name as agentname',
                'user_follow_up_leads_comments.userstatus',
                'user_follow_up_leads_comments.comment as comment',
                'user_follow_up_leads_comments.appointment_date',
                'user_follow_up_leads_comments.created_at'
            )->where('user_follow_up_leads_comments.user_id', $userid);

        /////////////////////// agent filter
        if ($userid != null) {
            $data = $data->where('user_follow_up_leads_comments.user_id', $userid);
        }

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_follow_up_leads_comments.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_follow_up_leads_comments.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_follow_up_leads_comments.created_at', '=', $searchdaytext);

        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_follow_up_leads_comments.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('follow_up_leads.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('follow_up_leads.project', $project);

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('comments', function ($row) {
                $comment = null;
                if ($row->userstatus == "Interested")
                    $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <p> <b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else if ($row->userstatus == "Not interested")
                    $comment = '<div class="row ml-1" style="background-color:#00ff95"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else if ($row->userstatus == "Not answer")
                    $comment = '<div class="row ml-1" style="background-color:#bab2e1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else if ($row->userstatus == "Number unavailable/Not working for call/Incomplete no")
                    $comment = '<div class="row ml-1" style="background-color:#ffc55c"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else if ($row->userstatus == "Switch off/Line busy/Wrong number/Invalid number")
                    $comment = '<div class="row ml-1" style="background-color:#AED6F1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else if ($row->userstatus == "Others")
                    $comment = '<div class="row ml-1" style="background-color:#DAF7A6"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div> ';
                else if ($row->userstatus == "Set appointment")
                    $comment = '<div class="row ml-1" style="background-color:#F9C4F8"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> <p><b>Appointment date: </b> ' . $row->appointment_date . '</p> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else
                    $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div> ';
                return $comment;
            })
            ->addColumn('action', function ($row) {
                if ($row->userstatus == "Interested" || $row->userstatus == "Not answer" || $row->userstatus == "Mobile Switched off" || $row->userstatus == "Contacted Via Email"  || $row->userstatus == "Line Busy" ){
                    $actionBtn = '<a class="edit btn btn-info btn-md ml-1">Edit</a>';
                }else{
                    $actionBtn="";
                }
                return $actionBtn;
            })
            ->addColumn('history', function ($row) {

                $historyBtn = '<a class="btn btn-info btn-md ml-1" onclick="show_more(' . $row->data_id . ',' . $row->created_by . ')" data-id="' . $row->created_by . '">Show Comments</a>';
                return $historyBtn;
            })
            ->addColumn('showcomment', function ($row) {
                return '<a class="btn btn-danger btn-md ml-1"  onclick="showcomment(' . $row->data_id. ',' . $row->created_by . ')" >Show Comments</a>';

            })
            ->rawColumns(['comments', 'action','history','showcomment'])
            ->make(true);
    }

    //////////////////////////// show comments info on followup leads data for agent and admin
    public function getadminfollowupdatacommentsinfo(Request $request)
    {
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->agentname;
        } else {
            $userid = Auth::user()->id;
        }
        $userstatus = $request->userstatus;
        $datasource = $request->datasource;
        $project = $request->project;
        $filtertext = $request->searchday;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $searchdaytext = null;
        $monthfiltertext = null;


        if (!is_null($filtertext)) {
            $filtertext = explode('-', $filtertext);
            $monthfiltertext = $filtertext[1];
            $searchdaytext = $filtertext[0];
            if ($searchdaytext == "" || $searchdaytext == "00")
                $searchdaytext = null;

            if ($monthfiltertext == "" || $monthfiltertext == "00")
                $monthfiltertext = null;
        }

        $filtertype = $request->filtertype;

        $sdate = null;
        $edate = null;
        // date range filteration
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
            // $sdate = $sdate->toDateString();
            $edate = $edate->addDay();
        }

        // specific date filteration
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        $data = UserFollowUpLeads::join('user_follow_up_leads_comments', function ($join) {
            $join->on('user_follow_up_leads.follow_up_id', '=', 'user_follow_up_leads_comments.follow_up_id')
                ->on('user_follow_up_leads.user_id', '=', 'user_follow_up_leads_comments.user_id');
        })
            ->join('follow_up_leads', 'follow_up_leads.id', '=', 'user_follow_up_leads.follow_up_id')
            ->join('users', 'users.id', '=', 'user_follow_up_leads_comments.user_id')
            ->select(
                'follow_up_leads.*',
                'follow_up_leads.phone',
                'follow_up_leads.email',
                'follow_up_leads.name',
                'follow_up_leads.project',
                'follow_up_leads.data_id',
                'follow_up_leads.source',
                'user_follow_up_leads.follow_up_id',
                'user_follow_up_leads.user_id',
                'users.name as agentname',
                'user_follow_up_leads_comments.userstatus',
                'user_follow_up_leads_comments.comment as comment',
                'user_follow_up_leads_comments.appointment_date',
                'user_follow_up_leads_comments.created_at'
            )->where('user_follow_up_leads_comments.user_id', $userid);

        /////////////////////// agent filter
        if ($userid != null) {
            $data = $data->where('user_follow_up_leads_comments.user_id', $userid);
        }

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_follow_up_leads_comments.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_follow_up_leads_comments.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_follow_up_leads_comments.created_at', '=', $searchdaytext);

        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_follow_up_leads_comments.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('follow_up_leads.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('follow_up_leads.project', $project);

        $data = $data->get();


        $notinterested = $data->where('userstatus', 'Not interested')->count();

        $Paid= $data->where('userstatus', 'Paid')->count();
        $MobileSwitchedoff=$data->where('userstatus', 'Mobile Switched off')->count();
        $LineBusy=$data->where('userstatus', 'Line Busy')->count();
        $ContactedViaEmail=$data->where('userstatus', 'Contacted Via Email')->count();
        $NumberEmailUnavailable=$data->where('userstatus', 'Number & Email Unavailable')->count();
        $WrongNumberEmail=$data->where('userstatus', 'Wrong Number & Email')->count();
        $InvalidNumberEmail=$data->where('userstatus', 'Invalid Number & Email')->count();
        $Cancelationafterappointment=$data->where('userstatus', 'Cancelation after appointment')->count();
        $others = $data->where('userstatus', 'Others')->count();
        $interested = $data->where('userstatus', 'Interested')->count();
        $notinterested = $data->where('userstatus', 'Not interested')->count();
        $notanswer = $data->where('userstatus', 'Not answer')->count();
        $setappointment = $data->where('userstatus', 'Appointment is set')->count();
        $total = $Paid + $MobileSwitchedoff + $LineBusy + $ContactedViaEmail + $NumberEmailUnavailable + $InvalidNumberEmail +$WrongNumberEmail+$Cancelationafterappointment + $others + $interested +  $notinterested + $notanswer +$setappointment ;
        $TotalAssigned = count(UserFollowUpLeads::where('user_id', $userid)->get());
        return response()->json([
            'succssess' => true,
            'others' => $others,
            'interested' => $interested,
            'notinterested' => $notinterested,
            'notanswer' => $notanswer,
            'total' => $total,
            'TotalAssigned' => $TotalAssigned,
            'MobileSwitchedoff'=>$MobileSwitchedoff,
            'LineBusy'=>$LineBusy,
            'setappointment' => $setappointment,
            'ContactedViaEmail'=>$ContactedViaEmail,
            'NumberEmailUnavailable'=>$NumberEmailUnavailable,
            'WrongNumberEmail'=>$WrongNumberEmail,
            'InvalidNumberEmail'=>$InvalidNumberEmail,
        ]);
    }

    //////////////////////////// show assigned leads pool data index for admin
    public function showassignedagentfollowupindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = FollowUpLeads::select('source')->groupBy('source')->pluck('source');
        return view('admin.followup.showassignedagentfollowupdata', ['agentnames' => $agentnames, 'datasources' => $datasources]);
    }

    //////////////////////////// show assigned leads pool data for admin
    public function showassignedagentfollowupdata(Request $request)
    {
        $data = FollowUpLeads::join('users', 'users.id', '=', 'follow_up_leads.created_by');
        $datasource = $request->datasource;
        $userid = $request->userid;
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        $users = User::all();
        $user = $users->where('id', $userid)->first();
        if ($user != null) {
            $temp = $user->followupdata()->pluck('follow_up_id');
            $data = $data->whereIn('follow_up_leads.id', $temp);
            $data = $data->select('follow_up_leads.*', 'users.name as agentname')->get();
        } else {
            $data = [];
        }
        return DataTables::of($data)
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check'])
            ->make(true);
    }
    public function updatecommentfollowupdata(Request $request)
    {
        $validator = Validator::make($request->toArray(), [
            'comment' => 'required',
            'status' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all(),
                'status' => false
            ]);
        }
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->user_id;
        } else {
            $userid = Auth::user()->id;
        }
        UserFollowUpLeadsComment::where('follow_up_id', $request->followup_id)->where('user_id', $userid)->update([
            'comment' => $request->comment,
            'userstatus' => $request->status,
            'appointment_date' => ($request->appartment != null) ? $request->appartment : NULL
        ]);
        $data = FollowUpLeads::find($request->followup_id);
        $wondata = WonLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->followup_id)->where('created_by', $userid)->first();
        $dedleds = DeadLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->followup_id)->where('created_by', $userid)->first();
        if ($wondata) {
            $wondata->delete();
        }
        if ($dedleds) {
            $dedleds->delete();
        }
        if ($request->status == "paid") {
            WonLeads::create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'mobile' => $data->mobile,
                'phone_whatsapp' => $data->phone_whatsup,
                'number_of_beds' => $data->number_of_beds,
                'source' => $data->source,
                'project' => $data->project,
                'title' => $data->title,
                'data_id' => $data->data_id,
                'previous_state' => '8',
                'previous_state_id' => $request->followup_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 5]);
        }elseif($request->status == "Not interested" || $request->status == "Number And Email Unavailable" || $request->status == "Wrong Number And Email" || $request->status == "Invalid Number And Email" || $request->status == "Cancelation after appointment" || $request->status == "Others" ) {
            DeadLeads::create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'mobile' => $data->mobile,
                'phone_whatsapp' => $data->phone_whatsup,
                'number_of_beds' => $data->number_of_beds,
                'source' => $data->source,
                'project' => $data->project,
                'title' => $data->title,
                'data_id' => $data->data_id,
                'previous_state' => '9',
                'previous_state_id' => $request->followup_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 6]);
        }
         else {
            followupstatuscommentshistory::create([
                'userstatus'=> $request->status,
                'follow_up_id' => $request->followup_id,
                'user_id'=> Auth::user()->id,
                'comment'=> $request->comment,
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 9]);
        }
        return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
    }
    // public function sendsmstofollowup(Request $request){
    //     $id = array_map('intval', explode(',', $request->id));
    //     $to = [];
    //     $body = $request->body;
    //     $templet_id = $request->templet_id;
    //     $option = $request->option;// body or templet
    //     foreach ($id as $key) {
    //         $data = FollowUpLeads::find($key);
    //         if ($data) {
    //             $to[] = [
    //                 'phone' => $data->phone,
    //             ];
    //         }
    //     };
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Send sms has been successfully'
    //     ]);

    // }

    public function commentfollowupleds(Request $request){
        $data_id = FollowUpLeads::find($request->data_id);
        $comment=Comment::create([
            'user_id'=>Auth::user()->id,
            'data_id'=>$data_id->data_id,
            'comment'=>$request->comment,
            'stage'=>'4',
            'appoentment_date'=>($request->appoentment_date != null ) ?$request->appoentment_date : null,
        ]);
        if($comment){
            return response()->json([
                'status' => true,
                'message' => 'Comment added successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Error in add Comment'
            ]);
        }
    }
    public function showcommentsfollowupleads(Request $request)
    {
        // dd($request->all());
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->user_id;
        } else {
            $userid = Auth::user()->id;
        }
        $data=Comment::where('data_id',$request->id)->where('user_id',$userid)->where('stage','4')->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function showmorecommentfollowup(Request $request){
        // dd($request->all());
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->user_id;
        } else {
            $userid = Auth::user()->id;
        }
        $data=followupstatuscommentshistory::where('follow_up_id', $request->id)->where('user_id', $userid)->get();

        return response()->json([
            'data'=>$data
        ]);
    }
    public function changefollowuptodead(){
        $followup_comments=UserFollowUpLeadsComment::where('userstatus','Interested')
        ->orWhere('userstatus','Not answer')->orWhere('userstatus','Mobile Switched off')
        ->orWhere('userstatus','Line Busy')->orWhere('userstatus','Contacted Via Email')
        ->get();
        foreach ($followup_comments as $followup_comment) {
            if($followup_comment->userstatus == 'Interested'){
                if($followup_comment->updated_at->addDay(30)->format('y-m-d') == Carbon::now()->format('y-m-d')){
                    $data=FollowUpLeads::find($followup_comment->follow_up_id);
                    DeadLeads::create([
                        'name' => $data->name,
                        'email' => $data->email,
                        'phone' => $data->phone,
                        'mobile' => $data->mobile,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => $data->number_of_beds,
                        'source' => $data->source,
                        'project' => $data->project,
                        'title' => $data->title,
                        'data_id' => $data->data_id,
                        'previous_state' => '9',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id,
                    ]);
                    Data::where('id', $data->data_id)->update(['data_status' => 6]);
                    $followup_comment->userstatus='Others';
                    $followup_comment->save();
                    $data->delete();
                };
            }else{
                if($followup_comment->updated_at->addDay(5)->format('y-m-d') == Carbon::now()->format('y-m-d')){
                    $data=FollowUpLeads::find($followup_comment->follow_up_id);
                    DeadLeads::create([
                        'name' => $data->name,
                        'email' => $data->email,
                        'phone' => $data->phone,
                        'mobile' => $data->mobile,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => $data->number_of_beds,
                        'source' => $data->source,
                        'project' => $data->project,
                        'title' => $data->title,
                        'data_id' => $data->data_id,
                        'previous_state' => '9',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id,
                    ]);
                    Data::where('id', $data->data_id)->update(['data_status' => 6]);
                    $followup_comment->userstatus='Others';
                    $followup_comment->save();
                    $data->delete();
                };
            }

        }
    }
    public function getcommentsfollowupleads($data_id, $user_id, $stage){
        $data = Comment::where('data_id', $data_id)->where('user_id', $user_id)->where('stage', $stage)->get();
        return Response::json(array('data' => $data));
    }
}
