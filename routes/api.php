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
    Route::post('/customers/store', 'APIController@storeCustomer');

    
    Route::post('/products/list', 'APIController@getProducts');
    
    Route::post('/pos', 'APIController@store_POS');

    Route::post('/hotel/ota', 'APIController@hotel_ota');
    Route::post('/hotel/payment', 'APIController@hotel_payment');

    // hotel kartika punya
    Route::post('/checkin/list', 'APIController@getCheckin');
    Route::post('/checkin/list/v2', 'APIController@checkinList');
    Route::post('/checkout/store', 'APIController@checkoutStore');
    Route::post('/checkin/update', 'APIController@checkinUpdate');
    // end hotel kartika

});

Route::post('/blog', 'APIController@list_blog');

Route::post('login',"APIController@login");
Route::post('recreate-token',"APIController@recreate_token");
Route::post('forget-password',"APIController@forget_password")->name('api.forget');

Route::middleware(['Cors'])->group(function () {
    Route::get("data","APIController@data");
});

Route::get('wilayah','itkonsultan\WilayahController@getData');

Route::post('midtrans-notify','itkonsultan\DataController@midtrans_notify');
Route::get('payment-landing','itkonsultan\ViewerController@landing_payment');

Route::group(['prefix'=>'itkonsultan'],function(){

    Route::get('form','itkonsultan\ViewerController@form');
    Route::post('form','itkonsultan\DataController@form_collection_store')->name('form.store');
    
    Route::get('profile','itkonsultan\ViewerController@profile');
    Route::get('detail','itkonsultan\ViewerController@detail');

    Route::get('setup-admin','itkonsultan\DataController@setup_admin');

    Route::get('next-payment','itkonsultan\DataController@next_payment')->name('itko.next_payment');

    Route::post('login','itkonsultan\DataController@login_admin');

    Route::post('change-status','itkonsultan\DataController@admin_change_status')->name('itko.change_status');
    Route::post('rekap','itkonsultan\DataController@history_transaction_rekap')->name('itko.rekap');
    
    Route::post('phone-store','itkonsultan\DataController@store_data_phone');
    Route::post('profile','itkonsultan\DataController@store_profile')->name('itko.profile_store');
    Route::post('transaction','itkonsultan\DataController@store_transaction')->name('itko.trx_store');
    Route::post('history-transaction','itkonsultan\DataController@history_transaction')->name('itko.trx_history');
    
});