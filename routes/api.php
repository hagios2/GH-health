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

Route::get('campuses', 'ResourceController@getCampus');

Route::get('categories', 'ProductsController@getCategories');

Route::get('category/{category}/products', 'ProductsController@getCategorysProduct');

Route::get('product/{product}/details', 'ProductsController@getProductDetails');

Route::get('/{category}/product-index', 'ProductsController@index');



Route::group(['prefix' => 'merchandiser'], function () {
    
    Route::post('login', 'MerchandiserAuthController@login');

    Route::get('/', 'MerchandiserAuthController@getAuthUser');

    Route::post('logout', 'MerchandiserAuthController@logout');

    Route::post('refresh-token', 'MerchandiserAuthController@refresh');

    Route::patch('/{merchandiser}/update', 'MerchandiserRegisterController@update');
});



Route::group(['prefix' => 'e-trader'], function () {
    
    Route::post('/create-category', 'SellersController@createCategory');

   // Route::get('/categories', 'SellersControllerController@getCategories');

    Route::post('/{category}/add-product', 'SellersController@storeProduct');

    Route::post('/{product}/product-images', 'SellersController@saveProductImages');

    Route::patch('/product/{product}/update', 'SellersController@updateProduct');
});


Route::fallback(function(){

    return response()->json(['message' => 'Route not found'], 404);
});

Route::options('{any}', function () {

    return response('', 204, \Illuminate\Http\Response::HTTP_NO_CONTENT)
          ->header('Access-Control-Allow-Origin', implode(',', config('cors.allow_origins')))
          ->header('Access-Control-Allow-Methods', implode(',', config('cors.allow_methods')))
          ->header('Access-Control-Allow-Headers', implode(',', config('cors.allow_headers')))
          ->header('Access-Control-Max-age', implode(',', config('cors.max_age')));


          return response()->json();
        });