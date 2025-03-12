<?php 
    Menu::create('admin-sidebar-primajasa', function ($menu) {
            
            $enabled_modules = !empty(session('business.enabled_modules')) ? session('business.enabled_modules') : [];

            //Home
            $menu->url(
                action('HomeController@index'), 
                __('home.home'),
                [
                    'icon' => 'fa fas fa-tachometer-alt', 
                    'active' => request()->segment(1) == 'home'
                ]
            )->order(1);

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

            $menu->dropdown(
                "Sparepart",
                function ($sub) {
                    $sub->url(
                        "#",
                        "Ketersediaan Sparepart",
                        [
                            'active' => request()->segment(1) == 'ketersediaan-sparepart'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Sparepart Masuk",
                        [
                            'active' => request()->segment(1) == 'sparepart-masuk'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Sparepart Keluar",
                        [
                            'active' => request()->segment(1) == 'sparepart-keluar'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Penyesuaian Stok",
                        [
                            'active' => request()->segment(1) == 'penyesuaian-stok'
                        ]
                    );
                },
                ['icon' => 'fa fas fa-wrench']
            )->order(2);

            $menu->dropdown(
                "Operasional",
                function ($sub) {
                    $sub->url(
                        "#",
                        "Daftar Titik RAM/RAMP",
                        [
                            'active' => request()->segment(1) == 'titk-ram'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Pencatatan RAM/RAMP",
                        [
                            'active' => request()->segment(1) == 'pencatatan-ram'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Data Angkutan (DT)",
                        [
                            'active' => request()->segment(1) == 'data-angkutan'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Penggunaan BBM",
                        [
                            'active' => request()->segment(1) == 'penggunaan-bbm'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Reimburse",
                        [
                            'active' => request()->segment(1) == 'reimburse'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Upah & Penggajian",
                        [
                            'active' => request()->segment(1) == 'upah'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Service & Pemeliharaan DT",
                        [
                            'active' => request()->segment(1) == 'serivce-dt'
                        ]
                    );
                },
                ['icon' => 'fa fa-cubes']
            )->order(3);

            $menu->dropdown(
                "Manajemen Staff",
                function ($sub) {
                    $sub->url(
                        "#",
                        "Data Supir",
                        [
                            'active' => request()->segment(1) == 'data-supir'
                        ]
                    );
                    $sub->url(
                        "#",
                        "Staff/Karyawan",
                        [
                            'active' => request()->segment(1) == 'staff-karyawan'
                        ]
                    );
                },
                ['icon' => 'fa fa-user-secret']
            )->order(5);

    });
?>