<?php

return [
    'default_scope' => env('SENTRY_FILTER_DEFAULT_SCOPE', 'laravel'),

    'scopes' => [
        'laravel' => [
            // Link to an external URL that hosts a filter list
            'filter_list' => env('SENTRY_FILTER_LIST_LARAVEL', null),

            // List of errors to ignore
            'ignore_errors' => [
                // ['message' => 'Unnecessary error'],
                // ['exception' => \App\UnnecessaryError::class],
            ],
        ],

        // More scopes can be added here
    ],

    'cache' => [
        'fresh' => env('SENTRY_FILTER_CACHE_FRESH', 3600),
        'stale' => env('SENTRY_FILTER_CACHE_STALE', 86400),
    ],
];
