<?php

Menu::create('admin-sidebar-ciptakarya', function ($menu) {

    $user = auth()->user();

    $menu->url(
        '/home',
        "Dashboard",
        [
            'icon' => 'fa fas fa-tachometer-alt', 
            'active' => 
            request()->segment(1) == 'home'
        ]
    )->order(0);

    $menu->url(
        route('ciptakarya.list_data_pbg'),
        "Pemohon / Pengajuan",
        [
            'icon' => 'fa fas fa-inbox', 
            'active' => request()->segment(1) == 'ciptakarya' && request()->segment(2) == 'list-data-pbg'
        ]
    )->order(2);

    if($user->checkAdmin()){
        
        $menu->dropdown(
            "Manajemen Pengguna",
            function ($sub) {
                $sub->url(
                    action('ManageUserController@index'),
                    __('user.users'),
                    ['icon' => 'fa fas fa-user', 'active' => request()->segment(1) == 'users']
                );
                $sub->url(
                    action('RoleController@index'),
                    "Role",
                    ['icon' => 'fa fas fa-briefcase', 'active' => request()->segment(1) == 'roles']
                );
            },
            ['icon' => 'fa fas fa-users']
        )->order(1);

        $menu->url(
            route('ciptakarya.list_data_petugas'),
            "Data Petugas",
            [
                'icon' => 'fa fas fa-user-secret', 
                'active' => request()->segment(1) == 'ciptakarya' && request()->segment(2) == 'petugas'
            ]
        )->order(3);
    }

});

?>