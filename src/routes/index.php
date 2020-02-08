<?php

use Slim\Http\Request;
use Slim\Http\Response;

include 'users.php';
include 'categories.php';
include 'recipes.php';


$app->group('/api', function() use ($app) {
    
    $app->get('/[{name}]', function (Request $request, Response $response, array $args) { 
        return $this->renderer->render($response, 'index.phtml', $args);
    });
    
    $app->group('/v1', function() use ($app) {
 
        // COMENTARIOS
        $app->post('/comment', 'CommentController:registerComment');
        $app->get('/comment/{id}', 'CommentController:getComment');
        $app->put('/comment/{id}', 'CommentController:updateComment');
        $app->delete('/comment/{id}', 'CommentController:deleteComment');  
        $app->get('/comment/recipe/{id}', 'CommentController:listCommentsByRecipe');

        // SEGUIDORES COCINEROS
        // Hacer seguidores de cocineros y recetas


        /**
         * CARS ROUTES DE TEST PARA IMPLEMENTAR LOS NUEVOS
         */
        $app->get('/cars', 'CarsController:listCars');
        $app->get('/cars/[{id}]', 'CarsController:infoCar');
        $app->post('/cars', 'CarsController:createCar');
        $app->delete('/cars/[{id}]', 'CarsController:removeCar');
        $app->put('/cars/[{id}]', 'CarsController:updatedCar');
        $app->get('/cars/search/{query}', 'CarsController:searchCar');

    });
    
});
