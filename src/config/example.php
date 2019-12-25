<?php
return [
    'settings' => [
        // set to false in production
        'displayErrorDetails' => true,
        // Allow the web server to send the content-length header
        'addContentLengthHeader' => false,
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../../templates/',
        ],
        // Monolog settings
        'logger' => [
            'name' => 'name',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        // DataBase
        'db' => [
            'host' => 'host_name',
            'dbname' => 'db_name',
            'user' => 'user_name',
            'pass' => 'pass_user'
        ],
        // jwt settings
        'jwt' => [
            'secret' => 'jwt_secret',
            'algorithm' => 'HS256'
        ]
    ]
];