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

Route::group([
    "prefix"=>'tastypointsapi',
    'middleware' => [
        'SetSessionData', 
        'web', 
        'auth', 
        'language', 
        'AdminSidebarMenu', 
        'superadmin'
    ],
], function() {

    Route::get('/install', 'InstallController@index');
    Route::get('/install/update', 'InstallController@update');
    Route::get('/install/uninstall', 'InstallController@uninstall');

    Route::get('verification', 'TastypointsAPIController@verification')->name("tastypointsapi.verification");
    Route::get('logout', 'TastypointsAPIController@logout')->name("tastypointsapi.logout");
    Route::post('set_session', 'TastypointsAPIController@test_session')->name("tastypointsapi.test_session");
    Route::post('testnet', 'TastypointsAPIController@testnet')->name("tastypointsapi.testnet");
    
    
    Route::group([ 'middleware' => ["checkSession"]],function(){

        Route::post('datatables', 'TastypointsAPIController@datatables')->name("tastypointsapi.datatables");

        //upload file
        Route::post('/upload/{type}', 'TastypointsAPIController@upload')->name("tastypointsapi.upload");

        // dashboard
        Route::get('/', 'TastypointsAPIController@index')->name("tastypointsapi.index");
    
        // setup connection to main server
        Route::get('setup', 'TastypointsAPIController@setup')->name("tastypointsapi.setup");
        Route::post('setup/update', 'TastypointsAPIController@setup_update')->name("tastypointsapi.setup.update");
        
        // page builder
        Route::get('pagebuilder', 'TastypointsAPIController@pageBuilder')->name("tastypointsapi.pagebuilder");
        
        // geo set
        Route::get('geo-settings', 'TastypointsAPIController@geoSettings')->name("tastypointsapi.geosettings");
        Route::get('geo-settings/state', 'TastypointsAPIController@state')->name("tastypointsapi.geosettings.state");
        Route::get('geo-settings/city', 'TastypointsAPIController@city')->name("tastypointsapi.geosettings.city");
        Route::get('geo-settings/subcity', 'TastypointsAPIController@subcity')->name("tastypointsapi.geosettings.subcity");
        Route::get('geo-settings/language', 'TastypointsAPIController@language')->name("tastypointsapi.geosettings.language");
        Route::get('geo-settings/currency', 'TastypointsAPIController@currency')->name("tastypointsapi.geosettings.currency");
        Route::get('geo-settings/timezone', 'TastypointsAPIController@timezone')->name("tastypointsapi.geosettings.timezone");
        
        // sclab screen
        Route::get('scdata_labs', 'TastypointsAPIController@scdata_labs')->name("tastypointsapi.scdata_labs");
        Route::get('scdata_labs_table', function(){
            $data["config"] = \Modules\TastypointsAPI\Entities\Tastyconfig::first();
            return view("tastypointsapi::tastyapi.sclabs_table",$data); 
        })->name("tastypointsapi.scdata_labs_table");

        Route::get('sclab-category', 'TastypointsAPIController@sclab_category')->name("tastypointsapi.sclab_category");
        Route::get('sclab-status', 'TastypointsAPIController@sclab_status')->name("tastypointsapi.sclab_status");

        Route::get('push-testing', function(){return view("tastypointsapi::tastyapi.push_notification");})->name("tastypointsapi.push_testing");
        Route::post('fcm', "TastypointsAPIController@fcm")->name("tastypointsapi.fcm");
        
        // other page
        Route::get('app-screens', 'TastypointsAPIController@app_screens')->name("tastypointsapi.app-screens");
        Route::get('sample-profile-image', 'TastypointsAPIController@sample_profile_image')->name("tastypointsapi.sample-profile-image");
        Route::get('settings', 'PartnerController@settings')->name("partner.settings");

        Route::group([
            "prefix"=>'stripe'
        ],function(){

            Route::get('index', function(){ return view("tastypointsapi::tastyapi.stripe.paymentIntent"); })->name("stripe.index");
            Route::get('customer', function(){ return view("tastypointsapi::tastyapi.stripe.Customers"); })->name("stripe.customer");
            Route::get('payout', function(){ return view("tastypointsapi::tastyapi.stripe.Payouts"); })->name("stripe.payout");
            Route::get('customer_test', function(){ return view("tastypointsapi::tastyapi.stripe.customer_test"); })->name("stripe.customer_test");
            Route::get('customer_log_test', function(){ return view("tastypointsapi::tastyapi.stripe.customer_log_test"); })->name("stripe.customer_log_test");
            Route::get('paypal_log', function(){ return view("tastypointsapi::tastyapi.stripe.paypal_log"); })->name("stripe.paypal_log");

            Route::get('paypal_log_data', "StripeController@paypal_log_data")->name("stripe.paypal_log.data");

            Route::post('list', "StripeController@list")->name("stripe.list");

            Route::get('list_test', "StripeController@list_test")->name("stripe.list_test");
            Route::get('test', "StripeController@test")->name("stripe.test");

        });

        Route::group([
            "prefix"=>'tpadmin'
        ],function(){
            Route::get('/language', 'TpadminController@index')->name("tpadmin.language");
            Route::get('/country', 'TpadminController@country')->name("tpadmin.country");
        });

        Route::group([
            "prefix"=>'partner-management'
        ],function(){

            Route::get('/', 'PartnerController@index')->name("partner.index");
            Route::get('/partner/create', 'PartnerController@create')->name("partner.create");
            Route::get('/partner/{id}/edit', 'PartnerController@edit')->name("partner.edit");

            Route::get('/industry', 'PartnerController@industry')->name("partner.industry");
            Route::get('/partner-types', 'PartnerController@partner_types')->name("partner.partner-types");
            Route::get('/photo-types', 'PartnerController@photo_types')->name("partner.photo-types");
            Route::get('/phone-types', 'PartnerController@phone_types')->name("partner.phone-types");
            Route::get('/partner-status', 'PartnerController@partner_status')->name("partner.partner-status");
            Route::get('/week-days', 'PartnerController@week_days')->name("partner.week-days");
            
            Route::get('/menu-access', 'PartnerController@menu_access')->name("partner.menu-access");
            Route::get('/staff-title', 'PartnerController@staff_title')->name("partner.staff-title");
            
            Route::get('/delivery-settings', 'PartnerController@delivery_settings')->name("partner.delivery-settings");
            Route::get('/menu-item-management', 'PartnerController@menu_items')->name("partner.menu-items");
            Route::get('/admin-level', 'PartnerController@admin_level')->name("partner.admin-level");
            Route::get('/app-sidemenu-management', 'PartnerController@sidemenu_manage')->name("partner.sidemenu-manage");

            Route::group([
                "prefix"=>'pos'
            ],function(){
                Route::get('/list-devices', 'PartnerController@pos_management')->name("partner.pos-management");
                Route::get('/setup', function(){ return view("tastypointsapi::partner.pos.setup"); })->name("partner.pos.setup");
                Route::get('/data-order', function(){ return view("tastypointsapi::partner.pos.data-order"); })->name("partner.pos.data-order");
                Route::get('/order-status', function(){ return view("tastypointsapi::partner.pos.order-status"); })->name("partner.pos.order-status");
                Route::get('/cancelation-reasons', function(){ return view("tastypointsapi::partner.pos.cancel"); })->name("partner.pos.cancel");
            });
            
            Route::get('/payment-management', function(){
                return view("tastypointsapi::partner.payment-management");
            })->name("partner.payment-management");

            Route::get('/partner-dish-list', function(){
                return view("tastypointsapi::partner.dish-list");
            })->name("partner.dish-list");

            Route::get('/dish-category', function(){
                return view("tastypointsapi::partner.dish-category");
            })->name("partner.dish-category");
            
            Route::get('/rewards-settings', function(){
                return view("tastypointsapi::partner.rewards-settings");
            })->name("partner.rewards-settings");

            Route::get('/partner/groups', function(){
                return view("tastypointsapi::partner.partner-groups");
            })->name("partner.partner-groups");
            
        });

        Route::group([
            "prefix"=>'communications'
        ],function(){

            Route::get('/', 'CommunicationController@index')->name("communication.index");

            Route::get('/sms/originators', 'CommunicationController@sms_originators')->name("comunication.sms-originators");
            Route::get('/sms/confirmation-code', 'CommunicationController@sms_confirm_code')->name("comunication.sms_confirm_code");
            Route::get('/sms/message-history', 'CommunicationController@sms_message_history')->name("comunication.sms_message_history");
            Route::get('/sms/send-sms-messages', 'CommunicationController@send_sms')->name("comunication.send_sms");
            Route::get('/sms/sms-messages-template', 'CommunicationController@sms_template')->name("comunication.sms_template");

            Route::get('/push-notification/send', 'CommunicationController@send_push_notification')->name("comunication.send_push_notification");
            
            Route::get('/message-parameter', 'CommunicationController@message_parameter')->name("comunication.message-parameter");
            Route::get('/manage-tasty-group', 'CommunicationController@manage_tasty_group')->name("comunication.manage_tasty_group");

            Route::get('/tasty-lovers', 'CommunicationController@tasty_lovers')->name("comunication.tasty_lovers");

        });

        Route::group([
            "prefix"=>'marketing'
        ],function(){
            
            Route::get('/stamp-campaigns', 'MarketingController@stamp_campaigns')->name("marketing.stamp_campaigns");

            Route::get('/embed', function(){
                return view("tastypointsapi::marketing.embed");
            })->name("marketing.embed");
            
            // newsletter page builder
            Route::get('/news-letter', 'MarketingController@newsletter')->name("marketing.newsletter");
            Route::get('/news-letter/pagebuilder', 'MarketingController@newsletter_pagebuilder')->name("marketing.newsletter.pagebuilder");
            Route::get('/news-letter/pagebuilder/{id}/{type}', 'MarketingController@newsletter_pagebuilder_edit')->name("marketing.newsletter.pagebuilder.edit");
            // landingpage builder
            Route::get('/landingpage', 'MarketingController@landingpage')->name("marketing.landingpage");
            Route::get('/landingpage/pagebuilder', 'MarketingController@landingpage_pagebuilder')->name("marketing.landingpage.pagebuilder");
            Route::get('/landingpage/pagebuilder/{id}/{type}', 'MarketingController@landingpage_pagebuilder_edit')->name("marketing.landingpage.pagebuilder.edit");
            
            //POS receipts
            Route::get('/pos', 'MarketingController@pos')->name("marketing.pos");
            Route::get('/pos/builder', 'MarketingController@pos_builder')->name("marketing.pos.pagebuilder");
            Route::get('/pos/builder/{id}/{type}', 'MarketingController@pos_builder_edit')->name("marketing.pos.pagebuilder.edit");

            //POS receipts
            Route::get('/flow', 'MarketingController@flow')->name("marketing.flow");
            Route::get('/flow/add', 'MarketingController@add')->name("marketing.add");
            Route::get('/flow/nodes-group', 'MarketingController@nodes_group')->name("marketing.flow.nodes_group");
            Route::get('/flow/create-nodes', 'MarketingController@create_node_screen')->name("marketing.flow.create_nodes_screen");
            Route::get('/flow/node-containers', 'MarketingController@node_containers')->name("marketing.flow.node_containers");
            
        });

    });


});

Route::get('/pages/{id}-{random_id}.html', "MarketingController@render_landingpage");
Route::get('/print-receipt/{id}.html', function(){
    return view("tastypointsapi::print-receipt");
});
Route::post('/upload-data/{type}', 'TastypointsAPIController@upload')->name("tastypointsapi.upload.public");
Route::get('/print', 'TastypointsAPIController@print')->name("tastypointsapi.print");