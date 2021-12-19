<?php

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


Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'AuthController@login');

    Route::post('logout', 'AuthController@logout');

    Route::post('refresh-token', 'AuthController@refresh');

    Route::post('request/password/reset', 'PasswordResetController@sendResetMail');

    Route::post('reset/password', 'PasswordResetController@reset');

    Route::post('change/password', 'PasswordResetController@changeUserPassword');

    Route::put('update/profile', 'AuthController@updateProfile');

});

Route::get('/', 'AuthController@getAuthUser');

Route::post('add-new-admin', 'NewAdminsController@newAdmin');

Route::patch('{admin}/block', 'NewAdminsController@blockAdmin');

Route::patch('{admin}/unblock', 'NewAdminsController@unBlockAdmin');

Route::patch('update', 'AdminsController@updateAdmin');

Route::get('fetch/facilitators', 'AdminsController@getUsers');

Route::get('fetch/{user}/facilitator', 'AdminsController@getFetchSingle');

Route::get('fetch-admins', 'NewAdminsController@fetchAdmins');

#--------------------------- Region -------------------------------------

Route::get('fetch/regions', 'ResourcesController@regionsIndex');

Route::post('store/regions', 'ResourcesController@storeRegion');

Route::patch('update/{region}/regions', 'ResourcesController@updateRegion');

Route::get('fetch/{region}/region', 'ResourcesController@showRegion');

Route::delete('delete/{region}/regions', 'ResourcesController@deleteRegion');

#--------------------------- End Region -----------------------------------------------------


#--------------------------- District -------------------------------------

Route::get('fetch/district', 'ResourcesController@districtIndex');

Route::post('store/district', 'ResourcesController@storeDistrict');

Route::get('show/{district}/district', 'ResourcesController@showDistrict');

Route::put('update/{district}/district', 'ResourcesController@updateDistrict');

Route::delete('delete/{district}/district', 'ResourcesController@deleteDistrict');

#--------------------------- End District -----------------------------------------------------


#--------------------------- Facility -------------------------------------

Route::get('fetch/facilities', 'ResourcesController@facilityIndex');

Route::post('store/facility', 'ResourcesController@storeFacility');

Route::get('show/{facility}/facility', 'ResourcesController@showFacility');

Route::put('update/{facility}/facility', 'ResourcesController@updateFacility');

Route::delete('delete/{facility}/facility', 'ResourcesController@deleteFacility');

#--------------------------- End Facility -----------------------------------------------------

#--------------------------- Facilitator -------------------------------------

Route::post('create/facilitator', 'AdminsController@createFacilitator');

Route::put('update/{user}/facilitator', 'AdminsController@updateFacilitator');

Route::delete('delete/{user}/facilitator', 'AdminsController@deleteFacilitator');

Route::get('fetch/facility/{facility}/facilitators', 'FacilitatorController@deleteFacilitator');

#--------------------------- End Facilitator -----------------------------------------------------

Route::get('fetch/dashboard/stats', 'DashBoardController@getStats');


Route::fallback(function(){

    return response()->json(['message' => 'Route not found'], 404);
});

