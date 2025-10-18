<?php

/*
|--------------------------------------------------------------------------
| Installation Web Routes
|--------------------------------------------------------------------------
|
| Routes related to installation of the software
|
*/

Route::group([
    'prefix'=>'ciptakarya',
    'middleware'=>['setData', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu', 'CheckUserLogin']
],function(){
    Route::get('list-data-pbg', 'CiptaKarya\DataController@list_index')->name('ciptakarya.list_data_pbg');
    Route::get('list-data-pbg/{id}/detail', 'CiptaKarya\DataController@show_pbg')->name('ciptakarya.pbg.show');
    Route::get('list-data-pbg/data', 'CiptaKarya\DataController@list_data_pbg')->name('ciptakarya.list_data_pbg_datatables');
    Route::post('store_pbg', 'CiptaKarya\DataController@store_pbg')->name('ciptakarya.store_pbg');
    
    Route::get('petugas', 'CiptaKarya\DataController@petugas_index')->name('ciptakarya.list_data_petugas');
    Route::get('petugas/data', 'CiptaKarya\DataController@list_data_petugas')->name('ciptakarya.list_data_petugas_datatables');
    Route::post('store_petugas_lapangan', 'CiptaKarya\DataController@store_petugas_lapangan')->name('ciptakarya.store_petugas_lapangan');
});