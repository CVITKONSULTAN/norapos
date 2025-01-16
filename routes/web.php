<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

include_once('install_r.php');

use Illuminate\Support\Facades\Artisan;

$database_domain = ['beautyproclinic.com','koneksiedu.com'];

// Route::get('/test-login', function(){
//     $domain = "koneksiedu";
//     $data = [];
//     return view("compro.$domain.login",$data);
// });

Route::group(['domain' => '{domain}.{tld}'], function() use($database_domain){
    $host = request()->getHost();
    if(in_array($host,$database_domain)){
        Route::get('/', "MultiDomainController@index")->name("multi.index");
        Route::get('/about', "MultiDomainController@about")->name("multi.about");
        Route::get('/gallery', "MultiDomainController@gallery")->name("multi.gallery");
        Route::get('/contact', "MultiDomainController@contact")->name("multi.contact");
        Route::get('/product', "MultiDomainController@product")->name("multi.product");
        Route::get('/services', "MultiDomainController@services")->name("multi.services");
        if($host == 'koneksiedu.com'){
            Route::get('/login', "MultiDomainController@login")->name("multi.login");
            Route::get('/ppdb-simuda', "SekolahSDController@ppdb")->name("sekolah.ppdb");
        }
    }
});

Route::get('/ppdb-simuda', "SekolahSDController@ppdb")->name("sekolah.ppdb");
Route::get('/ppdb-simuda/print/{id}', "SekolahSDController@ppdb_print")->name("sekolah.ppdb_print");



Route::get('/command', function () {
    // Artisan::call('migrate');
//     // Artisan::call('db:seed');
//     // Artisan::call('make:controller MultiDomainController');
//     // Artisan::call('migrate:rollback');
//     // Artisan::call('make:model Blog -m');
    // Artisan::call('db:seed --class=NilaiIntervalSeeder');
    return "OK";
});
Route::get('seeding','itkonsultan\DataController@seed_norapos');

Route::group(["prefix"=>"web"],function(){
    Route::get("/","Website\WebController@index")->name('web.index');
});

Route::group(['prefix'=>'auth'],function(){
    Route::get('/google',"SocialiteController@google")->name('auth.google');
    Route::get('/google/callback',"SocialiteController@google_callback");
});

Route::get('/update', "UpdateController@update");

Route::middleware(['setData'])->group(function () {
    Route::get('/', function () {
        // return view('welcome');
        return redirect()->to("login");
    });

    Auth::routes();

    Route::get('/business/register', 'BusinessController@getRegister')->name('business.getRegister');
    Route::post('/business/register', 'BusinessController@postRegister')->name('business.postRegister');
    Route::post('/business/register/check-username', 'BusinessController@postCheckUsername')->name('business.postCheckUsername');
    Route::post('/business/register/check-email', 'BusinessController@postCheckEmail')->name('business.postCheckEmail');

    Route::get('/invoice/{token}', 'SellPosController@showInvoice')
        ->name('show_invoice');
    Route::get('/quote/{token}', 'SellPosController@showInvoice')
        ->name('show_quote');
});

