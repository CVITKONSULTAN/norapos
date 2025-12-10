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
    Route::get('dashboard', 'CiptaKarya\DataController@dashboard')->name('ciptakarya.dashboard');

    Route::get('detail/{id}', 'CiptaKarya\DataController@detail_data')->name('ciptakarya.detail_data');
    Route::get('print/{id}', 'CiptaKarya\DataController@print_data')->name('ciptakarya.print_data');
    Route::get('list-data-pbg', 'CiptaKarya\DataController@list_index')->name('ciptakarya.list_data_pbg');
    Route::get('list-data-pbg/{id}/detail', 'CiptaKarya\DataController@show_pbg')->name('ciptakarya.pbg.show');
    Route::get('list-data-pbg/data', 'CiptaKarya\DataController@list_data_pbg')->name('ciptakarya.list_data_pbg_datatables');
    Route::get('pbg/{id}/timeline', 'CiptaKarya\DataController@timeline')->name('ciptakarya.timeline');

    Route::get('riwayatVerifikasi/{id}', 'CiptaKarya\DataController@riwayatVerifikasi')
    ->name('ciptakarya.riwayatVerifikasi');


    Route::post('store_pbg', 'CiptaKarya\DataController@store_pbg')->name('ciptakarya.store_pbg');
    Route::post('simpanVerifikasi', 'CiptaKarya\DataController@simpanVerifikasi')->name('ciptakarya.simpanVerifikasi');
    
    Route::get('petugas', 'CiptaKarya\DataController@petugas_index')->name('ciptakarya.list_data_petugas');
    Route::get('petugas', 'CiptaKarya\DataController@petugas_index')->name('ciptakarya.list_data_petugas');
    Route::get('petugas/data', 'CiptaKarya\DataController@list_data_petugas')->name('ciptakarya.list_data_petugas_datatables');
    Route::post('store_petugas_lapangan', 'CiptaKarya\DataController@store_petugas_lapangan')->name('ciptakarya.store_petugas_lapangan');

    Route::post('update-petugas', 'CiptaKarya\DataController@update_petugas')->name('ciptakarya.update_petugas');
    Route::get('search-petugas', 'CiptaKarya\DataController@search_petugas')->name('ciptakarya.search_petugas');

    Route::post('update-retribusi/{id}', 'CiptaKarya\DataController@updateRetribusi');

    Route::get('cek_retribusi', function(){
        return view('ciptakarya.retribusi_form');
    });

    Route::get('/pengajuan/disposisi/{id}', 'CiptaKarya\DataController@disposisi')->name('ciptakarya.disposisi');
    Route::post('/pengajuan/terbitkan/{id}', 'CiptaKarya\DataController@terbitkanDokumen')->name('ciptakarya.terbitkanDokumen');

});