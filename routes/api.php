<?php

use Illuminate\Http\Request;
// use DB;

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


Route::get('/hotel/available', "HotelController@availablity_kamar")->name("hotel.avail");
Route::get('/hotel/print', 'APIController@hotel_print');
Route::get('/hotel/room/print', 'APIController@hotel_room_print');

Route::group(['middleware'=>'auth:api'],function(){

    Route::post('delete-account','APIController@deleteAccount');
    
    Route::post('/card', 'CardLogController@store');

    Route::get('/brands/list', 'APIController@brands_list');
    Route::get('/kebersihan/list', 'APIController@kebersihan_list');

    Route::post('/transaction/receipt', 'APIController@print_trx_id');

    Route::post('/hotel/room/update', 'APIController@room_update');

    Route::get('/hotel/transaction/list', 'APIController@getCheckin');
    Route::get('/hotel/reservasi/list', 'HotelController@reservasi_list');
    Route::post('/hotel/reservasi/store', 'HotelController@reservasi_store');

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


    Route::group(['prefix'=>'sekolah_sd'],function(){

        Route::get('kelas','SekolahSDController@kelas_siswa_api');
        Route::get('profil','SekolahSDController@profil_siswa_api');
        Route::post('update-password','SekolahSDController@update_password');
        Route::get('notifikasi','SekolahSDController@notifikasi_api');
        Route::get('jurnal-kelas','SekolahSDController@jurnal_kelas_api');
    });

});

Route::group(['prefix'=>'sekolah_sd'],function(){

    Route::get('/',function(){
        return ['status'=>"OK"];
    });

    Route::get('raport-akhir/{id}/print',"SekolahSDController@raport_akhir_print");
    Route::get('raport-project/{id}/print',"SekolahSDController@raport_project_print");

    // Route::post('ppdb/store','SekolahSDController@ppdb_store');
    // Route::post('upload','SekolahSDController@upload')->name('sekolah_sd.upload');

});

Route::post('fcm-token','APIController@fcm_token_store');

Route::post('/blog', 'APIController@list_blog');

Route::post('login',"APIController@login");
Route::post('recreate-token',"APIController@recreate_token");
Route::post('forget-password',"APIController@forget_password")->name('api.forget');

Route::middleware(['Cors'])->group(function () {
    Route::get("data","APIController@data");
    Route::post('/sekolah_sd/upload','SekolahSDController@upload')->name('sekolah_sd.upload');
    // Route::post('/sekolah_sd/upload','SekolahSDController@upload')->name('sekolah_sd.upload');
    Route::post('/sekolah_sd/ppdb/store','SekolahSDController@ppdb_store');

});

Route::get('wilayah','itkonsultan\WilayahController@getData');

Route::post('midtrans-notify','itkonsultan\DataController@midtrans_notify');
Route::get('payment-landing','itkonsultan\ViewerController@landing_payment');

Route::group(['prefix'=>'pejantan'],function(){
    Route::get('config','pejantan\DataController@config');
    Route::get('jalan','pejantan\DataController@sk_jalan');
    Route::get('chart','pejantan\DataController@chart');
    Route::get('jembatan','pejantan\DataController@sk_jembatan');
});

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

// Route::get('test',function(){
//     $user = \App\User::where('username','kartika')->first();
//     $user->password = bcrypt('Kartika123456');
//     $user->save();
//     // ->update(['password'=>bcrypt('Kartika123456')]);
//     return "OK";
//     // return view('test');
// });