<?php 
    Menu::create('admin-sidebar-pejantan', function ($menu) {
            
            $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];

            //Home
            $menu->url(action('HomeController@index'), __('home.home'), ['icon' => 'fa fas fa-tachometer-alt', 'active' => request()->segment(1) == 'home'])->order(1);

            $menu->url(
                route('pejantan.jalan'), 
                "Data Jalan", 
                [
                    'icon' => 'fa fas fa-database', 
                    'active' => 
                    request()->segment(1) == 'pejantan' &&
                    request()->segment(2) == 'jalan'
                ]
            )->order(2);
            $menu->url(
                route('pejantan.jembatan'), 
                "Data Jembatan", 
                [
                    'icon' => 'fa fas fa-database', 
                    request()->segment(1) == 'pejantan' &&
                    request()->segment(2) == 'jembatan'
                ]
            )->order(3);

            //User management dropdown
            if (auth()->user()->can('user.view') || auth()->user()->can('user.create') || auth()->user()->can('roles.view')) {
                $menu->dropdown(
                    "Manajemen Pengguna",
                    function ($sub) {
                        if (auth()->user()->can('user.view')) {
                            $sub->url(
                                action('ManageUserController@index'),
                                __('user.users'),
                                ['icon' => 'fa fas fa-user', 'active' => request()->segment(1) == 'users']
                            );
                        }
                        if (auth()->user()->can('roles.view')) {
                            $sub->url(
                                action('RoleController@index'),
                                "Role",
                                ['icon' => 'fa fas fa-briefcase', 'active' => request()->segment(1) == 'roles']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-users']
                )->order(4);
            }

    });
?>