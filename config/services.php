<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'sendgrid' => [
        'api_key' => env('SENDGRID_API_KEY'),
        'transport' => 'sendgrid',
    ],
    'google' => [
        'client_id' => '478007783958-e06geeaog19lnrfr5su4r8rijdd4h4do.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'https://itkoskw.itkonsultan.co.id/auth/google/callback',
    ],

];
