<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // DataBase
        'db' => [
            'host' => 'PMYSQL105.dns-servicio.com:3306',
            'dbname' => '6511652_api_dlb',
            'user' => 'Nocete170304',
            'pass' => 'Azabache.2018.Rosco'
        ]
    ],
];
