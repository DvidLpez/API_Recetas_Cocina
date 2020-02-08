<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api/v1', function() use ($app) {
    // Create category
    $app->post('/category', 'CategoryController:registerCategory');
    // Select category
    $app->get('/category/{id}', 'CategoryController:getCategories');
    // Update category
    $app->put('/category/{id}', 'CategoryController:updateCategory');
    // Remove category
    $app->delete('/category/{id}', 'CategoryController:deleteCategory');
    // List categories
    $app->get('/categories', 'CategoryController:listCategories');
    
});
