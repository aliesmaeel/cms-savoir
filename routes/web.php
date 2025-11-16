<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\DownloadedBrochureController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\RealEstateController;
use App\Models\Community;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\CommunityController;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\OffPlanProjectController;
use App\Http\Controllers\SignatureController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('safa/{src?}/{na?}/{em?}/{ph?}/', [App\Http\Controllers\leadsregisteController::class, 'safa'])->name('safa');
Route::get('damac/{src?}/{na?}/{em?}/{ph?}/', [App\Http\Controllers\leadsregisteController::class, 'damac'])->name('damac');

Route::get('/', function () {
    return redirect('/login');
});

Route::get('progressbar', [HomeController::class, 'getProgressB'])->name('get-progressbar');
route::get('clearprogressbar', [HomeController::class, 'clearProgressBar'])->name('clear-progressbar');
route::get('getImportStatus', [HomeController::class, 'getImportStatus'])->name('get-importstatus');
route::get('finishImportStatus', [HomeController::class, 'finishImportStatus'])->name('finish-importstatus');
route::get('startImportStatus', [HomeController::class, 'startImportStatus'])->name('start-importstatus');

Auth::routes();
Route::get('/createlead', [App\Http\Controllers\HomeController::class, 'createleadindex'])->name('createlead');
Route::post('/createnewlead', [App\Http\Controllers\HomeController::class, 'createnewlead'])->name('create_new_lead');

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/agentdata', [App\Http\Controllers\HomeController::class, 'agentdata'])->name('agent_data');
Route::post('/filter', [App\Http\Controllers\HomeController::class, 'filter'])->name('filter');
Route::get('/uploadedFile', [App\Http\Controllers\HomeController::class, 'uploadedFiles'])->name('uploadedFiles');
Route::get('/downloadFile/{fileName}', [App\Http\Controllers\HomeController::class, 'downloadFile']);
Route::get('emirates', [App\Http\Controllers\HomeController::class, 'sample'])->name('sample');
Route::get('nationality', [App\Http\Controllers\HomeController::class, 'nationality'])->name('nationality');
Route::get('usage', [App\Http\Controllers\HomeController::class, 'usage'])->name('usage');
Route::post('deleteFile/{id}', [App\Http\Controllers\ImportExcelController::class, 'deleteFile'])->name('deleteFile');
Route::get('geochart', [App\Http\Controllers\HomeController::class, 'getLavaChart'])->name('geochart');

Route::get('filterIng/{emirates}&{area}&{residence}', [App\Http\Controllers\HomeController::class, 'filterIng']);


Route::get('/register', function () {
    return view('auth.login');
});

Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::post('allposts', [App\Http\Controllers\HomeController::class, 'search'])->name('allposts');
Route::post('allposts1', [App\Http\Controllers\HomeController::class, 'search1'])->name('allposts1');
Route::post('allposts2', [App\Http\Controllers\HomeController::class, 'search2'])->name('allposts2');
Route::post('serachforagentdata', [App\Http\Controllers\HomeController::class, 'serachforagentdata'])->name('serach_for_agent_data');
Route::post('addcomment', [App\Http\Controllers\HomeController::class, 'addcomment'])->name('add_comment');
Route::post('deletecomment', [App\Http\Controllers\HomeController::class, 'deletecomment'])->name('delete_comment');
Route::get('index1', [App\Http\Controllers\HomeController::class, 'index1'])->name('index1');
Route::get('showcommenteddata', [App\Http\Controllers\HomeController::class, 'showcommenteddata'])->name('show_commented_data');
Route::post('getcommenteduserdata', [App\Http\Controllers\HomeController::class, 'getcommenteduserdata'])->name('get_commented_user_data');
Route::post('addleadcomment', [App\Http\Controllers\HomeController::class, 'addleadcomment'])->name('add_lead_comment');
Route::post('addcommentmore', [App\Http\Controllers\HomeController::class, 'addcommentmore'])->name('add_comment_more');
Route::post('getcommentsleads', [App\Http\Controllers\HomeController::class, 'getcommentsleads'])->name('get_comments_leads');

Route::match(['get', 'post'], 'settinglogo', [SettingController::class, 'logo'])->name('setting.logo');
Route::get('sync', [PropertyController::class, 'sync'])->name('sync');
Route::get('synccommunities', [CommunityController::class, 'synccommunities'])->name('sync_communities');
Route::get('syncsubcommunities', [CommunityController::class, 'syncsubcommunities'])->name('sync_sub_communities');
Route::get('syncbuildings', [CommunityController::class, 'syncbuildings'])->name('sync_buildings');


// Excel Routes
Route::get('/export_excel', [App\Http\Controllers\ExportExcelController::class, 'index']);
Route::post('/export_excel/excel', [App\Http\Controllers\ExportExcelController::class, 'excel'])->name('export_excel.excel');

Route::get('map', [App\Http\Controllers\HomeController::class, 'map'])->name('map');

Route::get('import', [App\Http\Controllers\ImportExcelController::class, 'index'])->name('import_index');
Route::post('import', [App\Http\Controllers\ImportExcelController::class, 'import'])->name('importprocessajax');

route::get('createbuyerindex', [App\Http\Controllers\UserController::class, 'createbuyerindex'])->name('create_buyer_index');
route::post('createnewbuyer', [App\Http\Controllers\UserController::class, 'createnewbuyer'])->name('create_new_buyer');
route::get('updatebuyerindex/{id?}', [App\Http\Controllers\UserController::class, 'updatebuyerindex'])->name('update_buyer_index');
route::post('updatebuyer', [App\Http\Controllers\UserController::class, 'updatebuyer'])->name('update_buyer');

route::get('createuserindex', [App\Http\Controllers\UserController::class, 'createuserindex'])->name('create_user_index');
route::post('createnewuser', [App\Http\Controllers\UserController::class, 'createnewuser'])->name('create_new_user');
route::get('updateuserindex/{id?}', [App\Http\Controllers\UserController::class, 'updateuserindex'])->name('update_user_index');
route::post('updateuser', [App\Http\Controllers\UserController::class, 'updateuser'])->name('update_user');

