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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Hub Personal Integration
    |--------------------------------------------------------------------------
    |
    | Configuration for Hub Personal event tracking system.
    | This allows Portfolio to report events to the centralized Hub.
    |
    */

    'hub' => [
        'url' => env('HUB_API_URL'),
        'token' => env('HUB_API_TOKEN'),
        'enabled' => env('HUB_EVENTS_ENABLED', false),
        'source' => env('HUB_SOURCE', 'portfolio'),
        'env' => env('HUB_ENV', 'production'),

        // Analytics settings
        'track_pageviews' => env('HUB_TRACK_PAGEVIEWS', true),
        'track_interactions' => env('HUB_TRACK_INTERACTIONS', true),
        'report_errors' => env('HUB_REPORT_ERRORS', true),
    ],

];
