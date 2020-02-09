<?php

namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Recipe;

class RecipeController
{
   private $settings;

   public function __construct($c) {
       $this->settings = $c;
       $this->logger = $c['logger'];
       $this->logger->info('Recipe controller: '. $user_loged['email'] );
   }

   public function getRecipe( Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];

            $recipeModel = new Recipe($this->settings);
            $recipe = $recipeModel->getRecipe($id);  
            return $response->withJson(['status' => true, 'recipes' =>  $recipe], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }

    public function listRecipes( Request $request, Response $response, array $arg) {
        try {

            $recipeModel = new Recipe($this->settings);
            $recipes = $recipeModel->getlistRecipes();  
            return $response->withJson(['status' => true, 'recipes' =>  $recipes], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }

    public function removeRecipe( Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];

            $recipeModel = new Recipe($this->settings);
            $recipe = $recipeModel->removeRecipe($id);  
            return $response->withJson(['status' => true, 'recipes' =>  $recipe], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }

    // // handle single input with multiple file uploads
        // foreach ($uploadedFiles['example3'] as $uploadedFile) {
        //     if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        //         $filename = moveUploadedFile($directory, $uploadedFile);
        //         $response->write('uploaded ' . $filename . '<br/>');
        //     }
        // }
}