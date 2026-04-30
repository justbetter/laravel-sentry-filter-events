<?php

return [
    'default_scope' => 'laravel',

    'scopes' => [
        'laravel' => [
            // Link to an external URL that hosts a filter list
            'filter_list' => null,

            // List of errors to ignore
            'ignore_errors' => [
                // ['message' => 'Unnecessary error'],
                // ['exception' => \App\UnnecessaryError::class],
            ],
        ],

        // More scopes can be added here
    ],
];
