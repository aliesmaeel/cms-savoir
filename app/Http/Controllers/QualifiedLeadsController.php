<?php

namespace App\Http\Controllers;

use App\Mail\agentappointment;
use App\Mail\leadesemail;
use App\Models\booktable;
use App\Models\Comment;
use App\Models\Data;
use App\Models\DeadLeads;
use App\Models\FollowUpLeads;
use App\Models\ProceededLead;
use App\Models\QualifiedLeads;
use App\Models\sendinblue_templates;
use App\Models\sendinbluewhatsapptemplate;
use App\Models\User;
use App\Models\UserDataComment;
use App\Models\UserFollowUpLeads;
use App\Models\UserLeadsPoolComment;
use App\Models\UserProceededLead;
use App\Models\UserQualifiedLeads;
use App\Models\UserQualifiedLeadsComment;
use App\Models\WonLeads;
use Carbon\Carbon;
use Exception;
use Response;
use PHPUnit\Util\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Return_;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class QualifiedLeadsController extends Controller
{
    use SendEmailT;
    public function __construct()
    {
        $this->middleware('auth');
    }

    //////////////////////////// show qualified leads index for admin
    public function qualifiedleadsindex()
    {
        $projects = QualifiedLeads::select('project')->groupBy('project')->pluck('project');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = QualifiedLeads::select('source')->groupby('source')->get();
        $templet_name = sendinblue_templates::get();
        $template_whatsapps=sendinbluewhatsapptemplate::get();
        return view('admin.qualified.qualifiedleads', ['projects' => $projects, 'agentnames' => $agentnames, 'datasources' => $datasources, 'templetname' => $templet_name,'templatewhatsapps'=>$template_whatsapps]);
    }

    //////////////////////////// show qualified leads for admin
    public function qualifiedleads(Request $request)
    {
        $agentname = $request->agentname;
        $datasource = $request->datasource;
        $projects = $request->projects;
        $commenteddata = UserQualifiedLeadsComment::select('qualified_leads_id')->pluck('qualified_leads_id')->toArray();
        $data = QualifiedLeads::join('users', 'users.id', '=', 'qualified_leads.created_by')->whereNotIn('qualified_leads.id', $commenteddata)->orderBy('created_at','DESC');
        if ($agentname != null) {
            $data = $data->where('created_by', $agentname);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        if ($projects != null) {
            $data = $data->where('project', $projects);
        }
        $data = $data->select('qualified_leads.*', 'users.name as agentname')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check', 'action'])
            ->make(true);
    }
    public function sendemailtoqualifiedleads(Request $request)
    {
        // return $request->all();
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
        $body = $request->body;
        $option = $request->option;
        $templet_id = $request->templet_id;
        foreach ($id as $key) {
            $data_qualified_leads = QualifiedLeads::find($key);
            if ($data_qualified_leads) {
                $details = [
                    'name' => $data_qualified_leads->name,
                    'email' => $data_qualified_leads->email,
                    'body' => $body
                ];
                $to[] = [
                    'email' => $data_qualified_leads->email,
                    'name' => $data_qualified_leads->name,
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

    //////////////////////////// return list of unassigned data for qualified leads data table for admin
    public function searchforagentqualifieddata(Request $request)
    {
        $data = [];
        $user = User::find($request->userid);
        if ($user) {
            $data = QualifiedLeads::join('users', 'users.id', '=', 'qualified_leads.created_by')->where('assigned', 0);
            $data = $data->select('qualified_leads.*', 'users.name as agentname')->get();
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

    //////////////////////////// show assigned qualified data index for agent
    public function qualifieduserhomeindex()
    {
        $projects = QualifiedLeads::select('project')->groupBy('project')->get();
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasource = QualifiedLeads::select('source')->groupBy('source')->get();
        $userstates = config('app.user_status');
        $templet_name = sendinblue_templates::get();
        $template_whatsapps=sendinbluewhatsapptemplate::get();
        return view('agent.qualified.qualifieduserhome', ['projects' => $projects, 'agentnames' => $agentnames, 'datasource' => $datasource, 'userstates' => $userstates,'templetname'=>$templet_name,'templatewhatsapps'=>$template_whatsapps]);
    }

    //////////////////////////// show assigned qualified data for agent
    public function qualifieduserhomedata(Request $request)
    {
        $project = $request->project;
        $datasource = $request->datasource;

        $data = QualifiedLeads::query();
        if ($project != null) {
            $data = QualifiedLeads::where('project', $project);
        }
        if ($datasource != null) {
            $data = QualifiedLeads::where('source', $datasource);
        }

        $temp0 = Auth::user()->userqualifieddata()->pluck('qualified_leads_id');
        $data = $data->whereIn('qualified_leads.id', $temp0);
        $temp = Auth::user()->userqualifieddatacomment()->pluck('qualified_leads_id');
        $data = $data->whereNotIn('qualified_leads.id', $temp);
        $data = $data->join('users', 'users.id', '=', 'qualified_leads.created_by');
        $data = $data->select('qualified_leads.*', 'users.name as agentname');
        return DataTables::of($data)
            ->addColumn('comments', function ($row) {
                return '<div class="col-md-12"><input type="text" class="form-control w-75" id="comment' . $row->id . '" name=""></div>' .
                '<div class="row">' .
                '<div class="col-md-3 ml-1 mt-1 btn-group btn-group-sm"><button onclick="btnaddcomment(' . $row->id . ')" type="button" id="' . $row->data_id . '" class="btn btn-primary btn-sm mr-2">Add</button><button data-id="' . $row->id . '" type="button"  class="calender1 btn btn-danger btn-sm mr-2">Calendar</button>' .
                '<button onclick="show_comments(' . $row->data_id . ')" type="button" id="showcomments' . $row->data_id . '" class=" show-com btn btn-warning btn-sm">Show Comments</button></div>' .
                '</div>' .
                '<div id="calendar-date' . $row->id . '" style="text-align:center;color:red;width:250px"></div>';
        })
            ->addColumn('userstatus', function ($row) {
                return '<div class="row">' .
                    '<div class="col-md-7">'.
                    '<select name="userstatus" class="form-control w-100" id="userstatus' . $row->id . '" onchange="user_status_change_event(' . $row->id . ')">' .
                    '<option selected value="">User status</option>' .
                    '<optgroup label="Proceeded">'.
                        '<option value="Appointment is Suceeded">Appointment is Suceeded</option>'.
                    '</optgroup>'.
                    '<optgroup label="Follow Up">'.
                        '<option value="Cancelation After Appointment">Cancelation After Appointment</option>'.
                        '<option value="Appointment is Faild">Appointment is Faild </option>'.
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

    //////////////////// assign agent to qualified data index for admin
    public function assignagentqualifieddataindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = QualifiedLeads::select('source')->groupBy('source')->get();
        return view('admin.qualified.assignagentqualifieddata', ['agentnames' => $agentnames, 'datasources' => $datasources]);
    }

    //////////////////// assign agent to qualified data for admin
    public function assignagentqualifieddata(Request $request)
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
                $userdata[] = new UserQualifiedLeads([
                    'user_id' => $request->userid,
                    'qualified_leads_id' => $item
                ]);
            }
            $user = User::find($request->userid);
            $user->userqualifieddata()->saveMany($userdata);
            // update data status
            $status = QualifiedLeads::whereIn('id', $data)->update(['assigned' => true]);
            return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
        } catch (Exception $ex) {
            return response()->json(['success' => false, 'message' => 'Error while assign data for user']);
        }
    }

    //////////////////// unassign agent from qualified data for admin
    public function unassignagentqualifieddata(Request $request)
    {
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

            $comments = UserQualifiedLeadsComment::join('user_qualified_leads', function ($join) {
                $join->on('user_qualified_leads_comments.qualified_leads_id', '=', 'user_qualified_leads.qualified_leads_id')
                    ->on('user_qualified_leads_comments.user_id', '=', 'user_qualified_leads.user_id');
            })->where('user_qualified_leads_comments.user_id', $request->userid)->pluck('user_qualified_leads_comments.qualified_leads_id')->toArray();

            foreach ($data as $key => $item) {
                if (in_array($item, $comments)) {
                    unset($data[$key]);
                }
            }
            if ($data != null) {
                UserQualifiedLeads::where('user_id', $request->userid)->whereIn('qualified_leads_id', $data)->delete();
                Data::whereIn('id', $data)->update(['assigned' => false]);
                return response()->json(['success' => true, 'message' => 'User data has been unassigned successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Unable to unassign this data']);
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error while unassign data for user']);
        }
    }

    //////////////////// add comment on qualified data for agent
    public function addqualifiedcomment(Request $request)
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
        //10 proceeded lead

        $request->validate([
            'comment' => 'required'
        ]);

        try {
            if ($request->userstatus == "Appointment is Suceeded") {
                // add comment
                UserQualifiedLeadsComment::create([
                    'qualified_leads_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus,
                ]);
                $data_QualifiedLeads = QualifiedLeads::find($request->checkedrow);
                // $data=Data::where('id', $data_QualifiedLeads->data_id)->first();
                // $data->previous_status = $data->data_status;
                // $data->data_status = 5;
                // $data->save();
                $proceeded = ProceededLead::create([
                    'name' => $data_QualifiedLeads->name,
                    'email' => $data_QualifiedLeads->email,
                    'phone' => $data_QualifiedLeads->phone,
                    'mobile' => $data_QualifiedLeads->mobile,
                    'phone_whatsapp' => $data_QualifiedLeads->phone_whatsup,
                    'number_of_beds' => $data_QualifiedLeads->number_of_beds,
                    'source' => $data_QualifiedLeads->source,
                    'project' => $data_QualifiedLeads->project,
                    'title' => $data_QualifiedLeads->title,
                    'data_id' => $data_QualifiedLeads->data_id,
                    'previous_state' => '7',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true,
                ]);
                $userdata = new UserProceededLead;
                $userdata->user_id = Auth::user()->id;
                $userdata->proceeded_lead_id = $proceeded->id;
                $userdata->save();
                // $data->delete();
                // change data status to dead leads
                Data::where('id', $data_QualifiedLeads->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 10]);
            }
            else {
                // add comment
                UserQualifiedLeadsComment::create([
                    'qualified_leads_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);
                // add data to own leads
                $data = QualifiedLeads::find($request->checkedrow);
                $followup = FollowUpLeads::create([
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
                    'previous_state' => '7',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true,
                ]);
                $userdata = new UserFollowUpLeads;
                $userdata->user_id = Auth::user()->id;
                $userdata->follow_up_id = $followup->id;
                $userdata->save();
                // $data->delete();
                // change data status to dead leads
                Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 9]);
            }

            return response()->json(['success' => true, 'message' => 'Comment entered successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error happen call system admin']);
        }
    }

    //////////////////////////// show comments on qualified data index for admin
    public function showuserqualifieddatacommentsindex()
    {
        $userstatus = config('app.qualified_user_status');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = QualifiedLeads::select('source')->groupBy('source')->get();
        return view('admin.qualified.showusercommentedqualifieddata', ['userstatus' => $userstatus, 'datasources' => $datasources, 'agentnames' => $agentnames]);
    }

    //////////////////////////// show comemnts on qualified data index for agent
    public function showqualifieddatacommentsindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $userstatus = config('app.qualified_user_status');
        $datasources = QualifiedLeads::select('source')->groupBy('source')->get();
        return view('agent.qualified.showqualifieddatacomment', ['agentnames' => $agentnames, 'userstatus' => $userstatus, 'datasources' => $datasources]);
    }

    //////////////////////////// show comemnts on qualified data for agent and admin
    public function showqualifieddatacomments(Request $request)
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

        $data = UserQualifiedLeads::join('user_qualified_leads_comments', function ($join) {
            $join->on('user_qualified_leads.qualified_leads_id', '=', 'user_qualified_leads_comments.qualified_leads_id')
                ->on('user_qualified_leads.user_id', '=', 'user_qualified_leads_comments.user_id');
        })
            ->join('qualified_leads', 'qualified_leads.id', '=', 'user_qualified_leads.qualified_leads_id')
            ->join('users', 'users.id', '=', 'user_qualified_leads_comments.user_id')
            ->select(
                'qualified_leads.*',
                'qualified_leads.phone',
                'qualified_leads.email',
                'qualified_leads.name',
                'qualified_leads.project',
                'qualified_leads.data_id',
                'qualified_leads.source',
                'user_qualified_leads.qualified_leads_id',
                'user_qualified_leads.user_id',
                'users.name as agentname',
                'user_qualified_leads_comments.userstatus',
                'user_qualified_leads_comments.comment as comment',
                'user_qualified_leads_comments.appointment_date',
                'user_qualified_leads_comments.created_at'
            )->where('user_qualified_leads_comments.user_id', $userid);

        /////////////////////// agent filter
        if ($userid != null) {
            $data = $data->where('user_qualified_leads_comments.user_id', $userid);
        }

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_qualified_leads_comments.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_qualified_leads_comments.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_qualified_leads_comments.created_at', '=', $searchdaytext);


        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_qualified_leads_comments.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('qualified_leads.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('qualified_leads.project', $project);

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('comments', function ($row) {
                $comment = null;
                if ($row->userstatus == "Appointment is Suceeded") {
                    $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <p> <b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                } else if ($row->userstatus == "Appointment is Faild"){
                    $comment = '<div class="row ml-1" style="background-color:#00ff95"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                }else{
                    $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                }
                return $comment;
            })
            ->addColumn('action', function ($row) {
                $followUpLeads = FollowUpLeads::where('data_id', $row->data_id)->where('previous_state_id', $row->qualified_leads_id)->where('created_by', $row->user_id)->first();
                if ($followUpLeads) {
                    if ($followUpLeads->assigned == '1') {
                        $actionBtn = '<button onclick="show_comments(' . $row->data_id . ')" type="button" id="' . $row->data_id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    } else {
                        $actionBtn = '<button onclick="show_comments(' . $row->data_id . ')" type="button" id="' . $row->data_id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    }
                } else {
                    $actionBtn = '<button onclick="show_comments(' . $row->data_id . ')" type="button" id="' . $row->data_id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                }

                return $actionBtn;
            })
            ->rawColumns(['comments', 'action'])
            ->make(true);
    }

    //////////////////// show comments info on qualified leads for admin and agent
    public function getadminqualifieddatacommentsinfo(Request $request)
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
        $appissucceed = 0;
        $appisfailed = 0;
        $total =0;
        $TotalAssigned = 0;

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

            $edate->addDay();
        }

        // specific date filteration
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        $data = UserQualifiedLeads::join('user_qualified_leads_comments', function ($join) {
            $join->on('user_qualified_leads.qualified_leads_id', '=', 'user_qualified_leads_comments.qualified_leads_id')
                ->on('user_qualified_leads.user_id', '=', 'user_qualified_leads_comments.user_id');
        })
            ->join('qualified_leads', 'qualified_leads.id', '=', 'user_qualified_leads.qualified_leads_id')
            ->join('users', 'users.id', '=', 'user_qualified_leads_comments.user_id')
            ->select(
                'qualified_leads.*',
                'qualified_leads.phone',
                'qualified_leads.email',
                'qualified_leads.name',
                'qualified_leads.project',
                // 'qualified_leads.MOBILE',
                'qualified_leads.source',
                'user_qualified_leads.qualified_leads_id',
                'user_qualified_leads.user_id',
                'users.name as agentname',
                'user_qualified_leads_comments.userstatus',
                'user_qualified_leads_comments.comment as comment',
                'user_qualified_leads_comments.appointment_date',
                'user_qualified_leads_comments.created_at'
            )
            ->where('user_qualified_leads_comments.user_id', $userid);

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_qualified_leads_comments.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_qualified_leads_comments.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_qualified_leads_comments.created_at', '=', $searchdaytext);

        /////////////////////// agent filter
        if ($userid != null)
            $data = $data->where('user_qualified_leads_comments.user_id', $userid);

        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_qualified_leads_comments.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('qualified_leads.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('qualified_leads.project', $project);

        $data = $data->get();
        $appissucceed =  $data->where('userstatus', 'Appointment is Suceeded')->count();
        $appisfailed = $data->where('userstatus', 'Appointment is Faild')->count();
        $caafap=$data->where('userstatus', 'Cancelation after appointment')->count();
        $total = $appissucceed + $appisfailed+$caafap;
        $TotalAssigned = count(UserQualifiedLeads::where('user_id', $userid)->get());
        return response()->json([
            'succssess' => true,
            'appissucceed' => $appissucceed,
            'appisfailed' => $appisfailed,
            'total' => $total,
            'TotalAssigned' => $TotalAssigned,
            'caafap'=>$caafap,

        ]);
    }

    //////////////////// show assigned agent for qualified data index for admin
    public function showassignedagentqualifiedindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = QualifiedLeads::select('source')->groupBy('source')->pluck('source');
        return view('admin.qualified.showassignedagentqualifieddata', ['agentnames' => $agentnames, 'datasources' => $datasources]);
    }

    //////////////////// show assigned agent for qualified data for admin
    public function showassignedagentqualifieddata(Request $request)
    {
        $datasource = $request->datasource;
        $userdata = UserQualifiedLeads::where('user_id', $request->userid)->pluck('qualified_leads_id');
        $data = QualifiedLeads::join('users', 'users.id', '=', 'qualified_leads.created_by')->whereIn('qualified_leads.id', $userdata)->orderBy('created_at', 'DESC');
        if ($request->datasource != null)
            $data = $data->where('qualified_leads.source', $datasource);
        $data = $data->select('qualified_leads.*', 'users.name as agentname');
        return DataTables::of($data)
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check'])
            ->make(true);
    }
    public function updatecommentquilifydata(Request $request)
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
        UserQualifiedLeadsComment::where('qualified_leads_id', $request->qualified_id)->where('user_id', $userid)->update([
            'comment' => $request->comment,
            'userstatus' => $request->status,
            'appointment_date' => ($request->appartment != null) ? $request->appartment : NULL
        ]);
        $data = QualifiedLeads::find($request->qualified_id);
        $wondata = WonLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->qualified_id)->where('created_by', $userid)->first();
        $dedleds = DeadLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->qualified_id)->where('created_by', $userid)->first();
        $followUpLeads = FollowUpLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->qualified_id)->where('created_by', $userid)->first();
        if ($wondata) {
            $wondata->delete();
        }
        if ($dedleds) {
            $dedleds->delete();
        }
        if ($followUpLeads) {
            $followUpLeads->delete();
        }
        if ($request->status == "Paid") {
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
                'previous_state' => '7',
                'previous_state_id' => $request->qualified_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 5]);
            return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
        } else if ($request->status == "Not interested" || $request->status == "Number And Email Unavailable" || $request->status == "Wrong Number And Email" || $request->status == "Invalid Number And Email" || $request->status == "Cancelation after appointment" || $request->status == "Others") {
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
                'previous_state' => '7',
                'previous_state_id' => $request->qualified_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 6]);
            return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
        } else {
            FollowUpLeads::create([
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
                'previous_state' => '7',
                'previous_state_id' => $request->qualified_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 9]);
            return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
        }
    }
    // public function sendsmstoQualifiy(Request $request){
    //     $id = array_map('intval', explode(',', $request->id));
    //     $to = [];
    //     $body = $request->body;
    //     $templet_id = $request->templet_id;
    //     $option = $request->option;// body or templet
    //     foreach ($id as $key) {
    //         $data = QualifiedLeads::find($key);
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
    public function commentQualifiedleds(Request $request){
        $data_id = QualifiedLeads::find($request->data_id);
        // dd($data_id->data_id);
        $comment=Comment::create([
            'user_id'=>Auth::user()->id,
            'data_id'=>$data_id->data_id,
            'comment'=>$request->comment,
            'stage'=>'3',
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
    public function showcommentsqualifiedleads($data_id, $user_id, $stage)
    {
        $data = Comment::where('data_id', $data_id)->where('user_id', $user_id)->where('stage', $stage)->get();
        return Response::json(array('data' => $data));
    }

    public function getcommentsqualifiedadmin($data_id ,$agentname){
        $comment=Comment::where('user_id',$agentname)->where('data_id',$data_id)->where('stage','3')->get();
        return response()->json([
            'data'=>$comment
        ]);
    }
    public function sendemailtoagentbeforetheappointment(){
        $leadspoolcomment=UserLeadsPoolComment::where('userstatus','Set appointment')->where('appointment_date','!=',null)->get()->toArray();
        $datacomment=UserDataComment::where('userstatus','Set appointment')->where('appointment_date','!=',null)->get()->toArray();
        $appointments = array_merge($leadspoolcomment,$datacomment);
       foreach($appointments as $appointment){
            $user=User::find($appointment['user_id']);
            if(Carbon::parse($appointment['appointment_date'])->subHour(2)->format('d-m-y H') == Carbon::now()->format('d-m-y H')){
                Mail::to($user->email)->send(new agentappointment());
            }
       }
    }
}
