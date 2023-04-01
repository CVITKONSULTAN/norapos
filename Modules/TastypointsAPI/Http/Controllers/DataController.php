<?php

namespace Modules\TastypointsAPI\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Menu;


class DataController extends Controller
{

    /**
     * Defines user permissions for the module.
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'tastypointsapi.access_module',
                'label' => __('tastypointsapi::lang.access_module'),
                'default' => false
            ]
        ];
    }

     /**
     * Adds Tastypoints API menus
     * @return null
     */
    public function modifyAdminMenu()
    {
        if (auth()->user()->can('superadmin') || auth()->user()->can("tastypointsapi.access_module") ) {
            Menu::modify(
                'admin-sidebar-menu',
                function ($menu) {
                    $menu->url(
                        route("tastypointsapi.index"), 
                        __('tastypointsapi::lang.tastypoints'),
                        [
                            'icon' => 'fa fas fa-exchange-alt', 
                            'active' => request()->segment(1) == 'tastypointsapi' && empty(request()->segment(2))
                        ])->order(2);
                    $menu->url(
                        route("partner.index"), 
                        "Partner Management",
                        [
                            'icon' => 'fa fas fa-business-time', 
                            'active' => request()->segment(2) == 'partner-management'
                        ])->order(3);
                    // $menu->url(
                    //     route("tastypointsapi.pagebuilder"), 
                    //     "Page Builder",
                    //     [
                    //         'icon' => 'fa fas fa-file-alt', 
                    //         'active' => request()->segment(2) == 'pagebuilder'
                    //     ])->order(4);
                    $menu->url(
                        route("comunication.message-parameter"), 
                        "Communications",
                        [
                            'icon' => 'fa fas fa-bullhorn', 
                            'active' => request()->segment(2) == 'communications'
                        ])->order(4);
                    $menu->url(
                        route("marketing.newsletter"), 
                        "Marketing Campaigns",
                        [
                            'icon' => 'fab fa-gratipay', 
                            'active' => request()->segment(2) == 'marketing'
                        ])->order(4);
                }
            ); 

        }
        
    }

}
