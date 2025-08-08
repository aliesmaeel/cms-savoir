<?php

use App\Http\Controllers\leadsregisteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyApiController;

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
