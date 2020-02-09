<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api', function() use ($app) {
    // Register new user - OK
    $app->post('/register', 'AuthController:registerUser');
    // Login user - OK
    $app->post('/login', 'AuthController:loginUser');
    // Authentication request
    $app->group('/v1', function() use ($app) {
        // Get profile user - OK
        $app->get('/profile', 'AuthController:getUser');
        // Update profile user - OK
        $app->put('/profile', 'AuthController:updateProfile');
        // Delete profile user - OK
        $app->delete('/profile', 'AuthController:deleteProfile');

        // Post profile image - 
        $app->post('/profile/image', 'AuthController:UploadImageProfile');
    });
});
