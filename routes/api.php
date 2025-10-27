<?php

use App\Http\Controllers\Api\PropertyApiController;
use App\Http\Controllers\leadsregisteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('pf_webhook_lead_store',[leadsregisteController::class, 'property_finder_webhook_lead_store']);
Route::get('/getProperties', [PropertyApiController::class, 'getProperties'])->name('get_Properties');
Route::get('/getCommunities', [PropertyApiController::class, 'getCommunities'])->name('get_Communities');
Route::get('/getSubCommunities', [PropertyApiController::class, 'getSubCommunities'])->name('get_Sub_Communities');
Route::get('/getBuildings', [PropertyApiController::class, 'getBuildings'])->name('get_Buildings');


Route::get('/home', [\App\Http\Controllers\Api\HomeController::class, 'homePage']);
Route::get('/news', [\App\Http\Controllers\Api\HomeController::class, 'news']);
Route::get('/news/{slug}', [\App\Http\Controllers\Api\HomeController::class, 'newsDetails']);
Route::get('/updateShares/{id}', [\App\Http\Controllers\Api\HomeController::class, 'updateShares']);

Route::get('/blogs', [\App\Http\Controllers\Api\HomeController::class, 'blogs']);
Route::get('/blogs/{slug}', [\App\Http\Controllers\Api\HomeController::class, 'blogDetails']);

Route::post('/search', [\App\Http\Controllers\Api\HomeController::class, 'search']);

Route::get('/search-suggestions', [\App\Http\Controllers\Api\HomeController::class, 'searchSuggestions']);
Route::post('/subscribe', [\App\Http\Controllers\Api\HomeController::class, 'subscribe']);
Route::post('/downloadBrochure', [\App\Http\Controllers\Api\HomeController::class, 'downloadBrochure']);
Route::post('/talk-to-expert', [\App\Http\Controllers\Api\HomeController::class, 'talkToExpert']);
Route::post('/contact-us', [\App\Http\Controllers\Api\HomeController::class, 'contactUs']);
Route::post('/emails/mark-read', [\App\Http\Controllers\Api\HomeController::class, 'markAsRead'])->name('emails.markRead');

Route::get('/faqs', [\App\Http\Controllers\Api\HomeController::class, 'faqs']);
Route::get('/teams', [\App\Http\Controllers\Api\HomeController::class, 'teams']);
Route::get('/teams/{slug}', [\App\Http\Controllers\Api\HomeController::class, 'teamDetails']);

Route::post('/search-offplan', [\App\Http\Controllers\Api\HomeController::class, 'searchOffplan']);
Route::get('/offplan-projects', [\App\Http\Controllers\Api\HomeController::class, 'offplanProjects']);
Route::get('/offplan-projects/{slug}', [\App\Http\Controllers\Api\HomeController::class, 'offplanProjectDetails']);
Route::get('/global-project/{name}', [\App\Http\Controllers\Api\HomeController::class, 'globalProjectDetails']);
Route::get('/popular-areas/{slug}', [\App\Http\Controllers\Api\HomeController::class, 'popularAreaDetails']);
Route::post('/career', [\App\Http\Controllers\Api\HomeController::class, 'career']);
Route::get('/property/{slug}', [\App\Http\Controllers\Api\HomeController::class, 'propertyDetails']);
