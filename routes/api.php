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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'auth:api'],function(){
    
    Route::post('/home/get-totals', 'APIController@getTotals');
    Route::post('/home/chart', 'APIController@getChart');
    Route::post('/business', 'APIController@getBusiness');

    Route::post('/customers', 'APIController@getCustomers');
    
    Route::post('/products/list', 'APIController@getProducts');
    // Route::post('/products/list', 'APIController@getProductRow');
});

Route::post('login',"APIController@login");
Route::post('recreate-token',"APIController@recreate_token");
Route::post('forget-password',"APIController@forget_password")->name('api.forget');

Route::middleware(['Cors'])->group(function () {
    Route::get("data","APIController@data");
});
