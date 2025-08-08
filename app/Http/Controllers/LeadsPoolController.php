<?php

namespace App\Http\Controllers;

use App\Mail\leadesemail;
use App\Models\booktable;
use App\Models\Campaign;
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
use App\Models\UserLeadsPool;
use App\Models\UserLeadsPoolComment;
use App\Models\UserProceededLead;
use App\Models\UserQualifiedLeads;
use App\Models\usersleadshistory;
use App\Models\WonLeads;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class LeadsPoolController extends Controller
{
    use SendEmailT;
    public function __construct()
    {
        $this->middleware('auth');
    }

    //////////////////////////// show leads pool index for admin
    public function leadspoolindex()
    {
        $campaignsources  = Campaign::select('name')->get();
        $datasource = booktable::select('source')->groupBy('source')->pluck('source');
        $projects = booktable::select('project')->groupBy('project')->pluck('project');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $templet_name = sendinblue_templates::get();
        $template_whatsapps = sendinbluewhatsapptemplate::get();
        return view('admin.leadspool.leadsbool', ['projects' => $projects, 'campaignsources' => $campaignsources, 'datasource' => $datasource, 'agentnames' => $agentnames, 'templetname' => $templet_name, 'templatewhatsapps' => $template_whatsapps]);
    }

    //////////////////////////// show leads pool for admin
    public function leadspool(Request $request)
    {
        $campaignsource = $request->campaignsource;
        $projects = $request->projects;
        $agentname = $request->agentname;
        $datasource = $request->datasource;
        $commenteddata = UserLeadsPoolComment::select('leads_pool_id')->pluck('leads_pool_id')->toArray();
        $data = booktable::join('users', 'users.id', '=', 'booktables.created_by')->whereNotIn('booktables.id', $commenteddata)->orderBy('created_at','DESC');
        if ($campaignsource != null) {
            $data = $data->where('campaign_name', $campaignsource);
        }
        if ($projects != null) {
            $data = $data->where('project', $projects);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        if ($agentname != null) {
            $data = $data->where('created_by', $agentname);
        }
        $data = $data->select('booktables.*', 'users.name as agentname')->get();

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                if ($row->is_enquiry_customer) {
                    $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                    $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
                    return $actionBtn;
                } else if ($row->created_by == 0) {
                    $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                    return $actionBtn;
                }
            })
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check', 'action'])
            ->make(true);
    }
    public function sendemailtoleadspool(Request $request)
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
        $body = $request->body;
        $templet_id = $request->templet_id;
        $option = $request->option;
        foreach ($id as $key) {
            $data_leads_pool = booktable::find($key);
            if ($data_leads_pool) {
                $details = [
                    'name' => $data_leads_pool->name,
                    'email' => $data_leads_pool->email,
                    'body' => $body
                ];
                $to[] = [
                    'email' => $data_leads_pool->email,
                    'name' => $data_leads_pool->name,
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

    //////////////////////////// show assigned leads pool data index for agent
    public function leadspooluserhomeindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasource = booktable::select('source')->groupBy('source')->get();
        $projects = booktable::select('project')->groupBy('project')->get();
        $userstates = config('app.user_status');
        $templet_name = sendinblue_templates::get();
        $template_whatsapps = sendinbluewhatsapptemplate::get();
        return view('agent.leadspool.leadspooluserhome', ['projects' => $projects, 'agentnames' => $agentnames, 'datasource' => $datasource, 'userstates' => $userstates, 'templetname' => $templet_name, 'templatewhatsapps' => $template_whatsapps]);
    }

    //////////////////////////// show assigned leads pool data for agent
    public function leadspooluserhomedata(Request $request)
    {
        $project = $request->project;
        $datasource = $request->datasource;

        $data = booktable::query();


        $temp0 = Auth::user()->userleadsbooldata()->pluck('leads_pool_id');
        $data = $data->whereIn('booktables.id', $temp0);
        $temp = Auth::user()->userleadspooldatacomment()->pluck('leads_pool_id');
        $data = $data->whereNotIn('booktables.id', $temp);
        $data = $data->join('users', 'users.id', '=', 'booktables.created_by')->join('data', 'data.id', '=', 'booktables.data_id');
        $data = $data->select('booktables.*', 'users.name as agentname')->where('data.data_status', '8')->get();
        if ($project != null) {
            $data = $data->where('project', $project);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        return DataTables::of($data)
            ->addColumn('comments', function ($row) {
                return '<div class="col-md-9"><input type="text" class="form-control w-100" id="comment' . $row->id . '" name=""></div>' .
                    '<div class="row mt-3">' .
                    '<div class="col-md-9 ml-3 mt-1 btn-group btn-group-sm">' .
                    '<button onclick="add_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="btn btn-primary btn-sm mr-2">Add</button>' .
                    '<button  type="button" onclick="add_calender(' . $row->id . ')" class=" calender1 btn btn-primary btn-sm mr-2" >Calenda</button>' .
                    '<button onclick="show_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="show-com btn btn-primary ">Show Comments</button>' .
                    '</div>' .
                    '</div>' .
                    '<div id="calendar-appointment' . $row->id . '" class="mt-3" style="text-align:center;color:red;width:250px"></div>';
            })
            ->addColumn('userstatus', function ($row) {
                return '<div class="row">' .
                    '<div class="col-md-7"><select name="userstatus" class="form-control w-75" id="userstatus' . $row->id . '" onchange="user_status_change_event(' . $row->id . ')">' .
                    '<option selected value="">User status</option>' .
                    '<optgroup label="Dead">'.
                        '<option value="Others">Others</option>'.
                        '<option value="Invalid Number & Email">Invalid Number & Email</option>'.
                        '<option value="Wrong Number & Email">Wrong Number & Email</option>'.
                        '<option value="Number & Email Unavailable">Number & Email Unavailable</option>'.
                        '<option value="Not interested">Not interested</option>'.
                    '</optgroup>'.
                    '<optgroup label="Follow Up">'.
                        '<option value="Interested">Interested</option>'.
                        '<option value="Not Answered">Not Answered</option>'.
                        '<option value="Mobile Switched off">Mobile Switched off</option>'.
                        '<option value="Line Busy">Line Busy</option>'.
                        '<option value="Contacted Via Email">Contacted Via Email</option>'.
                    '</optgroup>'.
                    '<optgroup label="Qualified">'.
                        '<option value="Appointment is set">Appointment is set</option>'.
                    '</optgroup>'.
                    '</select></div>' .
                    '<div class="col-md-2 ml-3 mt-1">' .
                    '<button onclick="btn_click_add_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="btn btn-primary btn-sm">Set</button></div>';
            })
            ->addcolumn('project', function ($row) {
                $project = $row->project;
                if ($project != null) {
                    return $project;
                }
            })
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['comments', 'userstatus', 'check'])
            ->make(true);
    }

    //////////////////////////// show assigned leads pool data index for admin
    public function showassignedagentleadspoolindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasource = booktable::select('source')->groupBy('source')->pluck('source');
        // dd($datasources);
        return view('admin.leadspool.showassignedagentleadspooldata', ['agentnames' => $agentnames, 'datasource' => $datasource]);
    }

    //////////////////////////////unassign agent leads pool data
    public function changeclientleadspooldata(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->toArray(), [
            'user_id_change' => 'required',
        ], [
            'user_id_change.required' => 'please select agent'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
                'success' => false
            ]);
        }
        $wonleads = [];
        $id = array_map('intval', explode(',', $request->data_leadspool_id));
        foreach ($id as $key) {
            $leadspool = booktable::find($key);
            $data = Data::find($leadspool->data_id);
            if ($data->data_status == "7") {
                $qualifieddata = QualifiedLeads::where('data_id', $data->id)->first();
                UserQualifiedLeads::where('qualified_leads_id', $qualifieddata->id)->update(['user_id' => $request->user_id_change]);
                UserLeadsPool::where('leads_pool_id', $key)->update(['user_id' => $request->user_id_change]);
            }
            if ($data->data_status == "10") {
                $proceede = ProceededLead::where('data_id', $key)->first();
                UserProceededLead::where('proceeded_lead_id', $proceede->id)->update(['user_id' => $request->user_id_change]);
                UserLeadsPool::where('leads_pool_id', $key)->update(['user_id' => $request->user_id_change]);
            } elseif ($data->data_status == "6" || $data->data_status == "8") {
                UserLeadsPool::where('leads_pool_id', $key)->update(['user_id' => $request->user_id_change]);
            } elseif ($data->data_status == "9") {
                $followupleads = FollowUpLeads::where('data_id', $data->id)->first();
                UserLeadsPool::where('leads_pool_id', $key)->update(['user_id' => $request->user_id_change]);
                UserFollowUpLeads::where('follow_up_id', $followupleads->id)->update(['user_id' => $request->user_id_change]);
            } else {
                $wonleads[] = $data;
            }
        }
        if (count($wonleads) > 0) {
            return response()->json(['success' => true, 'message' => 'Client connot by changed to some data']);
        } else {
            return response()->json(['success' => true, 'message' => 'Change Client has been successfully']);
        }
    }

    //////////////////////////// show assigned leads pool data for admin
    public function showassignedagentleadspooldata(Request $request)
    {
        $data = booktable::get();

        $datasource = $request->datasource;
        $userid = $request->userid;

        if ($datasource != null) {
            $data = booktable::where('source', $datasource);
        }

        $user = User::find($userid);
        if ($user != null) {
            $temp = $user->leadspooldata()->pluck('leads_pool_id');
            $data = $data->whereIn('id', $temp);
        } else {
            $data = [];
        }

        $users = User::all();
        return DataTables::of($data)
            ->editColumn('created_by', function ($row) use ($users) {
                $user = $users->where('id', $row->created_by)->first();
                if ($user != null)
                    return $user->name;
                else
                    return null;
            })
            ->editColumn('created_at', function ($user) {
                return  date('d-m-Y h-m-s', strtotime($user->created_at));
            })
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check'])
            ->make(true);
    }

    //////////////////////////// return list of unassigned data for leads pool data table for admin
    public function searchforagentleadspooldata(Request $request)
    {
        $data = [];
        $user = User::find($request->userid);
        if ($user) {
            $data = booktable::join('users', 'users.id', '=', 'booktables.created_by')->where('assigned', 0);
            $data = $data->select('booktables.*', 'users.name as agentname')->get();
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

    //////////////////////////// assigne agent to leads pool data index for admin
    public function assignagentleadspoolindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = booktable::select('source')->groupBy('source')->get();
        return view('admin.leadspool.assignagentleadspooldata', ['agentnames' => $agentnames, 'datasources' => $datasources]);
    }

    //////////////////////////// assign agent to leads pool data for admin
    public function assignagentleadspooldata(Request $request)
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
                $userdata[] = new UserLeadsPool([
                    'user_id' => $request->userid,
                    'leads_pool_id' => $item
                ]);
            }
            $user = User::find($request->userid);
            $user->userleadspooldata()->saveMany($userdata);
            // update data status
            $status = booktable::whereIn('id', $data)->update(['assigned' => true]);
            $source = booktable::whereIn('id', $data)->select('source')->groupBy('source')->get();
            $data_soruce = "";
            foreach ($source as $key => $value) {
                if ($key > 0)
                    $data_soruce .= ', ' . $value->source;
                else
                    $data_soruce .= $value->source;
            }

            $details = [
                "agent_name" => $user->name,
                "data_source" => $data_soruce
            ];
            $this->sendEmailNewLead([["email" => $user->email]], $details);

            return response()->json(['success' => true, 'message' => 'Data has been assigned successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error while assign data for user']);
        }
    }

    //////////////////////////// add comments on leads bool data for agent
    public function addleadspoolcomment(Request $request)
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

        $request->validate([
            'comment' => 'required'
        ]);

        try {

            if ($request->appointment_date != null && $request->userstatus == "Appointment is set") {
                // add comment
                UserLeadsPoolComment::create([
                    'leads_pool_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus,
                    'appointment_date' => $request->appointment_date
                ]);

                // change data status to won leads
                $data = booktable::find($request->checkedrow);

                // add data to own leads
                $qualified = QualifiedLeads::create([
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
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true,
                ]);
                $userdata = new UserQualifiedLeads;
                $userdata->user_id = Auth::user()->id;
                $userdata->qualified_leads_id = $qualified->id;
                $userdata->save();

                Comment::create([
                    'user_id' => Auth::user()->id,
                    'data_id' => $data->data_id,
                    'comment' => $request->comment,
                    'appoentment_date' => $request->appointment_date,
                    'stage' => '2'
                ]);
                // $data->delete();
                // change data status to won leads
                Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 7]);
                // }
                //  else if ($request->userstatus == "Paid"){
                //     // add comment
                //     UserLeadsPoolComment::create([
                //         'leads_pool_id' => $request->checkedrow,
                //         'user_id' => Auth::user()->id,
                //         'comment' => $request->comment,
                //         'userstatus' => $request->userstatus,
                //     ]);
                //      // change data status to won leads
                //      $data = booktable::find($request->checkedrow);
                //      WonLeads::create([
                //         'name' => $data->name,
                //         'email' => $data->email,
                //         'phone' => $data->phone,
                //         'mobile' => $data->mobile,
                //         'phone_whatsapp' => $data->phone_whatsup,
                //         'number_of_beds' => $data->number_of_beds,
                //         'source' => $data->source,
                //         'project' => $data->project,
                //         'title' => $data->title,
                //         'data_id' => $data->data_id,
                //         'previous_state' => '8',
                //         'previous_state_id' => $request->checkedrow,
                //         'created_by' => Auth::user()->id
                //     ]);
                //     // change data status to dead leads
                //     Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 5]);
            } else if ($request->userstatus == "Not interested" || $request->userstatus == "Number & Email Unavailable" || $request->userstatus == "Wrong Number & Email" || $request->userstatus == "Invalid Number & Email" || $request->userstatus == "Others") {
                // add comment
                UserLeadsPoolComment::create([
                    'leads_pool_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);
                // add data to own leads
                $data = booktable::find($request->checkedrow);
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
                    'previous_state' => '8',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);

                // $data->delete();
                // change data status to dead leads
                Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 6]);
            } else {
                // add comment
                UserLeadsPoolComment::create([
                    'user_id' => Auth::user()->id,
                    'leads_pool_id' => $request->checkedrow,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);

                // change data status to leads pool
                $data = booktable::find($request->checkedrow);

                // add data to follow up leads
                $followup = FollowUpLeads::create([
                    'name' => $data->name,
                    'email' => $data->email,
                    'phone' => $data->phone,
                    'mobile' => $data->mobile,
                    'phone_whatsapp' => $data->phone_whatsup,
                    'number_of_beds' => $data->number_of_beds,
                    'source' => $data->source,
                    'project' => $data->project,
                    'data_id' => $data->data_id,
                    'title' => $data->title,
                    'data_id' => $data->data_id,
                    'previous_state' => '8',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true,
                ]);
                $userdata = new UserFollowUpLeads;
                $userdata->user_id = Auth::user()->id;
                $userdata->follow_up_id = $followup->id;
                $userdata->save();
                // $data->delete();
                // change data status to follow up leads
                Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 9]);
                // $data->delete();
            }

            return response()->json(['success' => true, 'message' => 'Comment entered successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error happen call system admin']);
        }
    }

    //////////////////////////// show comments on leads pool data index for admin
    public function showuserleadspooldatacommentsindex()
    {
        $userstatus = config('app.user_status');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = booktable::select('source')->groupBy('source')->get();
        return view('admin.leadspool.showuserleadspooldatacomment', ['userstatus' => $userstatus, 'datasources' => $datasources, 'agentnames' => $agentnames]);
    }

    //////////////////////////// show comments on leads pool data index for agent
    public function showleadspooldatacommentsindex()
    {
        $userstatus = config('app.user_status');
        $datasources = booktable::select('source')->groupBy('source')->get();
        return view('agent.leadspool.showleadspooldatacomment', ['userstatus' => $userstatus, 'datasources' => $datasources]);
    }

    //////////////////////////// show comments on leads pool data for agent and admin
    public function showleadspooldatacomments(Request $request)
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

        $data = UserLeadsPool::join('user_leads_pool_comments', function ($join) {
            $join->on('user_leads_pools.leads_pool_id', '=', 'user_leads_pool_comments.leads_pool_id')
                ->on('user_leads_pools.user_id', '=', 'user_leads_pool_comments.user_id');
        })
            ->join('booktables', 'booktables.id', '=', 'user_leads_pools.leads_pool_id')
            ->join('users', 'users.id', '=', 'user_leads_pool_comments.user_id')
            ->select(
                'booktables.*',
                'booktables.phone',
                'booktables.data_id',
                'booktables.email',
                'booktables.name',
                'booktables.project',
                'booktables.mobile',
                'booktables.source',
                'user_leads_pools.leads_pool_id',
                'user_leads_pools.user_id',
                'users.name as agentname',
                'user_leads_pool_comments.userstatus',
                'user_leads_pool_comments.comment as comment',
                'user_leads_pool_comments.appointment_date',
                'user_leads_pool_comments.created_at'
            )->where('user_leads_pool_comments.user_id', $userid);

        /////////////////////// agent filter
        if ($userid != null) {
            $data = $data->where('user_leads_pool_comments.user_id', $userid);
        }

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_leads_pool_comments.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_leads_pool_comments.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_leads_pool_comments.created_at', '=', $searchdaytext);

        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_leads_pool_comments.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('booktables.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('booktables.project', $project);

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('comments', function ($row) {
                $comment = null;
                if ($row->userstatus == "Interested") {
                    $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <p> <b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                } else if ($row->userstatus == "Not interested")
                    $comment = '<div class="row ml-1" style="background-color:#00ff95"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div> ';
                else if ($row->userstatus == "Not answer") {
                    $comment = '<div class="row ml-1" style="background-color:#bab2e1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                } else if ($row->userstatus == "Number unavailable/Not working for call/Incomplete no") {
                    $comment = '<div class="row ml-1" style="background-color:#ffc55c"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                } else if ($row->userstatus == "Switch off/Line busy/Wrong number/Invalid number") {
                    $comment = '<div class="row ml-1" style="background-color:#AED6F1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                } else if ($row->userstatus == "Others") {
                    $comment = '<div class="row ml-1" style="background-color:#DAF7A6"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                } else if ($row->userstatus == "Set appointment")
                    $comment = '<div class="row ml-1" style="background-color:#F9C4F8"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> <p><b>Appointment date: </b> ' . $row->appointment_date . '</p> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else
                    $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                return $comment;
            })
            ->addColumn('action', function ($row) {
                $followUpLeads = FollowUpLeads::where('data_id', $row->data_id)->where('previous_state_id', $row->leads_pool_id)->where('created_by', $row->user_id)->first();
                $qualifiedLeads = QualifiedLeads::where('data_id', $row->data_id)->where('previous_state_id', $row->leads_pool_id)->where('created_by', $row->user_id)->first();
                if ($followUpLeads) {
                    if ($followUpLeads->assigned == '1') {
                        $actionBtn = '<button onclick="show_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    } else {
                        $actionBtn = '<button onclick="show_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    }
                } else if ($qualifiedLeads) {
                    if ($qualifiedLeads->assigned == '1') {
                        $actionBtn = '<button onclick="show_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    } else {
                        $actionBtn = '<button onclick="show_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    }
                } else {
                    $actionBtn = '<button onclick="show_comment(' . $row->id . ')" type="button" id="' . $row->id . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                }
                return $actionBtn;
            })
            ->rawColumns(['comments', 'action'])
            ->make(true);
    }

    //////////////////////////// show comments info on leads pool data for agent and admin
    public function getadminleadspooldatacommentsinfo(Request $request)
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
        $setappointment = 0;
        $lineBusy = 0;
        $nuanemun = 0;
        $others = 0;
        $interested = 0;
        $notinterested = 0;
        $notanswer = 0;
        $wrnuanem = 0;
        $innuanem = 0;
        $caafap = 0;
        $paid = 0;
        $moswof = 0;
        $coviem = 0;
        $total = 0;
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
            // $sdate = $sdate->toDateString();
            $edate = $edate->addDay();
        }

        // specific date filteration
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        $data = UserLeadsPool::join('user_leads_pool_comments', function ($join) {
            $join->on('user_leads_pools.leads_pool_id', '=', 'user_leads_pool_comments.leads_pool_id')
                ->on('user_leads_pools.user_id', '=', 'user_leads_pool_comments.user_id');
        })
            ->join('booktables', 'booktables.id', '=', 'user_leads_pools.leads_pool_id')
            ->join('users', 'users.id', '=', 'user_leads_pool_comments.user_id')
            ->select(
                'booktables.*',
                'booktables.phone',
                'booktables.email',
                'booktables.name',
                'booktables.project',
                // 'booktables.MOBILE',
                'booktables.source',
                'user_leads_pools.leads_pool_id',
                'user_leads_pools.user_id',
                'users.name as agentname',
                'user_leads_pool_comments.userstatus',
                'user_leads_pool_comments.comment as comment',
                'user_leads_pool_comments.appointment_date',
                'user_leads_pool_comments.created_at'
            )->where('user_leads_pool_comments.user_id', $userid);

        /////////////////////// agent filter
        if ($userid != null) {
            $data = $data->where('user_leads_pool_comments.user_id', $userid);
        }

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_leads_pool_comments.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_leads_pool_comments.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_leads_pool_comments.created_at', '=', $searchdaytext);

        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_leads_pool_comments.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('booktables.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('booktables.project', $project);

        $data = $data->get();

        $setappointment = $data->where('userstatus', 'Appointment is set')->count();
        $lineBusy = $data->where('userstatus', 'Line Busy')->count();
        $nuanemun = $data->where('userstatus', 'Number & Email Unavailable')->count();
        $others = $data->where('userstatus', 'Others')->count();
        $interested = $data->where('userstatus', 'Interested')->count();
        $notinterested = $data->where('userstatus', 'Not interested')->count();
        $notanswer = $data->where('userstatus', 'Not Answered')->count();
        $wrnuanem = $data->where('userstatus', 'Wrong Number & Email')->count();
        $innuanem = $data->where('userstatus', 'Invalid Number & Email')->count();
        $moswof = $data->where('userstatus', 'Mobile Switched off')->count();
        $coviem = $data->where('userstatus', 'Contacted Via Email')->count();

        $total = $setappointment + $lineBusy + $nuanemun + $others + $interested + $notinterested + $notanswer + $wrnuanem + $innuanem + $caafap + $paid + $moswof + $coviem;
        $TotalAssigned = count(UserLeadsPool::where('user_id', $userid)->get());
        return response()->json([
            'succssess' => true,
            'setappointment' => $setappointment,
            'lineBusy' => $lineBusy,
            'nuanemun' => $nuanemun,
            'others' => $others,
            'interested' => $interested,
            'notinterested' => $notinterested,
            'notanswer' => $notanswer,
            'wrnuanem' => $wrnuanem,
            'innuanem' => $innuanem,
            'moswof' => $moswof,
            'coviem' => $coviem,
            'total' => $total,
            'TotalAssigned' => $TotalAssigned
        ]);
    }
    public function updatecommentlesadsbooldata(Request $request)
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
        UserLeadsPoolComment::where('leads_pool_id', $request->leadspool_id)->where('user_id', $userid)->update([
            'comment' => $request->comment,
            'userstatus' => $request->status,
            'appointment_date' => ($request->appartment != null) ? $request->appartment : NULL
        ]);

        $data = booktable::find($request->leadspool_id);
        $wondata = WonLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->leadspool_id)->where('created_by', $userid)->first();
        $dedleds = DeadLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->leadspool_id)->where('created_by', $userid)->first();
        $followUpLeads = FollowUpLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->leadspool_id)->where('created_by', $userid)->first();
        $qualifiedLeads = QualifiedLeads::where('data_id', $request->data_id)->where('previous_state_id', $request->leadspool_id)->where('created_by', $userid)->first();
        if ($wondata) {
            $wondata->delete();
        }
        if ($dedleds) {
            $dedleds->delete();
        }
        if ($followUpLeads) {
            $followUpLeads->delete();
        }
        if ($qualifiedLeads) {
            $qualifiedLeads->delete();
        }
        if ($request->appartment != null && $request->status == "Appointment is set") {
            QualifiedLeads::create([
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
                'previous_state_id' => $request->leadspool_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 7]);
            return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
        } else if ($request->status == "Paid") {
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
                'previous_state_id' => $request->leadspool_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 5]);
            return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
        } else if ($request->userstatus == "Not interested" || $request->userstatus == "Number & Email Unavailable" || $request->userstatus == "Wrong Number & Email" || $request->userstatus == "Invalid Number & Email" || $request->userstatus == "Cancelation after appointment" || $request->userstatus == "Others") {
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
                'previous_state' => '8',
                'previous_state_id' => $request->leadspool_id,
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
                'data_id' => $data->data_id,
                'title' => $data->title,
                'previous_state' => '8',
                'previous_state_id' => $request->leadspool_id,
                'created_by' => $userid
            ]);
            Data::where('id', $data->data_id)->update(['data_status' => 9]);
            return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
        }
    }
    // public function sendsmstoleadspool(Request $request){
    //     $id = array_map('intval', explode(',', $request->id));
    //     $to = [];
    //     $body = $request->body;
    //     $templet_id = $request->templet_id;
    //     $option = $request->option;// body or templet
    //     foreach ($id as $key) {
    //         $data = booktable::find($key);
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
    public function getcommentsleadspool($data_id)
    {
        $data_id_comment = booktable::find($data_id);
        $comment = Comment::where('user_id', Auth::user()->id)->where('data_id', $data_id_comment->data_id)->where('stage', '2')->get();
        return response()->json([
            'data' => $comment
        ]);
    }
    public function getcommentsleadspooladmin($data_id, $agentname)
    {
        $data_id_comment = booktable::find($data_id);
        $comment = Comment::where('user_id', $agentname)->where('data_id', $data_id_comment->data_id)->where('stage', '2')->get();
        return response()->json([
            'data' => $comment
        ]);
    }
    public function addcommentmoreleadspool(Request $request)
    {
        $data_id_comment = booktable::find($request->data_id);
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'data_id' => $data_id_comment->data_id,
            'comment' => $request->comment,
            'appoentment_date' => $request->appoentment_date,
            'stage' => "2"
        ]);
        if ($comment) {
            return response()->json([
                'status' => true,
                'message' => 'Comment added successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Error in add Comment'
            ]);
        }
    }
}