route::post('createnewproperty', [App\Http\Controllers\PropertyController::class, 'createnewproperty'])->name('create_new_property');
route::match(['get', 'post'], 'createnewcommunity', [App\Http\Controllers\CommunityController::class, 'createnewcommunity'])->name('create_new_community');
route::match(['get', 'post'], 'listcommunities', [CommunityController::class, 'listcommunities'])->name('list_communities');
route::get('updatecommunityindex/{id}', [CommunityController::class, 'updatecommunityindex'])->name('update_community_index');
route::post('updatecommunity', [CommunityController::class, 'updatecommunity'])->name('update_community');
route::post('deletecommunity', [CommunityController::class, 'deletecommunity'])->name('delete_community');
route::match(['get', 'post'], 'createnewsubcommunity', [App\Http\Controllers\CommunityController::class, 'createnewsubcommunity'])->name('create_new_subcommunity');
route::match(['get', 'post'], 'listsubcommunities', [CommunityController::class, 'listsubcommunities'])->name('list_subcommunities');
route::get('updatesubcommunityindex/{id}', [CommunityController::class, 'updatesubcommunityindex'])->name('update_subcommunity_index');
route::post('updatesubcommunity', [CommunityController::class, 'updatesubcommunity'])->name('update_subcommunity');
route::post('deletesubcommunity', [CommunityController::class, 'deletesubcommunity'])->name('delete_subcommunity');

route::get('createcustomerindex', [App\Http\Controllers\CustomerController::class, 'createcustomerindex'])->name('create_customer_index');
route::post('createnewcustomer', [App\Http\Controllers\CustomerController::class, 'createnewcustomer'])->name('create_new_customer');
route::get('updatecustomerindex/{id?}', [App\Http\Controllers\CustomerController::class, 'updatecustomerindex'])->name('update_customer_index');
route::post('updatecustomer', [App\Http\Controllers\CustomerController::class, 'updatecustomer'])->name('update_customer');
route::post('deletecustomer', [App\Http\Controllers\CustomerController::class, 'deletecustomer'])->name('delete_customer');

route::get('createpaymentindex', [App\Http\Controllers\PaymentController::class, 'createpaymentindex'])->name('create_payment_index');
route::post('createnewpayment', [App\Http\Controllers\PaymentController::class, 'createnewpayment'])->name('create_new_payment');
Route::get('upnewproperty/{id?}', [App\Http\Controllers\PropertyController::class, 'upnewproperty'])->name('upnewproperty');
route::post('update_new_property/{id}', [App\Http\Controllers\PropertyController::class, 'update_new_property'])->name('update_new_property');
Route::get('shownewproperty/{id?}', [App\Http\Controllers\PropertyController::class, 'shownewproperty'])->name('shownewproperty');


route::post('assignagenttolandpage', [App\Http\Controllers\HomeController::class, 'assignagenttolandpage'])->name('assign_agent_to_landpage');
route::post('listassignedlandingagent', [App\Http\Controllers\HomeController::class, 'listassignedlandingagent'])->name('list_assigned_landing_agent');

Route::get(
    'test11',
    function () {

        $filename = public_path('/data.csv');
        $file = fopen($filename, "r");
        $all_data = array();
        $duplicated = [];
        while (($data = fgetcsv($file, 200, ",")) !== FALSE) {
            $res = Community::firstOrCreate(['name' => $data[0]], ['name' => $data[0]]);
            if (!$res->wasRecentlyCreated)
                $duplicated[] = $data;
        }
        $f = fopen(public_path('/data1.csv'), 'w');
        foreach ($duplicated as $item) {
            fputcsv($f, $item);
        }
        fclose($f);
        dd($duplicated);
    }
);

route::get('assignagentforlanding', [App\Http\Controllers\HomeController::class, 'assignagentforlanding'])->name('assign_agent_for_landing');
route::post('deletelanding', [App\Http\Controllers\HomeController::class, 'deletelanding'])->name('delete_landing');

route::get('listpaymentsindex', [App\Http\Controllers\PaymentController::class, 'listpaymentsindex'])->name('list_payments_index');
route::post('listpayments', [App\Http\Controllers\PaymentController::class, 'listpayments'])->name('list_payments');
route::post('deletepayment', [App\Http\Controllers\PaymentController::class, 'deletepayment'])->name('delete_payment');

route::get('listusersindex', [App\Http\Controllers\UserController::class, 'listusersindex'])->name('list_users_index');
route::post('listusers', [App\Http\Controllers\UserController::class, 'listusers'])->name('list_users');
route::post('deleteuser', [App\Http\Controllers\UserController::class, 'deleteuser'])->name('delete_user');

route::get('listpropertiesindex', [App\Http\Controllers\PropertyController::class, 'listpropertiesindex'])->name('list_properties_index');
route::post('listproperties', [App\Http\Controllers\PropertyController::class, 'listproperties'])->name('list_properties');
route::get('listarchpropertiesindex', [App\Http\Controllers\PropertyController::class, 'listarchpropertiesindex'])->name('list_archived_properties_index');
route::post('listarchproperties', [App\Http\Controllers\PropertyController::class, 'listarchproperties'])->name('list_archived_properties');
route::post('deleteproperty', [App\Http\Controllers\PropertyController::class, 'deleteproperty'])->name('delete_property');

route::get('createpropertyindex', [App\Http\Controllers\PropertyController::class, 'createpropertyindex'])->name('create_property_index');
route::post('getassigneduserdatainfo', [App\Http\Controllers\HomeController::class, 'getassigneduserdatainfo'])->name('get_assigned_user_data_info');
route::post('getusercommentedinfo', [App\Http\Controllers\HomeController::class, 'getusercommentedinfo'])->name('get_user_commented_info');
route::post('getadmincommentedinfo', [App\Http\Controllers\HomeController::class, 'getadmincommentedinfo'])->name('get_admin_commented_info');
Route::get('get_sub_community/{id?}', [PropertyController::class, 'getsubcommunity'])->name('get_sub_community');
Route::get('get_tower_name/{id?}', [PropertyController::class, 'gettowername'])->name('get_tower_name');

