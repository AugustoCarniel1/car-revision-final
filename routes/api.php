<?php

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

// Owner Based Requests
Route::apiResource('owner', 'App\Http\Controllers\OwnerController');
Route::get('owner/bygender/{gender}', 'App\Http\Controllers\OwnerController@by_gender');

// Brand Based Requests
Route::apiResource('brand', 'App\Http\Controllers\CarBrandController');

// Vehicle Based Requests
Route::get('vehicle/infos', 'App\Http\Controllers\VehicleController@count_info');
Route::get('vehicles/byowner/{owner_id?}', 'App\Http\Controllers\VehicleController@by_owner');
Route::get('vehicle/{filter}/{gender}', 'App\Http\Controllers\VehicleController@list');
Route::post('vehicle/register', 'App\Http\Controllers\VehicleController@register');

// Revision Based Requests
Route::get('revision/infos', 'App\Http\Controllers\RevisionController@get_info');
Route::get('revision/byvehicle/{vehicle_id}', 'App\Http\Controllers\RevisionController@by_vehicle');
Route::post('revision/register', 'App\Http\Controllers\RevisionController@register');
