<?php

   use Slim\Http\Request;
   use Slim\Http\Response;

   $app->group('/api/v1', function() use ($app) {
      // Create recipe - OK
      $app->post('/recipe', 'RecipeController:registerRecipe');
      // Select recipe - OK
      $app->get('/recipe/{id}', 'RecipeController:getRecipe');
      // Update recipe - OK
      $app->put('/recipe/{id}', 'RecipeController:updateRecipe');
      // Remove recipe - OK
      $app->delete('/recipe/{id}', 'RecipeController:removeRecipe');
      // List all recipes with pagination - OK 
      $app->get('/recipes', 'RecipeController:listRecipes');
      // List recipes by category with pagination - OK
      $app->get('/recipes/category/{id}', 'RecipeController:listRecipesByCategory');
      // Search recipes with pagination - OK
      $app->get('/recipes/search', 'RecipeController:searchRecipes');
   });