route::post('getcustomerpaymentsinfo', [App\Http\Controllers\HomeController::class, 'getcustomerpaymentsinfo'])->name('get_customer_payments_info');
route::post('getcustomerpropertiesinfo', [App\Http\Controllers\HomeController::class, 'getcustomerpropertiesinfo'])->name('get_customer_properties_info');

route::get('getassigneddataindex', [App\Http\Controllers\HomeController::class, 'getassigneddataindex'])->name('get_assigned_data_index');
route::post('getassignedagentdata', [App\Http\Controllers\HomeController::class, 'getassignedagentdata'])->name('get_assigned_agent_data');
route::post('changeclient', [App\Http\Controllers\HomeController::class, 'changeclient'])->name('changeclient');
route::post('assignagentdata', [App\Http\Controllers\HomeController::class, 'assignagentdata'])->name('assign_agent_data');
route::get('assignagentdataindex', [App\Http\Controllers\HomeController::class, 'assignagentdataindex'])->name('assign_agent_data_index');
route::get('showbooksindex', [App\Http\Controllers\HomeController::class, 'showbooksindex'])->name('showbooksindex');
route::post('showbooks', [App\Http\Controllers\HomeController::class, 'showbooks'])->name('showbooks');
route::get('showbookviews', [App\Http\Controllers\HomeController::class, 'showbookviews'])->name('show_book_views');
route::get('showbookviewsindex', [App\Http\Controllers\HomeController::class, 'showbookviewsindex'])->name('show_book_views_index');

route::post('importenquirycustomer', [App\Http\Controllers\HomeController::class, 'importenquirycustomer'])->name('import_enquiry_customer');

route::get('charts', [ChartController::class, 'index'])->name('getcharts');

route::get('leaderboardindex', [ReportController::class, 'leaderboardindex'])->name('leader_board_index');
route::post('getleaderboard', [ReportController::class, 'getleaderboard'])->name('get_leader_board');
route::get('showdetailsuser/{username?}', [ReportController::class, 'showdetailsuserindex'])->name('show_details_user_index');
route::post('getdetailsuser', [ReportController::class, 'getdetailsuser'])->name('get_details_user');

// qualified data
route::get('qualifiedleadsindex', [App\Http\Controllers\QualifiedLeadsController::class, 'qualifiedleadsindex'])->name('qualified_leads_index');
route::post('qualifiedleads', [App\Http\Controllers\QualifiedLeadsController::class, 'qualifiedleads'])->name('qualified_leads');
route::get('assignagentqualifieddataindex', [App\Http\Controllers\QualifiedLeadsController::class, 'assignagentqualifieddataindex'])->name('assign_agent_qualified_data_index');
route::post('assignagentqualifieddata', [App\Http\Controllers\QualifiedLeadsController::class, 'assignagentqualifieddata'])->name('assign_agent_qualified_data');
route::post('unassignagentqualifieddata', [App\Http\Controllers\QualifiedLeadsController::class, 'unassignagentqualifieddata'])->name('unassign_agent_qualified_data');
route::post('searchforagentqualifieddata', [App\Http\Controllers\QualifiedLeadsController::class, 'searchforagentqualifieddata'])->name('search_for_agent_qualified_data');
route::get('qualifieduserhomeindex', [App\Http\Controllers\QualifiedLeadsController::class, 'qualifieduserhomeindex'])->name('qualified_user_home_index');
Route::post('qualifieduserhomedata', [App\Http\Controllers\QualifiedLeadsController::class, 'qualifieduserhomedata'])->name('qualified_user_home_data');
Route::post('addqualifiedcomment', [App\Http\Controllers\QualifiedLeadsController::class, 'addqualifiedcomment'])->name('add_qualified_comment');
Route::get('showqualifieddatacommentsindex', [App\Http\Controllers\QualifiedLeadsController::class, 'showqualifieddatacommentsindex'])->name('show_qualified_data_comments_index');
Route::post('showqualifieddatacomments', [App\Http\Controllers\QualifiedLeadsController::class, 'showqualifieddatacomments'])->name('show_qualified_data_comments');
route::post('getqualifieddatacommentsinfo', [App\Http\Controllers\QualifiedLeadsController::class, 'getqualifieddatacommentsinfo'])->name('get_qualified_data_comments_info');
route::post('getadminqualifieddatacommentsinfo', [App\Http\Controllers\QualifiedLeadsController::class, 'getadminqualifieddatacommentsinfo'])->name('get_admin_qualified_data_comments_info');
route::get('showuserqualifieddatacommentsindex', [App\Http\Controllers\QualifiedLeadsController::class, 'showuserqualifieddatacommentsindex'])->name('show_user_qualified_data_comments_index');
route::get('showassignedagentqualifiedindex', [App\Http\Controllers\QualifiedLeadsController::class, 'showassignedagentqualifiedindex'])->name('show_assigned_agent_qualified_index');
route::post('showassignedagentqualifieddata', [App\Http\Controllers\QualifiedLeadsController::class, 'showassignedagentqualifieddata'])->name('show_assigned_agent_qualified_data');
Route::post('sendemailtoqualifiedleads', [App\Http\Controllers\QualifiedLeadsController::class, 'sendemailtoqualifiedleads'])->name('sendemailtoqualifiedleads');
Route::post('commentQualifiedleds', [App\Http\Controllers\QualifiedLeadsController::class, 'commentQualifiedleds'])->name('commentQualifiedleds');
Route::get('showcommentsqualifiedleads/{data_id}/{user_id}/{stage}', [App\Http\Controllers\QualifiedLeadsController::class, 'showcommentsqualifiedleads'])->name('get_comments_Qualified_leads');
Route::get('getcommentsqualifiedadmin/{data_id}/{agentname}', [App\Http\Controllers\QualifiedLeadsController::class, 'getcommentsqualifiedadmin'])->name('get_comments_qualified_admin');
// Route::get('sendemailtoagentbeforetheappointment',[App\Http\Controllers\QualifiedLeadsController::class,'sendemailtoagentbeforetheappointment'])->name('sendemailtoagentbeforetheappointment');

