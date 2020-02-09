<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api/v1', function() use ($app) {
    // Create category - OK
    $app->post('/category', 'CategoryController:registerCategory');
    // Select category - OK
    $app->get('/category/{id}', 'CategoryController:getCategory');
    // Update category - OK
    $app->put('/category/{id}', 'CategoryController:updateCategory');
    // Remove category - OK
    $app->delete('/category/{id}', 'CategoryController:deleteCategory');
    // List categories - OK
    $app->get('/categories', 'CategoryController:listCategories');
});
