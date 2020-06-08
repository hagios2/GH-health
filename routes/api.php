<?php

use Illuminate\Http\Request;

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
/* 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::group(['prefix' => 'auth'], function ($router) {

    Route::post('login', 'AuthController@login');

    Route::post('logout', 'AuthController@logout');

    Route::post('refresh-token', 'AuthController@refresh');

    Route::get('user', 'AuthController@getAuthUser');

    Route::patch('update/{user}/user', 'UsersRegisterController@update');

});


Route::post('register-user', 'UsersRegisterController@register');

Route::post('register-merchandiser', 'MerchandiserRegisterController@register');

Route::post('campuses', 'ResourceController@register');



Route::group(['prefix' => 'merchandiser'], function () {
    
    Route::post('login', 'MerchandiserAuthController@login');

    Route::get('/', 'MerchandiserAuthController@getAuthUser');

    Route::post('logout', 'MerchandiserAuthController@logout');

    Route::post('refresh-token', 'MerchandiserAuthController@refresh');

    Route::patch('/{merchandiser}/update', 'MerchandiserRegisterController@update');
});

Route::fallback(function(){

    return response()->json(['message' => 'Route not found'], 404);
});