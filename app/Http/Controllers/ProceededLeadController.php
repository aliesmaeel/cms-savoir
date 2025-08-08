<?php

namespace App\Http\Controllers;

use App\Models\booktable;
use App\Models\Comment;
use App\Models\Data;
use App\Models\DeadLeads;
use App\Models\FollowUpLeads;
use App\Models\ProceededLead;
use App\Models\QualifiedLeads;
use App\Models\sendinblue_templates;
use App\Models\sendinbluewhatsapptemplate;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Response;
use Carbon\Carbon;
use PHPUnit\Util\Json;
use App\Models\User;
use App\Models\UserDataComment;
use App\Models\UserFollowUpLeads;
use App\Models\UserProceededLead;
use App\Models\UserProceededLeadComment;
use App\Models\UserQualifiedLeadsComment;
use App\Models\WonLeads;
use Illuminate\Http\Request;

class ProceededLeadController extends Controller
{
    use SendEmailT;

    public function proceededuserhomeindex()
    {
        $projects = ProceededLead::select('project')->groupBy('project')->get();
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasource = ProceededLead::select('source')->groupBy('source')->get();
        $userstates = config('app.proceeded_user_status');
        $templet_name = sendinblue_templates::get();
        $template_whatsapps=sendinbluewhatsapptemplate::get();
        return view('agent.proceeded.proceededuserhome', ['projects' => $projects, 'agentnames' => $agentnames, 'datasource' => $datasource, 'userstates' => $userstates,'templetname'=>$templet_name,'templatewhatsapps'=>$template_whatsapps]);
    }

