<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Data;
use App\Models\User;
use App\Models\UserData;
use App\Models\booktable;
use Illuminate\Http\Request;
use App\Models\FollowUpLeads;
use App\Models\ProceededLead;
use App\Models\UserLeadsPool;
use App\Models\QualifiedLeads;
use App\Models\AgentAttendance;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\UserProceededLeadComment;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function leaderboardindex()
    {
        return view('admin.leaderboard');
    }
    public function getleaderboard(Request $request)
    {
        $data = [];
        $users = User::whereNotIn('role_id', ['1', '6', '5'])->get();
        foreach ($users as $key => $user) {
            $Line_Busy = 0;
            $Mobile_Switched_off = 0;
            $Contacted_Via_Email = 0;
            $Number_And_Email_Unavailable = 0;
            $Wrong_Number_And_Email = 0;
            $Invalid_Number_And_Email = 0;
            $Cancelation_after_appointment = 0;
            $Cancel = 0;
            $Paid = 0;
            $others = 0;
            $Appointment_is_failed = 0;
            $Appointment_is_succeed = 0;
            $interested = 0;
            $notinterested = 0;
            $notanswer = 0;
            $total = 0;
            $totalassigne = 0;
            if ($user != null) {
                $username = $user->name;
                $userid = $user->id;
                ////interesting
                $interested_data = $user->userdatacomment()->wherePivot('userstatus', 'Interested')->count();
                $interested_qualifiy = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Interested')->count();
                $interested_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Interested')->count();
                $interested_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Interested')->count();
                $interested_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Interested')->count();
                $interested = $interested_proceeded + $interested_followup + $interested_leadspool + $interested_qualifiy + $interested_data;
                $INTERESTE_CALL = $interested_data + $interested_leadspool;
                //////other
                $others_data = $user->userdatacomment()->wherePivot('userstatus', 'Others')->count();
                $others_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Others')->count();
                $others_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Others')->count();
                $others_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Others')->count();
                $others_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Others')->count();
                $others = $others_data + $others_followup + $others_proceeded + $others_leadspool + $others_quailified;
                $others_CALL = $others_leadspool + $others_data;
                ////Mobile Switched off
                $Mobile_Switched_off_data = $user->userdatacomment()->wherePivot('userstatus', 'Mobile Switched off')->count();
                $Mobile_Switched_off_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Mobile Switched off')->count();
                $Mobile_Switched_off_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Mobile Switched off')->count();
                $Mobile_Switched_off_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Mobile Switched off')->count();
                $Mobile_Switched_off_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Mobile Switched off')->count();
                $Mobile_Switched_off = $Mobile_Switched_off_proceeded + $Mobile_Switched_off_followup + $Mobile_Switched_off_leadspool + $Mobile_Switched_off_quailified + $Mobile_Switched_off_data;
                $Mobile_Switched_off_CALL = $Mobile_Switched_off_leadspool + $Mobile_Switched_off_data;
                ///Not interested
                $notinterested_data = $user->userdatacomment()->wherePivot('userstatus', 'Not interested')->count();
                $notinterested_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Not interested')->count();
                $notinterested_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Not interested')->count();
                $notinterested_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Not interested')->count();
                $notinterested_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Not interested')->count();
                $notinterested = $notinterested_proceeded + $notinterested_followup + $notinterested_leadspool + $notinterested_quailified + $notinterested_data;
                $notinterested_CALL = $notinterested_leadspool + $notinterested_data;
                ////Not answer
                $notanswer_data = $user->userdatacomment()->wherePivot('userstatus', 'Not Answered')->count();
                $notanswer_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Not Answered')->count();
                $notanswer_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Not Answered')->count();
                $notanswer_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Not Answered')->count();
                $notanswer_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Not Answered')->count();
                $notanswer = $notanswer_data + $notanswer_quailified + $notanswer_leadspool + $notanswer_followup + $notanswer_proceeded;
                $notanswer_CALL = $notanswer_data + $notanswer_leadspool;
                /////Line Busy
                $Line_Busy_data = $user->userdatacomment()->wherePivot('userstatus', 'Line Busy')->count();
                $Line_Busy_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Line Busy')->count();
                $Line_Busy_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Line Busy')->count();
                $Line_Busy_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Line Busy')->count();
                $Line_Busy_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Line Busy')->count();
                $Line_Busy = $Line_Busy_data + $Line_Busy_followup + $Line_Busy_quailified + $Line_Busy_leadspool + $Line_Busy_proceeded;
                $Line_Busy_CALL = $Line_Busy_data + $Line_Busy_leadspool;
                /////////Contacted Via Email
                $Contacted_Via_Email_data = $user->userdatacomment()->wherePivot('userstatus', 'Contacted Via Email')->count();
                $Contacted_Via_Email_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Contacted Via Email')->count();
                $Contacted_Via_Email_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Contacted Via Email')->count();
                $Contacted_Via_Email_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Contacted Via Email')->count();
                $Contacted_Via_Email_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Contacted Via Email')->count();
                $Contacted_Via_Email = $Contacted_Via_Email_data + $Contacted_Via_Email_followup + $Contacted_Via_Email_quailified + $Contacted_Via_Email_leadspool + $Contacted_Via_Email_proceeded;
                $Contacted_Via_Email_CALL = $Contacted_Via_Email_data + $Contacted_Via_Email_leadspool;
                ////////Number And Email Unavailable
                $Number_And_Email_Unavailable_data = $user->userdatacomment()->wherePivot('userstatus', 'Number & Email Unavailable')->count();
                $Number_And_Email_Unavailable_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Number & Email Unavailable')->count();
                $Number_And_Email_Unavailable_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Number & Email Unavailable')->count();
                $Number_And_Email_Unavailable_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Number & Email Unavailable')->count();
                $Number_And_Email_Unavailable_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Number & Email Unavailable')->count();
                $Number_And_Email_Unavailable = $Number_And_Email_Unavailable_data + $Number_And_Email_Unavailable_followup + $Number_And_Email_Unavailable_quailified + $Number_And_Email_Unavailable_leadspool + $Number_And_Email_Unavailable_proceeded;
                $Number_And_Email_Unavailable_CALL = $Number_And_Email_Unavailable_data + $Number_And_Email_Unavailable_leadspool;
                /////Wrong Number And Email
                $Wrong_Number_And_Email_data = $user->userdatacomment()->wherePivot('userstatus', 'Wrong Number & Email')->count();
                $Wrong_Number_And_Email_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Wrong Number & Email')->count();
                $Wrong_Number_And_Email_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Wrong Number & Email')->count();
                $Wrong_Number_And_Email_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Wrong Number & Email')->count();
                $Wrong_Number_And_Email_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Wrong Number & Email')->count();
                $Wrong_Number_And_Email = $Wrong_Number_And_Email_data + $Wrong_Number_And_Email_followup + $Wrong_Number_And_Email_quailified + $Wrong_Number_And_Email_leadspool + $Wrong_Number_And_Email_proceeded;
                $Wrong_Number_And_Email_CALL = $Wrong_Number_And_Email_data + $Wrong_Number_And_Email_leadspool;
                /////Invalid Number And Email
                $Invalid_Number_And_Email_data = $user->userdatacomment()->wherePivot('userstatus', 'Invalid Number & Email')->count();
                $Invalid_Number_And_Email_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Invalid Number & Email')->count();
                $Invalid_Number_And_Email_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Invalid Number & Email')->count();
                $Invalid_Number_And_Email_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Invalid Number & Email')->count();
                $Invalid_Number_And_Email_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Invalid Number & Email')->count();
                $Invalid_Number_And_Email = $Invalid_Number_And_Email_data + $Invalid_Number_And_Email_followup + $Invalid_Number_And_Email_quailified + $Invalid_Number_And_Email_leadspool + $Invalid_Number_And_Email_proceeded;
                $Invalid_Number_And_Email_CALL = $Invalid_Number_And_Email_data + $Invalid_Number_And_Email_leadspool;
                ////////Cancelation after appointment
                $Cancelation_after_appointment_data = $user->userdatacomment()->wherePivot('userstatus', 'Cancelation after appointment')->count();
                $Cancelation_after_appointment_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Cancelation after appointment')->count();
                $Cancelation_after_appointment_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Cancelation after appointment')->count();
                $Cancelation_after_appointment_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Cancelation after appointment')->count();
                $Cancelation_after_appointment_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Cancelation after appointment')->count();
                $Cancelation_after_appointment = $Cancelation_after_appointment_data + $Cancelation_after_appointment_followup + $Cancelation_after_appointment_quailified + $Cancelation_after_appointment_leadspool + $Cancelation_after_appointment_proceeded;
                $Cancelation_after_appointment_CALL = $Cancelation_after_appointment_data + $Cancelation_after_appointment_leadspool;
                ///Set appointment
                $setappointment_data = $user->userdatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
                $setappointment_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
                $setappointment_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
                $setappointment_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
                $setappointment_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
                $setappointment = $setappointment_data + $setappointment_followup + $setappointment_quailified + $setappointment_leadspool + $setappointment_proceeded;
                $setappointment_CALL = $setappointment_data + $setappointment_leadspool;
                /////////Paid
                $Paid_data = $user->userdatacomment()->wherePivot('userstatus', 'Paid')->count();
                $Paid_quailified = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Paid')->count();
                $Paid_leadspool = $user->userleadspooldatacomment()->wherePivot('userstatus', 'Paid')->count();
                $Paid_followup = $user->userfollowupdatacomment()->wherePivot('userstatus', 'Paid')->count();
                $Paid_proceeded = $user->userproceededdatacomment()->wherePivot('userstatus', 'Paid')->count();
                $Paid = $Paid_data + $Paid_followup + $Paid_quailified + $Paid_leadspool + $Paid_proceeded;
                ////Cancel
                $Cancel = $user->userproceededdatacomment()->wherePivot('userstatus', 'Canceled')->count();
                ///Appointment is succeed
                $Appointment_is_succeed = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Appointment is Suceeded')->count();
                ///Appointment is failed
                $Appointment_is_failed = $user->userqualifieddatacomment()->wherePivot('userstatus', 'Appointment is Faild')->count();
                $total =  $Line_Busy_CALL + $Mobile_Switched_off_CALL + $Contacted_Via_Email_CALL + $Number_And_Email_Unavailable_CALL + $Wrong_Number_And_Email_CALL + $Invalid_Number_And_Email_CALL + $Cancelation_after_appointment_CALL + $others_CALL + $INTERESTE_CALL + $notinterested_CALL + $notanswer_CALL + $setappointment_CALL;
                $totalassigne_data = $user->userdata()->where('user_id', $user->id)->count();
                $totalassigne_leads = $user->userleadsbooldata()->where('user_id', $user->id)->count();
                $totalassigne = $totalassigne_leads + $totalassigne_data;
                $data[] = [
                    'username' => $username,
                    'userid' => $userid,
                    'others' => $others,
                    'interested' => $interested,
                    'MobileSwitchedoff' => $Mobile_Switched_off,
                    'notinterested' => $notinterested,
                    'notanswer' => $notanswer,
                    'LineBusy' => $Line_Busy,
                    'ContactedViaEmail' => $Contacted_Via_Email,
                    'NumberAndEmailUnavailable' => $Number_And_Email_Unavailable,
                    'WrongNumberAndEmail' => $Wrong_Number_And_Email,
                    'InvalidNumberAndEmail' => $Invalid_Number_And_Email,
                    'Cancelationafterappointment' => $Cancelation_after_appointment,
                    'setappointment' => $setappointment,
                    'Paid' => $Paid,
                    'Cancel' => $Cancel,
                    'Appointmentissucceed' => $Appointment_is_succeed,
                    'Appointmentisfailed' => $Appointment_is_failed,
                    'total' => $total,
                    'totalassigne' => $totalassigne
                ];
            }
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('username', function ($row) {
                return ucfirst($row['username']);
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="details btn btn-info btn-sm ml-1" >Details</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function showdetailsuserindex($username)
    {
        return view('admin.detailsuser', ['userid' => $username]);
    }
    public function getdetailsuser(Request $request)
    {
        $data = [];
        $user = User::find($request->userid);
        $sources_data = UserData::where('user_id', $request->userid)->join('data', 'data.id', '=', 'user_data.data_id')->select('data.source', 'data.id')->get()->toArray();
        $source_leads_pool = UserLeadsPool::where('user_id', $request->userid)->join('booktables', 'booktables.id', 'user_leads_pools.leads_pool_id')->select('booktables.data_id as id', 'booktables.source')->get()->toArray();
        $D = [];
        $sources = array_merge($source_leads_pool, $sources_data);
        // dd($sources);
        $dataf = [];
        foreach ($sources as $key => $source) {
            $swoflibuwonuinnu = 0;
            $unavnotworkincomp = 0;
            $others = 0;
            $notinterested = 0;
            $notanswer = 0;
            $total = 0;
            $totalassigne = 0;
            if ($source != null) {
                if (in_array($source['source'], $D)) {
                    ////interested
                    $interested_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Interested')->count();
                    $interested_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Interested')->count();
                    $interested_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Interested')->count();
                    $interested = $interested_followup + $interested_leadspool + $interested_data;
                    $INTERESTE_CALL = $interested_data + $interested_leadspool;
                    //////other
                    $others_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Others')->count();
                    $others_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Others')->count();
                    $others_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Others')->count();
                    $others = $others_data + $others_followup + $others_leadspool;
                    $others_CALL = $others_leadspool + $others_data;
                    ///mobile
                    $Mobile_Switched_off_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Mobile Switched off')->count();
                    $Mobile_Switched_off_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Mobile Switched off')->count();
                    $Mobile_Switched_off_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Mobile Switched off')->count();
                    $Mobile_Switched_off = $Mobile_Switched_off_followup + $Mobile_Switched_off_leadspool + $Mobile_Switched_off_data;
                    $Mobile_Switched_off_CALL = $Mobile_Switched_off_leadspool + $Mobile_Switched_off_data;
                    ///Not interested
                    $notinterested_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Not interested')->count();
                    $notinterested_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Not interested')->count();
                    $notinterested_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Not interested')->count();
                    $notinterested = $notinterested_followup + $notinterested_leadspool + $notinterested_data;
                    $notinterested_CALL = $notinterested_leadspool + $notinterested_data;
                    ////Not answer
                    $notanswer_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Not Answered')->count();
                    $notanswer_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Not Answered')->count();
                    $notanswer_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Not Answered')->count();
                    $notanswer = $notanswer_data + $notanswer_leadspool + $notanswer_followup;
                    $notanswer_CALL = $notanswer_data + $notanswer_leadspool;
                    /////Line Busy
                    $Line_Busy_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Line Busy')->count();
                    $Line_Busy_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Line Busy')->count();
                    $Line_Busy_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Line Busy')->count();
                    $Line_Busy = $Line_Busy_data + $Line_Busy_followup + $Line_Busy_leadspool;
                    $Line_Busy_CALL = $Line_Busy_data + $Line_Busy_leadspool;
                    /////////Contacted Via Email
                    $Contacted_Via_Email_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Contacted Via Email')->count();
                    $Contacted_Via_Email_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Contacted Via Email')->count();
                    $Contacted_Via_Email_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Contacted Via Email')->count();
                    $Contacted_Via_Email_CALL = $Contacted_Via_Email_data + $Contacted_Via_Email_leadspool;
                    $Contacted_Via_Email = $Contacted_Via_Email_data + $Contacted_Via_Email_followup + $Contacted_Via_Email_leadspool;
                    ////////Number And Email Unavailable
                    $Number_And_Email_Unavailable_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Number & Email Unavailable')->count();
                    $Number_And_Email_Unavailable_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Number & Email Unavailable')->count();
                    $Number_And_Email_Unavailable_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Number & Email Unavailable')->count();
                    $Number_And_Email_Unavailable_CALL = $Number_And_Email_Unavailable_data + $Number_And_Email_Unavailable_leadspool;
                    $Number_And_Email_Unavailable = $Number_And_Email_Unavailable_data + $Number_And_Email_Unavailable_followup + $Number_And_Email_Unavailable_leadspool;
                    $Wrong_Number_And_Email_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Wrong Number & Email')->count();
                    $Wrong_Number_And_Email_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Wrong Number & Email')->count();
                    $Wrong_Number_And_Email_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Wrong Number & Email')->count();
                    $Wrong_Number_And_Email = $Wrong_Number_And_Email_data + $Wrong_Number_And_Email_followup + $Wrong_Number_And_Email_leadspool;
                    $Wrong_Number_And_Email_CALL = $Wrong_Number_And_Email_data + $Wrong_Number_And_Email_leadspool;
                    /////Invalid Number And Email
                    $Invalid_Number_And_Email_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Invalid Number & Email')->count();
                    $Invalid_Number_And_Email_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Invalid Number & Email')->count();
                    $Invalid_Number_And_Email_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Invalid Number & Email')->count();
                    $Invalid_Number_And_Email = $Invalid_Number_And_Email_data + $Invalid_Number_And_Email_followup + $Invalid_Number_And_Email_leadspool;
                    $Invalid_Number_And_Email_CALL = $Invalid_Number_And_Email_data + $Invalid_Number_And_Email_leadspool;
                    ////////Cancelation after appointment
                    $Cancelation_after_appointment_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_QUI = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_CALL = $Cancelation_after_appointment_data + $Cancelation_after_appointment_leadspool;
                    $Cancelation_after_appointment = $Cancelation_after_appointment_data + $Cancelation_after_appointment_followup + $Cancelation_after_appointment_leadspool + $Cancelation_after_appointment_QUI;
                    $setappointment_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Appointment is set')->count();
                    $setappointment_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Appointment is set')->count();
                    $setappointment_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Appointment is set')->count();
                    $setappointment = $setappointment_data + $setappointment_leadspool + $setappointment_followup;
                    $setappointment_CALL = $setappointment_data + $setappointment_leadspool;
                    /////////Paid
                    $Paid_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Paid')->count();
                    $Paid_quailified = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Paid')->count();
                    $user->userqualifieddatacomment()->wherePivot('userstatus', 'Paid')->count();
                    $Paid_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Paid')->count();
                    $Paid_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Paid')->count();
                    $Paid_proceeded = ProceededLead::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_proceeded_leads_comment', 'user_proceeded_leads_comment.proceeded_lead_id', 'proceeded_lead.id')
                        ->select('user_proceeded_leads_comment.*')->where('userstatus', 'Paid')->count();
                    $Paid = $Paid_data + $Paid_followup + $Paid_quailified + $Paid_leadspool + $Paid_proceeded;
                    $Cancel = ProceededLead::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_proceeded_leads_comment', 'user_proceeded_leads_comment.proceeded_lead_id', 'proceeded_lead.id')
                        ->select('user_proceeded_leads_comment.*')->where('userstatus', 'Canceled')->count();
                    ///Appointment is succeed
                    $Appointment_is_succeed = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Appointment is Suceeded')->count();
                    ///Appointment is failed
                    $Appointment_is_failed = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Appointment is Faild')->count();
                    $total = $Line_Busy_CALL + $Mobile_Switched_off_CALL + $Contacted_Via_Email_CALL + $Number_And_Email_Unavailable_CALL + $Wrong_Number_And_Email_CALL + $Invalid_Number_And_Email_CALL + $Cancelation_after_appointment_CALL + $others_CALL + $INTERESTE_CALL + $notinterested_CALL + $notanswer_CALL + $setappointment_CALL;
                    $totalassigne_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data', 'user_data.data_id', 'data.id')
                        ->select('user_data.*')->count();
                    $totalassigne_leads = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pools', 'user_leads_pools.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pools.*')->count();
                    $totalassigne = $totalassigne_leads + $totalassigne_data;
                    foreach ($data as $key => $value) {
                        if ($value['sourcename'] == $source['source']) {
                            $i = $value['interested'] + $interested;
                            $o = $value['others'] + $others;
                            $m_d_o = $value['MobileSwitchedoff'] + $Mobile_Switched_off;
                            $n_i = $value['notinterested'] + $notinterested;
                            $n_a = $value['notanswer'] + $notanswer;
                            $l_b = $value['LineBusy'] + $Line_Busy;
                            $c_v_e = $value['ContactedViaEmail'] + $Contacted_Via_Email;
                            $n_a_e_u = $value['NumberAndEmailUnavailable'] + $Number_And_Email_Unavailable;
                            $w_n_a_e = $value['WrongNumberAndEmail'] + $Wrong_Number_And_Email;
                            $i_n_a_e = $value['InvalidNumberAndEmail'] + $Invalid_Number_And_Email;
                            $c_a_ap = $value['Cancelationafterappointment'] + $Cancelation_after_appointment;
                            $s_ap = $value['setappointment'] + $setappointment;
                            $p = $value['Paid'] + $Paid;
                            $c = $value['Cancel'] + $Cancel;
                            $aisu = $value['Appointmentissucceed'] + $Appointment_is_succeed;
                            $aisf = $value['Appointmentisfailed'] + $Appointment_is_failed;
                            $tot = $value['total'] + $total;
                            $tot_ass = $value['totalassigne'] + $totalassigne;
                            unset($data[$key]);
                            $data[] = [
                                'sourcename' => $source['source'], 'interested' => $i, 'others' => $o, 'MobileSwitchedoff' => $m_d_o, 'notinterested' => $n_i, 'notanswer' => $n_a,
                                'LineBusy' => $l_b, 'ContactedViaEmail' => $c_v_e, 'NumberAndEmailUnavailable' => $n_a_e_u,
                                'WrongNumberAndEmail' => $w_n_a_e, 'InvalidNumberAndEmail' => $i_n_a_e, 'Cancelationafterappointment' => $c_a_ap,
                                'setappointment' => $s_ap, 'Paid' => $p, 'Cancel' => $c, 'Appointmentisfailed' => $aisf, 'Appointmentissucceed' => $aisu,
                                'total' => $tot, 'totalassigne' => $tot_ass
                            ];
                        }
                    }
                } else {
                    $D[] = $source['source'];
                    $interested_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Interested')->count();
                    $interested_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Interested')->count();
                    $interested_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Interested')->count();
                    $interested = $interested_followup + $interested_leadspool + $interested_data;
                    $INTERESTE_CALL = $interested_data + $interested_leadspool;
                    ///other
                    $others_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Others')->count();
                    $others_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Others')->count();
                    $others_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Others')->count();
                    $others = $others_data + $others_followup + $others_leadspool;
                    $others_CALL = $others_leadspool + $others_data;
                    /////mo
                    $Mobile_Switched_off_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Mobile Switched off')->count();
                    $Mobile_Switched_off_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Mobile Switched off')->count();
                    $Mobile_Switched_off_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Mobile Switched off')->count();
                    $Mobile_Switched_off_CALL = $Mobile_Switched_off_leadspool + $Mobile_Switched_off_data;
                    $Mobile_Switched_off = $Mobile_Switched_off_followup + $Mobile_Switched_off_leadspool + $Mobile_Switched_off_data;
                    $notinterested_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Not interested')->count();
                    $notinterested_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Not interested')->count();
                    $notinterested_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Not interested')->count();
                    $notinterested = $notinterested_followup + $notinterested_leadspool + $notinterested_data;
                    $notinterested_CALL = $notinterested_leadspool + $notinterested_data;
                    ////Not answer
                    $notanswer_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Not Answered')->count();
                    $notanswer_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Not Answered')->count();
                    $notanswer_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Not Answered')->count();
                    $notanswer = $notanswer_data + $notanswer_leadspool + $notanswer_followup;
                    $notanswer_CALL = $notanswer_data + $notanswer_leadspool;
                    /////Line Busy
                    $Line_Busy_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Line Busy')->count();
                    $Line_Busy_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Line Busy')->count();
                    $Line_Busy_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Line Busy')->count();
                    $Line_Busy_CALL = $Line_Busy_data + $Line_Busy_leadspool;
                    $Line_Busy = $Line_Busy_data + $Line_Busy_followup + $Line_Busy_leadspool;
                    $Contacted_Via_Email_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Contacted Via Email')->count();
                    $Contacted_Via_Email_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Contacted Via Email')->count();
                    $Contacted_Via_Email_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Contacted Via Email')->count();
                    $Contacted_Via_Email_CALL = $Contacted_Via_Email_data + $Contacted_Via_Email_leadspool;
                    $Contacted_Via_Email = $Contacted_Via_Email_data + $Contacted_Via_Email_followup + $Contacted_Via_Email_leadspool;
                    $Number_And_Email_Unavailable_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Number & Email Unavailable')->count();
                    $Number_And_Email_Unavailable_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Number & Email Unavailable')->count();
                    $Number_And_Email_Unavailable_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Number & Email Unavailable')->count();
                    $Number_And_Email_Unavailable_CALL = $Number_And_Email_Unavailable_data + $Number_And_Email_Unavailable_leadspool;
                    $Number_And_Email_Unavailable = $Number_And_Email_Unavailable_data + $Number_And_Email_Unavailable_followup + $Number_And_Email_Unavailable_leadspool;
                    $Wrong_Number_And_Email_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Wrong Number & Email')->count();
                    $Wrong_Number_And_Email_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Wrong Number & Email')->count();
                    $Wrong_Number_And_Email_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Wrong Number & Email')->count();
                    $Wrong_Number_And_Email = $Wrong_Number_And_Email_data + $Wrong_Number_And_Email_followup + $Wrong_Number_And_Email_leadspool;
                    $Wrong_Number_And_Email_CALL = $Wrong_Number_And_Email_data + $Wrong_Number_And_Email_leadspool;
                    /////Invalid Number And Email
                    $Invalid_Number_And_Email_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Invalid Number & Email')->count();
                    $Invalid_Number_And_Email_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Invalid Number & Email')->count();
                    $Invalid_Number_And_Email_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Invalid Number & Email')->count();
                    $Invalid_Number_And_Email = $Invalid_Number_And_Email_data + $Invalid_Number_And_Email_followup + $Invalid_Number_And_Email_leadspool;
                    $Invalid_Number_And_Email_CALL = $Invalid_Number_And_Email_data + $Invalid_Number_And_Email_leadspool;
                    ////////Cancelation after appointment
                    $Cancelation_after_appointment_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_QUI = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Cancelation after appointment')->count();
                    $Cancelation_after_appointment_CALL = $Cancelation_after_appointment_data + $Cancelation_after_appointment_leadspool;
                    $Cancelation_after_appointment = $Cancelation_after_appointment_QUI + $Cancelation_after_appointment_data + $Cancelation_after_appointment_followup + $Cancelation_after_appointment_leadspool;
                    $setappointment_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Appointment is set')->count();
                    $setappointment_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Appointment is set')->count();
                    $setappointment_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Appointment is set')->count();
                    $setappointment = $setappointment_data + $setappointment_leadspool + $setappointment_followup;
                    $setappointment_CALL = $setappointment_data + $setappointment_leadspool;
                    $Paid_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data_comment', 'user_data_comment.data_id', 'data.id')
                        ->select('user_data_comment.*')->where('userstatus', 'Paid')->count();
                    $Paid_quailified = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Paid')->count();
                    $Paid_leadspool = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pool_comments', 'user_leads_pool_comments.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pool_comments.*')->where('userstatus', 'Paid')->count();
                    $Paid_followup = FollowUpLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
                        ->select('user_follow_up_leads_comments.*')->where('userstatus', 'Paid')->count();
                    $Paid_proceeded = ProceededLead::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_proceeded_leads_comment', 'user_proceeded_leads_comment.proceeded_lead_id', 'proceeded_lead.id')
                        ->select('user_proceeded_leads_comment.*')->where('userstatus', 'Paid')->count();
                    $Paid = $Paid_data + $Paid_followup + $Paid_quailified + $Paid_leadspool + $Paid_proceeded;
                    $Cancel = ProceededLead::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_proceeded_leads_comment', 'user_proceeded_leads_comment.proceeded_lead_id', 'proceeded_lead.id')
                        ->select('user_proceeded_leads_comment.*')->where('userstatus', 'Canceled')->count();
                    ///Appointment is succeed
                    $Appointment_is_succeed = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Appointment is Suceeded')->count();
                    ///Appointment is failed
                    $Appointment_is_failed = QualifiedLeads::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_qualified_leads_comments', 'user_qualified_leads_comments.qualified_leads_id', 'qualified_leads.id')
                        ->select('user_qualified_leads_comments.*')->where('userstatus', 'Appointment is Faild')->count();
                    $total =  $Line_Busy_CALL + $Mobile_Switched_off_CALL + $Contacted_Via_Email_CALL + $Number_And_Email_Unavailable_CALL + $Wrong_Number_And_Email_CALL + $Invalid_Number_And_Email_CALL + $Cancelation_after_appointment_CALL + $others_CALL + $INTERESTE_CALL + $notinterested_CALL + $notanswer_CALL + $setappointment_CALL;
                    $totalassigne_data = Data::where('source', $source['source'])->where('data_id', $source['id'])
                        ->join('user_data', 'user_data.data_id', 'data.id')
                        ->select('user_data.*')->count();
                    $totalassigne_leads = booktable::where('data_id', $source['id'])->where('source', $source['source'])
                        ->join('user_leads_pools', 'user_leads_pools.leads_pool_id', 'booktables.id')
                        ->select('user_leads_pools.*')->count();
                    $totalassigne = $totalassigne_leads + $totalassigne_data;
                    $data[] = [
                        'sourcename' => $source['source'], 'interested' => $interested, 'others' => $others, 'MobileSwitchedoff' => $Mobile_Switched_off,
                        'notinterested' => $notinterested, 'notanswer' => $notanswer, 'LineBusy' => $Line_Busy, 'ContactedViaEmail' => $Contacted_Via_Email,
                        'NumberAndEmailUnavailable' => $Number_And_Email_Unavailable,
                        'WrongNumberAndEmail' => $Wrong_Number_And_Email,
                        'InvalidNumberAndEmail' => $Invalid_Number_And_Email,
                        'Cancelationafterappointment' => $Cancelation_after_appointment,
                        'setappointment' => $setappointment,
                        'Paid' => $Paid,
                        'Cancel' => $Cancel,
                        'Appointmentissucceed' => $Appointment_is_succeed,
                        'Appointmentisfailed' => $Appointment_is_failed,
                        'total' => $total,
                        'totalassigne' => $totalassigne
                    ];
                }
            }
        }
        // dd($interested_leadspool);

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('sourcename', function ($row) {
                return ucfirst($row['sourcename']);
            })
            ->make(true);
    }
    public function officetime()
    {
        return view('admin.officetime');
    }
    public function getofficetime(Request $request)
    {
        $user = User::where('role_id', '3')->get();
        $FROM_last = Carbon::now()->subDay(7);
        $end_last = Carbon::now()->subDay();
        $FROM_last_month = Carbon::now()->subDay(30);
        $end_last_month = Carbon::now()->subDay();
        $start_of_year = now()->startOfYear();
        $end_of_year = now()->endOfYear();
        foreach ($user as $key) {
            $YESTERDAY = [];
            $lastweek = [];
            $lastmonth = [];
            $Thisyear = [];
            $yester = 0;
            $month = 0;
            $week = 0;
            $year = 0;
            $officetimes_yesterday = AgentAttendance::where('agent_id', $key->id)->whereDate('created_at', Carbon::now()->subDay())->get();
            foreach ($officetimes_yesterday as $officetime) {
                $YESTERDAY[] = $officetime->duration;
            }
            for ($i = 0; $i < count($YESTERDAY); $i++) {
                $yester += $YESTERDAY[$i];
            }
            $officetimes_lastweek = AgentAttendance::where('agent_id', $key->id)->WhereBetween('created_at', [$FROM_last, $end_last])->get();
            foreach ($officetimes_lastweek as $officetime_lastweek) {
                $lastweek[] = $officetime_lastweek->duration;
            }
            for ($j = 0; $j < count($lastweek); $j++) {
                $week += $lastweek[$j];
            }
            $officetimes_lastmonth = AgentAttendance::where('agent_id', $key->id)->WhereBetween('created_at', [$FROM_last_month, $end_last_month])->get();
            foreach ($officetimes_lastmonth as $officetime_lastmonth) {
                $lastmonth[] = $officetime_lastmonth->duration;
            }
            for ($k = 0; $k < count($lastmonth); $k++) {
                $month += $lastmonth[$k];
            }
            $officetimes_Thisyear = AgentAttendance::where('agent_id', $key->id)->WhereBetween('created_at', [$start_of_year, $end_of_year])->get();
            foreach ($officetimes_Thisyear as $officetime_Thisyear) {
                $Thisyear[] = $officetime_Thisyear->duration;
            }
            for ($y = 0; $y < count($Thisyear); $y++) {
                $year += $Thisyear[$y];
            }
            $data[] = [
                'username' => $key->name,
                'yesterday' => intval($yester / 60) . " hour " . ($yester % 60) . " minutes",
                'lastweek' =>  intval($week / 60) . " hour " . ($week % 60) . " minutes",
                'year' => intval($year / 60) . " hour " . ($year % 60) . " minutes",
                'month' =>  intval($month / 60) . " hour " . ($month % 60) . " minutes",
            ];
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="details btn btn-info btn-sm">Show Details</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function Success()
    {
        return view('admin.Success');
    }
    public function getSuccess(Request $request)
    {
        $agents = User::where('role_id', '3')->get();
        foreach ($agents as $agent) {
            $user_data = UserData::where('user_id', $agent->id)->count();
            $user_leadspool = UserLeadsPool::where('user_id', $agent->id)->count();
            $assign = $user_data + $user_leadspool;
            $meetings_data = $agent->userdatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
            $meetings_leadspool = $agent->userleadspooldatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
            $meetings_followup = $agent->userfollowupdatacomment()->wherePivot('userstatus', 'Appointment is set')->count();
            $meetings = $meetings_data + $meetings_followup + $meetings_leadspool;
            $won = UserProceededLeadComment::where('user_id', $agent->id)->where('userstatus', 'Paid')->count();
            $data[] = [
                'username' => $agent->name,
                'assigned' => $assign,
                'meetings' => $meetings,
                'won' => $won
            ];
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    public function reportassignedagentsleads(Request $request)
    {

        if ($request->ajax()) {
            $source = $request->get('source');

            // $coll = new Collection();
            // $leadsbool = DB::select(DB::raw('SELECT DISTINCT data.id, data.name, data.phone, data.email, users.name as agent from data JOIN booktables on booktables.data_id = data.id JOIN user_leads_pools on user_leads_pools.leads_pool_id = booktables.id JOIN users on user_leads_pools.user_id=users.id where booktables.assigned=1;'));
            // $coll = $coll->concat($leadsbool);

            // $importedlead = DB::select(DB::raw('SELECT DISTINCT data.id, data.name, data.phone, data.email, users.name as agent from data JOIN user_data on user_data.data_id = data.id JOIN users on user_data.user_id=users.id where data.assigned=1;'));
            // $coll = $coll->concat($importedlead);

            if ($source) {
                $data = DB::select(DB::raw('select DISTINCT * from (SELECT DISTINCT booktables.data_id as id, booktables.name, booktables.phone, booktables.email, users.name as agent from booktables JOIN user_leads_pools on user_leads_pools.leads_pool_id = booktables.id JOIN users on user_leads_pools.user_id = users.id WHERE booktables.assigned=1 and booktables.source="'.$source.'" UNION ALL SELECT DISTINCT data.id, data.name, data.phone, data.email, users.name as agent from data JOIN user_data on user_data.data_id = data.id JOIN users on user_data.user_id=users.id where data.assigned=1 and data.source="'.$source.'") as aa GROUP BY aa.id'));
            } else {
                $data = DB::select(DB::raw('select DISTINCT * from (SELECT DISTINCT booktables.data_id as id, booktables.name, booktables.phone, booktables.email, users.name as agent from booktables JOIN user_leads_pools on user_leads_pools.leads_pool_id = booktables.id JOIN users on user_leads_pools.user_id = users.id WHERE booktables.assigned=1 UNION ALL SELECT DISTINCT data.id, data.name, data.phone, data.email, users.name as agent from data JOIN user_data on user_data.data_id = data.id JOIN users on user_data.user_id=users.id where data.assigned=1) as aa GROUP BY aa.id;'));
            }


            // $leads_list = [];
            // $followup = FollowUpLeads::where('assigned', 1)->get();
            // foreach ($followup as $key => $item) {
            //     $user = UserFollowUpLeads::where('follow_up_id', $item->id)->first();
            //     $tmp_user = User::where('id', $user->user_id)->first();
            //     $tmp = Data::where('id', $item->data_id)->first();
            //     if (!in_array($tmp->id, array_column($leads_list, 'id'))) {
            //         $leads_list[] = [
            //             'id' => $tmp->id,
            //             'name' => $tmp->NAME,
            //             'phone' => $tmp->PHONE,
            //             'email' => $tmp->EMAIL,
            //             'agent' => $tmp_user->name
            //         ];
            //     }
            // }

            // $qualified = QualifiedLeads::where('assigned', 1)->get();
            // foreach ($qualified as $key => $item) {
            //     $user = UserQualifiedLeads::where('qualified_leads_id', $item->id)->first();
            //     $tmp_user = User::where('id', $user->user_id)->first();
            //     $tmp = Data::where('id', $item->data_id)->first();

            //     if (!in_array($tmp->id, array_column($leads_list, 'id'))) {
            //         $leads_list[] = [
            //             'id' => $tmp->id,
            //             'name' => $tmp->NAME,
            //             'phone' => $tmp->PHONE,
            //             'email' => $tmp->EMAIL,
            //             'agent' => $tmp_user->name
            //         ];
            //     }
            // }

            // $proceeded = ProceededLead::where('assigned', 1)->get();
            // foreach ($proceeded as $key => $item) {
            //     $user = UserProceededLead::where('proceeded_lead_id', $item->id)->first();
            //     $tmp_user = User::where('id', $user->user_id)->first();
            //     $tmp = Data::where('id', $item->data_id)->first();

            //     if (!in_array($tmp->id, array_column($leads_list, 'id'))) {
            //         $leads_list[] = [
            //             'id' => $tmp->id,
            //             'name' => $tmp->NAME,
            //             'phone' => $tmp->PHONE,
            //             'email' => $tmp->EMAIL,
            //             'agent' => $tmp_user->name
            //         ];
            //     }
            // }

            // $books = booktable::where('assigned', 1)->get();
            // foreach ($books as $key => $item) {
            //     $user = UserLeadsPool::where('leads_pool_id', $item->id)->first();
            //     if ($user) {
            //         $tmp_user = User::where('id', $user->user_id)->first();
            //         $tmp = Data::where('id', $item->data_id)->first();

            //         if (!in_array($tmp->id, array_column($leads_list, 'id'))) {
            //             $leads_list[] = [
            //                 'id' => $tmp->id,
            //                 'name' => $tmp->NAME,
            //                 'phone' => $tmp->PHONE,
            //                 'email' => $tmp->EMAIL,
            //                 'agent' => $tmp_user != '' ? $tmp_user->name : ''
            //             ];
            //         }
            //     }
            // }

            // $dataTabel = Data::where('assigned', 1)->get();
            // foreach ($dataTabel as $key => $item) {
            //     $user = UserData::where('data_id', $item->id)->first();
            //     if ($user) {
            //         $tmp_user = User::where('id', $user->user_id)->first();

            //         if (!in_array($item->id, array_column($leads_list, 'id'))) {
            //             $leads_list[] = [
            //                 'id' => $item->id,
            //                 'name' => $item->NAME,
            //                 'phone' => $item->PHONE,
            //                 'email' => $item->EMAIL,
            //                 'agent' => $tmp_user != '' ? $tmp_user->name : ''
            //             ];
            //         }
            //     }
            // }

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        $soruces = DB::select(DB::raw('select DISTINCT * from (SELECT DISTINCT booktables.source from booktables join user_leads_pools on user_leads_pools.leads_pool_id = booktables.id WHERE booktables.assigned=1 UNION ALL SELECT DISTINCT data.source from data join user_data on user_data.data_id=data.id where data.assigned=1) as aa GROUP BY aa.source;'));

        return view('admin.reportassignedagentsleads', ['soruces' => $soruces]);
    }

}