// leads pool
route::get('leadspoolindex', [App\Http\Controllers\LeadsPoolController::class, 'leadspoolindex'])->name('leads_pool_index');
route::post('leadspool', [App\Http\Controllers\LeadsPoolController::class, 'leadspool'])->name('leads_pool');
route::get('assignagentleadspoolindex', [App\Http\Controllers\LeadsPoolController::class, 'assignagentleadspoolindex'])->name('assign_agent_leads_pool_index');
route::post('assignagentleadspooldata', [App\Http\Controllers\LeadsPoolController::class, 'assignagentleadspooldata'])->name('assign_agent_leads_pool_data');
route::post('changeclientleadspooldata', [App\Http\Controllers\LeadsPoolController::class, 'changeclientleadspooldata'])->name('changeclientleadspooldata');
route::post('searchforagentleadspooldata', [App\Http\Controllers\LeadsPoolController::class, 'searchforagentleadspooldata'])->name('search_for_agent_leads_pool_data');
route::get('leadspooluserhomeindex', [App\Http\Controllers\LeadsPoolController::class, 'leadspooluserhomeindex'])->name('leads_pool_user_home_index');
Route::post('leadspooluserhomedata', [App\Http\Controllers\LeadsPoolController::class, 'leadspooluserhomedata'])->name('leads_pool_user_home_data');
Route::post('addleadspoolcomment', [App\Http\Controllers\LeadsPoolController::class, 'addleadspoolcomment'])->name('add_leads_pool_comment');
Route::get('showleadspooldatacommentsindex', [App\Http\Controllers\LeadsPoolController::class, 'showleadspooldatacommentsindex'])->name('show_leads_pool_data_comments_index');
Route::post('showleadspooldatacomments', [App\Http\Controllers\LeadsPoolController::class, 'showleadspooldatacomments'])->name('show_leads_pool_data_comments');
route::post('getleadspooldatacommentsinfo', [App\Http\Controllers\LeadsPoolController::class, 'getleadspooldatacommentsinfo'])->name('get_leads_pool_data_comments_info');
route::post('getadminleadspooldatacommentsinfo', [App\Http\Controllers\LeadsPoolController::class, 'getadminleadspooldatacommentsinfo'])->name('get_admin_leads_pool_data_comments_info');
route::get('showuserleadspooldatacommentsindex', [App\Http\Controllers\LeadsPoolController::class, 'showuserleadspooldatacommentsindex'])->name('show_user_leads_pool_data_comments_index');
route::get('showassignedagentleadspoolindex', [App\Http\Controllers\LeadsPoolController::class, 'showassignedagentleadspoolindex'])->name('show_assigned_agent_leads_pool_index');
route::post('showassignedagentleadspooldata', [App\Http\Controllers\LeadsPoolController::class, 'showassignedagentleadspooldata'])->name('show_assigned_agent_leads_pool_data');
Route::post('sendemailtoleadspool', [App\Http\Controllers\LeadsPoolController::class, 'sendemailtoleadspool'])->name('sendemailtoleadspool');
Route::post('sendsmstoleadspool', [App\Http\Controllers\LeadsPoolController::class, 'sendsmstoleadspool'])->name('sendsmstoleadspool');
Route::get('getcommentsleadspool/{data_id?}', [App\Http\Controllers\LeadsPoolController::class, 'getcommentsleadspool'])->name('get_comments_leads_pool');
Route::get('getcommentsleadspooladmin/{data_id}/{agentname}', [App\Http\Controllers\LeadsPoolController::class, 'getcommentsleadspooladmin'])->name('get_comments_leads_pool_admin');
Route::post('addcommentmoreleadspool', [App\Http\Controllers\LeadsPoolController::class, 'addcommentmoreleadspool'])->name('add_comment_more_leads_pool');


// follow up leads
route::get('followupindex', [App\Http\Controllers\FollowUpController::class, 'followupindex'])->name('follow_up_index');
route::post('followup', [App\Http\Controllers\FollowUpController::class, 'followup'])->name('follow_up');
route::get('assignagentfollowupindex', [App\Http\Controllers\FollowUpController::class, 'assignagentfollowupindex'])->name('assign_agent_follow_up_index');
route::post('assignagentfollowupdata', [App\Http\Controllers\FollowUpController::class, 'assignagentfollowupdata'])->name('assign_agent_follow_up_data');
route::post('unassignagentfollowupdata', [App\Http\Controllers\FollowUpController::class, 'unassignagentfollowupdata'])->name('unassign_agent_follow_up_data');
route::post('searchforagentfollowupdata', [App\Http\Controllers\FollowUpController::class, 'searchforagentfollowupdata'])->name('search_for_agent_follow_up_data');
route::get('followupuserhomeindex', [App\Http\Controllers\FollowUpController::class, 'followupuserhomeindex'])->name('follow_up_user_home_index');
Route::post('followupuserhomedata', [App\Http\Controllers\FollowUpController::class, 'followupuserhomedata'])->name('follow_up_user_home_data');
Route::post('addfollowupcomment', [App\Http\Controllers\FollowUpController::class, 'addfollowupcomment'])->name('add_follow_up_comment');
Route::get('showfollowupdatacommentsindex', [App\Http\Controllers\FollowUpController::class, 'showfollowupdatacommentsindex'])->name('show_follow_up_data_comments_index');
Route::post('showfollowupdatacomments', [App\Http\Controllers\FollowUpController::class, 'showfollowupdatacomments'])->name('show_follow_up_data_comments');
route::post('getfollowupdatacommentsinfo', [App\Http\Controllers\FollowUpController::class, 'getfollowupdatacommentsinfo'])->name('get_follow_up_data_comments_info');
route::post('getadminfollowupdatacommentsinfo', [App\Http\Controllers\FollowUpController::class, 'getadminfollowupdatacommentsinfo'])->name('get_admin_follow_up_data_comments_info');
route::get('showuserfollowupdatacommentsindex', [App\Http\Controllers\FollowUpController::class, 'showuserfollowupdatacommentsindex'])->name('show_user_follow_up_data_comments_index');
route::get('showassignedagentfollowupindex', [App\Http\Controllers\FollowUpController::class, 'showassignedagentfollowupindex'])->name('show_assigned_agent_follow_up_index');
route::post('showassignedagentfollowupdata', [App\Http\Controllers\FollowUpController::class, 'showassignedagentfollowupdata'])->name('show_assigned_agent_follow_up_data');
route::post('sendemailtofollowUpleads', [App\Http\Controllers\FollowUpController::class, 'sendemailtofollowUpleads'])->name('sendemailtofollowUpleads');
route::post('commentfollowupleds', [App\Http\Controllers\FollowUpController::class, 'commentfollowupleds'])->name('commentfollowupleds');
route::post('showmorecommentfollowup', [App\Http\Controllers\FollowUpController::class, 'showmorecommentfollowup'])->name('show_more_comment_followup');
route::post('showcommentsfollowupleads', [App\Http\Controllers\FollowUpController::class, 'showcommentsfollowupleads'])->name('get_comments_followup_lead');