    public function showproceededdatacommentsindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $userstatus = config('app.proceeded_user_status');
        $datasources = ProceededLead::select('source')->groupBy('source')->get();
        return view('agent.proceeded.showproceededdatacomment', ['agentnames' => $agentnames, 'userstatus' => $userstatus, 'datasources' => $datasources]);
    }

    public function proceededuserhomedata(Request $request)
    {
        // dd($request->all());
        $project = $request->project;
        $datasource = $request->datasource;



        $data = ProceededLead::query();
        if ($project != null) {
            $data = ProceededLead::where('project', $project);
        }
        if ($datasource != null) {
            $data = ProceededLead::where('source', $datasource);
        }

        $temp0 = Auth::user()->userproceededdata()->pluck('proceeded_lead_id');
        $data = $data->whereIn('proceeded_lead.id', $temp0);
        $temp = Auth::user()->userproceededdatacomment()->pluck('proceeded_lead_id');
        $data = $data->whereNotIn('proceeded_lead.id', $temp);
        $data = $data->join('users', 'users.id', '=', 'proceeded_lead.created_by');
        $data = $data->select('proceeded_lead.*', 'users.name as agentname');
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
                    '<optgroup label="Won">'.
                        '<option value="Paid">Paid</option>'.
                    '</optgroup>'.
                    '<optgroup label="Follow Up">'.
                        '<option value="Canceled">Canceled </option>'.
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

    public function addproceededcomment(Request $request)
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
            if ($request->userstatus == "Paid") {
                // add comment
                UserProceededLeadComment::create([
                    'proceeded_lead_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus,
                ]);

                // change data status to won leads
                $data = ProceededLead::find($request->checkedrow);

                // add data to own leads
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
                    'previous_state' => '10',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);
                // $data->delete();
                // change data status to dead leads
                Data::where('id', $data->data_id)->update(['previous_status' => DB::raw('data_status'), 'data_status' => 5]);
            } else {
                // add comment
                UserProceededLeadComment::create([
                    'proceeded_lead_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);
                // add data to own leads
                $data = ProceededLead::find($request->checkedrow);
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
                    'previous_state' => '10',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true
                ]);
                $userdata = new UserFollowUpLeads();
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

    public function commentproceededleads(Request $request){
        $data_id = ProceededLead::find($request->data_id);
        // dd($data_id->data_id);
        $comment=Comment::create([
            'user_id'=>Auth::user()->id,
            'data_id'=>$data_id->data_id,
            'comment'=>$request->comment,
            'stage'=>'5',
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

    public function showcommentsproceededleads($data_id, $user_id, $stage)
    {
        $data = Comment::where('data_id', $data_id)->where('user_id', $user_id)->where('stage', $stage)->get();
        return Response::json(array('data' => $data));
    }

    public function getadminproceededdatacommentsinfo(Request $request)
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
        $paid = 0;
        $cancel = 0;
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

        $data = UserProceededLead::join('user_proceeded_leads_comment', function ($join) {
            $join->on('user_proceeded_leads.proceeded_lead_id', '=', 'user_proceeded_leads_comment.proceeded_lead_id')
                ->on('user_proceeded_leads.user_id', '=', 'user_proceeded_leads_comment.user_id');
        })
            ->join('proceeded_lead', 'proceeded_lead.id', '=', 'user_proceeded_leads.proceeded_lead_id')
            ->join('users', 'users.id', '=', 'user_proceeded_leads_comment.user_id')
            ->select(
                'proceeded_lead.*',
                'proceeded_lead.phone',
                'proceeded_lead.email',
                'proceeded_lead.name',
                'proceeded_lead.project',
                // 'proceeded_lead.MOBILE',
                'proceeded_lead.source',
                'user_proceeded_leads.proceeded_lead_id',
                'user_proceeded_leads.user_id',
                'users.name as agentname',
                'user_proceeded_leads_comment.userstatus',
                'user_proceeded_leads_comment.comment as comment',
                'user_proceeded_leads_comment.created_at'
            )
            ->where('user_proceeded_leads_comment.user_id', $userid);

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_proceeded_leads_comment.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_proceeded_leads_comment.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_proceeded_leads_comment.created_at', '=', $searchdaytext);

        /////////////////////// agent filter
        if ($userid != null)
            $data = $data->where('user_proceeded_leads_comment.user_id', $userid);

        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_proceeded_leads_comment.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('proceeded_lead.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('proceeded_lead.project', $project);

        $data = $data->get();
        $paid = $data->where('userstatus', 'Paid')->count();
        $cancel = $data->where('userstatus', 'Canceled')->count();

        $total = $paid +$cancel;
        $TotalAssigned = count(UserProceededLead::where('user_id', $userid)->get());
        return response()->json([
            'succssess' => true,
            'paid' => $paid,
            'cancel' => $cancel,
            'total' => $total,
            'TotalAssigned' => $TotalAssigned
        ]);
    }

    public function showproceededdatacomments(Request $request)
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

        $data = UserProceededLead::join('user_proceeded_leads_comment', function ($join) {
            $join->on('user_proceeded_leads.proceeded_lead_id', '=', 'user_proceeded_leads_comment.proceeded_lead_id')
                ->on('user_proceeded_leads.user_id', '=', 'user_proceeded_leads_comment.user_id');
        })
            ->join('proceeded_lead', 'proceeded_lead.id', '=', 'user_proceeded_leads.proceeded_lead_id')
            ->join('users', 'users.id', '=', 'user_proceeded_leads_comment.user_id')
            ->select(
                'proceeded_lead.*',
                'proceeded_lead.phone',
                'proceeded_lead.email',
                'proceeded_lead.name',
                'proceeded_lead.project',
                'proceeded_lead.data_id',
                'proceeded_lead.source',
                'user_proceeded_leads.proceeded_lead_id',
                'user_proceeded_leads.user_id',
                'users.name as agentname',
                'user_proceeded_leads_comment.userstatus',
                'user_proceeded_leads_comment.comment as comment',
                'user_proceeded_leads_comment.created_at'
            )->where('user_proceeded_leads_comment.user_id', $userid);

            /////////////////////// agent filter
        if ($userid != null) {
            $data = $data->where('user_proceeded_leads_comment.user_id', $userid);
        }

        /////////////////////// date filter
        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_proceeded_leads_comment.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_proceeded_leads_comment.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_proceeded_leads_comment.created_at', '=', $searchdaytext);


        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_proceeded_leads_comment.userstatus', $userstatus);

        /////////////////////// data source filter
        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('proceeded_lead.source', $datasource);

        /////////////////////// data project filter
        if (!is_null($project) && $project != "Show")
            $data = $data->where('proceeded_lead.project', $project);

        $data = $data->get()->toArray();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('comments', function ($row) {
                $comment = null;
                if ($row['userstatus'] == "Paid") {
                    $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <p> <b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                } else if ($row['userstatus'] == "Canceled ") {
                    $comment = '<div class="row ml-1" style="background-color:#00ff95"> <p><b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                }else{
                    $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                }
                return $comment;
            })
            ->addColumn('action', function ($row) {
                $followUpLeads = FollowUpLeads::where('data_id', $row['data_id'])->where('previous_state_id', $row['proceeded_lead_id'])->where('created_by', $row['user_id'])->first();
                if ($followUpLeads) {
                    if ($followUpLeads->assigned == '1') {
                        $actionBtn = '<button onclick="show_comments(' . $row['data_id'] . ')" type="button" id="' . $row['data_id'] . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    } else {
                        $actionBtn = '<button onclick="show_comments(' . $row['data_id'] . ')" type="button" id="' . $row['data_id'] . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                    }
                } else {
                    $actionBtn = '<button onclick="show_comments(' . $row['data_id'] . ')" type="button" id="' . $row['data_id'] . '" class="show-com btn btn-primary btn-md ml-1">Show Comments</button>';
                }
                return $actionBtn;
            })
            ->rawColumns(['comments', 'action'])
            ->make(true);
    }

    public function proceededleadsindex()
    {
        $projects = ProceededLead::select('project')->groupBy('project')->pluck('project');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = ProceededLead::select('source')->groupby('source')->get();
        $templet_name = sendinblue_templates::get();
        $template_whatsapps=sendinbluewhatsapptemplate::get();
        return view('admin.proceeded.proceededleads', ['projects' => $projects, 'agentnames' => $agentnames, 'datasources' => $datasources, 'templetname' => $templet_name,'templatewhatsapps'=>$template_whatsapps]);
    }

    public function proceededleads(Request $request)
    {
        $agentname = $request->agentname;
        $datasource = $request->datasource;
        $projects = $request->projects;
        $commenteddata = UserProceededLeadComment::select('proceeded_lead_id')->pluck('proceeded_lead_id')->toArray();
        $data = ProceededLead::join('users', 'users.id', '=', 'proceeded_lead.created_by')->whereNotIn('proceeded_lead.id', $commenteddata)->orderBy('created_at','DESC');


        if ($agentname != null) {
            $data = $data->where('created_by', $agentname);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        if ($projects != null) {
            $data = $data->where('project', $projects);
        }
        $data = $data->select('proceeded_lead.*', 'users.name as agentname')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check', 'action'])
            ->make(true);
    }

    public function sendemailtoproceededleads(Request $request)
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
            $data_proceeded_leads = ProceededLead::find($key);
            if ($data_proceeded_leads) {
                $details = [
                    'name' => $data_proceeded_leads->name,
                    'email' => $data_proceeded_leads->email,
                    'body' => $body
                ];
                $to[] = [
                    'email' => $data_proceeded_leads->email,
                    'name' => $data_proceeded_leads->name,
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

    public function showuserproceededdatacommentsindex()
    {
        $userstatus = config('app.proceeded_user_status');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = ProceededLead::select('source')->groupBy('source')->get();
        return view('admin.proceeded.showusercommentedproceededdata', ['userstatus' => $userstatus, 'datasources' => $datasources, 'agentnames' => $agentnames]);
    }

    public function getcommentsproceededadmin($data_id ,$agentname){
        $comment=Comment::where('user_id',$agentname)->where('data_id',$data_id)->where('stage','5')->get();
        return response()->json([
            'data'=>$comment
        ]);
    }
    public function  allcomments(Request $request){
        $comment=Comment::where('data_id',$request->data_id)->where('user_id',$request->userid)->where('stage',$request->stage)->get();
        return response()->json([
            'data'=>$comment
        ]);
    }
    public function showleadsinfo(Request $request){
        if($request->userstatus =="Paid"){
            $data=WonLeads::where('data_id',$request->data_id)->first()->toArray();
        }elseif($request->userstatus =="Appointment is succeed" || $request->userstatus =="Appointment is failed" || $request->userstatus =="Set appointment"  ){
            $data=QualifiedLeads::where('data_id',$request->data_id)->first()->toArray();
        }elseif($request->userstatus =="Canceled "){
            $data=ProceededLead::where('data_id',$request->data_id)->first()->toArray();
        }elseif($request->userstatus == "Not interested" || $request->userstatus == "Number And Email Unavailable" || $request->userstatus == "Wrong Number And Email" || $request->userstatus == "Invalid Number And Email" || $request->userstatus == "Cancelation after appointment" || $request->userstatus == "Others" ) {
            $data=DeadLeads::where('data_id',$request->data_id)->first()->toArray();
        }else{
            $data=FollowUpLeads::where('data_id',$request->data_id)->first()->toArray();
        }
        // dd($data);
        return response()->json([
            'data'=>$data
        ]);
    }
    public function historycomment(Request $request){
        $data=UserDataComment::where('data_id',$request->data_id)->get()->toArray();
        $qualified =QualifiedLeads::where('data_id',$request->data_id)->join('user_qualified_leads_comments','user_qualified_leads_comments.qualified_leads_id','qualified_leads.id')->get()->toArray();
        $followup =FollowUpLeads::where('data_id',$request->data_id)->join('user_follow_up_leads_comments','user_follow_up_leads_comments.follow_up_id','follow_up_leads.id')->whereNotIn('userstatus',['Interested','Not answer','Mobile Switched off','Line Busy','Contacted Via Email'])->get()->toArray();
        $followup_history =FollowUpLeads::where('data_id',$request->data_id)->join('followupstatuscommentshistories','followupstatuscommentshistories.follow_up_id','follow_up_leads.id')->get()->toArray();
        $proceeded =ProceededLead::where('data_id',$request->data_id)->join('user_proceeded_leads_comment','user_proceeded_leads_comment.proceeded_lead_id','proceeded_lead.id')->get()->toArray();
        $leadspool =booktable::where('data_id',$request->data_id)->join('user_leads_pool_comments','user_leads_pool_comments.leads_pool_id','booktables.id')->get()->toArray();
        $comment = array_merge($data,$qualified,$followup,$proceeded,$leadspool,$followup_history);
        return response()->json([
            'data'=>$comment
        ]);
    }
}