//Routes for authenticated users only
Route::middleware(['setData', 'auth', 'SetSessionData', 'language', 'timezone', 'AdminSidebarMenu', 'CheckUserLogin'])->group(function () {

    Route::get('/log_activity/data', "LogActivityController@data")->name('log.data');

    Route::post('/upload', "FileUploadController@upload")->name('upload');

    Route::get('/reservasi', "ReservasiController@index");
    Route::get('/reservasi/data', "HotelController@reservasi_list");

    Route::group(['prefix'=>'pejantan'],function(){

        Route::get('home','pejantan\DataController@home')->name('pejantan.home');
        Route::get('jalan',function(){
            return view('pejantan.jalan');
        })->name('pejantan.jalan');
        Route::get('jembatan',function(){
            return view('pejantan.jembatan');
        })->name('pejantan.jembatan');
        Route::get('jalan/data','pejantan\DataController@jalan')->name('pejantan.jalan.api');
        Route::get('jembatan/data','pejantan\DataController@jembatan')->name('pejantan.jembatan.api');

    });

    Route::group(['prefix'=>'sekolah_sd'],function(){

        Route::get('ppdb/update','SekolahSDController@update_nama_ppdb')
        ->name('sekolah_sd.ppdb.update');

        Route::get('ppdb/list','SekolahSDController@ppdb_data')
        ->name('sekolah_sd.ppdb.data');
        Route::get('ppdb/{id}','SekolahSDController@ppdb_data_show')
        ->name('sekolah_sd.ppdb.show');
        Route::post('ppdb/{id}','SekolahSDController@ppdb_data_store')
        ->name('sekolah_sd.ppdb.store');

        Route::get('hitung-nilai','Sekolah\NilaiSiswaController@hitungNilaiRapor')
        ->name('sekolah_sd.hitung-formatif');
        Route::get('calculate-catatan-penilaian','Sekolah\NilaiSiswaController@generateCatatanPenilaian')
        ->name('sekolah_sd.calculate-catatan-penilaian');

        Route::get('formatif-walikelas','SekolahSDController@formatif_walikelas_index')
        ->name('sekolah_sd.walikelas.formatif');
        Route::get('sumatif-walikelas','SekolahSDController@sumatif_walikelas_index')
        ->name('sekolah_sd.walikelas.sumatif');

        Route::post('dimensi-projek/import',"Sekolah\ProjekController@import_dimensi_projek")
        ->name('sekolah_sd.dimensi_projek.import');
        Route::get('dimensi-projek',"SekolahSDController@dimensi_projek")
        ->name('sekolah_sd.dimensi_projek');
        Route::get('dimensi-projek/data',"Sekolah\ProjekController@data_dimensi_projek")
        ->name('sekolah_sd.dimensi_projek.data');

        Route::get('skenario-projek',"SekolahSDController@skenario_projek")
        ->name('sekolah_sd.skenarion_projek');
        Route::post('rapor-projek',"Sekolah\ProjekController@rapor_projek_store")
        ->name('sekolah_sd.rapor_projek.store');
        Route::post('rapor-projek/apply',"Sekolah\ProjekController@applyProjek")
        ->name('sekolah_sd.rapor_projek.apply');
        Route::post('rapor-projek/store',"Sekolah\ProjekController@storeNilai")
        ->name('sekolah_sd.rapor_projek.storeNilai');

        Route::get('rapor-projek/data',"Sekolah\ProjekController@data_rapor_projek")
        ->name('sekolah_sd.rapor_projek.data');

        Route::get('fase-dimensi',"Sekolah\ProjekController@fase_dimensi_data")
        ->name('sekolah_sd.fase_dimensi.data');

        Route::get('penilaian-projek',"SekolahSDController@penilaian_projek")
        ->name('sekolah_sd.penilaian_projek');

        Route::get('create-role-seeder',"SekolahSDController@create_role_sekolah")
        ->name('sekolah_sd.seed.role');

        Route::get('jurnal-kelas',"SekolahSDController@jurnal_kelas")
        ->name('sekolah_sd.jurnal_kelas.index');
        Route::post('jurnal-kelas',"Sekolah\KelasController@storeJurnalKelas")
        ->name('sekolah_sd.jurnal_kelas.store');
        
        Route::get('dashboard',"SekolahSDController@dashboard")
        ->name('sekolah_sd.dashboard');

        Route::get('kelas-siswa',"SekolahSDController@kelas_index")
        ->name('sekolah_sd.kelas.index');
        Route::get('kelas-siswa/data',"Sekolah\KelasController@data")
        ->name('sekolah_sd.kelas.data');
        Route::get('kelas-siswa/{id}/detail',"Sekolah\KelasController@detail")
        ->name('sekolah_sd.kelas.detail');
        Route::post('kelas-siswa/store',"Sekolah\KelasController@store")
        ->name('sekolah_sd.kelas.store');
        Route::post('kelas-siswa/import',"Sekolah\KelasController@kelasSiswaImport")
        ->name('sekolah_sd.kelas.import');

        Route::post('kelas-repo',"Sekolah\KelasController@KelasRepo")
        ->name('sekolah_sd.kelas_repo.store');
        Route::get('kelas-data',"Sekolah\KelasController@KelasData")
        ->name('sekolah_sd.kelas_repo.data');
        

        Route::get('data-siswa',"SekolahSDController@data_siswa_index")
        ->name('sekolah_sd.siswa.index');
        Route::get('data-siswa/create',"SekolahSDController@data_siswa_create")
        ->name('sekolah_sd.siswa.create');
        Route::get('data-siswa/{id}/edit',"Sekolah\SiswaController@edit")
        ->name('sekolah_sd.siswa.edit');

        Route::post('data-siswa',"Sekolah\SiswaController@store")
        ->name('sekolah_sd.siswa.store');
        Route::get('data-siswa/data',"Sekolah\SiswaController@data")
        ->name('sekolah_sd.siswa.data');
        Route::put('data-siswa/{id}',"Sekolah\SiswaController@update")
        ->name('sekolah_sd.siswa.update');
        Route::delete('data-siswa/{id}',"Sekolah\SiswaController@destroy")
        ->name('sekolah_sd.siswa.delete');
        Route::post('data-siswa/import',"Sekolah\SiswaController@import")
        ->name('sekolah_sd.siswa.import');

        Route::get('data-mapel',"SekolahSDController@data_mapel_index")
        ->name('sekolah_sd.mapel.index');
        Route::get('data-mapel/create',"SekolahSDController@data_mapel_create")
        ->name('sekolah_sd.mapel.create');
        Route::get('data-mapel/{id}/edit',"Sekolah\MapelController@edit")
        ->name('sekolah_sd.mapel.edit');
        Route::post('data-mapel/import',"Sekolah\MapelController@import")
        ->name('sekolah_sd.mapel.import');
        Route::post('data-mapel/apply',"Sekolah\MapelController@applyKelas")
        ->name('sekolah_sd.mapel.apply');

        Route::post('data-mapel/apply/perkelas',"Sekolah\MapelController@applyKelasPerkelas")
        ->name('sekolah_sd.mapel.apply.perkelas');

        Route::post('data-mapel',"Sekolah\MapelController@store")
        ->name('sekolah_sd.mapel.store');
        Route::get('data-mapel/data',"Sekolah\MapelController@data")
        ->name('sekolah_sd.mapel.data');

        Route::get('data-mapel/perkelas',"Sekolah\MapelController@data_perkelas")
        ->name('sekolah_sd.mapel.data.perkelas');

        Route::put('data-mapel/{id}',"Sekolah\MapelController@update")
        ->name('sekolah_sd.mapel.update');
        Route::delete('data-mapel/{id}',"Sekolah\MapelController@destroy")
        ->name('sekolah_sd.mapel.delete');

        Route::get('data-rekap-nilai/data',"Sekolah\NilaiSiswaController@data")
        ->name('sekolah_sd.rekap_nilai.data');
        Route::get('data-rekap-nilai',"SekolahSDController@data_rekap_nilai_index")
        ->name('sekolah_sd.rekap_nilai.index');
        Route::get('data-rekap-nilai/{id}/show',"Sekolah\NilaiSiswaController@showNilaiFormatif")
        ->name('sekolah_sd.rekap_nilai.show');
        Route::post('data-rekap-nilai',"Sekolah\NilaiSiswaController@storeNilaiFormatif")
        ->name('sekolah_sd.rekap_nilai.store');

        Route::get('data-rekap-nilai-sumatif',"SekolahSDController@data_rekap_nilai_sumatif_index")
        ->name('sekolah_sd.rekap_nilai_sumatif.index');

        Route::get('data-ekskul',"SekolahSDController@data_ekskul_index")
        ->name('sekolah_sd.ekskul.index');
        Route::get('data-ekskul/create',"SekolahSDController@data_ekskul_create")
        ->name('sekolah_sd.ekskul.create');
        Route::post('data-ekskul',"Sekolah\EkstrakurikulerController@store")
        ->name('sekolah_sd.ekskul.store');
        Route::get('data-ekskul/data',"Sekolah\EkstrakurikulerController@data")
        ->name('sekolah_sd.ekskul.data');
        Route::delete('data-ekskul/{id}',"Sekolah\EkstrakurikulerController@destroy")
        ->name('sekolah_sd.ekskul.delete');
        Route::post('data-ekskul-siswa',"Sekolah\EkstrakurikulerController@storeEkskulSiswa")
        ->name('sekolah_sd.ekskul-siswa.store');

        Route::get('ekskul-siswa/show',"Sekolah\EkstrakurikulerController@ekskul_siswa")
        ->name('sekolah_sd.ekskul-siswa.show');

        Route::get('data-tendik',"SekolahSDController@data_tendik_index")
        ->name('sekolah_sd.tendik.index');
        Route::get('data-tendik/create',"SekolahSDController@data_tendik_create")
        ->name('sekolah_sd.tendik.create');
        Route::post('data-tendik',"Sekolah\TenagaPendidikController@store")
        ->name('sekolah_sd.tendik.store');
        Route::put('data-tendik/{id}',"Sekolah\TenagaPendidikController@update")
        ->name('sekolah_sd.tendik.update');
        Route::get('data-tendik/data',"Sekolah\TenagaPendidikController@data")
        ->name('sekolah_sd.tendik.data');
        Route::get('data-tendik/{id}/edit',"Sekolah\TenagaPendidikController@edit")
        ->name('sekolah_sd.tendik.edit');
        Route::post('data-tendik/import',"Sekolah\TenagaPendidikController@import")
        ->name('sekolah_sd.tendik.import');
        Route::delete('data-tendik/{id}',"Sekolah\TenagaPendidikController@destroy")
        ->name('sekolah_sd.tendik.delete');

        Route::get('data-rekap-absen',"SekolahSDController@data_rekap_absen_index")
        ->name('sekolah_sd.rekap_absen.index');

        Route::get('hitung-absen',"Sekolah\KelasController@hitungJurnalAbsen")
        ->name('sekolah_sd.rekap_absen.hitung');

        Route::get('buku-induk',"SekolahSDController@buku_induk_index")
        ->name('sekolah_sd.buku_induk.index');
        Route::get('buku-induk/create',"SekolahSDController@buku_induk_create")
        ->name('sekolah_sd.buku_induk.create');
        Route::get('buku-induk/{id}/print',"SekolahSDController@buku_induk_print")
        ->name('sekolah_sd.buku_induk.print');

        Route::get('project-rapor',"SekolahSDController@rapor_project_index")
        ->name('sekolah_sd.project.rapor');
        
        Route::get('project',"SekolahSDController@project_index")
        ->name('sekolah_sd.project.index');
        Route::get('project/create',"SekolahSDController@project_create")
        ->name('sekolah_sd.project.create');

        Route::get('raport-tengah',"SekolahSDController@raport_tengah_index")
        ->name('sekolah_sd.raport_tengah.index');
        Route::get('raport-tengah/{id}/print',"SekolahSDController@raport_tengah_print")
        ->name('sekolah_sd.raport_tengah.print');

        Route::get('raport-akhir',"SekolahSDController@raport_akhir_index")
        ->name('sekolah_sd.raport_akhir.index');
        Route::get('raport-akhir/{id}/print',"SekolahSDController@raport_akhir_print")
        ->name('sekolah_sd.raport_akhir.print');
        Route::get('raport-akhir/perkelas',"SekolahSDController@cetak_rapor_akhir_perkelas")
        ->name('sekolah_sd.raport_akhir.print.perkelas');

        Route::get('raport-project/{id}/print',"SekolahSDController@raport_project_print")
        ->name('sekolah_sd.raport_project.print');
        Route::get('raport-project/perkelas',"SekolahSDController@raport_project_print_perkelas")
        ->name('sekolah_sd.raport_project.print.perkelas');

        Route::get('raport-table',"SekolahSDController@raport_table_index")
        ->name('sekolah_sd.raport_table.index');

        Route::get('ranking-kelas',"SekolahSDController@raking_kelas_index")
        ->name('sekolah_sd.ranking_kelas.index');

        Route::get('peserta-didik-baru/export',"SekolahSDController@export_ppdb")->name('sekolah_sd.ppdb.export');
        Route::get('peserta-didik-baru/cetak',"SekolahSDController@export_cetak")->name('sekolah_sd.ppdb.cetak');

        Route::get('peserta-didik-baru',function(){
            return view('sekolah_sd.peserta_didik_baru');
        })
        ->name('sekolah_sd.peserta_didik_baru');
        
        Route::get('dashboard/api',"SekolahSDController@dashboard_api")
        ->name('sekolah_sd.dashboard.api');
    });

    Route::get('/card', "CardLogController@index");
    Route::get('/card/data', "CardLogController@data");

    Route::get('/absensi', "AbsensiController@create")->name('absensi.create');
    Route::post('/absensi/store', "AbsensiController@store")->name('absensi.store');
    Route::get('/absensi/list', "AbsensiController@index")->name('absensi.list');
    Route::get('/absensi/list/all', "AbsensiController@index_all")->name('absensi.list.all');
    Route::get('/absensi/data', "AbsensiController@data")->name('absensi.data');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/get-totals', 'HomeController@getTotals');
    Route::get('/home/product-stock-alert', 'HomeController@getProductStockAlert');
    Route::get('/home/purchase-payment-dues', 'HomeController@getPurchasePaymentDues');
    Route::get('/home/sales-payment-dues', 'HomeController@getSalesPaymentDues');
    
    Route::post('/test-email', 'BusinessController@testEmailConfiguration');
    Route::post('/test-sms', 'BusinessController@testSmsConfiguration');
    Route::get('/business/settings', 'BusinessController@getBusinessSettings')->name('business.getBusinessSettings');
    Route::post('/business/update', 'BusinessController@postBusinessSettings')->name('business.postBusinessSettings');
    Route::get('/user/profile', 'UserController@getProfile')->name('user.getProfile');
    Route::post('/user/update', 'UserController@updateProfile')->name('user.updateProfile');
    Route::post('/user/update-password', 'UserController@updatePassword')->name('user.updatePassword');

    Route::resource('brands', 'BrandController');
    
    Route::resource('payment-account', 'PaymentAccountController');

    Route::resource('tax-rates', 'TaxRateController');

    Route::resource('units', 'UnitController');

    Route::get('/contacts/map', 'ContactController@contactMap');
    Route::get('/contacts/update-status/{id}', 'ContactController@updateStatus');
    Route::get('/contacts/stock-report/{supplier_id}', 'ContactController@getSupplierStockReport');
    Route::get('/contacts/ledger', 'ContactController@getLedger');
    Route::post('/contacts/send-ledger', 'ContactController@sendLedger');
    Route::get('/contacts/import', 'ContactController@getImportContacts')->name('contacts.import');
    Route::post('/contacts/import', 'ContactController@postImportContacts');
    Route::post('/contacts/check-contact-id', 'ContactController@checkContactId');
    Route::get('/contacts/customers', 'ContactController@getCustomers');
    Route::resource('contacts', 'ContactController');

    Route::get('taxonomies-ajax-index-page', 'TaxonomyController@getTaxonomyIndexPage');
    Route::resource('taxonomies', 'TaxonomyController');

    Route::resource('variation-templates', 'VariationTemplateController');

    Route::get('/delete-media/{media_id}', 'ProductController@deleteMedia');
    Route::post('/products/mass-deactivate', 'ProductController@massDeactivate');
    Route::get('/products/activate/{id}', 'ProductController@activate');
    Route::get('/products/view-product-group-price/{id}', 'ProductController@viewGroupPrice');
    Route::get('/products/add-selling-prices/{id}', 'ProductController@addSellingPrices');
    Route::post('/products/save-selling-prices', 'ProductController@saveSellingPrices');
    Route::post('/products/mass-delete', 'ProductController@massDestroy');
    Route::get('/products/view/{id}', 'ProductController@view');
    Route::get('/products/list', 'ProductController@getProducts');
    Route::get('/products/list-no-variation', 'ProductController@getProductsWithoutVariations');
    Route::post('/products/bulk-edit', 'ProductController@bulkEdit');
    Route::post('/products/bulk-update', 'ProductController@bulkUpdate');
    Route::post('/products/bulk-update-location', 'ProductController@updateProductLocation');
    Route::get('/products/get-product-to-edit/{product_id}', 'ProductController@getProductToEdit');
    
    Route::post('/products/get_sub_categories', 'ProductController@getSubCategories');
    Route::get('/products/get_sub_units', 'ProductController@getSubUnits');
    Route::post('/products/product_form_part', 'ProductController@getProductVariationFormPart');
    Route::post('/products/get_product_variation_row', 'ProductController@getProductVariationRow');
    Route::post('/products/get_variation_template', 'ProductController@getVariationTemplate');
    Route::get('/products/get_variation_value_row', 'ProductController@getVariationValueRow');
    Route::post('/products/check_product_sku', 'ProductController@checkProductSku');
    Route::get('/products/quick_add', 'ProductController@quickAdd');
    Route::post('/products/save_quick_product', 'ProductController@saveQuickProduct');
    Route::get('/products/get-combo-product-entry-row', 'ProductController@getComboProductEntryRow');
    
    Route::resource('products', 'ProductController');

    Route::post('/purchases/update-status', 'PurchaseController@updateStatus');
    Route::get('/purchases/get_products', 'PurchaseController@getProducts');
    Route::get('/purchases/get_suppliers', 'PurchaseController@getSuppliers');
    Route::post('/purchases/get_purchase_entry_row', 'PurchaseController@getPurchaseEntryRow');
    Route::post('/purchases/check_ref_number', 'PurchaseController@checkRefNumber');
    Route::resource('purchases', 'PurchaseController')->except(['show']);

    Route::get('/toggle-subscription/{id}', 'SellPosController@toggleRecurringInvoices');
    Route::post('/sells/pos/get-types-of-service-details', 'SellPosController@getTypesOfServiceDetails');
    Route::get('/sells/subscriptions', 'SellPosController@listSubscriptions');
    Route::get('/sells/duplicate/{id}', 'SellController@duplicateSell');
    Route::get('/sells/drafts', 'SellController@getDrafts');
    Route::get('/sells/quotations', 'SellController@getQuotations');
    Route::get('/sells/draft-dt', 'SellController@getDraftDatables');
    Route::resource('sells', 'SellController')->except(['show']);
    
    Route::get('/check/invoice', 'APIController@checkInvoiceNo')->name('invoice_no.check');

    Route::get('/import-sales', 'ImportSalesController@index');
    Route::post('/import-sales/preview', 'ImportSalesController@preview');
    Route::post('/import-sales', 'ImportSalesController@import');
    Route::get('/revert-sale-import/{batch}', 'ImportSalesController@revertSaleImport');

    Route::get('/sells/pos/get_product_row/{variation_id}/{location_id}', 'SellPosController@getProductRow');
    Route::post('/sells/pos/get_payment_row', 'SellPosController@getPaymentRow');
    Route::post('/sells/pos/get-reward-details', 'SellPosController@getRewardDetails');
    Route::get('/sells/pos/get-recent-transactions', 'SellPosController@getRecentTransactions');
    Route::get('/sells/pos/get-product-suggestion', 'SellPosController@getProductSuggestion');
    Route::resource('pos', 'SellPosController');

    Route::resource('roles', 'RoleController');

    Route::resource('users', 'ManageUserController');

    Route::resource('group-taxes', 'GroupTaxController');

    Route::get('/barcodes/set_default/{id}', 'BarcodeController@setDefault');
    Route::resource('barcodes', 'BarcodeController');

    //Invoice schemes..
    Route::get('/invoice-schemes/set_default/{id}', 'InvoiceSchemeController@setDefault');
    Route::resource('invoice-schemes', 'InvoiceSchemeController');

    //Print Labels
    Route::get('/labels/show', 'LabelsController@show');
    Route::get('/labels/add-product-row', 'LabelsController@addProductRow');
    Route::get('/labels/preview', 'LabelsController@preview');

    //Reports...
    Route::get('/reports/purchase-report', 'ReportController@purchaseReport');
    Route::get('/reports/sale-report', 'ReportController@saleReport');
    Route::get('/reports/service-staff-report', 'ReportController@getServiceStaffReport');
    Route::get('/reports/service-staff-line-orders', 'ReportController@serviceStaffLineOrders');
    Route::get('/reports/table-report', 'ReportController@getTableReport');
    Route::get('/reports/profit-loss', 'ReportController@getProfitLoss');
    Route::get('/reports/get-opening-stock', 'ReportController@getOpeningStock');
    Route::get('/reports/purchase-sell', 'ReportController@getPurchaseSell');
    Route::get('/reports/customer-supplier', 'ReportController@getCustomerSuppliers');
    Route::get('/reports/stock-report', 'ReportController@getStockReport');
    Route::get('/reports/stock-details', 'ReportController@getStockDetails');
    Route::get('/reports/tax-report', 'ReportController@getTaxReport');
    Route::get('/reports/tax-details', 'ReportController@getTaxDetails');
    Route::get('/reports/trending-products', 'ReportController@getTrendingProducts');
    Route::get('/reports/expense-report', 'ReportController@getExpenseReport');
    Route::get('/reports/stock-adjustment-report', 'ReportController@getStockAdjustmentReport');
    Route::get('/reports/register-report', 'ReportController@getRegisterReport');
    Route::get('/reports/sales-representative-report', 'ReportController@getSalesRepresentativeReport');
    Route::get('/reports/sales-representative-total-expense', 'ReportController@getSalesRepresentativeTotalExpense');
    Route::get('/reports/sales-representative-total-sell', 'ReportController@getSalesRepresentativeTotalSell');
    Route::get('/reports/sales-representative-total-commission', 'ReportController@getSalesRepresentativeTotalCommission');
    Route::get('/reports/stock-expiry', 'ReportController@getStockExpiryReport');
    Route::get('/reports/stock-expiry-edit-modal/{purchase_line_id}', 'ReportController@getStockExpiryReportEditModal');
    Route::post('/reports/stock-expiry-update', 'ReportController@updateStockExpiryReport')->name('updateStockExpiryReport');
    Route::get('/reports/customer-group', 'ReportController@getCustomerGroup');
    Route::get('/reports/product-purchase-report', 'ReportController@getproductPurchaseReport');
    Route::get('/reports/product-sell-report', 'ReportController@getproductSellReport');
    Route::get('/reports/product-sell-report-with-purchase', 'ReportController@getproductSellReportWithPurchase');
    Route::get('/reports/product-sell-grouped-report', 'ReportController@getproductSellGroupedReport');
    Route::get('/reports/lot-report', 'ReportController@getLotReport');
    Route::get('/reports/purchase-payment-report', 'ReportController@purchasePaymentReport');
    Route::get('/reports/sell-payment-report', 'ReportController@sellPaymentReport');
    Route::get('/reports/product-stock-details', 'ReportController@productStockDetails');
    Route::get('/reports/adjust-product-stock', 'ReportController@adjustProductStock');
    Route::get('/reports/get-profit/{by?}', 'ReportController@getProfit');
    Route::get('/reports/items-report', 'ReportController@itemsReport');
    Route::get('/reports/get-stock-value', 'ReportController@getStockValue');
    
    Route::get('business-location/activate-deactivate/{location_id}', 'BusinessLocationController@activateDeactivateLocation');

    //Business Location Settings...
    Route::prefix('business-location/{location_id}')->name('location.')->group(function () {
        Route::get('settings', 'LocationSettingsController@index')->name('settings');
        Route::post('settings', 'LocationSettingsController@updateSettings')->name('settings_update');
    });

    //Business Locations...
    Route::post('business-location/check-location-id', 'BusinessLocationController@checkLocationId');
    Route::resource('business-location', 'BusinessLocationController');

    //Invoice layouts..
    Route::resource('invoice-layouts', 'InvoiceLayoutController');

    //Expense Categories...
    Route::resource('expense-categories', 'ExpenseCategoryController');

    //Expenses...
    Route::resource('expenses', 'ExpenseController');

    //Transaction payments...
    // Route::get('/payments/opening-balance/{contact_id}', 'TransactionPaymentController@getOpeningBalancePayments');
    Route::get('/payments/show-child-payments/{payment_id}', 'TransactionPaymentController@showChildPayments');
    Route::get('/payments/view-payment/{payment_id}', 'TransactionPaymentController@viewPayment');
    Route::get('/payments/add_payment/{transaction_id}', 'TransactionPaymentController@addPayment');
    Route::get('/payments/pay-contact-due/{contact_id}', 'TransactionPaymentController@getPayContactDue');
    Route::post('/payments/pay-contact-due', 'TransactionPaymentController@postPayContactDue');
    Route::resource('payments', 'TransactionPaymentController');

    //Printers...
    Route::resource('printers', 'PrinterController');

    Route::get('/stock-adjustments/remove-expired-stock/{purchase_line_id}', 'StockAdjustmentController@removeExpiredStock');
    Route::post('/stock-adjustments/get_product_row', 'StockAdjustmentController@getProductRow');
    Route::resource('stock-adjustments', 'StockAdjustmentController');

    Route::get('/cash-register/register-details', 'CashRegisterController@getRegisterDetails');
    Route::get('/cash-register/close-register/{id?}', 'CashRegisterController@getCloseRegister');
    Route::post('/cash-register/close-register', 'CashRegisterController@postCloseRegister');
    Route::resource('cash-register', 'CashRegisterController');

    //Import products
    Route::get('/import-products', 'ImportProductsController@index');
    Route::post('/import-products/store', 'ImportProductsController@store');

    //Sales Commission Agent
    Route::resource('sales-commission-agents', 'SalesCommissionAgentController');

    //Stock Transfer
    Route::get('stock-transfers/print/{id}', 'StockTransferController@printInvoice');
    Route::post('stock-transfers/update-status/{id}', 'StockTransferController@updateStatus');
    Route::resource('stock-transfers', 'StockTransferController');
    
    Route::get('/opening-stock/add/{product_id}', 'OpeningStockController@add');
    Route::post('/opening-stock/save', 'OpeningStockController@save');

    //Customer Groups
    Route::resource('customer-group', 'CustomerGroupController');

    //Import opening stock
    Route::get('/import-opening-stock', 'ImportOpeningStockController@index');
    Route::post('/import-opening-stock/store', 'ImportOpeningStockController@store');

    //Sell return
    Route::resource('sell-return', 'SellReturnController');
    Route::get('sell-return/get-product-row', 'SellReturnController@getProductRow');
    Route::get('/sell-return/print/{id}', 'SellReturnController@printInvoice');
    Route::get('/sell-return/add/{id}', 'SellReturnController@add');
    
    //Backup
    Route::get('backup/download/{file_name}', 'BackUpController@download');
    Route::get('backup/delete/{file_name}', 'BackUpController@delete');
    Route::resource('backup', 'BackUpController', ['only' => [
        'index', 'create', 'store'
    ]]);

    Route::get('selling-price-group/activate-deactivate/{id}', 'SellingPriceGroupController@activateDeactivate');
    Route::get('export-selling-price-group', 'SellingPriceGroupController@export');
    Route::post('import-selling-price-group', 'SellingPriceGroupController@import');

    Route::resource('selling-price-group', 'SellingPriceGroupController');

    Route::resource('notification-templates', 'NotificationTemplateController')->only(['index', 'store']);
    Route::get('notification/get-template/{transaction_id}/{template_for}', 'NotificationController@getTemplate');
    Route::post('notification/send', 'NotificationController@send');

    Route::post('/purchase-return/update', 'CombinedPurchaseReturnController@update');
    Route::get('/purchase-return/edit/{id}', 'CombinedPurchaseReturnController@edit');
    Route::post('/purchase-return/save', 'CombinedPurchaseReturnController@save');
    Route::post('/purchase-return/get_product_row', 'CombinedPurchaseReturnController@getProductRow');
    Route::get('/purchase-return/create', 'CombinedPurchaseReturnController@create');
    Route::get('/purchase-return/add/{id}', 'PurchaseReturnController@add');
    Route::resource('/purchase-return', 'PurchaseReturnController', ['except' => ['create']]);

    Route::get('/discount/activate/{id}', 'DiscountController@activate');
    Route::post('/discount/mass-deactivate', 'DiscountController@massDeactivate');
    Route::resource('discount', 'DiscountController');

    Route::group(['prefix' => 'account'], function () {
        Route::resource('/account', 'AccountController');
        Route::get('/fund-transfer/{id}', 'AccountController@getFundTransfer');
        Route::post('/fund-transfer', 'AccountController@postFundTransfer');
        Route::get('/deposit/{id}', 'AccountController@getDeposit');
        Route::post('/deposit', 'AccountController@postDeposit');
        Route::get('/close/{id}', 'AccountController@close');
        Route::get('/activate/{id}', 'AccountController@activate');
        Route::get('/delete-account-transaction/{id}', 'AccountController@destroyAccountTransaction');
        Route::get('/get-account-balance/{id}', 'AccountController@getAccountBalance');
        Route::get('/balance-sheet', 'AccountReportsController@balanceSheet');
        Route::get('/trial-balance', 'AccountReportsController@trialBalance');
        Route::get('/payment-account-report', 'AccountReportsController@paymentAccountReport');
        Route::get('/link-account/{id}', 'AccountReportsController@getLinkAccount');
        Route::post('/link-account', 'AccountReportsController@postLinkAccount');
        Route::get('/cash-flow', 'AccountController@cashFlow');
    });
    
    Route::resource('account-types', 'AccountTypeController');

    //Restaurant module
    Route::group(['prefix' => 'modules'], function () {
        Route::resource('tables', 'Restaurant\TableController');
        Route::resource('modifiers', 'Restaurant\ModifierSetsController');

        //Map modifier to products
        Route::get('/product-modifiers/{id}/edit', 'Restaurant\ProductModifierSetController@edit');
        Route::post('/product-modifiers/{id}/update', 'Restaurant\ProductModifierSetController@update');
        Route::get('/product-modifiers/product-row/{product_id}', 'Restaurant\ProductModifierSetController@product_row');

        Route::get('/add-selected-modifiers', 'Restaurant\ProductModifierSetController@add_selected_modifiers');

        Route::get('/kitchen', 'Restaurant\KitchenController@index');
        Route::get('/kitchen/mark-as-cooked/{id}', 'Restaurant\KitchenController@markAsCooked');
        Route::post('/refresh-orders-list', 'Restaurant\KitchenController@refreshOrdersList');
        Route::post('/refresh-line-orders-list', 'Restaurant\KitchenController@refreshLineOrdersList');

        Route::get('/orders', 'Restaurant\OrderController@index');
        Route::get('/orders/mark-as-served/{id}', 'Restaurant\OrderController@markAsServed');
        Route::get('/data/get-pos-details', 'Restaurant\DataController@getPosDetails');
        Route::get('/orders/mark-line-order-as-served/{id}', 'Restaurant\OrderController@markLineOrderAsServed');
    });

    Route::get('bookings/get-todays-bookings', 'Restaurant\BookingController@getTodaysBookings');
    Route::resource('bookings', 'Restaurant\BookingController');

    Route::resource('types-of-service', 'TypesOfServiceController');
    Route::get('sells/edit-shipping/{id}', 'SellController@editShipping');
    Route::put('sells/update-shipping/{id}', 'SellController@updateShipping');
    Route::get('shipments', 'SellController@shipments');

    Route::post('upload-module', 'Install\ModulesController@uploadModule');
    Route::resource('manage-modules', 'Install\ModulesController')
        ->only(['index', 'destroy', 'update']);
    Route::resource('warranties', 'WarrantyController');

    Route::resource('dashboard-configurator', 'DashboardConfiguratorController')
    ->only(['edit', 'update']);

    //common controller for document & note
    Route::get('get-document-note-page', 'DocumentAndNoteController@getDocAndNoteIndexPage');
    Route::post('post-document-upload', 'DocumentAndNoteController@postMedia');
    Route::resource('note-documents', 'DocumentAndNoteController');
});

