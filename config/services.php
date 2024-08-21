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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'search' => [
        'enabled' => env('SEARCH_ENABLED', false),
        'hosts'   => explode(',', env('ELASTICSEARCH_HOSTS')),
    ],

    'currency_api' => [

        'free' => [

            'base_url' => env('CURRENCY_BANK_API_URL', 'https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_n4r4oLOruKB426bC3UXpinIOEF7jQWpQ7nM358ad'),

            'key' => 'fca_live_n4r4oLOruKB426bC3UXpinIOEF7jQWpQ7nM358ad',
        ],

        'freaks' => [

            'base_url' => 'https://api.currencyfreaks.com/v2.0/rates/latest?apikey=YOUR_APIKEY',

            'key' => 'f115da5e5ef341d1bb662b9c7d7005fa',
        ]

    ],

];
