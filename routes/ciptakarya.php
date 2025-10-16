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
    Route::get('petugas', 'CiptaKarya\DataController@petugas_index')->name('ciptakarya.list_data_petugas');
});