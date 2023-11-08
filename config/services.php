<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
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

    'app_url' => env('APP_URL', 'http://192.168.2.152:9000'),
    'company_base_url' => env('COMPANY_API', 'http://tnf-cloud.com:8002/api/v1.0'),
    'region_base_url' => env('REGION_API', 'http://tnf-cloud.com:8004/api/v1.0'),
    'construction_base_url' => env('CONSTRUCTION_API', 'http://tnf-cloud.com:8003/api/v1.0')
];
