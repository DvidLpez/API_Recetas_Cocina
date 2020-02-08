<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api/v1', function() use ($app) {
    // Create recipe
    $app->post('/recipe', 'RecipeController:registerRecipe');
    // Select recipe
    $app->get('/recipe/{id}', 'RecipeController:getRecipe');
    // Update recipe
    $app->put('/recipe/{id}', 'RecipeController:updateRecipe');
    // Remove recipe
    $app->delete('/recipe/{id}', 'RecipeController:deleteRecipe');
    // List all recipes
    $app->get('/recipes', 'RecipeController:listRecipes');
    // List recipes by category
    $app->get('/recipes/category/{id}', 'RecipeController:getRecipesByCategory');
    // Search recipes
    $app->get('/recipes/search/{query}', 'RecipeController:searchRecipes');
});
