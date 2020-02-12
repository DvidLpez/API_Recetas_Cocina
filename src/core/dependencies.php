<?php

// DIC configuration
$container = $app->getContainer();
// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};
// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};
// DataBase PDO conection
$container['db'] = function ($c) {
    $db = $c->get('settings')['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'].';charset=utf8;', $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
// DataBase PDO conection
$container['jwt'] = function ($c) {
    return $c->get('settings')['jwt'];
};

// $container['eloquent'] = function ($container) {
//     $capsule = new \Illuminate\Database\Capsule\Manager;
//     $capsule->addConnection($container['settings']['eloquent']);
//     // $capsule->addConnection($container['settings']['eloquent']);
//     $capsule->setAsGlobal();
//     $capsule->bootEloquent();
//     return $capsule;
// };


//User Controller
$container['AuthController'] = function($container) {
    // retrieve the 'logger' from the container
    $logger = $container['logger'];
    // retrieve the 'database' from the container
    $database = $container['db'];
    // retrieve the 'JWT' from the container
    $jwt = $container['jwt'];
   return new App\Controllers\AuthController($logger, $database, $jwt);
};
//Category Controller
$container['CategoryController'] = function($container) {
    // retrieve the 'logger' from the container
    $logger = $container['logger'];
    // retrieve the 'database' from the container
    $database = $container['db'];
    // $db = $c->get('eloquent');
   return new App\Controllers\CategoryController($logger, $database);
};
//Recipe Controller
$container['RecipeController'] = function($container) {
    // retrieve the 'logger' from the container
    $logger = $container['logger'];
    // retrieve the 'database' from the container
    $database = $container['db'];
   return new App\Controllers\RecipeController($logger, $database);
};
//Comment Controller
$container['CommentController'] = function($container) {
    // retrieve the 'logger' from the container
    $logger = $container['logger'];
    // retrieve the 'database' from the container
    $database = $container['db'];
   return new App\Controllers\CommentController($logger, $database);
};