//Proceeded Lead
Route::get('proceededuserhomeindex', [App\Http\Controllers\ProceededLeadController::class, 'proceededuserhomeindex'])->name('proceeded_user_home_index');
Route::post('proceededuserhomedata', [App\Http\Controllers\ProceededLeadController::class, 'proceededuserhomedata'])->name('proceeded_user_home_data');
Route::post('addproceededcomment', [App\Http\Controllers\ProceededLeadController::class, 'addproceededcomment'])->name('add_proceeded_comment');
Route::post('commentproceededleads', [App\Http\Controllers\ProceededLeadController::class, 'commentproceededleads'])->name('comment_proceeded_leads');
Route::get('showcommentsproceededleads/{data_id}/{user_id}/{stage}', [App\Http\Controllers\ProceededLeadController::class, 'showcommentsproceededleads'])->name('get_comments_proceeded_leads');
Route::get('showproceededdatacommentsindex', [App\Http\Controllers\ProceededLeadController::class, 'showproceededdatacommentsindex'])->name('show_proceeded_data_comments_index');
Route::post('getadminproceededdatacommentsinfo', [App\Http\Controllers\ProceededLeadController::class, 'getadminproceededdatacommentsinfo'])->name('get_admin_proceeded_data_comments_info');
Route::post('showproceededdatacomments', [App\Http\Controllers\ProceededLeadController::class, 'showproceededdatacomments'])->name('show_proceeded_data_comments');
Route::get('proceededleadsindex', [App\Http\Controllers\ProceededLeadController::class, 'proceededleadsindex'])->name('proceeded_leads_index');
Route::post('proceededleads', [App\Http\Controllers\ProceededLeadController::class, 'proceededleads'])->name('proceeded_leads');
Route::post('sendemailtoproceededleads', [App\Http\Controllers\ProceededLeadController::class, 'sendemailtoproceededleads'])->name('sendemailtoproceededleads');
route::get('showuserproceededdatacommentsindex', [App\Http\Controllers\ProceededLeadController::class, 'showuserproceededdatacommentsindex'])->name('show_user_proceeded_data_comments_index');
Route::get('getcommentsproceededadmin/{data_id}/{agentname}', [App\Http\Controllers\ProceededLeadController::class, 'getcommentsproceededadmin'])->name('get_comments_proceeded_admin');
Route::post('allcomments', [App\Http\Controllers\ProceededLeadController::class, 'allcomments'])->name('allcomments');
Route::post('showleadsinfo', [App\Http\Controllers\ProceededLeadController::class, 'showleadsinfo'])->name('showleadsinfo');
Route::post('historycomment', [App\Http\Controllers\ProceededLeadController::class, 'historycomment'])->name('historycomment');


route::get('wonleadsindex', [App\Http\Controllers\HomeController::class, 'wonleadsindex'])->name('won_leads_index');
route::post('wonleadsdata', [App\Http\Controllers\HomeController::class, 'wonleadsdata'])->name('won_leads_data');

route::get('deadleadsindex', [App\Http\Controllers\HomeController::class, 'deadleadsindex'])->name('dead_leads_index');
route::post('deadleadsdata', [App\Http\Controllers\HomeController::class, 'deadleadsdata'])->name('dead_leads_data');

route::get('createinventoryindex', [App\Http\Controllers\inventoryController::class, 'createinventoryindex'])->name('create_inventory_index');
route::post('createnewinventory', [App\Http\Controllers\inventoryController::class, 'createnewinventory'])->name('create_new_inventory');
route::post('importinventory', [App\Http\Controllers\inventoryController::class, 'importinventory'])->name('import_inventory');
route::get('getinventoriesindex', [App\Http\Controllers\inventoryController::class, 'getinventoriesindex'])->name('get_inventories_index');
Route::post('getinventories', [App\Http\Controllers\inventoryController::class, 'getinventories'])->name('get_inventories');
Route::post('deleteinventory', [App\Http\Controllers\inventoryController::class, 'deleteinventory'])->name('delete_inventory');
Route::post('updatecommentdata', [App\Http\Controllers\HomeController::class, 'updatecommentdata'])->name('update_comment_data');
Route::post('updatecommentquilifydata', [App\Http\Controllers\QualifiedLeadsController::class, 'updatecommentquilifydata'])->name('update_comment_quilify_data');
Route::post('updatecommentlesadsbooldata', [App\Http\Controllers\LeadsPoolController::class, 'updatecommentlesadsbooldata'])->name('update_comment_lesads_bool_data');
Route::post('updatecommentfollowupdata', [App\Http\Controllers\FollowUpController::class, 'updatecommentfollowupdata'])->name('update_comment_followup_data');
Route::get('createsuperAdmin', [App\Http\Controllers\UserController::class, 'createsuperAdmin'])->name('create_super_Admin');
Route::post('storesuperAdmin', [App\Http\Controllers\UserController::class, 'storesuperAdmin'])->name('storesuperAdmin');
Route::post('sendemailtoleads', [App\Http\Controllers\HomeController::class, 'sendemailtoleads'])->name('sendemailtoleads');

