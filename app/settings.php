<?php
return [
    'settings' => [
        'mode' => 'dev',
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'timezone' => 'America/Argentina/Buenos_Aires',

        // Twig settings
        'twig' => [
            'path' => __DIR__ . '/templates',
            'options' => [
                'cache' => __DIR__ . '/../var/cache',
                'debug' => true,
            ]
        ],
        
        // SwiftMailer settings
        'swiftmailer' => [
            'transport' => 'mail',
            'options' => [
                'host' => 'localhost',
                'port' => 25,
                'username' => '',
                'password' => '',
            ]
        ],

        // Monolog settings
        'monolog' => [
            'name' => 'monolog',
            'path' => __DIR__ . '/../var/logs/app.log',
        ],
        
        // ORM settings
        'eloquent' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'slim_starter',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
        ],
    ],
];
