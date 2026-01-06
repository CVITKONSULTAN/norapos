<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Robot SIMBG Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration untuk integrasi dengan Robot SIMBG API
    |
    */

    'base_url' => env('SIMBG_ROBOT_URL', 'https://simbg.simtek-menanjak.com'),

    'api_key' => env('SIMBG_ROBOT_API_KEY', null),

    'timeout' => env('SIMBG_ROBOT_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Sync Configuration
    |--------------------------------------------------------------------------
    */

    'sync' => [
        'per_page' => 100, // Berapa data per request
        'max_retry' => 3,  // Max retry jika gagal
        'retry_delay' => 2, // Delay antar retry (detik)
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notification Recipients
    |--------------------------------------------------------------------------
    |
    | Role yang akan menerima email notifikasi saat ada pengajuan baru
    |
    */

    'notification_roles' => ['Kepala Bidang', 'Admin'],

];
