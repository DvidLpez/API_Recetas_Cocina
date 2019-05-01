<?php
return [
    'settings' => [
        // set to false in production
        'displayErrorDetails' => true,
        // Allow the web server to send the content-length header
        'addContentLengthHeader' => false,
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],
        // Monolog settings
        'logger' => [
            'name' => 'API-DLB',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        // DataBase
        'db' => [
            'host' => 'PMYSQL105.dns-servicio.com:3306',
            'dbname' => '6511652_api_dlb',
            'user' => 'Nocete170304',
            'pass' => 'Azabache.2018.Rosco'
        ],
        // jwt settings
        'jwt' => [
            'secret' => 'david1985cris1985azabache2004rosco2018',
            'algorithm' => 'HS256'
        ]
    ],
];
