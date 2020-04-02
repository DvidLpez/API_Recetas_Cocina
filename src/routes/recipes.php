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
      // List recipes by user with pagination - OK
      $app->get('/recipes/user/{id}', 'RecipeController:listRecipesByUser');
      // Search recipes with pagination - OK
      $app->get('/recipes/search', 'RecipeController:searchRecipes');
      // Upload images recipes
      $app->post('/recipe/images', 'RecipeController:UploadImagesRecipe');

      
      // List Favourites recipes user - OK
      $app->get('/recipes/favourites/{id}', 'RecipeController:getfavouritesRecipesUser');
      // New Favourites recipes user - OK
      $app->post('/recipes/favourites/{id}', 'RecipeController:setfavouritesRecipesUser');
      // Remove Favourites recipes user - OK
      $app->delete('/recipes/favourites/{id}', 'RecipeController:removefavouritesRecipesUser');
   });