// XMl
Route::feeds();
// Import Xml
Route::match(["get", "post"], "import_xml", [App\Http\Controllers\ImportXmlXontroller::class, "index"])->name('xml-import');

Route::post('sendsmstoleads', [App\Http\Controllers\HomeController::class, 'sendsmstoleads'])->name('sendsmstoleads');
Route::post('showappoentmentdatetoday', [App\Http\Controllers\HomeController::class, 'showappoentmentdatetoday'])->name('show_appoentmentdate_today');
Route::post('changeappoentmentdateshow', [App\Http\Controllers\HomeController::class, 'changeappoentmentdateshow'])->name('changeappoentmentdateshow');


Route::get('showcommentsindex', [App\Http\Controllers\HomeController::class, 'showdatacommentsindex'])->name('show_comments_admin_index');
Route::post('showdatacomments', [App\Http\Controllers\HomeController::class, 'showdatacomments'])->name('show_comments_admin');
/////////event
Route::get('eventindex', [App\Http\Controllers\EventController::class, 'eventindex'])->name('create_event');
Route::post('eventstory', [App\Http\Controllers\EventController::class, 'eventstory'])->name('eventstory');
Route::get('showevent', [App\Http\Controllers\EventController::class, 'showevent'])->name('list_event');
Route::post('events', [App\Http\Controllers\EventController::class, 'events'])->name('list_event_datatable');
Route::post('deleteevent', [App\Http\Controllers\EventController::class, 'deleteevent'])->name('delete_event');
Route::get('editevent/{id?}', [App\Http\Controllers\EventController::class, 'editevent'])->name('edit_event');
Route::post('eventupdate', [App\Http\Controllers\EventController::class, 'eventupdate'])->name('eventupdate');
Route::post('eventdetalis', [App\Http\Controllers\EventController::class, 'eventdetalis'])->name('eventdetalis');
Route::post('Attend', [App\Http\Controllers\EventController::class, 'Attend'])->name('Attend');
Route::get('attend/{event_id}/{user_id?}', [App\Http\Controllers\EventController::class, 'attendLink'])->name('attendLink');
Route::post('uploadattendpoof', [App\Http\Controllers\EventController::class, 'uploadattendpoof'])->name('upload_attend_poof');
Route::get('addtocalendar/{id}', [App\Http\Controllers\EventController::class, 'addtocalendar'])->name('add_to_calendar');
Route::get('aproved/{id}', [App\Http\Controllers\EventController::class, 'aproved'])->name('aproved');
Route::get('reject/{id}', [App\Http\Controllers\EventController::class, 'reject'])->name('reject');
Route::get('calender/{id}', [App\Http\Controllers\EventController::class, 'calender'])->name('calender');
Route::post('storecalender', [App\Http\Controllers\EventController::class, 'storecalender'])->name('storecalender');
Route::post('approvedcrm', [App\Http\Controllers\EventController::class, 'approvedcrm'])->name('approved_crm');
Route::post('rejectcrm', [App\Http\Controllers\EventController::class, 'rejectcrm'])->name('reject_crm');
Route::get('add_event_to_calendar/{id}/{type}', [EventController::class, 'add_event_to_calendar']);

// Meetings
Route::match(['get', 'post'], 'createmeeting', [MeetingController::class, 'index'])->name('create.meeting');
Route::match(['get', 'post'], 'listmeetings', [MeetingController::class, 'list'])->name('list.meetings');
Route::match(['get', 'post'], 'attendmeeting/{id?}', [MeetingController::class, 'attend'])->name('attend.meeting');
Route::post('update', [MeetingController::class, 'update'])->name('meeting.update');
Route::delete('deletemeeting', [MeetingController::class, 'delete'])->name('delete.meeting');
Route::get('add_meeting_to_calendar/{id}', [MeetingController::class, 'add_meeting_to_calendar']);

/// Appointment
Route::get('createappointmentindex', [App\Http\Controllers\AppointmentController::class, 'createappointmentindex'])->name('create_appointment_index');
Route::post('createnewappointment', [App\Http\Controllers\AppointmentController::class, 'createnewappointment'])->name('create_new_appointment');
Route::get('confirmappointment/{appointment_id}/{agent_id}', [App\Http\Controllers\AppointmentController::class, 'confirmappointment'])->name('confirm_appointment');
Route::get('rejectappointment/{appointment_id}/{agent_id}', [App\Http\Controllers\AppointmentController::class, 'rejectappointment'])->name('reject_appointment');
Route::post('confirmappointmentcrm', [App\Http\Controllers\AppointmentController::class, 'confirmappointmentcrm'])->name('confirm_appointment_crm');
Route::post('rejectappointmentcrm', [App\Http\Controllers\AppointmentController::class, 'rejectappointmentcrm'])->name('reject_appointment_crm');
Route::get('updateappointmentindex/{id?}', [App\Http\Controllers\AppointmentController::class, 'updateappointmentindex'])->name('update_appointment_index');
Route::post('updateappointment', [App\Http\Controllers\AppointmentController::class, 'updateappointment'])->name('update_appointment');
Route::get('showappointmentindex', [App\Http\Controllers\AppointmentController::class, 'showappointmentindex'])->name('show_appointment_index');
Route::post('showappointment', [App\Http\Controllers\AppointmentController::class, 'showappointment'])->name('show_appointment');
Route::post('deleteappointment', [App\Http\Controllers\AppointmentController::class, 'deleteappointment'])->name('delete_appointment');
Route::post('bookappointment', [App\Http\Controllers\AppointmentController::class, 'bookappointment'])->name('book_appointment');
Route::post('requestapponitment', [App\Http\Controllers\AppointmentController::class, 'requestapponitment'])->name('request_apponitment');
///////calender
Route::get('getcalender', [App\Http\Controllers\HomeController::class, 'getcalender'])->name('get_calender');



