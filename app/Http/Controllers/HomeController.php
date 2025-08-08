<?php

namespace App\Http\Controllers;

use Str;
use File;
use Response;
use Exception;
use App\Models\ge;
use Carbon\Carbon;
use App\Models\Data;
use App\Models\User;
use PHPUnit\Util\Json;
use App\Models\Payment;
use App\Models\BookView;
use App\Models\Campaign;
use App\Models\Property;
use App\Models\Building;
use App\Models\sendinbluewhatsapptemplate;
use App\Models\UserBook;
use App\Models\UserData;
use App\Models\WonLeads;
use App\Mail\leadesemail;
use App\Models\booktable;
use App\Models\DeadLeads;
use App\Models\Inventory;
use Carbon\CarbonInterval;
use App\Models\NewProperty;
use App\Models\LandingAgent;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use App\Models\BayutProperty;
use App\Models\EmiratesProperty;
use App\Models\FinderProperty;
use App\Models\DubizzleProperty;
use App\Models\FollowUpLeads;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use App\Models\QualifiedLeads;
use App\Mail\SendAgentInfoMail;
use App\Models\UserDataComment;
use Illuminate\Validation\Rule;
use App\Imports\InventoryImport;
use Khill\Lavacharts\Lavacharts;
use Yajra\DataTables\DataTables;
use App\Models\PropertyFloorPlan;
use Illuminate\Support\Facades\DB;
use App\Models\sendinblue_templates;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EnquriyCustomerImport;
use App\Mail\appoentment;
use App\Mail\appoentmentData;
use App\Mail\appoentmentphotographer;
use App\Mail\SendConfirmedReport;
use App\Mail\SendMailToPhotographer;
use App\Mail\SendRejectionReport;
use App\Models\AgentAttendance;
use App\Models\Appointment;
use App\Models\calender;
use App\Models\Comment;
use App\Models\Community;
use App\Models\event;
use App\Models\event_attendance;
use App\Models\Meeting;
use App\Models\PhotosheetType;
use App\Models\ProceededLead;
use Illuminate\Support\Facades\Storage;
use App\Models\session as ModelsSession;
use App\Models\Setting;
use App\Models\SubCommunity;
use App\Models\UserFollowUpLeads;
use App\Models\UserFollowUpLeadsComment;
use App\Models\UserLeadsPool;
use App\Models\UserLeadsPoolComment;
use App\Models\UserQualifiedLeads;
use App\Models\usersleadshistory;
use App\Models\UserProceededLead;
use App\Models\UserProceededLeadComment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;
use DateTime;
use Illuminate\Support\Facades\Http;


