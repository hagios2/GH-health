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


Route::group(['prefix' => 'auth'], function () {

    Route::post('login', 'AuthController@login');

    Route::post('logout', 'AuthController@logout');

    Route::post('refresh-token', 'AuthController@refresh');

    Route::get('user', 'AuthController@getAuthUser');

    Route::patch('update/{user}/user', 'UsersRegisterController@update');

    Route::delete('user/delete', 'UsersRegisterController@destroy');

    Route::post('email/verify', 'VerificationController@verify')->name('verification.verify'); // Make sure to keep this as your route name

    Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');

    Route::post('request/password/reset', 'PasswordResetController@sendResetMail');

    Route::post('reset/password', 'PasswordResetController@reset');

    Route::post('change/password', 'PasswordResetController@changeUserPassword');

});

#----------------------- Product Routes ----------------------------------------------

Route::post('product/create', 'ProductsController@createProduct');

Route::get('fetch/products', 'ProductsController@fetchProducts');

Route::put('update/{product}/product', 'ProductsController@updateProduct');

Route::delete('delete/{product}/product', 'ProductsController@deleteProduct');

Route::get('get/{product}/details', 'ProductsController@getProductDetails');

Route::post('product/{product}/issue/out', 'ProductsController@issueOutProduct');

Route::get('view/issued-out/products', 'ProductsController@viewIssuedOutProduct');

Route::get('view/{issuedProduct}/issued-out/product/report', 'ProductsController@fetchASingleIssuedCase');

Route::put('update/{issuedProduct}/reported/case', 'ProductsController@updateIssueOutProduct');

#--------------------- End Product Routes -------------------------------------------------------

#--------------------- Victims Routes -------------------------------------------------------

Route::get('fetch/victims', 'VictimsController@fetchVictims');

Route::post('victims/create', 'VictimsController@createVictim');

Route::put('update/{victim}/victim', 'VictimsController@updateVictim');

Route::get('fetch/{victim}/victim', 'VictimsController@fetchVictim');

Route::delete('delete/{victim}/victim', 'VictimsController@DeleteVictim');

Route::get('fetch/{victim}/victim/reports', 'VictimsController@fetchPreviousReports');
#------------------------------------------------------------------------------------------------

#------------------------------------------ Resource Routes ------------------------------------------

Route::get('fetch/districts/resource', 'ResourceController@fetchDistricts');

Route::get('fetch/victims/resource', 'ResourceController@fetchVictims');

Route::get('fetch/products/resource', 'ResourceController@fetchProducts');

Route::get('fetch/dashboard/stats', 'FacilitatorDashboardController@getStats');

#------------------------------------------ End Resource Routes ------------------------------------------

Route::get('fetch/dashboard/stats', 'DashboardController@getStats');



Route::get('search/item', 'SearchController@search');


#------------------------ Payment Integration --------------------------------------

Route::post('/user/product/payment', 'UserSellerPaymentController@payment')->name('user.seller.pay');

Route::post('/user/product/payment/callback', 'UserSellerPaymentController@callback')->name('user.seller.callback');

Route::post('/shop/payment', 'PaymentController@payment')->name('merchandiser.pay');

Route::get('shop/payment/transactions', 'PaymentController@paymentTransactions');

Route::get('user/product/payment/transactions', 'UserSellerPaymentController@paymentTransactions');

Route::post('/shop/payment/callback', 'PaymentController@callback')->name('shop.payment.callback');

#------------------------ End of Payment Integration --------------------------------------

Route::fallback(function(){

    return response()->json(['message' => 'Route not found'], 404);
});
