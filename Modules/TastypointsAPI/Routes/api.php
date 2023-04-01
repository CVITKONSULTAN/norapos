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

Route::middleware('auth:api')->get('/tastypointsapi', function (Request $request) {
    return $request->user();
});

Route::group(["prefix"=>"tasty/test"],function(){
    Route::post("customers","StripeController@customers");
    Route::post("update_balance","StripeController@update_balance");
    Route::post("update_response","StripeController@update_response");
});