Route::middleware(['EcomApi'])->prefix('api/ecom')->group(function () {
    Route::get('products/{id?}', 'ProductController@getProductsApi');
    Route::get('categories', 'CategoryController@getCategoriesApi');
    Route::get('brands', 'BrandController@getBrandsApi');
    Route::post('customers', 'ContactController@postCustomersApi');
    Route::get('settings', 'BusinessController@getEcomSettings');
    Route::get('variations', 'ProductController@getVariationsApi');
    Route::post('orders', 'SellPosController@placeOrdersApi');
});

//common route
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});

Route::middleware(['setData', 'auth', 'SetSessionData', 'language', 'timezone'])->group(function () {
    Route::get('/load-more-notifications', 'HomeController@loadMoreNotifications');
    Route::get('/get-total-unread', 'HomeController@getTotalUnreadNotifications');
    Route::get('/purchases/print/{id}', 'PurchaseController@printInvoice');
    Route::get('/purchases/{id}', 'PurchaseController@show');
    Route::get('/sells/{id}', 'SellController@show');
    Route::get('/sells/{transaction_id}/print', 'SellPosController@printInvoice')->name('sell.printInvoice');
    Route::get('/sells/invoice-url/{id}', 'SellPosController@showInvoiceUrl');
});

Route::get('/print-invoice/{transaction_id}', 'SellPosController@printInvoice')->name('sell.printInvoice');

Route::group(['prefix'=>'webview'],function(){
    Route::get('/reports/profit-loss', 'ReportController@getProfitLossWebview');
});

Route::get('/sekolah_sd/peserta-didik-baru/check',"SekolahSDController@checkNikPPDB")->name('sekolah_sd.ppdb.cek_nik');
