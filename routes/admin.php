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



Route::post('auth/login', 'AuthController@login');

Route::post('auth/logout', 'AuthController@logout');

Route::post('auth/refresh-token', 'AuthController@refresh');

Route::get('/', 'AuthController@getAuthUser');

Route::post('add-new-admin', 'NewAdminsController@newAdmin');

Route::post('change-password', 'NewAdminsController@changePassword');

Route::post('{admin}/block', 'NewAdminsController@blockAdmin');

Route::post('{admin}/unblock', 'NewAdminsController@unBlockAdmin');

Route::patch('update/', 'AdminsController@updateAdmin');

Route::get('fetch/facilitators', 'AdminsController@getUsers');

Route::get('fetch-admins', 'AdminsController@fetchAdmins');

#--------------------------- Region -------------------------------------

Route::get('fetch/regions', 'ResourcesController@regionsIndex');

Route::post('store/regions', 'ResourcesController@storeRegion');

Route::post('update/{region}/regions', 'ResourcesController@updateRegion');

Route::post('fetch/{region}/region', 'ResourcesController@showRegion');

Route::delete('delete/{region}/regions', 'ResourcesController@deleteRegion');

#--------------------------- End Region -----------------------------------------------------


#--------------------------- District -------------------------------------

Route::get('fetch/district', 'ResourcesController@districtIndex');

Route::post('store/district', 'ResourcesController@storeDistrict');

Route::post('update/{district}/district', 'ResourcesController@updateDistrict');

Route::delete('delete/{district}/district', 'ResourcesController@deleteDistrict');

#--------------------------- End District -----------------------------------------------------


#--------------------------- Facility -------------------------------------

Route::get('fetch/facilities', 'ResourcesController@facilityIndex');

Route::post('store/facility', 'ResourcesController@storeFacility');

Route::post('update/{facility}/facility', 'ResourcesController@updateFacility');

Route::delete('delete/{facility}/facility', 'ResourcesController@deleteFacility');

#--------------------------- End Facility -----------------------------------------------------

#--------------------------- Facilitator -------------------------------------

Route::post('create/facilitator', 'AdminsController@createFacilitator');

Route::put('update/{user}/facilitator', 'AdminsController@updateFacilitator');

Route::delete('delete/{user}/facilitator', 'AdminsController@deleteFacilitator');

#--------------------------- End Facilitator -----------------------------------------------------


Route::fallback(function(){

    return response()->json(['message' => 'Route not found'], 404);
});