Route::get('getcommentsimportedleads/{data_id}/{user_id}/{stage}', [App\Http\Controllers\HomeController::class, 'getcommentsimportedleads'])->name('get_comments_imported_leads');
Route::get('getcommentsfollowupleads/{data_id}/{user_id}/{stage}', [App\Http\Controllers\FollowUpController::class, 'getcommentsfollowupleads'])->name('get_comments_followup_leads');
Route::get('officetime', [App\Http\Controllers\ReportController::class, 'officetime'])->name('officetime');
Route::post('getofficetime', [App\Http\Controllers\ReportController::class, 'getofficetime'])->name('get_office_time');
Route::get('Success', [App\Http\Controllers\ReportController::class, 'Success'])->name('Success');
Route::post('getSuccess', [App\Http\Controllers\ReportController::class, 'getSuccess'])->name('get_Success');

Route::match(['get','post'], 'reportassignedagentsleads', [ReportController::class, 'reportassignedagentsleads'])->name('reportassignedagentsleads');


// Route::delete('delete_property_images/{id}', [App\Http\Controllers\PropertyController::class, 'delete_property_images'])
//     ->name('delete_property_images');

//creat blog
Route::get('create_blog', [App\Http\Controllers\EventController::class, 'create_blog'])->name('create_blog');
Route::post('create_new_blog', [App\Http\Controllers\EventController::class, 'create_new_blog'])->name('create_new_blog');
//list blog
Route::get('listblogindex', [App\Http\Controllers\EventController::class, 'listblogindex'])->name('listblogindex');
Route::post('list_blog', [App\Http\Controllers\EventController::class, 'list_blog'])->name('list_blog');
//update
Route::get('upnewblog/{id?}', [App\Http\Controllers\EventController::class, 'upnewblog'])->name('upnewblog');
route::post('update_blog/{id}', [App\Http\Controllers\EventController::class, 'update_blog'])->name('update_blog');
//delet
route::post('delete_blog', [App\Http\Controllers\EventController::class, 'delete_blog'])->name('delete_blog');


//create building
Route::get('create_building', [App\Http\Controllers\BuildingController::class, 'create_building'])->name('create_building');
Route::post('create_building', [App\Http\Controllers\BuildingController::class, 'create_new_building'])->name('create_new_building');
//list building
Route::get('listbuildingindex', [App\Http\Controllers\BuildingController::class, 'listbuildingindex'])->name('listbuildingindex');
Route::post('list_building', [App\Http\Controllers\BuildingController::class, 'list_building'])->name('list_building');
//update building
Route::get('upnewbuilding/{id?}', [App\Http\Controllers\BuildingController::class, 'upnewbuilding'])->name('upnewbuilding');
Route::post('update_building/{id}', [App\Http\Controllers\BuildingController::class, 'update_building'])->name('update_building');
//delete building
Route::post('delete_building', [App\Http\Controllers\BuildingController::class, 'delete_building'])->name('delete_building');

//duplicate property
Route::get('duplicateproperty/{id?}', [App\Http\Controllers\PropertyController::class, 'duplicateproperty'])->name('duplicateproperty');
Route::post('duplicate_property/{id}', [App\Http\Controllers\PropertyController::class, 'duplicate_property'])->name('duplicate_property');

//create developer
Route::get('create_developer', [App\Http\Controllers\DeveloperController::class, 'create_developer'])->name('create_developer');
Route::post('create_new_developer', [App\Http\Controllers\DeveloperController::class, 'create_new_developer'])->name('create_new_developer');
//list developer
Route::get('listdeveloperindex', [App\Http\Controllers\DeveloperController::class, 'listdeveloperindex'])->name('listdeveloperindex');
Route::post('list_developer', [App\Http\Controllers\DeveloperController::class, 'list_developer'])->name('list_developer');
//update developer
Route::get('upnewdeveloper/{id?}', [App\Http\Controllers\DeveloperController::class, 'upnewdeveloper'])->name('upnewdeveloper');
route::post('update_developer/{id}', [App\Http\Controllers\DeveloperController::class, 'update_developer'])->name('update_developer');
//delet developer
route::post('delete_developer', [App\Http\Controllers\DeveloperController::class, 'delete_developer'])->name('delete_developer');


// Import Building
Route::get('/import_view_building',[App\Http\Controllers\ImportExcelController::class,
            'import_buildingView'])->name('import_view_building');
Route::post('/import_building',[App\Http\Controllers\ImportExcelController::class,
            'import_building'])->name('import_building');
Route::controller(SubscriptionController::class)->prefix('subscriptions')->group(function () {
    Route::match(['post', 'get'], '/', 'index')->name('subscriptions');
    Route::post('/delete-subscription', 'delete')->name('subscriptionsdelete');
});

Route::get('/signature',[SignatureController::class,'index'])->name('signature.index');
Route::post('/signature',[SignatureController::class,'update'])->name('signature.update');

Route::match(['get', 'post'], '/contact_us_list',[App\Http\Controllers\ContactUsController::class, 'contact_us_list'])->name('contact_us_list');
Route::get('/contact_us_delete',[App\Http\Controllers\ContactUsController::class, 'contact_us_delete'])->name('contact_us_delete');
Route::match(['post', 'get'], '/insight_create', [InsightController::class,'insight_create'])->name('insight_create');
Route::match(['post', 'get'], '/insight_list', [InsightController::class,'insight_list'])->name('insight_list');
Route::match(['post', 'get'], '/insight_list_update/{id}', [InsightController::class,'insight_list_update'])->name('insight_update');
Route::post('/insight_delete', [InsightController::class,'insight_delete'])->name('insight_delete');