class HomeController extends Controller
{
    use SendEmailT;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showbooksindex()
    {
        $userstatus = config('app.user_status');
        $campaignsources = Campaign::pluck('name');
        return view('admin.showbooks', ['userstatus' => $userstatus, 'campaignsources' => $campaignsources]);
    }
    public function createleadindex()
    {

        if (Auth::user()->isPhotographer()) {
            return redirect()->route('show_appointment_index');
        } else {
            return view('admin.createlead');
        }
    }
    public function createnewlead(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required',
                'pphone' => 'required|regex:/^\+(?:[0-9] ?){8,13}[0-9]$/',
                'source' => 'required'
            ],
            [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'pphone.required' => 'The phone field is required.',
                'pphone.regex' => 'Please enter valid phone number',
                'pphone.unique' => 'This phone number is already in use',
            ]
        );

        $exist = Data::where('phone', $request->pphone)->where('source', $request->source)->count();
        if ($exist > 0) {
            return response()->json(['success' => false, 'message' => 'Phone number already exists in this source']);
        }

        if (Auth::user()->isagent()) {
            // add to data
            $data = Data::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' =>  $request->pphone,
                'source' => $request->source,
                'Project' => $request->project,
                'property_type' => $request->property_type,
                'location' => $request->location,
                'agents' => Auth::user()->name,
                'data_status' => 8,
                'previous_status' => 0,
                'is_campaign' => 1,
                'assigned' => true
            ]);
            $user = booktable::create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'campaign_name' => $data->source,
                'source' => $data->source,
                'project' => $data->Project,
                'property_type' => $data->property_type,
                'location' => $data->location,
                'data_id' => $data->id,
                'previous_state' => '0',
                'previous_state_id' => $data->id,
                'created_by' => Auth::user()->id,
                'assigned' => true
            ]);
            $userdata = new UserLeadsPool;
            $userdata->user_id = Auth::user()->id;
            $userdata->leads_pool_id = $user->id;
            $userdata->save();
        } else {
            // add to data
            $data = Data::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' =>  $request->pphone,
                'source' => $request->source,
                'Project' => $request->project,
                'property_type' => $request->property_type,
                'location' => $request->location,
                'agents' => Auth::user()->name,
                'data_status' => 8,
                'previous_status' => 0,
                'is_campaign' => 1,
            ]);
            // add data to leads pool
            $user = booktable::create([
                'name' => $data->name,
                'email' => $data->email,
                'phone' => $data->phone,
                'campaign_name' => $data->source,
                'source' => $data->source,
                'project' => $data->Project,
                'property_type' => $data->property_type,
                'location' => $data->location,
                'data_id' => $data->id,
                'previous_state' => '0',
                'previous_state_id' => $data->id,
                'created_by' => Auth::user()->id,
            ]);
        }
        if ($user != null)
            return response()->json(['success' => true, 'message' => 'Lead created successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error in creating new lead']);
    }

    public function assignagentforlanding()
    {
        $agents = User::where('role_id', 'like', '%3%')->select('id', 'name')->get();
        $campaigns = Campaign::select('id', 'name')->get();
        return view('admin.assignagentforlandingpage', ['agents' => $agents, 'campaigns' => $campaigns]);
    }

    public function assignagenttolandpage(Request $request)
    {
        $request->validate([
            'landingname' => 'required',
            'agent' => 'required|exists:users,id'
        ]);
        try {
            $landingagent = LandingAgent::create([
                'landing_name' => $request->landingname,
                'user_id' => $request->agent
            ]);
            if ($landingagent)
                return response()->json(['success' => true, 'message' => 'Assign proccess completed successfully']);
            else
                return response()->json(['success' => false, 'message' => 'Error while assigning proccess']);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function deletelanding(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|exists:landing_agents,id'
            ]
        );
        $landingagent = LandingAgent::find($request->id);

        $res = $landingagent->delete();
        if ($res)
            return response()->json(['success' => true, 'message' => 'Landing agent has been deleted successfully']);
        else
            return response()->json(['success' => false, 'message' => 'Error hapen while delete landing agent']);
    }

    public function listassignedlandingagent()
    {
        $data = LandingAgent::all();
        $agents = User::all();
        $campaigns = Campaign::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('agentname', function ($row) use ($agents) {
                $agentname = $agents->where('id', $row->user_id)->first();
                if ($agentname != null)
                    return $agentname->email;
            })
            ->addColumn('landing_name', function ($row) use ($campaigns) {
                $landingname = $campaigns->where('id', $row->landing_name)->first();
                if ($landingname != null)
                    return $landingname->name;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function getcustomerpaymentsinfo(Request $request)
    {
        if (Auth::user()->isadmin()) {
            if ($request->propertyname == null) {
                $userpayments = Payment::where('buyer_id', $request->userid)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', $request->userid)->count();
            } else {
                $userpayments = Payment::where('buyer_id', $request->userid)->where('property', $request->propertyname)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', $request->userid)->where('name', $request->propertyname)->count();
            }
            return response()->json([
                'success' => true,
                'totalpaymentscount' => $totalpaymentscount,
                'totalpaymentsamount' => $totalpaymentsamount,
                'totalpropertiescount' => $totalpropertiescount
            ]);
        } else if (Auth::user()->iscustomer()) {
            if ($request->propertyname == null) {
                $userpayments = Payment::where('buyer_id', Auth::user()->id)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', Auth::user()->id)->count();
            } else {
                $userpayments = Payment::where('buyer_id', Auth::user()->id)->where('property', $request->propertyname)->get();
                $totalpaymentscount = $userpayments->count();
                $totalpaymentsamount = $userpayments->sum('payment_amount');
                $totalpropertiescount = Property::where('buyer_id', Auth::user()->id)->where('name', $request->propertyname)->count();
            }
            return response()->json([
                'success' => true,
                'totalpaymentscount' => $totalpaymentscount,
                'totalpaymentsamount' => $totalpaymentsamount,
                'totalpropertiescount' => $totalpropertiescount
            ]);
        }
    }

    public function getcustomerpropertiesinfo(Request $request)
    {
        $customerproperties = Property::where('buyer_id', $request->userid)->get();
        $totalpropertiescount = $customerproperties->count();
        $totalpropertiesamount = $customerproperties->sum('price');
        return response()->json([
            'success' => true,
            'totalpropertiescount' => $totalpropertiescount,
            'totalpropertiesamount' => $totalpropertiesamount
        ]);
    }

    // assign agent data
    public function assignagentdataindex()
    {
        // jsut for normal agent and aconsultant agent
        $users = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $address = Data::select('ADDRESS')->distinct()->where('is_campaign', '0')->get();
        $emirates = Data::select('EMIRATE')->distinct()->where('is_campaign', '0')->get();
        $residencecountries = Data::select('RESIDENCE_COUNTRY')->distinct()->where('is_campaign', '0')->get();
        $nationalities = Data::select('NATIONALITY')->where('is_campaign', '0')->distinct()->get();
        $datasources = Data::select('source')->where('is_campaign', '0')->distinct()->get();
        $areas = Data::select('AREA')->where('is_campaign', '0')->distinct()->get();
        return view('admin.assignagentdata', ['datasources' => $datasources, 'users' => $users, 'address' => $address, 'emirates' => $emirates, 'residencecountries' => $residencecountries, 'nationalities' => $nationalities, 'areas' => $areas]);
    }

    public function showcommenteddata()
    {
        $users = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $comments = UserData::select('comment')->distinct()->get();
        $emirates = Data::select('EMIRATE')->where('is_campaign', '0')->distinct()->get();
        $residencecountries = Data::select('RESIDENCE_COUNTRY')->where('is_campaign', '0')->distinct()->get();
        $userstatus = config('app.user_status');
        $datasource = Data::select('source')->where('is_campaign', '0')->groupby('source')->get();
        return view('admin.showusercommenteddata', [
            'users' => $users,
            'comments' => $comments,
            'userstatus' => $userstatus,
            'emirates' => $emirates,
            'residences' => $residencecountries,
            'datasource' => $datasource
        ]);
    }


    public function showbookviewsindex()
    {
        return view('showbookview');
    }


    public function importenquirycustomer(Request $request)
    {
        try {
            if ($request->file == 'undefined')
                return response()->json(['success' => false, 'message' => 'You should select file first']);
            $validator = Validator::make(
                [
                    'file' => $request->file,
                    'extension' => strtolower($request->file->getClientOriginalExtension()),
                ],
                [
                    'file' => 'required',
                    'extension' => 'required|in:csv',
                ]
            );

            $validator->validate();
            Excel::import(new EnquriyCustomerImport, $request->file('file'));
            return response()->json(['success' => true, 'message' => 'File imported successfully']);
        } catch (Exception $ex) {
            dd($ex);
        }
    }
    public function showbooks(Request $request)
    {
        $users = User::all();
        $userbook = UserBook::all();
        if ($request->campaignsource == '' && $request->userstatus == '') {
            $data = booktable::orderBy('created_at', 'DESC')->get();
        } else if ($request->campaignsource != '' && $request->userstatus == '') {
            $data = booktable::where('campaign_name', $request->campaignsource)->orderBy('created_at', 'DESC')->get();
        } else if ($request->campaignsource == '' && $request->userstatus != '') {
            $userbk = UserBook::where('userstatus', $request->userstatus)->groupBy('book_id')->pluck('book_id');
            $data = booktable::whereIn('id', $userbk)->orderBy('created_at', 'DESC')->get();
        } else {
            $userbk = UserBook::where('userstatus', $request->userstatus)->groupBy('book_id')->pluck('book_id');
            $data = booktable::whereIn('id', $userbk)->where('campaign_name', $request->campaignsource)->orderBy('created_at', 'DESC')->get();
        }

        $userstates = config('app.user_status');
        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at', function ($user) {
                return date('d-m-Y h-m-s', strtotime($user->created_at));
            })
            ->addColumn('action', function ($row) {
                if ($row->is_enquiry_customer) {
                    $actionBtn = '<a class="delete btn btn-danger btn-md ml-3">Delete</a>' . " ";
                    $actionBtn .= '<a style="background-color:#70cacc" class="edit btn btn-info btn-md ml-1">Edit</a>';
                    return $actionBtn;
                }
            })
            ->addColumn('comments', function ($row) use ($userbook, $users) {
                $values = $userbook->where('book_id', $row->id);
                $res = "";
                foreach ($values as $key => $value) {
                    $user = $users->where('id', $value->user_id)->first();
                    if ($user != null) {
                        $comment = '<div class="row"> <h4> ' . $value->comment . '</h4> , <div style="color:#70cacc">&nbsp;&nbsp;' . $value->userstatus . ' </div> </div> <div class="row"> <h6>' . $user->name . ', ' . $value->created_at . '</h6> </div>';
                        // $comment = '<input style="border-width:0px;border:none;" class="form-control" id="comment mr-2' . $row->id . '" name="comment" value= "' . $user->name .', ' .  $value->comment . ', ' . $value->created_at . '" type="text" >';
                        $res .= $comment;
                    }
                }
                return $res;
                // if ($res != null)
                // else
                //     return '<input class="form-control trackInput" id="comment mr-2' . $row->id . '" name="comment" value="" type="text" >';
            })
            ->addColumn('customerstatus', function ($row) use ($userstates) {
                $userbook = UserBook::select(DB::raw("COUNT(*) as count_row"), 'userstatus')->where('book_id', $row->id)->groupBy('userstatus')->orderBy('count_row', 'desc')->pluck('userstatus', 'count_row')->first();
                $options = '<select name="" class="form-control ml-2" id="">';
                $options .= "<option> </option>";
                foreach ($userstates as $key => $value) {
                    if ($userbook != null) {
                        if ($value == $userbook)
                            $options .= '' . $value . ' selected>' . $value . '</option>';
                        else
                            $options .= '' . $value . '>' . $value . '</option>';
                    } else {
                        $options .= '<option class="selected" value=' . $value . '>' . $value . '</option>';
                    }
                }
                $options .= '</select>';
                return $options;
            })
            ->addColumn('comment', function ($row) {
                return '<input class="form-control trackInput ml-3 mr-3" id="comment' . $row->id . '" name="comment" value="" type="text" >';
            })
            ->addColumn('addcomment', function ($row) {
                return '<input style="background-color:#70cacc" class="btn btn-md btn-success ml-4 addcomment" value="Add" id="addcomment' . $row->id . '" name="addcomment" type="button" >';
            })
            ->rawColumns(['action', 'comments', 'customerstatus', 'comment', 'addcomment'])
            ->make(true);
    }

    public function showbookviews()
    {
        $data = BookView::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn = '<a class="delete btn btn-danger btn-sm">Delete</a>' . " ";
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function getLavaChart()
    {
        $lava = new Lavacharts;
        $COUNTS = DB::table('data')
            ->select("NATIONALITY as first", DB::raw("COUNT(NATIONALITY) as second"))
            ->groupby('NATIONALITY')
            ->get()->toArray();
        $array = [];
        foreach ($COUNTS as $count) {
            array_push($array, ['0' => $count->first, '1' => $count->second]);
        }


        // foreach ($COUNTS as $COUNT) {
        //     ge::updateOrCreate([
        //         'first' => $COUNT->NATIONALITY,
        //         'second' => $COUNT->second
        //     ],[
        // 'first' =>  $COUNT->NATIONALITY ,
        // 'second' => $COUNT->second ,
        // ]);
        // }
        // $ss = DB::table('data')
        // ->select('NATIONALITY', DB::raw('COUNT(NATIONALITY)'))
        // ->groupby('NATIONALITY')
        // ->get()->toArray();
        // dd($ss);


        $users = $lava->DataTable();
        // $data = ge::select("first as 0","second as 1")->get()->toArray();
        $users->addStringColumn('Country');
        $users->addNumberColumn('Users');
        $users->addRows($array);
        $lava->GeoChart('Users', $users, [
            'colorAxis' => ['green'],   //ColorAxis Options
            'enableRegionInteractivity' => true,
            'keepAspectRatio' => true,
            'minZoom' => true,
            //SizeAxis Options
        ]);


        return view('lavacharts', compact('lava'));
    }

    public function getProgressB()
    {
        try {
            $totalexcelrows = session('constvar1988', 0) + session('constvar1989', 0);
            $starttime = new DateTime(session('starttime'));
            $elapsedtime = now()->getTimestamp() - $starttime->getTimestamp();
            $minutes = intval($elapsedtime / 60);
            $seconds = $elapsedtime % 60;
            $res = [
                'imported' => session('constvar1988', 0),
                'duplicated' => session('constvar1989', 0),
                'processstatus' => session('processstatus', 0),
                'filename' => session('filename', ''),
                'filesize' => session('filesize', 0),
                'totalexcelrows' => $totalexcelrows,
                'elapsedtime' => isset($minutes) ? $minutes . ' m, ' . $seconds . ' s' : ''
            ];
            return $res;
        } catch (Exception $ex) {
            $res = [
                'imported' => 0,
                'duplicated' => 0,
                'processstatus' => 0,
                'filename' => '',
                'filesize' => 0,
                'totalexcelrows' => 0,
                'starttime' => 0
            ];
            return $res;
        }
    }

    public function getImportStatus()
    {
        return session('processstatus', 0);
    }

    public function finishImportStatus()
    {
        session()->put(['processstatus' => 0]);
        session::save();
    }

    public function startImportStatus()
    {
        session()->put(
            [
                'processstatus' => 1,
                'starttime' => now(),
                'imported' => 0,
                'duplicated' => 0
            ]
        );
        session::save();
    }

    public function clearProgressBar()
    {
        session::forget('filename');
        session::forget('filesize');
        session::forget('starttime');
        session::forget('processstatus');
        session::forget('constvar1988');
        session::forget('constvar1989');
        session::forget('imported');
        session::forget('duplicated');
    }

    public function agentdata()
    {
        $areas = Data::select('AREA')->distinct()->where('AREA', '<>', '')->where('is_campaign', '0')->get();
        $emirates = Data::select('EMIRATE')->distinct()->where('EMIRATE', '<>', '')->where('is_campaign', '0')->get();
        $residences = Data::select('RESIDENCE_COUNTRY')->distinct()->where('RESIDENCE_COUNTRY', '<>', '')->where('is_campaign', '0')->get();
        $datasource = Data::select('source')->groupby('source')->where('is_campaign', '0')->get();

        if (Auth::user()->isadmin())
            return view('admin.agentdata')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences)->with('datasource', $datasource);
        else
            return view('agent.userhome')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences);
    }

    public function index()
    {
        $areas = Data::select('AREA')->distinct()->where('AREA', '<>', '')->where('is_campaign', '0')->get();
        $emirates = Data::select('EMIRATE')->distinct()->where('EMIRATE', '<>', '')->where('is_campaign', '0')->get();
        $residences = Data::select('RESIDENCE_COUNTRY')->distinct()->where('RESIDENCE_COUNTRY', '<>', '')->where('is_campaign', '0')->get();
        $userstates = config('app.user_status');
        $datasource = Data::select('source')->groupby('source')->where('is_campaign', '0')->get();
        $templet_name = sendinblue_templates::get();
        $template_whatsapps = sendinbluewhatsapptemplate::get();

        if (Auth::user()->isadmin())
            return view('admin.home')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences)->with('datasource', $datasource)->with('templetname', $templet_name)->with('templatewhatsapps', $template_whatsapps);
        else
            return view('agent.userhome')->with('areas', $areas)
                ->with('emirates', $emirates)->with('residences', $residences)->with('userstates', $userstates)->with('datasource', $datasource)->with('templetname', $templet_name)->with('datasource', $datasource)->with('templetname', $templet_name)->with('templatewhatsapps', $template_whatsapps);
    }

    public function index1()
    {
        $areas = Data::select('AREA')->distinct()->where('AREA', '<>', '')->get();
        $emirates = Data::select('EMIRATE')->distinct()->where('EMIRATE', '<>', '')->get();
        $residences = Data::select('RESIDENCE_COUNTRY')->distinct()->where('RESIDENCE_COUNTRY', '<>', '')->get();
        $userstatus = config('app.user_status');
        $datasource = Data::select('source')->groupby('source')->get();
        return view('agent.userhomeshow')->with('areas', $areas)
            ->with('emirates', $emirates)->with('residences', $residences)->with('userstatus', $userstatus)->with('datasource', $datasource);
    }

    public function map()
    {
        $markers = DB::table('data')->select('lng', 'lat')->where(
            [
                ['lng', '<>', null],
                ['lat', '<>', null],
                ['lat', '<>', ''],
                ['lat', '<>', ''],
            ]
        )->distinct()->get();

        $emptyMarker = DB::table('data')->select('lng', 'lat')->where(
            [
                ['lng', '=', null],
                ['lat', '=', null],
            ]
        )->get();

        return view('admin.map', compact('markers', 'emptyMarker'));
    }

    public function uploadedFiles()
    {
        $files = DB::table('uploaded_files')->select('id', 'fileName', 'created_at', 'numberofimportedrows')->distinct()->get();
        $totaRowsCount = 0;
        foreach ($files as $value) {
            $totaRowsCount += intval($value->numberofimportedrows);
        }
        return view('admin.uploadedFiles', compact('files', 'totaRowsCount'));
    }

    public function downloadFile($fileName)
    {
        $file = 'uploadedFiles/' . $fileName;
        $headers = array(
            'Content-Type: application/octet-stream',
        );


        return Response::download($file, $fileName, $headers);
    }

    function getall()
    {
        try {
            // $data = Data::all();
            return (Datatables::of(Data::all())->make(true));
        } catch (Exception $th) {
            dd($th);
        }
    }

    public function filterIng($emirates, $area, $residence)
    {
        if ($emirates == 'Show' && $area == 'Show' && $residence == 'Show') {
            $data = DB::table('data')->limit(100)->get();
            return $data;
        }


        $data = DB::table('data')
            ->where('EMIRATE', $emirates)
            ->orWhere('RESIDENCE_COUNTRY', $residence)
            ->orWhere('AREA', $area)->get();
        return $data;
    }

    public function search(Request $request)
    {
        $emirates = $request->emirates;
        $datasource = $request->datasource;
        $residence = $request->residence;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $filtertext = $request->searchday;
        $datasource = $request->datasource;
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
        // search between range
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
            $sdate = $sdate->subDay();
        }

        //
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        if (Auth::user()->isadmin()) {
            $commenteddata = UserDataComment::select('data_id')->pluck('data_id')->toArray();
            $data = Data::whereNotIn('id', $commenteddata)->orderBy('created_at', 'DESC')->where('is_campaign', '0');
        } else {
            $commenteddata = Auth::user()->userdatacomment()->pluck('data_id');
            $data =  Auth::user()->data()->whereNotIn('data.id', $commenteddata)->where('data.data_status', '0');
        }

        if (!is_null($emirates) && $emirates != "Show")
            $data->where('EMIRATE', 'LIKE', '%' . $emirates . '%');
        // if (!is_null($area) && $area != "Show")
        //     $data->where('AREA', 'LIKE', '%' . $area . '%');
        if (!is_null($residence) && $residence != "Show") {
            $data->where('RESIDENCE_COUNTRY', 'LIKE', '%' . $residence . '%');
        }
        if (!is_null($datasource) && $datasource != "Show")
            $data->where('source', '=', $datasource);

        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2) {
            $data->whereBetween('DOB', [$sdate, $edate]);
        }
        if (!is_null($monthfiltertext))
            $data->whereMonth('DOB', '=', $monthfiltertext);

        if (!is_null($searchdaytext))
            $data->whereDay('DOB', '=', $searchdaytext);

        if (Auth::user()->isadmin()) {
            return DataTables::of($data)
                ->addcolumn('check', function () {
                    return null;
                })
                ->rawColumns(['check'])
                ->make(true);
        } else {
            return DataTables::of($data)
                ->addColumn('addComment', function ($row) {
                    return '<div class="col-md-7"><input type="text" class="form-control w-100" id="comment' . $row->data_id . '" name=""></div>' .
                        '<div class="row mt-3">' .
                        '<div class="col-md-3 ml-1 mt-1 btn-group btn-group-sm">' .
                        '<button onclick="add_comment(' . $row->data_id . ')" type="button" id="' . $row->data_id . '" class="btn btn-primary btn-sm mr-2">Add</button>' .
                        '<button  type="button" onclick="add_calender(' . $row->data_id . ')" class=" calender1 btn btn-primary btn-sm mr-2" >Calenda</button>' .
                        '<button onclick="show_comment(' . $row->data_id . ')" type="button" id="' . $row->data_id . '" class="show-com btn btn-primary btn-sm ml-1">Show Comments</button>' .
                        '</div>' .
                        '</div>' .
                        '<div id="calendar-appointment' . $row->data_id . '" class="mt-3" style="text-align:center;color:red;width:250px"></div>';
                })
                ->addColumn('userStatus', function ($row) {
                    return '<div class="row">' .
                        '<div class="col-md-7"><select name="userstatus" class="form-control w-75" id="userstatus' . $row->data_id . '" onchange="user_status_change_event(' . $row->data_id . ')">' .
                        '<option selected value="">User status</option>' .
                        '<optgroup label="Dead">' .
                        '<option value="Others">Others</option>' .
                        '<option value="Invalid Number & Email">Invalid Number & Email</option>' .
                        '<option value="Wrong Number & Email">Wrong Number & Email</option>' .
                        '<option value="Number & Email Unavailable">Number & Email Unavailable</option>' .
                        '<option value="Not interested">Not interested</option>' .
                        '</optgroup>' .
                        '<optgroup label="Follow Up">' .
                        '<option value="Interested">Interested</option>' .
                        '<option value="Not Answered">Not Answered</option>' .
                        '<option value="Mobile Switched off">Mobile Switched off</option>' .
                        '<option value="Line Busy">Line Busy</option>' .
                        '<option value="Contacted Via Email">Contacted Via Email</option>' .
                        '</optgroup>' .
                        '<optgroup label="Qualified">' .
                        '<option value="Appointment is set">Appointment is set</option>' .
                        '</optgroup>' .
                        '</select></div>' .
                        '<div class="col-md-2 ml-3 mt-1">' .
                        '<button onclick="btn_click_add_comment(' . $row->data_id . ')" type="button" id="' . $row->data_id . '" class="btn btn-primary btn-sm">Set</button></div>';
                })->addColumn('check', function ($row) {
                    return null;
                })
                ->rawColumns(['addComment', 'check', 'userStatus'])
                ->make(true);
        }
    }

    public function search1(Request $request)
    {
        $userid = Auth::user()->id;
        $userstatus = $request->userstatus;
        $datasource = $request->datasource;
        $filtertext = $request->searchday;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $emirates = $request->emirates;
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
        // search between range
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
        }

        //
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        $data = UserData::join('user_data_comment', function ($join) {
            $join->on('user_data.data_id', '=', 'user_data_comment.data_id')
                ->on('user_data.user_id', '=', 'user_data_comment.user_id');
        })
            ->join('data', 'data.id', '=', 'user_data.data_id')
            ->join('users', 'users.id', '=', 'user_data_comment.user_id')
            ->where('user_data_comment.user_id', $userid)
            ->select(
                'data.PHONE',
                'data.EMAIL',
                'data.NAME',
                'data.EMIRATE',
                'data.ADDRESS',
                'data.GENDER',
                'data.DOB',
                'data.MOBILE',
                'data.SECONDARY_MOBILE',
                'data.Project',
                'data.source',
                'data.lat',
                'data.lng',
                'data.RESIDENCE_COUNTRY',
                'data.NATIONALITY',
                'user_data.data_id',
                'data.Agents',
                'user_data.user_id',
                'users.name as agentname',
                'user_data_comment.userstatus',
                'user_data_comment.comment as comment',
                'user_data_comment.appointment_date',
                'user_data_comment.created_at',
                'data.*'
            );


        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_data_comment.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_data_comment.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_data_comment.created_at', '=', $searchdaytext);
        if ($userstatus != null)
            $data = $data->where('user_data_comment.userstatus', $userstatus);

        if ($emirates != null)
            $data = $data->where('data.emirate', $emirates);

        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('data.source', $datasource);

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
                    $comment = '<div class="row ml-1" style="background-color:#DAF7A6"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else if ($row->userstatus == "Set appointment")
                    $comment = '<div class="row ml-1" style="background-color:#F9C4F8"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> <p><b>Appointment date: </b> ' . $row->appointment_date . '</p> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                else
                    $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                return $comment;
            })
            ->rawColumns(['comments'])
            ->make(true);
    }

    public function search2(Request $request)
    {
        $emirates = $request->emirates;
        $area = $request->area;
        $residence = $request->residence;
        $datasource = $request->datasource;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $filtertext = $request->searchday;
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
        // search between range
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
            $sdate = $sdate->subDay();
        }

        //
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }
        try {
            $data = Data::where('is_campaign', '0')->latest();

            if (!is_null($emirates) && $emirates != "Show")
                $data = $data->where('EMIRATE', $emirates);
            if (!is_null($area) && $area != "Show")
                $data = $data->where('AREA', $area);
            if (!is_null($residence) && $residence != "Show") {
                $data = $data->where('RESIDENCE_COUNTRY', $residence);
            }
            if (!is_null($datasource) && $datasource != "Show")
                $data = $data->where('source', '=', $datasource);
            if (!is_null($sdate) && !is_null($edate) && $filtertype == 2) {
                $data = $data->whereBetween('DOB', [$sdate, $edate]);
            }
            if (!is_null($monthfiltertext))
                $data = $data->whereMonth('DOB', '=', $monthfiltertext);

            if (!is_null($searchdaytext))
                $data = $data->whereDay('DOB', '=', $searchdaytext);

            return DataTables::of($data)
                ->addcolumn('check', function () {
                    return null;
                })
                ->rawColumns(['check'])
                ->make(true);
        } catch (Exception $th) {
            // dd($th);
        }
    }


    public function deletecomment(Request $request)
    {
        try {
            $dataid = $request->id;
            $data = Data::find($dataid);
            // 5 won leads
            // 6 dead leads
            // 7 qualified leads
            // 8 leads pool
            // 9 follow up leads

            if ($data) {
                try {
                    if ($data->data_status == 5) {
                        $wondata = WonLeads::where('data_id', $dataid)->first();
                        Data::find($dataid)->update(['data_status' => $wondata->previous_state, 'previous_status' => 0]);
                        $wondata->delete();
                    } else if ($data->data_status == 6) {
                        $deaddata = DeadLeads::where('data_id', $dataid)->first();
                        Data::find($dataid)->update(['data_status' => $deaddata->previous_state, 'previous_status' => 0]);
                        $deaddata->delete();
                    } else if ($data->data_status == 7) {
                        $qualifieddata = QualifiedLeads::where('data_id', $dataid)->first();
                        Data::find($dataid)->update(['data_status' => $qualifieddata->previous_state, 'previous_status' => 0]);
                        $qualifieddata->delete();
                    } else if ($data->data_status == 8) {
                        $leadspool = booktable::where('data_id', $dataid)->first();
                        Data::find($dataid)->update(['data_status' => $leadspool->previous_state, 'previous_status' => 0]);
                        $leadspool->delete();
                    } else if ($data->data_status == 9) {
                        $followupleads = FollowUpLeads::where('data_id', $dataid)->first();
                        Data::find($dataid)->update(['data_status' => $followupleads->previous_state, 'previous_status' => 0]);
                        $followupleads->delete();
                    }
                    $data = UserData::where('user_id', Auth::user()->id)->where('data_id', $dataid)->first();
                    $data->comment = null;
                    $data->userstatus = null;
                    $data->save();
                    UserDataComment::where('user_id', Auth::user()->id)->where('data_id', $dataid)->delete();
                } catch (Exception $ex) {
                    return response()->json(['success' => false, 'message' => "Data cannot be deleted"]);
                }
                return response()->json(['success' => true, 'message' => "Data comment has been deleted successfully"]);
            } else
                return response()->json(['success' => false, 'message' => "Data not found"]);
        } catch (Exception $ex) {
        }
    }

    public function addcomment(Request $request)
    {
        // dd($request->all());
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
                UserDataComment::create([
                    'data_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus,
                    'appointment_date' => $request->appointment_date
                ]);

                // change data status to won leads
                $data = Data::find($request->checkedrow);
                $data->previous_status = $data->data_status;
                $data->data_status = 7;
                $data->save();

                $qualifieddata = QualifiedLeads::create([
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'phone' => $data->PHONE,
                    'mobile' => $data->MOBILE,
                    'phone_whatsapp' => $data->phone_whatsup,
                    'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                    'source' => $data->source,
                    'project' => $data->Master_Project,
                    'title' => $data->unique,
                    'data_id' => $data->id,
                    'previous_state' => '0',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true
                ]);

                Comment::create([
                    'user_id' => Auth::user()->id,
                    'data_id' => $data->id,
                    'comment' => $request->comment,
                    'appoentment_date' => $request->appointment_date,
                    'stage' => '1'
                ]);

                $userdata = new UserQualifiedLeads([
                    'user_id' => Auth::user()->id,
                    'qualified_leads_id' => $qualifieddata->id
                ]);
                $userdata->save();
            }
            // } elseif ($request->userstatus == "Paid") {
            //     UserDataComment::create([
            //         'user_id' => Auth::user()->id,
            //         'data_id' => $request->checkedrow,
            //         'comment' => $request->comment,
            //         'userstatus' => $request->userstatus
            //     ]);
            //     $data = Data::find($request->checkedrow);
            //     $data->previous_status = $data->data_status;
            //     $data->data_status = 5;
            //     $data->save();
            //     WonLeads::create([
            //         'name' => $data->NAME,
            //         'email' => $data->EMAIL,
            //         'phone' => $data->PHONE,
            //         'mobile' => $data->MOBILE,
            //         'phone_whatsapp' => $data->phone_whatsup,
            //         'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
            //         'source' => $data->source,
            //         'project' => $data->Master_Project,
            //         'title' => $data->unique,
            //         'data_id' => $data->id,
            //         'previous_state' => '0',
            //         'previous_state_id' => $request->checkedrow,
            //         'created_by' => Auth::user()->id
            //     ]);
            // }
            elseif ($request->userstatus == "Not interested" || $request->userstatus == "Number & Email Unavailable" || $request->userstatus == "Wrong Number & Email" || $request->userstatus == "Invalid Number & Email" || $request->userstatus == "Cancelation after appointment" || $request->userstatus == "Others") {
                // add comment
                UserDataComment::create([
                    'data_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);
                // add data to own leads
                $data = Data::find($request->checkedrow);
                DeadLeads::create([
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'phone' => $data->PHONE,
                    'mobile' => $data->MOBILE,
                    'phone_whatsapp' => $data->phone_whatsup,
                    'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                    'source' => $data->source,
                    'project' => $data->Master_Project,
                    'title' => $data->unique,
                    'data_id' => $data->id,
                    'previous_state' => '0',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id
                ]);

                // change data status to dead leads
                $data->previous_status = $data->data_status;
                $data->data_status = 6;
                $data->save();
            } else {
                // add comment
                UserDataComment::create([
                    'data_id' => $request->checkedrow,
                    'user_id' => Auth::user()->id,
                    'comment' => $request->comment,
                    'userstatus' => $request->userstatus
                ]);

                // change data status to qualified leads
                $data = Data::find($request->checkedrow);
                $data->previous_status = $data->data_status;
                $data->data_status = 9;
                $data->save();

                // add data to FollowUp leads
                $followupleads = FollowUpLeads::create([
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'phone' => $data->PHONE,
                    'mobile' => $data->MOBILE,
                    'phone_whatsapp' => $data->phone_whatsup,
                    'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                    'source' => $data->source,
                    'project' => $data->Master_Project,
                    'data_id' => $data->id,
                    'title' => $data->title,
                    'previous_state' => '0',
                    'previous_state_id' => $request->checkedrow,
                    'created_by' => Auth::user()->id,
                    'assigned' => true
                ]);
                $userdata = new UserFollowUpLeads([
                    'user_id' => Auth::user()->id,
                    'follow_up_id' => $followupleads->id,
                ]);
                $userdata->save();
            }

            return response()->json(['success' => true, 'message' => 'Comment entered successfully']);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return response()->json(['success' => false, 'message' => 'Error happen call system admin']);
        }
    }

    public function addleadcomment(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:booktables,id',
            'comment' => 'required'
        ]);
        try {
            if (Str::contains($request->comment, '['))
                return response()->json(['success' => false, 'message' => 'You should delete old comment then add new one']);
            $isuserbookfound = UserBook::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->where('comment', $request->comment)->count();
            if ($isuserbookfound == 0) {
                $userbook = UserBook::Create([
                    'user_id' => Auth::user()->id,
                    'book_id' => $request->book_id,
                    'comment' => $request->comment,
                    'userstatus' => $request->customerstate
                ]);
                if ($userbook != null)
                    return response()->json(['success' => true, 'message' => 'Comment created successfully']);
                else
                    return response()->json(['success' => false, 'message' => 'Error while creating Comment']);
            }
        } catch (Exception $ex) {
        }
    }

    public function serachforagentdata(Request $request)
    {
        $data = [];
        $user = User::find($request->userid);
        if ($user != null) {
            $temp = $user->data()->pluck('data.id');
            $data = Data::where('assigned', '0')->where('is_campaign', '0');
        }
        return DataTables::of($data)
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check'])
            ->make(true);
    }

    public function sendemailtoleads(Request $request)
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
            $data = Data::find($key);
            if ($data) {
                $details = [
                    'name' => $data->NAME,
                    'email' => $data->EMAIL,
                    'body' => $body
                ];
                $to[] = [
                    'email' => $data->EMAIL,
                    'name' => $data->NAME,
                ];
                // Mail::to($data->email)->send(new leadesemail($details));
            }
        };

        $data = [
            'to' => $to,
            'body' => $body,
            'template_id' => $templet_id
        ];

        return $this->SendEmail($data, $option);
    }

    public function changeclient(Request $request)
    {
        $wonleads = [];
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
        $id = array_map('intval', explode(',', $request->data_id));
        foreach ($id as $key) {
            $data = Data::find($key);
            if ($data->data_status == "7") {
                $qualifieddata = QualifiedLeads::where('data_id', $key)->first();
                UserQualifiedLeads::where('qualified_leads_id', $qualifieddata->id)->update(['user_id' => $request->user_id_change]);
                $comment = UserDataComment::where('data_id', $key)->where('user_id', $request->userid)->first();
                usersleadshistory::create([
                    'user_id' => $request->userid,
                    'data_id' => $key,
                    'userstatus' => $comment->userstatus, 'comment' => $comment->comment
                ]);
                UserData::where('data_id', $key)->update(['user_id' => $request->user_id_change]);
            }
            if ($data->data_status == "10") {
                $proceede = ProceededLead::where('data_id', $key)->first();
                UserProceededLead::where('proceeded_lead_id', $proceede->id)->update(['user_id' => $request->user_id_change]);
                $comment = UserDataComment::where('data_id', $key)->where('user_id', $request->userid)->first();
                usersleadshistory::create([
                    'user_id' => $request->userid,
                    'data_id' => $key,
                    'userstatus' => $comment->userstatus, 'comment' => $comment->comment
                ]);
                UserData::where('data_id', $key)->update(['user_id' => $request->user_id_change]);
            } elseif ($data->data_status == "0" || $data->data_status == "6") {
                UserData::where('data_id', $key)->update(['user_id' => $request->user_id_change]);
            } elseif ($data->data_status == "9") {
                $followupleads = FollowUpLeads::where('data_id', $key)->first();
                $comment = UserDataComment::where('data_id', $key)->where('user_id', $request->userid)->first();
                usersleadshistory::create([
                    'user_id' => $request->userid,
                    'data_id' => $key,
                    'userstatus' => $comment->userstatus, 'comment' => $comment->comment
                ]);
                UserData::where('data_id', $key)->update(['user_id' => $request->user_id_change]);
                UserFollowUpLeads::where('follow_up_id', $followupleads->id)->update(['user_id' => $request->user_id_change]);
            } elseif ($data->data_status == "8") {
                $comment = UserDataComment::where('data_id', $key)->where('user_id', $request->userid)->first();
                usersleadshistory::create([
                    'user_id' => $request->userid,
                    'data_id' => $key,
                    'userstatus' => $comment->userstatus, 'comment' => $comment->comment
                ]);
                UserData::where('data_id', $key)->update(['user_id' => $request->user_id_change]);
                $leadspool = booktable::where('data_id', $key)->first();
                UserLeadsPool::where('leads_pool_id', $leadspool->id)->update(['user_id' => $request->user_id_change]);
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

    public function assignagentdata(Request $request)
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
            // $userfound = UserData::where('user_id', $request->userid)->count();
            // if ($userfound > 0) {
            //     $currentuserdata = UserData::select('data_id')->where('user_id', $request->userid)->get();
            //     $repateddatalist = [];
            //     $notrepateddatalist = [];
            //     foreach ($data as $key => $item) {
            //         if ($currentuserdata->contains('data_id', $item))
            //             $repateddatalist[] = $item;
            //         else
            //             $notrepateddatalist[] = $item;
            //     }

            //     foreach ($notrepateddatalist as $key => $item) {
            //         $userdata[] = new UserData([
            //             'user_id' => $request->userid,
            //             'data_id' => $item
            //         ]);
            //     }
            //     $user = User::find($request->userid);
            //     $user->userdata()->saveMany($userdata);

            //     if (count($repateddatalist) > 0) {
            //         $request->session()->remove('repateddatalist');
            //         $request->session()->push('repateddatalist', $repateddatalist);
            //         return response()->json(['success' => false, 'message' => 'There are some duplicated data']);
            //     } else
            //         return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
            // } else {
            // }
            foreach ($data as $key => $item) {
                $userdata[] = new UserData([
                    'user_id' => $request->userid,
                    'data_id' => $item
                ]);
            }
            $user = User::find($request->userid);
            $user->userdata()->saveMany($userdata);
            // update data status
            $status = Data::whereIn('id', $data)->update(['assigned' => true]);
            $source = Data::whereIn('id', $data)->select('source')->groupBy('source')->get();
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
            return response()->json(['success' => true, 'message' => 'User data has been assigned successfully']);
        } catch (Exception $ex) {
            return response()->json(['success' => false, 'message' => 'Error while assign data for user']);
        }
    }

    // show assigned data for each egent for admin
    public function getassigneddataindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $datasources = Data::distinct()->where('is_campaign', '0')->pluck('source');
        return view('admin.showagentassigneddata', ['datasources' => $datasources, 'agentnames' => $agentnames, 'assigneddatacount' => 0, 'commenteddatacount' => 0]);
    }

    //////////// get assigned data for each agent for admin
    public function getassignedagentdata(Request $request)
    {
        $datasource = $request->datasource;
        $userdata = UserData::where('user_id', $request->userid)->pluck('data_id');
        $data = Data::whereIn('id', $userdata)->where('is_campaign', '0')->orderBy('created_at', 'DESC');
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        return DataTables::of($data)
            ->addcolumn('check', function () {
                return null;
            })
            ->rawColumns(['check'])
            ->make(true);
    }

    public function getassigneduserdatainfo(Request $request)
    {
        $assigneddatacount = UserData::where('user_id', $request->userid)->count();
        $commenteddatacount = UserDataComment::where('user_id', $request->userid)->count();
        return response()->json(['succssess' => true, 'assigneddatacount' => $assigneddatacount, 'commenteddatacount' => $commenteddatacount]);
    }

    public function getadmincommentedinfo(Request $request)
    {
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->userid;
        } else {
            $userid = Auth::user()->id;
        }
        $userstatus = $request->userstatus;
        $datasource = $request->datasource;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $emirates = $request->emirates;
        $filtertext = $request->searchday;
        $searchdaytext = null;
        $monthfiltertext = null;
        $swoflibuwonuinnu = 0;
        $unavnotworkincomp = 0;
        $others = 0;
        $interested = 0;
        $notinterested = 0;
        $notanswer = 0;
        $setappointment = 0;
        $total = 0;
        $TotalAssigned = 0;
        $MobileSwitchedoff = 0;
        $Paid = 0;
        $LineBusy = 0;
        $ContactedViaEmail = 0;
        $NumberEmailUnavailable = 0;
        $WrongNumberEmail = 0;
        $InvalidNumberEmail = 0;
        $Cancelationafterappointment = 0;

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
        // search between range
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
        }

        //
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        $data = UserDataComment::join('user_data', function ($join) {
            $join->on('user_data_comment.data_id', '=', 'user_data.data_id')
                ->on('user_data_comment.user_id', '=', 'user_data.user_id');
        })->join('data', 'data.id', '=', 'user_data_comment.data_id')
            ->select('user_data.data_id', 'user_data.user_id', 'user_data_comment.userstatus', 'user_data_comment.comment', 'user_data_comment.appointment_date', 'user_data_comment.created_at')->where('user_data_comment.user_id', $userid);

        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_data_comment.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_data_comment.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_data_comment.created_at', '=', $searchdaytext);

        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('data.source', $datasource);

        if ($userid != null)
            $data = $data->where('user_data_comment.user_id', $userid);

        if ($emirates != null)
            $data = $data->where('data.emirate', $emirates);

        if ($userstatus != null)
            $data = $data->where('user_data_comment.userstatus', $userstatus);

        $data = $data->get();

        $MobileSwitchedoff = $data->where('userstatus', 'Mobile Switched off')->count();
        $LineBusy = $data->where('userstatus', 'Line Busy')->count();
        $ContactedViaEmail = $data->where('userstatus', 'Contacted Via Email')->count();
        $NumberEmailUnavailable = $data->where('userstatus', 'Number & Email Unavailable')->count();
        $WrongNumberEmail = $data->where('userstatus', 'Wrong Number & Email')->count();
        $InvalidNumberEmail = $data->where('userstatus', 'Invalid Number & Email')->count();
        $others = $data->where('userstatus', 'Others')->count();
        $interested = $data->where('userstatus', 'Interested')->count();
        $notinterested = $data->where('userstatus', 'Not interested')->count();
        $notanswer = $data->where('userstatus', 'Not Answered')->count();
        $setappointment = $data->where('userstatus', 'Appointment is set')->count();

        $total = $Paid + $MobileSwitchedoff + $LineBusy + $ContactedViaEmail + $NumberEmailUnavailable + $InvalidNumberEmail + $WrongNumberEmail + $Cancelationafterappointment + $others + $interested +  $notinterested + $notanswer + $setappointment;
        $TotalAssigned = count(UserData::where('user_id', $userid)->get());
        return response()->json([
            'succssess' => true,
            'MobileSwitchedoff' => $MobileSwitchedoff,
            'LineBusy' => $LineBusy,
            'ContactedViaEmail' => $ContactedViaEmail,
            'NumberEmailUnavailable' => $NumberEmailUnavailable,
            'WrongNumberEmail' => $WrongNumberEmail,
            'InvalidNumberEmail' => $InvalidNumberEmail,
            'others' => $others,
            'interested' => $interested,
            'notinterested' => $notinterested,
            'notanswer' => $notanswer,
            'setappointment' => $setappointment,
            'total' => $total,
            'TotalAssigned' => $TotalAssigned
        ]);
    }

    public function getcommenteduserdata(Request $request)
    {
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->userid;
        } else {
            $userid = Auth::user()->id;
        }
        $userstatus = $request->userstatus;
        $datasource = $request->datasource;
        $filtertext = $request->searchday;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $emirates = $request->emirates;
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
        // search between range
        if (!is_null($startdate) && !is_null($enddate) && $filtertype == 2) {
            $sdate = Carbon::parse($startdate);
            $edate = Carbon::parse($enddate);
            if ($sdate->gt($edate))
                return response()->json(['message' => 'start date must smaller than end date']);
            $edate = $edate->addDay();
        }

        //
        if (!is_null($startdate) && $filtertype == 1) {
            $sdate = Carbon::parse($startdate);
        }

        $data = UserData::join('user_data_comment', function ($join) {
            $join->on('user_data.data_id', '=', 'user_data_comment.data_id')
                ->on('user_data.user_id', '=', 'user_data_comment.user_id');
        })
            ->join('data', 'data.id', '=', 'user_data.data_id')
            ->join('users', 'users.id', '=', 'user_data_comment.user_id')
            ->select(
                'data.PHONE',
                'data.EMAIL',
                'data.NAME',
                'data.EMIRATE',
                'data.ADDRESS',
                'data.GENDER',
                'data.DOB',
                'data.MOBILE',
                'data.SECONDARY_MOBILE',
                'data.Project',
                'data.source',
                'data.lat',
                'data.lng',
                'data.RESIDENCE_COUNTRY',
                'data.NATIONALITY',
                'user_data.data_id',
                'data.Agents',
                'user_data.user_id',
                'users.name as agentname',
                'user_data_comment.userstatus',
                'user_data_comment.comment as comment',
                'user_data_comment.appointment_date',
                'user_data_comment.created_at',
                'data.*'
            )->where('user_data_comment.user_id', $userid);


        if (!is_null($sdate) && !is_null($edate) && $filtertype == 2)
            $data = $data->whereBetween('user_data_comment.created_at', [$sdate, $edate]);
        if (!is_null($monthfiltertext))
            $data = $data->whereMonth('user_data_comment.created_at', $monthfiltertext);
        if (!is_null($searchdaytext))
            $data = $data->whereDay('user_data_comment.created_at', '=', $searchdaytext);

        if ($userid != null)
            $data = $data->where('user_data_comment.user_id', $userid);

        if ($userstatus != null)
            $data = $data->where('user_data_comment.userstatus', $userstatus);

        if ($emirates != null)
            $data = $data->where('data.emirate', $emirates);

        if (!is_null($datasource) && $datasource != "Show")
            $data = $data->where('data.source', $datasource);

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('comments', function ($row) {
                $comment = null;
                if ($row->userstatus == "Interested") {
                    $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <p> <b>Comment: </b>' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
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
                    $comment = '<div class="row ml-1" style="background-color:#F9C4F8"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> <p><b>Appointment date: </b> ' . $row->appointment_date . '</p> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div> ';
                else
                    $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row->comment . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row->agentname . ', ' . $row->created_at . '</h6> </div>';
                return $comment;
            })
            ->addColumn('action', function ($row) {
                $followupleads = FollowUpLeads::where('data_id', $row->data_id)->where('previous_state_id', $row->data_id)->where('created_by', $row->user_id)->first();
                $qualifieddata = QualifiedLeads::where('data_id', $row->data_id)->where('previous_state_id', $row->data_id)->where('created_by', $row->user_id)->first();
                $booktable = booktable::where('data_id', $row->data_id)->where('previous_state_id', $row->data_id)->where('created_by', $row->user_id)->first();
                if ($qualifieddata) {
                    if ($qualifieddata->assigned == '1') {
                        $actionBtn = '';
                    } else {
                        $actionBtn = '<a class="edit btn btn-info btn-md ml-1">Edit</a>';
                    }
                } elseif ($followupleads) {
                    if ($followupleads->assigned == '1') {
                        $actionBtn = '';
                    } else {
                        $actionBtn = '<a class="edit btn btn-info btn-md ml-1">Edit</a>';
                    }
                } elseif ($booktable) {
                    if ($booktable->assigned == '1') {
                        $actionBtn = '';
                    } else {
                        $actionBtn = '<a class="edit btn btn-info btn-md ml-1">Edit</a>';
                    }
                } else {
                    $actionBtn = '<a class="edit btn btn-info btn-md ml-1">Edit</a>';
                }

                return $actionBtn;
            })
            ->addColumn('showcomment', function ($row) {
                $historyBtn = '<a class="btn btn-info btn-md ml-1" onclick="showcomment(' . $row->id . ')" >Show Comments</a>';
                return $historyBtn;
            })
            ->rawColumns(['comments', 'action', 'showcomment'])
            ->make(true);
    }

    public function updatecommentdata(Request $request)
    {
        // dd($request->all());
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
        $data = Data::find($request->id);
        if ($data->data_status == 8 && $data->is_campaign == '0') {
            $booktable = booktable::where('data_id', $data->id)->where('previous_state_id', $data->id)->where('created_by', $userid)->first();
            if ($booktable) {
                $UserDataComment = UserDataComment::where('data_id', $data->id)->where('user_id', $userid)->first();
                $UserDataComment->comment = $request->comment;
                $UserDataComment->userstatus = $request->status;
                $UserDataComment->appointment_date = ($request->appartment != null) ? $request->appartment : NULL;
                $UserDataComment->save();
                if ($request->appartment != null && $request->status == "Appointment is set") {
                    $data->data_status = 7;
                    $data->save();
                    QualifiedLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Paid") {
                    $data->data_status = 5;
                    $data->save();
                    WonLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Not interested" || $request->status == "Number & Email Unavailable" || $request->status == "Wrong Number & Email" || $request->status == "Invalid Number & Email" || $request->status == "Cancelation after appointment" || $request->status == "Others") {
                    $data->data_status = 6;
                    $data->save();
                    DeadLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => $userid
                    ]);
                } else {
                    $data->data_status = 9;
                    $data->save();
                    FollowUpLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'data_id' => $data->id,
                        'title' => $data->unique,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
                return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
            } else {
                return response()->json(['status' => "true1", 'message' => 'Error while comment update']);
            }
        } elseif ($data->data_status == 5) {
            $wondata = WonLeads::where('data_id', $data->id)->where('previous_state_id', $data->id)->where('created_by', $userid)->first();
            if ($wondata) {
                $wondata->delete();
                $UserDataComment = UserDataComment::where('data_id', $data->id)->where('user_id', $userid)->first();
                $UserDataComment->comment = $request->comment;
                $UserDataComment->userstatus = $request->status;
                $UserDataComment->appointment_date = ($request->appartment != null) ? $request->appartment : NULL;
                $UserDataComment->save();
                if ($request->appartment != null && $request->status == "Appointment is set") {
                    $data->data_status = 7;
                    $data->save();
                    FollowUpLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'data_id' => $data->id,
                        'title' => $data->unique,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Paid") {
                    $data->data_status = 5;
                    $data->save();
                    WonLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Not interested" || $request->status == "Number & Email Unavailable" || $request->status == "Wrong Number & Email" || $request->status == "Invalid Number & Email" || $request->status == "Cancelation after appointment" || $request->status == "Others") {
                    $data->data_status = 6;
                    $data->save();
                    DeadLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => $userid
                    ]);
                } else {
                    $data->data_status = 9;
                    $data->save();
                    FollowUpLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'data_id' => $data->id,
                        'title' => $data->unique,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
                return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
            } else {
                return response()->json(['status' => "true1", 'message' => 'Error while comment update']);
            }
        } elseif ($data->data_status == 9) {
            $followupleads = FollowUpLeads::where('data_id', $data->id)->where('previous_state_id', $data->id)->where('created_by', $userid)->first();
            if ($followupleads) {
                $followupleads->delete();
                $UserDataComment = UserDataComment::where('data_id', $data->id)->where('user_id', $userid)->first();
                $UserDataComment->comment = $request->comment;
                $UserDataComment->userstatus = $request->status;
                $UserDataComment->appointment_date = ($request->appartment != null) ? $request->appartment : NULL;
                $UserDataComment->save();
                if ($request->appartment != null && $request->status == "Appointment is set") {
                    $data->data_status = 7;
                    $data->save();
                    QualifiedLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Paid") {
                    $data->data_status = 5;
                    $data->save();
                    WonLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Not interested" || $request->status == "Number & Email Unavailable" || $request->status == "Wrong Number & Email" || $request->status == "Invalid Number & Email"  || $request->status == "Others") {
                    $data->data_status = 6;
                    $data->save();
                    DeadLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => $userid
                    ]);
                } else {
                    $data->data_status = 9;
                    $data->save();
                    FollowUpLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'data_id' => $data->id,
                        'title' => $data->unique,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
                return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
            } else {
                return response()->json(['status' => "true1", 'message' => 'Error while comment update']);
            }
        } elseif ($data->data_status == 6) {
            $dedleds = DeadLeads::where('data_id', $data->id)->where('previous_state_id', $data->id)->where('created_by', $userid)->first();
            if ($dedleds) {
                $dedleds->delete();
                $UserDataComment = UserDataComment::where('data_id', $data->id)->where('user_id', $userid)->first();
                $UserDataComment->comment = $request->comment;
                $UserDataComment->userstatus = $request->status;
                $UserDataComment->appointment_date = ($request->appartment != null) ? $request->appartment : NULL;
                $UserDataComment->save();
                if ($request->appartment != null && $request->status == "Appointment is set") {
                    $data->data_status = 7;
                    $data->save();
                    QualifiedLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Paid") {
                    $data->data_status = 5;
                    $data->save();
                    WonLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Not interested" || $request->status == "Number & Email Unavailable" || $request->status == "Wrong Number & Email" || $request->status == "Invalid Number & Email" || $request->status == "Cancelation after appointment" || $request->status == "Others") {
                    $data->data_status = 6;
                    $data->save();
                    DeadLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => $userid
                    ]);
                } else {
                    $data->data_status = 9;
                    $data->save();
                    FollowUpLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'data_id' => $data->id,
                        'title' => $data->unique,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
                return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
            } else {
                return response()->json(['status' => "true1", 'message' => 'Error while comment update']);
            }
        } else {
            $qualifieddata = QualifiedLeads::where('data_id', $data->id)->where('previous_state_id', $data->id)->where('created_by', $userid)->first();
            if ($qualifieddata) {
                $qualifieddata->delete();
                $UserDataComment = UserDataComment::where('data_id', $data->id)->where('user_id', $userid)->first();
                $UserDataComment->comment = $request->comment;
                $UserDataComment->userstatus = $request->status;
                $UserDataComment->appointment_date = ($request->appartment != null) ? $request->appartment : NULL;
                $UserDataComment->save();
                if ($request->appartment != null && $request->status == "Appointment is set") {
                    $data->data_status = 7;
                    $data->save();
                    QualifiedLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Paid") {
                    $data->data_status = 5;
                    $data->save();
                    WonLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id
                    ]);
                } elseif ($request->status == "Not interested" || $request->status == "Number & Email Unavailable" || $request->status == "Wrong Number & Email" || $request->status == "Invalid Number & Email" || $request->status == "Cancelation after appointment" || $request->status == "Others") {
                    $data->data_status = 6;
                    $data->save();
                    DeadLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'title' => $data->unique,
                        'data_id' => $data->id,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => $userid
                    ]);
                } else {
                    $data->data_status = 9;
                    $data->save();
                    FollowUpLeads::create([
                        'name' => $data->NAME,
                        'email' => $data->EMAIL,
                        'phone' => $data->PHONE,
                        'mobile' => $data->MOBILE,
                        'phone_whatsapp' => $data->phone_whatsup,
                        'number_of_beds' => is_numeric($data->No_of_Beds) ? $data->No_of_Beds : null,
                        'source' => $data->source,
                        'project' => $data->Master_Project,
                        'data_id' => $data->id,
                        'title' => $data->unique,
                        'previous_state' => '0',
                        'previous_state_id' => $data->id,
                        'created_by' => Auth::user()->id,
                    ]);
                }
                return response()->json(['status' => true, 'message' => 'Comment updated successfully']);
            } else {
                return response()->json(['status' => "true1", 'message' => 'Error while comment update']);
            }
        }
    }

    public function wonleadsindex()
    {
        $datasource = WonLeads::groupBy('source')->select('source')->pluck('source');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $projects = WonLeads::where('project', '!=', '')->select('project')->groupBy('project')->pluck('project');
        return view('admin.wonleads', ['datasource' => $datasource, 'agentnames' => $agentnames, 'projects' => $projects]);
    }

    public function wonleadsdata(Request $request)
    {
        $projects = $request->projects;
        $agentname = $request->agentname;
        $datasource = $request->datasource;
        $data = WonLeads::join('users', 'users.id', '=', 'won_leads.created_by');
        if ($projects != null) {
            $data = $data->where('project', $projects);
        }
        if ($agentname != null) {
            $data = $data->where('created_by', $agentname);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }

        $data = $data->select('won_leads.*', 'users.name as agentname')->get();

        return DataTables::of($data)
            ->make(true);
    }

    public function deadleadsindex()
    {
        $datasource = DeadLeads::groupBy('source')->select('source')->pluck('source');
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $projects = DeadLeads::where('project', '!=', '')->select('project')->groupBy('project')->pluck('project');
        return view('admin.deadleads', ['datasource' => $datasource, 'agentnames' => $agentnames, 'projects' => $projects]);
    }

    public function deadleadsdata(Request $request)
    {
        $projects = $request->projects;
        $agentname = $request->agentname;
        $datasource = $request->datasource;
        $data = DeadLeads::join('users', 'users.id', '=', 'dead_leads.created_by');
        if ($projects != null) {
            $data = $data->where('project', $projects);
        }
        if ($datasource != null) {
            $data = $data->where('source', $datasource);
        }
        if ($agentname != null) {
            $data = $data->where('created_by', $agentname);
        }
        $data = $data->select('dead_leads.*', 'users.name as agentname')->get();
        return DataTables::of($data)
            ->make(true);
    }

    // public function sample()
    // {

    //     $chart = (new LarapexChart)->pieChart()
    //     ->setTitle('Pie')
    //     ->addData([
    //         \App\Models\Data::where('EMIRATE', '=', 'Dubai')->count(),
    //         \App\Models\Data::where('EMIRATE', '=', 'Sharjah')->count(),
    //         \App\Models\Data::where('EMIRATE', '=', 'Abu Dhabi')->count(),
    //     ])
    //     ->setColors(['#a5378f', '#ffc70b','#cc2411'])
    //     ->setLabels(['Dubai', 'Sharjah','Abu Dhabi']);

    //     $chart1 = (new LarapexChart)->barChart()
    //     ->setTitle('Histogram')
    //     ->addBar('Dubai', [\App\Models\Data::where('EMIRATE', '=', 'Dubai')->count()])
    //     ->addBar('Sharjah', [\App\Models\Data::where('EMIRATE', '=', 'Sharjah')->count()])
    //     ->addBar('Abu Dhabi', [\App\Models\Data::where('EMIRATE', '=', 'Abu Dhabi')->count()])
    //     ->setColors(['blue'])
    //     ->setLabels([' ']);
    //     return view('sample')->with('chart',$chart)->with('chart1',$chart1);
    // }

    // public function nationality()
    // {
    //     $chart2 = (new LarapexChart)->barChart()
    //     ->setTitle('Histogram')
    //     ->addBar('Russia', [\App\Models\Data::where('NATIONALITY', '=', 'Russia')->count()])
    //     ->addBar('Kyrgistan',[\App\Models\Data::where('NATIONALITY', '=', 'Kyrgistan')->count()])
    //     ->addBar('India', [\App\Models\Data::where('NATIONALITY', '=', 'India')->count()])
    //     ->addBar('Italy', [\App\Models\Data::where('NATIONALITY', '=', 'Italy')->count()])
    //     ->addBar('South Africa', [\App\Models\Data::where('NATIONALITY', '=', 'South Africa')->count()])
    //     ->addBar('United Kingdom', [\App\Models\Data::where('NATIONALITY', '=', 'United Kingdom')->count()])
    //     ->addBar('United States of America', [\App\Models\Data::where('NATIONALITY', '=', 'United States of America')->count()])
    //     ->addBar('Pakistan', [\App\Models\Data::where('NATIONALITY', '=', 'Pakistan')->count()])
    //     ->addBar('China', [\App\Models\Data::where('NATIONALITY', '=', 'China')->count()])
    //     ->addBar('Afghanistan', [\App\Models\Data::where('NATIONALITY', '=', 'Afghanistan')->count()])
    //     ->addBar('Kuwait', [\App\Models\Data::where('NATIONALITY', '=', 'Kuwait')->count()])
    //     ->addBar('Iran', [\App\Models\Data::where('NATIONALITY', '=', 'Iran')->count()])
    //     ->addBar('France', [\App\Models\Data::where('NATIONALITY', '=', 'France')->count()])
    //     ->addBar('Canada', [\App\Models\Data::where('NATIONALITY', '=', 'Canada')->count()])
    //     ->addBar('Jordan', [\App\Models\Data::where('NATIONALITY', '=', 'Jordan')->count()])
    //     ->addBar('Kazakhstan', [\App\Models\Data::where('NATIONALITY', '=', 'Kazakhstan')->count()])
    //     ->addBar('Brunei', [\App\Models\Data::where('NATIONALITY', '=', 'Brunei')->count()])
    //     ->addBar('Palestine', [\App\Models\Data::where('NATIONALITY', '=', 'Palestine')->count()])
    //     ->addBar('Greece', [\App\Models\Data::where('NATIONALITY', '=', 'Greece')->count()])
    //     ->addBar('Lebanon', [\App\Models\Data::where('NATIONALITY', '=', 'Lebanon')->count()])
    //     ->addBar('South Korea', [\App\Models\Data::where('NATIONALITY', '=', 'South Korea')->count()])
    //     ->addBar('Bangladesh', [\App\Models\Data::where('NATIONALITY', '=', 'Bangladesh')->count()])
    //     ->addBar('United Arab Emirates', [\App\Models\Data::where('NATIONALITY', '=', 'United Arab Emirates')->count()])
    //     ->addBar('Syria', [\App\Models\Data::where('NATIONALITY', '=', 'Syria')->count()])
    //     ->addBar('Northern Ireland', [\App\Models\Data::where('NATIONALITY', '=', 'Northern Ireland')->count()])
    //     ->addBar('Morocco', [\App\Models\Data::where('NATIONALITY', '=', 'Morocco')->count()])
    //     ->setColors(['blue'])
    //     ->setLabels([' ']);

    //     $chart3 = (new LarapexChart)->pieChart()
    //     ->setTitle('Pie')
    //     ->addData([
    //         \App\Models\Data::where('NATIONALITY', '=', 'Russia')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Kyrgistan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'India')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Italy')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'South Africa')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'United Kingdom')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'United States of America')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Pakistan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'China')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Afghanistan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Kuwait')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Iran')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'France')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Canada')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Jordan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Kazakhstan')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Brunei')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Palestine')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Greece')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Lebanon')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'South Korea')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Bangladesh')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'United Arab Emirates')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Syria')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Northern Ireland')->count(),
    //         \App\Models\Data::where('NATIONALITY', '=', 'Morocco')->count(),
    //     ])
    //     ->setColors(['#a5378f', '#ffc70b','#cc2411','#f00','#80a2c7','#985dde','#7b1dea',
    //     '#1dea3c','#157123','#437115','#b1bf18','#bf6218','#254869','#2fe8a0','#de4f4f'])
    //     ->setLabels(['Russia', 'Kyrgistan','India','Italy','South Africa','United Kingdom',
    //     'United States of America','Pakistan','China','Afghanistan','Kuwait','Iran','France'
    //     ,'Canada','Jordan','Kazakhstan','Brunei','Palestine','Greece','Lebanon','South Korea'
    //     ,'Bangladesh','United Arab Emirates','Syria','Northern Ireland','Morocco']);

    //     return view('nationality')->with('chart',$chart)->with('chart1',$chart1);
    // }

    // public function usage(){
    //     $chart4 = (new LarapexChart)->barChart()
    //     ->setTitle('Histogram')
    //     ->addBar('Residential', [\App\Models\Data::where('USAGE', '=', 'Residential')->count()])
    //     ->addBar('Building',[\App\Models\Data::where('USAGE', '=', 'Building')->count()])
    //     ->addBar('Flat', [\App\Models\Data::where('USAGE', '=', 'Flat')->count()])
    //     ->setColors(['blue'])
    //     ->setLabels([' ']);

    //     $chart5 = (new LarapexChart)->pieChart()
    //     ->setTitle('Pie')
    //     ->addData([
    //         \App\Models\Data::where('USAGE', '=', 'Residential')->count(),
    //         \App\Models\Data::where('USAGE', '=', 'Building')->count(),
    //         \App\Models\Data::where('USAGE', '=', 'Flat')->count(),
    //     ])
    //     ->setColors(['#ffc70b', '#cc2411','#a5378f'])
    //     ->setLabels(['Residential', 'Building','Flat']);

    //     return view('usage')->with('chart',$chart)->with('chart1',$chart1);
    // }
    // public function sendsmstoleads(Request $request){
    //     $id = array_map('intval', explode(',', $request->id));
    //     $to = [];
    //     $body = $request->body;
    //     $templet_id = $request->templet_id;
    //     $option = $request->option;// body or templet
    //     foreach ($id as $key) {
    //         $data = Data::find($key);
    //         if ($data) {
    //             $to[] = [
    //                 'phone' => $data->PHONE,
    //             ];
    //         }
    //     };
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Send sms has been successfully'
    //     ]);

    // }



    public function addcommentmore(Request $request)
    {
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'data_id' => $request->data_id,
            'comment' => $request->comment,
            'appoentment_date' => $request->appoentment_date,
            'stage' => "1"
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
    public function getcommentsleads(Request $request)
    {
        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->user_id;
        } else {
            $userid = Auth::user()->id;
        }
        $comment = Comment::where('data_id', $request->id)->where('user_id', $userid)->where('stage', '1')->get();
        return response()->json([
            'data' => $comment
        ]);
    }
    public function showappoentmentdatetoday()
    {
        $appointments = Comment::where('appoentment_date', '!=', null)->where('user_id', Auth::user()->id)->get();
        $appointments_today = [];
        foreach ($appointments as $appointment) {
            $date = new DateTime($appointment->appoentment_date);
            if ($date->format('y-m-d') == Carbon::now()->format('y-m-d')) {
                if ($appointment->stage == 1) {
                    $stage = 'imported data';
                } elseif ($appointment->stage == 2) {
                    $stage = 'leads pool';
                } elseif ($appointment->stage == 3) {
                    $stage = 'qualified leads';
                } elseif ($appointment->stage == 5) {
                    $stage = 'proceed leads';
                } else {
                    $stage = 'follow up leads';
                }
                $appointments_today[] = [
                    'id' => $appointment->id,
                    'appointments' => $appointment->appoentment_date,
                    'comment' => $appointment->comment,
                    'show' => $appointment->show,
                    'stage' => $stage
                ];
            }
        }
        return response()->json([
            'appointments_today' => array_slice($appointments_today, 0, 10),
        ]);
    }
    public function changeappoentmentdateshow(Request $request)
    {
        $appointments = Comment::find($request->id)->update([
            'show' => true,
        ]);
        if ($appointments) {
            return response()->json([
                'status' => true,
            ]);
        }
    }

    public function showdatacommentsindex()
    {
        $agentnames = User::select('id', 'name')->where('role_id', 'like', '%3%')->get();
        $userstatus = config('app.all_status');
        return view('admin.comments', ['agentnames' => $agentnames, 'userstatus' => $userstatus]);
    }

    public function showdatacomments(Request $request)
    {
        // dd($request->all());
        $leadpool_stage = [];
        $data_stage = [];
        $qualified_stage = [];
        $proceeded_stage = [];
        $followup_stage = [];

        $userid = null;
        if (Auth::user()->isadmin()) {
            $userid = $request->agentname;
        } else {
            $userid = Auth::user()->id;
        }
        $userstatus = $request->userstatus;
        $data = UserData::join('user_data_comment', function ($join) {
            $join->on('user_data.data_id', '=', 'user_data_comment.data_id')
                ->on('user_data.user_id', '=', 'user_data_comment.user_id');
        })
            ->join('data', 'data.id', '=', 'user_data.data_id')
            ->join('users', 'users.id', '=', 'user_data_comment.user_id')
            ->select(
                'data.phone',
                'data.email',
                'data.name',
                'data.mobile',
                'user_data.data_id',
                'user_data.user_id',
                'users.name as agentname',
                'user_data_comment.userstatus',
                'user_data_comment.comment as comment',
                'user_data_comment.appointment_date',
                'user_data_comment.created_at',
                'data.*'
            );
        /////////////////////// customer status filter
        if ($userstatus != null)
            $data = $data->where('user_data_comment.userstatus', $userstatus);
        //////////////////////
        /////////////////////// agent filter
        if ($userid != null) {
            $data = $data->where('user_data_comment.user_id', $userid);
        }
        //////////////////////
        $data = $data->get()->toArray();
        foreach ($data  as $key) {
            $data_stage[] = array_merge($key, ['stage' => '1']);
        }

        $qualified = UserQualifiedLeads::join('user_qualified_leads_comments', function ($join) {
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
                'qualified_leads.mobile',
                'qualified_leads.data_id',
                'user_qualified_leads.qualified_leads_id',
                'user_qualified_leads.user_id',
                'users.name as agentname',
                'user_qualified_leads_comments.userstatus',
                'user_qualified_leads_comments.comment as comment',
                'user_qualified_leads_comments.appointment_date',
            );
        /////////////////////// customer status filter
        if ($userstatus != null)
            $qualified = $qualified->where('user_qualified_leads_comments.userstatus', $userstatus);
        //////////////////////
        /////////////////////// agent filter
        if ($userid != null) {
            $qualified = $qualified->where('user_qualified_leads_comments.user_id', $userid);
        }
        //////////////////////
        $qualified = $qualified->get()->toArray();
        foreach ($qualified   as $key) {
            $qualified_stage[] = array_merge($key, ['stage' => '3']);
        }
        $comment = array_merge($data_stage, $qualified_stage);

        $proceeded = UserProceededLead::join('user_proceeded_leads_comment', function ($join) {
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
                'proceeded_lead.mobile',
                'proceeded_lead.data_id',
                'user_proceeded_leads.proceeded_lead_id',
                'user_proceeded_leads.user_id',
                'users.name as agentname',
                'user_proceeded_leads_comment.userstatus',
                'user_proceeded_leads_comment.comment as comment',
                'user_proceeded_leads_comment.created_at'
            );
        /////////////////////// customer status filter
        if ($userstatus != null)
            $proceeded = $proceeded->where('user_proceeded_leads_comment.userstatus', $userstatus);
        ///////////////////////
        /////////////////////// agent filter
        if ($userid != null) {
            $proceeded = $proceeded->where('user_proceeded_leads_comment.user_id', $userid);
        }
        //////////////////////
        $proceeded = $proceeded->get()->toArray();
        foreach ($proceeded  as $proceede) {
            $proceeded_stage[] = array_merge($proceede, ['stage' => '5']);
        }
        $comment1 = array_merge($comment, $proceeded_stage);

        $leadpool = UserLeadsPool::join('user_leads_pool_comments', function ($join) {
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
                'booktables.mobile',
                'user_leads_pools.leads_pool_id',
                'user_leads_pools.user_id',
                'users.name as agentname',
                'user_leads_pool_comments.userstatus',
                'user_leads_pool_comments.comment as comment',
                'user_leads_pool_comments.appointment_date',
                'user_leads_pool_comments.created_at'
            );
        /////////////////////// customer status filter
        if ($userstatus != null)
            $leadpool = $leadpool->where('user_leads_pool_comments.userstatus', $userstatus);
        //////////////////////
        /////////////////////// agent filter
        if ($userid != null) {
            $leadpool = $leadpool->where('user_leads_pool_comments.user_id', $userid);
        }

        //////////////////////
        $leadpool = $leadpool->get()->toArray();
        foreach ($leadpool  as $leadpoo) {
            $leadpool_stage[] = array_merge($leadpoo, ['stage' => '2']);
        }
        // dd($leadpool_stage);
        $comment2 = array_merge($comment1, $leadpool_stage);

        $followups = UserFollowUpLeads::join('user_follow_up_leads_comments', function ($join) {
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
                'follow_up_leads.mobile',
                'follow_up_leads.source',
                'user_follow_up_leads.follow_up_id',
                'user_follow_up_leads.user_id',
                'users.name as agentname',
                'user_follow_up_leads_comments.userstatus',
                'user_follow_up_leads_comments.comment as comment',
                'user_follow_up_leads_comments.appointment_date',
                'user_follow_up_leads_comments.created_at'
            );

        /////////////////////// customer status filter
        if ($userstatus != null)
            $followups = $followups->where('user_follow_up_leads_comments.userstatus', $userstatus);
        //////////////////////
        /////////////////////// agent filter
        if ($userid != null) {
            $followups = $followups->where('user_follow_up_leads_comments.user_id', $userid);
        }

        //////////////////////
        $followups = $followups->get()->toArray();
        foreach ($followups as $followup) {
            $followup_stage[] = array_merge($followup, ['stage' => '4']);
        }
        $comment4 = [];
        $comment3 = array_merge($comment2, $followup_stage);
        if ($request->stage != null) {
            foreach ($comment3 as $key) {
                if ($key['stage'] == $request->stage) {
                    $comment4[] = $key;
                }
            }
        }

        // dd($comment4);
        if ($userid != null) {
            return DataTables::of($comment4)
                ->addIndexColumn()
                ->editColumn('comments', function ($row) {
                    $comment = null;
                    if ($row['userstatus'] == "Paid") {
                        $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <p> <b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                    } else if ($row['userstatus'] == "Cancel") {
                        $comment = '<div class="row ml-1" style="background-color:#00ff95"> <p><b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                    } else {
                        $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                    }
                    return $comment;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button onclick="show_comments(' . $row['stage'] . ',' . $row['data_id'] . ')" type="button" data-id="' . $row['stage'] . '" class="show-com' . $row['data_id'] . ' btn btn-primary btn-md ml-1">Show All Comment</button>' .
                        '<button  onclick="ShowLead_Info(' . $row['data_id'] . ')" id="' . $row['userstatus'] . '" type="button"class=" showleadsinfo' . $row['data_id'] . ' btn btn-info btn-md ml-1">Show Lead Info</button>' .
                        '<button type="button"class="show_history btn btn-md ml-1">Show History</button>';
                    return $actionBtn;
                })
                ->rawColumns(['comments', 'action'])
                ->make(true);
        } else {
            return DataTables::of($comment4)
                ->addIndexColumn()
                ->editColumn('comments', function ($row) {
                    $comment = null;
                    if ($row['userstatus'] == "Paid") {
                        $comment = '<div class="row ml-1" style="background-color:#FEFEE7"> <p> <b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                    } else if ($row['userstatus'] == "Cancel") {
                        $comment = '<div class="row ml-1" style="background-color:#00ff95"> <p><b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                    } else {
                        $comment = '<div class="row ml-1"> <p><b>Comment: </b> ' . $row['comment'] . '</p> , <div style="color:#70cacc">&nbsp;&nbsp; </div> </div> <div class="row ml-1"> <h6>' . $row['agentname'] . ', ' . $row['created_at'] . '</h6> </div>';
                    }
                    return $comment;
                })
                ->addColumn('stage', function ($row) {
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" onclick="ShowLead_Info(' . $row['data_id'] . ')" id="' . $row['userstatus'] . '" class="showleadsinfo' . $row['data_id'] . ' btn btn-info btn-md ml-1">Show Lead Info</button>' . '<button type="button"class="show_history btn btn-md ml-1">Show History</button>';
                    return $actionBtn;
                })
                ->rawColumns(['comments', 'action'])
                ->make(true);
        }
    }
    public function getcalender()
    {
        $event_calender = calender::select('event_title', 'start_time', 'end_time', 'event_id', 'event_source')->distinct('event_title')->get();
        $event = [];
        foreach ($event_calender as $key) {
            if ($key->event_source == "normal") {
                $event_nor = event::find($key->event_id);
                if ($event_nor) {
                    $users = event_attendance::where('event_id', $event_nor->id)->get();
                    $l = [];
                    foreach ($users as $user) {
                        $useratt = User::find($user->user_id);
                        if ($useratt)
                            $l[] = $useratt->name;
                    }
                    $tmp_s = Carbon::parse(str_replace("/", "-", $key->start_time))->format('Y-m-d H:m:s');
                    $tmp_e = Carbon::parse(str_replace("/", "-", $key->end_time))->format('Y-m-d H:m:s');
                    // $event[] = \Calendar::event(
                    //     $key->event_title,
                    //     false,
                    //     $tmp_s,
                    //     $tmp_e,
                    //     $key->id,
                    //     [
                    //         'type' => 'Event Normal',
                    //         'source' => $key->event_source,
                    //         'location' => $event_nor->address,
                    //         'dec' => $event_nor->description,
                    //         'usernmae' => $l,
                    //         'color' => '#555'
                    //     ]
                    // );
                }
            } else if ($key->event_source == "meeting") {
                $meeting_app = Meeting::find($key->event_id);
                if ($meeting_app) {
                    $user = User::find($meeting_app->user_id);
                    $tmp_s = Carbon::parse(str_replace("/", "-", $key->start_time))->format('Y-m-d H:m:s');
                    $tmp_e = Carbon::parse(str_replace("/", "-", $key->end_time))->format('Y-m-d H:m:s');
                    // $event[] = \Calendar::event(
                    //     $key->event_title,
                    //     false,
                    //     $tmp_s,
                    //     $tmp_e,
                    //     $key->id,
                    //     [
                    //         'type' => 'Meeting',
                    //         'title' => $key->event_title,
                    //         'source' => $key->event_source,
                    //         'dec' => $meeting_app->description,
                    //         'usernmae' => $user != null ? $user->name : '',
                    //         'color' => '#ddd'
                    //     ]
                    // );
                }
            } else {
                $event_app = Appointment::find($key->event_id);
                if ($event_app) {
                    $user = User::find($event_app->agent_id);
                    $PHOTO = User::find($event_app->user_id);
                    $tmp_s = Carbon::parse(str_replace("/", "-", $key->start_time))->format('Y-m-d H:m:s');
                    $tmp_e = Carbon::parse(str_replace("/", "-", $key->end_time))->format('Y-m-d H:m:s');
                    // $event[] = \Calendar::event(
                    //     $key->event_title,
                    //     false,
                    //     $tmp_s,
                    //     $tmp_e,
                    //     $key->id,
                    //     [
                    //         'type' => 'Photo Session',
                    //         'source' => $key->event_source,
                    //         'location' => $event_app->location,
                    //         'dec' => $event_app->comment,
                    //         'usernmae' => $user != null ? $user->name : '',
                    //         'PHOTO' => $PHOTO->name,
                    //         'color' => '#ccc'
                    //     ]
                    // );
                }
            }
        }
        // $calendar = \Calendar::addevents($event)
        //     ->setCallbacks([
        //         'select' => 'function(selectionInfo){
        //         }',
        //         'eventClick' => 'function(event){
        //         document.getElementById("loginPopup").style.display = "block";
        //         $(".t").val(event.event.title);
        //         var date1 = new Date(event.event.startStr).toLocaleString("en-US");
        //         $(".s").val(date1);
        //         $(".title").empty();
        //         $(".title").append(event.event.extendedProps.type);
        //         $(".e").val(event.event.extendedProps.source);
        //         $(".l").val(event.event.extendedProps.location);
        //         $(".d").val(event.event.extendedProps.dec);
        //         $(".user").val(event.event.extendedProps.usernmae);
        //         if(event.event.extendedProps.PHOTO){
        //             document.getElementById("PhotographerNAME").style.display = "block";
        //             document.getElementById("Photographerinput").style.display = "block";
        //             $(".Photogra").val(event.event.extendedProps.PHOTO);
        //         }else{
        //             document.getElementById("PhotographerNAME").style.display = "none";
        //             document.getElementById("Photographerinput").style.display = "none";
        //         }
        //     }'
        //     ]);
        // dd($calendar);
        return view('admin.calendar', compact('calendar'));
    }
    public function getevent($id)
    {
        dd($id);
    }
    public function getcommentsimportedleads($data_id, $user_id, $stage)
    {
        $data = Comment::where('data_id', $data_id)->where('user_id', $user_id)->where('stage', $stage)->get();
        return Response::json(array('data' => $data));
    }

    public function sendemailtoagenttoday()
    {
        $comments_all = Comment::where('appoentment_date', '!=', null)
            ->select('data_id', 'user_id', 'appoentment_date')->get()->toArray();
        $followup = FollowUpLeads::join('user_follow_up_leads_comments', 'user_follow_up_leads_comments.follow_up_id', 'follow_up_leads.id')
            ->join('users', 'users.id', 'user_id')
            ->where('userstatus', 'Appointment is set')
            ->where('appointment_date', '!=', null)
            ->select('data_id', 'user_id', 'appointment_date as appoentment_date')
            ->get()->toArray();
        $comments = array_merge($followup, $comments_all);
        $calendar = calender::where('start_time', '!=', null)->get();
        foreach ($comments as  $comment) {
            $date = new DateTime($comment['appoentment_date']);
            $user = User::find($comment['user_id']);
            $leads = Data::find($comment['data_id']);
            if ($date->format('y-m-d') == Carbon::now()->format('y-m-d')) {
                if ($user && $leads) {
                    $detiles = [
                        'agentname' => $user->name,
                        'leadsname' => $leads->NAME,
                        'comment' => $date->format('y-m-d H:i')
                    ];
                    Mail::to($user->email)->send(new appoentment($detiles));
                }
            }
        }
        foreach ($calendar as $key) {
            if ($key->event_source == "normal") {
                $user = User::find($key->user_id);
                $event = event::find($key->event_id);
                $starttime = new DateTime($key->start_time);
                if ($starttime->format('y-m-d') == Carbon::now()->format('y-m-d')) {
                    if ($event) {
                        $detiles = [
                            'title' => $key->event_title,
                            'location' => $event->address,
                            'description' => $event->description,
                            'username' => $user->name,
                        ];
                        Mail::to($user->email)->send(new appoentmentData($detiles));
                    }
                }
            } else {
                $appointment = Appointment::find($key->event_id);
                $users = User::whereIn('id', [$appointment->user_id, $appointment->agent_id])->get();
                $starttime = new DateTime($key->start_time);
                if ($starttime->format('y-m-d') == Carbon::now()->format('y-m-d')) {
                    if ($appointment) {
                        foreach ($users as $user) {
                            $detiles = [
                                'title' => $key->event_title,
                                'location' => $appointment->location,
                                'description' => $appointment->comment,
                                'username' => $user->name,
                            ];
                            Mail::to($user->email)->send(new appoentmentData($detiles));
                        }
                    }
                }
            }
        }
    }

}
