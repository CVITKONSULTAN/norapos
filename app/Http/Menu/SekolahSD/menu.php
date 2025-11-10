<?php

Menu::create('admin-sidebar-sekolah_sd', function ($menu) {

    $user = auth()->user();

    $menu->url(
        '/home',
        "Dashboard",
        [
            'icon' => 'fa fas fa-tachometer-alt', 
            'active' => 
            request()->segment(1) == 'home'
        ]
    );

    if($user->checkAdmin()){
        $menu->dropdown(
            "Rekap Nilai Siswa",
            function ($sub) {
                $sub->url(
                        action('SekolahSDController@data_rekap_nilai_index'),
                    "Nilai Formatif",
                    [
                        'icon' => 'fa fas fa-user', 
                        'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'data-rekap-nilai' 
                        ]
                    );
                    $sub->url(
                        action('SekolahSDController@data_rekap_nilai_sumatif_index'),
                        "Nilai Sumatif",
                        [
                            'icon' => 'fa fas fa-briefcase', 
                            'active' => 
                            request()->segment(1) == 'sekolah_sd' &&
                            request()->segment(2) == 'data-rekap-nilai-sumatif' 
                        ]
                );
            },
            ['icon' => 'fa fas fa-server']
        )->order(1);
        $menu->dropdown(
            "Kontrol Pengguna",
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
        )->order(0);
        $menu->url(
            action('SekolahSDController@data_tendik_index'),
            "Data Tenaga Pendidik",
            [
                'icon' => 'fa fas fa-graduation-cap', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-tendik' 
            ]
        );
        $menu->url(
            action('SekolahSDController@data_ekskul_index'),
            "Ekstrakurikuler",
            [
                'icon' => 'fa fa-futbol', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-ekskul' 
            ]
        );
        $menu->url(
            action('SekolahSDController@kelas_index'),
            "Data Kelas",
            [
                'icon' => 'fa fas fa-cube', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'kelas-siswa' 
            ]
        );
        $menu->url(
            action('SekolahSDController@data_siswa_index'),
            "Data Siswa",
            [
                'icon' => 'fa fas fa-user-circle', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-siswa' 
            ]
        );
        $menu->dropdown(
            "Peserta Didik Baru",
            function ($sub) {
                $sub->url(
                    route('sekolah_sd.peserta_didik_baru'),
                    "Daftar Data",
                    [
                        'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'peserta-didik-baru' 
                    ]
                );
                $sub->url(
                    route('sekolah_sd.peserta_didik_baru.config'),
                    "Pengaturan Penerimaan",
                    [
                        'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'peserta-didik-baru-config'
                    ]
                );
            },
            ['icon' => 'fa fas fa-user-plus']
        );
        if($user->checkAdmin()){
            $menu->url(
                action('SekolahSDController@data_mapel_index'),
                "Mata Pelajaran",
                [
                    'icon' => 'fa fas fa-cubes', 
                    'active' =>
                    request()->segment(1) == 'sekolah_sd' &&
                    request()->segment(2) == 'data-mapel' 
                ]
            );
        }
        if(!$user->checkAdmin() && $user->business->show_mapel == 1){
            $menu->url(
                action('SekolahSDController@data_mapel_index'),
                "Mata Pelajaran",
                [
                    'icon' => 'fa fas fa-cubes', 
                    'active' =>
                    request()->segment(1) == 'sekolah_sd' &&
                    request()->segment(2) == 'data-mapel' 
                ]
            );
        }
        $menu->url(
            action('SekolahSDController@data_rekap_absen_index'),
            "Rekap Absen Siswa",
            [
                'icon' => 'fa fas fa-tasks', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-rekap-absen' 
            ]
        );
        $menu->url(
            action('SekolahSDController@buku_induk_index'),
            "Buku Induk Siswa",
            [
                'icon' => 'fa fas fa-book', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'buku-induk' 
            ]
        );
        $menu->dropdown(
            "E-Raport",
            function ($sub) {
                $sub->url(
                    action('SekolahSDController@rapor_project_index'),
                    "Raport Project Siswa",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'project-rapor' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@raport_akhir_index'),
                    "Raport Akhir",
                    ['icon' => 'fa fas fa-user', 
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'raport-akhir' 
                    ]
                );
                $sub->url(
                    route('sekolah_sd.raport_table.index'),
                    "Tabel Siswa",
                    ['icon' => 'fa fas fa-user', 
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'raport-table' 
                    ]
                );
                $sub->url(
                    route('sekolah_sd.ranking_kelas.index'),
                    "Ranking Kelas",
                    [
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'ranking-kelas' 
                    ]
                );
            },
            ['icon' => 'fa fas fa-address-book']
        )->order(1);
        $menu->dropdown(
            "Projek Siswa",
            function ($sub) {
                $sub->url(
                    action('SekolahSDController@dimensi_projek'),
                    "Dimensi",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'dimensi-projek' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@skenario_projek'),
                    "Skenario Projek",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'skenario-projek' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@project_index'),
                    "Penilaian Projek",
                    ['icon' => 'fa fas fa-user', 'active' => 
                    request()->segment(1) == 'sekolah_sd' &&
                    request()->segment(2) == 'project' 
                    ]
                );
            },
            ['icon' => 'fa fas fa-archive']
        )->order(1);
    }

    if($user->checkGuruMapel()){
        $menu->url(
            action('SekolahSDController@data_mapel_index'),
            "Mata Pelajaran",
            [
                'icon' => 'fa fas fa-cubes', 
                'active' =>
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-mapel' 
            ]
        );
    }

    if($user->checkGurukelas()){
        $menu->url(
            action('SekolahSDController@data_rekap_absen_index'),
            "Rekap Absen Siswa",
            [
                'icon' => 'fa fas fa-tasks', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-rekap-absen' 
            ]
        );
        $menu->dropdown(
            "E-Raport",
            function ($sub) {
                $sub->url(
                    action('SekolahSDController@rapor_project_index'),
                    "Raport Project Siswa",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'project-rapor' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@raport_akhir_index'),
                    "Raport Akhir",
                    ['icon' => 'fa fas fa-user', 
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'raport-akhir' 
                    ]
                );
            },
            ['icon' => 'fa fas fa-address-book']
        )->order(1);

        $menu->dropdown(
            "Rekap Nilai Siswa",
            function ($sub) {
                $sub->url(
                        action('SekolahSDController@data_rekap_nilai_index'),
                    "Nilai Formatif",
                    [
                        'icon' => 'fa fas fa-user', 
                        'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'data-rekap-nilai' 
                        ]
                    );
                    $sub->url(
                        action('SekolahSDController@data_rekap_nilai_sumatif_index'),
                        "Nilai Sumatif",
                        [
                            'icon' => 'fa fas fa-briefcase', 
                            'active' => 
                            request()->segment(1) == 'sekolah_sd' &&
                            request()->segment(2) == 'data-rekap-nilai-sumatif' 
                        ]
                );
            },
            ['icon' => 'fa fas fa-server']
        )->order(1);

        $menu->dropdown(
            "Projek Siswa",
            function ($sub) {
                $sub->url(
                    action('SekolahSDController@dimensi_projek'),
                    "Dimensi",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'dimensi-projek' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@skenario_projek'),
                    "Skenario Projek",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'skenario-projek' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@project_index'),
                    "Penilaian Projek",
                    ['icon' => 'fa fas fa-user', 'active' => 
                    request()->segment(1) == 'sekolah_sd' &&
                    request()->segment(2) == 'project' 
                    ]
                );
            },
            ['icon' => 'fa fas fa-archive']
        )->order(1);
    }

    if($user->checkGuruWalikelas()){
        $menu->url(
            action('SekolahSDController@data_mapel_index'),
            "Mata Pelajaran",
            [
                'icon' => 'fa fas fa-cubes', 
                'active' =>
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-mapel' 
            ]
        );
        $menu->url(
            action('SekolahSDController@data_rekap_absen_index'),
            "Rekap Absen Siswa",
            [
                'icon' => 'fa fas fa-tasks', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'data-rekap-absen' 
            ]
        );
        $menu->url(
            action('SekolahSDController@buku_induk_index'),
            "Buku Induk Siswa",
            [
                'icon' => 'fa fas fa-book', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'buku-induk' 
            ]
        );
        $menu->dropdown(
            "E-Raport",
            function ($sub) {
                $sub->url(
                    action('SekolahSDController@rapor_project_index'),
                    "Raport Project Siswa",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'project-rapor' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@raport_akhir_index'),
                    "Raport Akhir",
                    ['icon' => 'fa fas fa-user', 
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'raport-akhir' 
                    ]
                );
                $sub->url(
                    route('sekolah_sd.raport_table.index'),
                    "Tabel Siswa",
                    ['icon' => 'fa fas fa-user', 
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'raport-table' 
                    ]
                );
                $sub->url(
                    route('sekolah_sd.ranking_kelas.index'),
                    "Ranking Kelas",
                    [
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'ranking-kelas' 
                    ]
                );
                $sub->url(
                    route('sekolah_sd.walikelas.formatif'),
                    "Rekap Formatif Walikelas",
                    ['icon' => 'fa fas fa-user', 
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'formatif-walikelas' 
                    ]
                );
                $sub->url(
                    route('sekolah_sd.walikelas.sumatif'),
                    "Rekap Sumatif Walikelas",
                    ['icon' => 'fa fas fa-user', 
                    'active' =>
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'sumatif-walikelas' 
                    ]
                );
            },
            ['icon' => 'fa fas fa-address-book']
        )->order(1);

        $menu->dropdown(
            "Rekap Nilai Siswa",
            function ($sub) {
                $sub->url(
                        action('SekolahSDController@data_rekap_nilai_index'),
                    "Nilai Formatif",
                    [
                        'icon' => 'fa fas fa-user', 
                        'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'data-rekap-nilai' 
                        ]
                    );
                    $sub->url(
                        action('SekolahSDController@data_rekap_nilai_sumatif_index'),
                        "Nilai Sumatif",
                        [
                            'icon' => 'fa fas fa-briefcase', 
                            'active' => 
                            request()->segment(1) == 'sekolah_sd' &&
                            request()->segment(2) == 'data-rekap-nilai-sumatif' 
                        ]
                );
            },
            ['icon' => 'fa fas fa-server']
        )->order(1);
        $menu->dropdown(
            "Projek Siswa",
            function ($sub) {
                $sub->url(
                    action('SekolahSDController@dimensi_projek'),
                    "Dimensi",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'dimensi-projek' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@skenario_projek'),
                    "Skenario Projek",
                    ['icon' => 'fa fas fa-user', 'active' => 
                        request()->segment(1) == 'sekolah_sd' &&
                        request()->segment(2) == 'skenario-projek' 
                    ]
                );
                $sub->url(
                    action('SekolahSDController@project_index'),
                    "Penilaian Projek",
                    ['icon' => 'fa fas fa-user', 'active' => 
                    request()->segment(1) == 'sekolah_sd' &&
                    request()->segment(2) == 'project' 
                    ]
                );
            },
            ['icon' => 'fa fas fa-archive']
        )->order(1);
        $menu->url(
            action('SekolahSDController@kelas_index'),
            "Data Kelas",
            [
                'icon' => 'fa fas fa-cube', 
                'active' => 
                request()->segment(1) == 'sekolah_sd' &&
                request()->segment(2) == 'kelas-siswa' 
            ]
        );
    }

    $menu->url(
        action('SekolahSDController@jurnal_kelas'),
        "Jurnal Kelas",
        [
            'icon' => 'fa fas fa-address-book', 
            'active' => 
            request()->segment(1) == 'sekolah_sd' &&
            request()->segment(2) == 'jurnal-kelas' 
        ]
    );

    //Absensi dropdown
    $menu->dropdown(
        "Absensi",
        function ($sub) {
            $sub->url(
                route('absensi.list'),
                "Daftar Absensi",
                ['icon' => 'fa fas fa-star', 'active' => request()->is('absensi/list')]
            );
            $sub->url(
                route('absensi.create'),
                "Tambah",
                ['icon' => 'fa fas fa-star', 'active' => request()->is('absensi')]
            );
        },
        ['icon' => 'fa fas fa-user', 'id' => "tour_step9"]
    )->order(12);

});

?>