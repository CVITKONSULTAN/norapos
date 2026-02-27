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

    // Public Routes (outside auth middleware)
    Route::get('statistics', 'CiptaKarya\DataController@getStatistics')->name('ciptakarya.statistics');

    // SIMBG Sync Routes
    Route::post('sync-simbg', 'CiptaKarya\SimbgSyncController@sync')->name('ciptakarya.sync_simbg');
    Route::get('last-sync', 'CiptaKarya\SimbgSyncController@getLastSync')->name('ciptakarya.last_sync');
    Route::get('sync-logs', 'CiptaKarya\SimbgSyncController@getLogs')->name('ciptakarya.get_sync_logs');
    
    // SIMBG Detail Proxy (untuk mengatasi CORS)
    Route::get('simbg-detail', 'CiptaKarya\DataController@getSimbgDetail')->name('ciptakarya.simbg_detail');

    Route::get('/pengajuan/disposisi/{id}', 'CiptaKarya\DataController@disposisi')->name('ciptakarya.disposisi');
    Route::post('/pengajuan/terbitkan/{id}', 'CiptaKarya\DataController@terbitkanDokumen')->name('ciptakarya.terbitkanDokumen');

    Route::get('cek_retribusi', function(){
        return view('ciptakarya.retribusi_form');
    });

    Route::get('cek_gambar', function(){
        return view('ciptakarya.gambar_teknis');
    });

});

// =========================================
// ROUTES PETUGAS LAPANGAN (PASSWORDLESS LOGIN)
// =========================================

// Login Routes (tanpa auth middleware)
Route::get('ciptakarya/petugas/login', 'CiptaKarya\PetugasController@showLogin')
    ->name('petugas.login');
Route::post('ciptakarya/petugas/login', 'CiptaKarya\PetugasController@sendMagicLink')
    ->name('petugas.login.send');
Route::get('ciptakarya/petugas/verify/{token}', 'CiptaKarya\PetugasController@verifyMagicLink')
    ->name('petugas.login.verify');

// Protected Routes (dengan middleware auth.petugas)
Route::group(['prefix' => 'ciptakarya/petugas', 'middleware' => 'auth.petugas'], function() {
    Route::get('dashboard', 'CiptaKarya\PetugasController@dashboard')
        ->name('petugas.dashboard');
    
    Route::get('api/tugas', 'CiptaKarya\PetugasController@apiListTugas')
        ->name('petugas.api.tugas');
    
    // Detail tugas
    Route::get('tugas/{id}', 'CiptaKarya\PetugasController@detailTugas')
        ->name('petugas.tugas.detail');
    
    // Foto Lapangan
    Route::get('tugas/{id}/foto', 'CiptaKarya\PetugasController@fotoLapangan')
        ->name('petugas.tugas.foto');
    Route::post('tugas/{id}/save-photos', 'CiptaKarya\PetugasController@savePhotos')
        ->name('petugas.tugas.save-photos');
    
    // Kuesioner
    Route::get('tugas/{id}/kuesioner', 'CiptaKarya\PetugasController@kuesioner')
        ->name('petugas.tugas.kuesioner');
    Route::post('tugas/{id}/save-answers', 'CiptaKarya\PetugasController@saveAnswers')
        ->name('petugas.tugas.save-answers');
    
    // Submit Verifikasi
    Route::get('tugas/{id}/submit', 'CiptaKarya\PetugasController@showSubmitVerifikasi')
        ->name('petugas.tugas.submit');
    Route::post('tugas/{id}/submit', 'CiptaKarya\PetugasController@submitVerifikasi')
        ->name('petugas.tugas.verifikasi');
    
    // Cetak Laporan
    Route::get('tugas/{id}/cetak', 'CiptaKarya\PetugasController@cetakLaporan')
        ->name('petugas.tugas.cetak');
    
    // Upload foto
    Route::post('upload-photo', 'CiptaKarya\PetugasController@uploadPhoto')
        ->name('petugas.upload-photo');
    
    Route::get('profil', 'CiptaKarya\PetugasController@profil')
        ->name('petugas.profil');
    
    Route::post('logout', 'CiptaKarya\PetugasController@logout')
        ->name('petugas.logout');
});

// Public Tracking Route (tanpa auth middleware)
Route::post('ciptakarya/public-tracking', 'CiptaKarya\DataController@publicTracking')
    ->name('ciptakarya.public_tracking');

// Public Visitor Statistics Route
Route::get('visitor-statistics', 'CiptaKarya\DataController@getVisitorStatistics')
    ->name('visitor.statistics');