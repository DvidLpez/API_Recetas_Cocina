<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api', function() use ($app) {
    /**
     * USER ACCOUNT ROUTES
     */
    $app->post('/register', 'AuthController:registerUser');
    $app->post('/login', 'AuthController:loginUser');

    $app->group('/v1', function() use ($app) {
        /**
         * USER PROFILES ROUTES
         */
        $app->get('/profile', 'AuthController:getUser');
        $app->put('/profile', 'AuthController:updateProfile');
        $app->delete('/profile', 'AuthController:deleteProfile');
    });
});
