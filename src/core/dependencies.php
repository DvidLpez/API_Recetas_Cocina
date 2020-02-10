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
//User Controller
$container['AuthController'] = function($c) {
    // retrieve the 'view' from the container
   return new App\Controllers\AuthController($c);
};
//Category Controller
$container['CategoryController'] = function($c) {
    // retrieve the 'view' from the container
   return new App\Controllers\CategoryController($c);
};
//Recipe Controller
$container['RecipeController'] = function($c) {
    // retrieve the 'view' from the container
   return new App\Controllers\RecipeController($c);
};