Route::match(['post', 'get'], '/marketing_create', [MarketingController::class,'marketing_create'])->name('create_marketing');
Route::match(['post', 'get'], '/marketing_list', [MarketingController::class,'marketing_list'])->name('list_marketing');
Route::post('/marketing_delete', [MarketingController::class,'marketing_delete'])->name('delete_marketing');
Route::match(['post', 'get'], '/marketing_update/{id}', [MarketingController::class,'marketing_update'])->name('marketing_update');

Route::match(['post', 'get'], '/listing_create', [MarketingController::class,'listing_create'])->name('create_listing');
Route::match(['post', 'get'], '/listing_list', [MarketingController::class,'listing_list'])->name('list_listing');
Route::post('/listing_delete', [MarketingController::class,'listing_delete'])->name('delete_listing');
Route::match(['post', 'get'], '/listing_update/{id}', [MarketingController::class,'listing_update'])->name('update_listing');

// Off-Plan Projects
Route::match(['post', 'get'], '/off_plan_project_create', [OffPlanProjectController::class,'off_plan_project_create'])->name('off_plan_project_create');
Route::match(['post', 'get'], '/testimonial_project_create', [HomePageController::class,'testimonial_project_create'])->name('create_testimonial');
Route::match(['post', 'get'], '/real_estate_guides', [RealEstateController::class,'real_estate_guides_create'])->name('real_estate_guides_create');
Route::post('/real_estate_guides_delete', [RealEstateController::class,'real_estate_guides_delete'])->name('real_estate_guides_delete');
Route::match(['post', 'get'], '/real_estate_guides_update/{id}', [RealEstateController::class,'real_estate_guides_update'])->name('real_estate_guides_update');
Route::get('download/{filename}', [RealEstateController::class, 'download'])->name('file.download');

Route::match(['post', 'get'], '/off_plan_project_list', [OffPlanProjectController::class,'off_plan_project_list'])->name('off_plan_project_list');
Route::match(['post', 'get'], '/testimonial_project_list', [HomePageController::class,'testimonial_project_list'])->name('list_testimonials');
Route::match(['post', 'get'], '/real_estate_list', [RealEstateController::class,'real_estate_list'])->name('real_estate_list');
Route::match(['post', 'get'], '/off_plan_project_update/{id}', [OffPlanProjectController::class,'off_plan_project_update'])->name('off_plan_project_update');
Route::match(['post', 'get'], '/testimonial_project_update/{id}', [HomePageController::class,'testimonial_project_update'])->name('testimonial_project_update');
Route::match(['post', 'get'], '/popup', [OffPlanProjectController::class,'popUpUpdate'])->name('pop-up-update');
Route::post('/off_plan_project_delete', [OffPlanProjectController::class,'off_plan_project_delete'])->name('off_plan_project_delete');
Route::post('/testimonial_project_delete', [HomePageController::class,'testimonial_project_delete'])->name('testimonial_project_delete');
Route::controller(CountryController::class)->prefix('countries')->group(function () {
    Route::match(['post', 'get'], '/', 'index')->name('list_countries');
    Route::match(['post', 'get'], '/create', 'create')->name('create_country');
    Route::match(['post', 'get'], '/update/{id?}', 'update')->name('update_country');
    Route::post('/delete', 'delete')->name('delete_country');
});
// cities
Route::controller(CountryController::class)->prefix('cities')->group(function () {
    Route::match(['post', 'get'], '/', 'list_cities')->name('list_cities');
    Route::match(['post', 'get'], '/create', 'create_city')->name('create_city');
    Route::match(['post', 'get'], '/update/{id?}', 'update_city')->name('update_city');
    Route::post('/delete', 'delete_city')->name('delete_city');
    Route::get('/get_cities/{country_id?}', 'get_cities')->name('get_cities');

});
Route::get('/emails', [SignatureController::class, 'showEmails'])->name('emails.show');
Route::post('/emails', [SignatureController::class, 'processEmails'])->name('emails.process');
Route::post('/emails/delete', [SignatureController::class, 'delete'])->name('emails.delete');


Route::controller(DownloadedBrochureController::class)->prefix('Brochure')->group(function () {
    Route::match(['post', 'get'], '/', 'index')->name('downloadedBrochures');
    Route::post('/delete-downloadedBrochure', 'delete')->name('delete_downloadedBrochure');
});
Route::match(['post', 'get'], '/faq_create', [FaqController::class,'faq_create'])->name('faq_create');
Route::match(['post', 'get'], '/faq_list', [FaqController::class,'faq_list'])->name('faq_list');
Route::match(['post', 'get'], '/faq_list_update/{id}', [FaqController::class,'faq_list_update'])->name('faq_update');
Route::post('/faq_delete', [FaqController::class,'faq_delete'])->name('faq_delete');

Route::match(['post', 'get'], '/global_project_create', [FaqController::class,'global_project_create'])->name('create_global');
Route::match(['post', 'get'], '/global_project_list', [FaqController::class,'global_project_list'])->name('list_globals');
Route::match(['post', 'get'], '/global_project_update/{id}', [FaqController::class,'global_project_update'])->name('global_project_update');
Route::post('/global_project_delete', [FaqController::class,'global_project_delete'])->name('global_project_delete');

// Careers & Applicants
Route::match(['post', 'get'], '/career_create', [CareerController::class, 'career_create'])->name('career_create');
Route::match(['post', 'get'], '/career_list', [CareerController::class, 'career_list'])->name('career_list');
Route::match(['post', 'get'], '/career_update/{id}', [CareerController::class, 'career_update'])->name('career_update');
Route::post('/career_delete', [CareerController::class, 'career_delete'])->name('career_delete');
Route::match(['post', 'get'], '/career_applicants/{careerId}', [CareerController::class, 'career_applicants'])->name('career_applicants');
Route::post('/career_apply/{careerId}', [CareerController::class, 'apply'])->name('career_apply');
