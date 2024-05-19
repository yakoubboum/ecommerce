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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'stripe' => [
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '426171816867065',
        'client_secret' =>'c0bf1a7e6af5bc340cd23adbaaae57e1',
        'redirect' => 'http://127.0.0.1:8000/auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '31877227991-2qbfjplel69nhki0breg3jk4nqkihjle.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],

];
