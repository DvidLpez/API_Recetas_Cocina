<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//     // Render index view
return $this->renderer->render($response, 'index.phtml', $args);
});

$app->group('/api', function() use ($app) {
    /**
     * USER ACCOUNTS ROUTES
     */
    $app->post('/register', 'AuthController:registerUser');
    $app->post('/login', 'AuthController:loginUser');
    /**
     * PROFILE ROUTE
     */
    $app->get('/v1/profile', 'AuthController:getUser');
    $app->put('/v1/profile', 'AuthController:updateProfile');
    $app->delete('/v1/profile', 'AuthController:deleteProfile');

    /**
     * CARS ROUTES
     */
    $app->get('/v1/cars', 'CarsController:listCars');
    $app->get('/v1/cars/[{id}]', 'CarsController:infoCar');
    $app->post('/v1/cars', 'CarsController:createCar');
    $app->delete('/v1/cars/[{id}]', 'CarsController:removeCar');
    $app->put('/v1/cars/[{id}]', 'CarsController:updatedCar');
    $app->get('/v1/cars/search/{query}', 'CarsController:searchCar');
});
