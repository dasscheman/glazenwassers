<?php
/**
 * Application configuration shared by all test types
 */
return [
    'components' => [
        'db' => [
            'dsn' => 'mysql:host=localhost;dbname=glazenwassers_tests',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];
