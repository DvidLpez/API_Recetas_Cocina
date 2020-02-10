<?php

   use Slim\Http\Request;
   use Slim\Http\Response;
      
   $app->group('/api/v1', function() use ($app) {
      // Add comment - 
      $app->post('/comment', 'CommentController:registerComment');
      // Get comment - 
      $app->get('/comment/{id}', 'CommentController:getComment');
      // Update comment - 
      $app->put('/comment/{id}', 'CommentController:updateComment');
      // Remove comment - 
      $app->delete('/comment/{id}', 'CommentController:deleteComment');  
      // Get comments recipe - 
      $app->get('/comment/recipe/{id}', 'CommentController:listCommentsByRecipe');
   });
