<?php
// $app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//     // Sample log message
//     $this->logger->info("Slim-Skeleton '/' route");

//     // Render index view
//     return $this->renderer->render($response, 'index.phtml', $args);
// });

$app->group('/api', function() use ($app) 
{
    /**
     * USER ROUTES
     */
    $app->post('/login', 'AuthController:getToken');
    $app->post('/users', 'AuthController:newUser');   
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
