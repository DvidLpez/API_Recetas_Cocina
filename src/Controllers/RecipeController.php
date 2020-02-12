<?php

namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\RecipeModel as Recipe;

class RecipeController
{
private $database;

public function __construct($logger, $database) {
    $this->database = $database;
    $this->logger = $logger;
    $this->logger->info('Recipe controller: '. $user_loged['email'] );
}

    /**
     *  Register a new recipe
     */
    public function registerRecipe(Request $request, Response $response){
        try {
            $params = $request->getParsedBody();
            $recipe = new Recipe($this->database);  
            if ($recipe->recipeExists($params['name'])) {
                throw new \Exception('La receta ya existe', 400);
            }
            $recipe->createRecipe($params);   
            return $response->withJson(['status' => true, 'recipe' => $params], 201);
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }

    public function getRecipe( Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];
            $recipeModel = new Recipe($this->database);
            $recipe = $recipeModel->getRecipe($id);  
            return $response->withJson(['status' => true, 'recipes' =>  $recipe], 200);
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     *  Update recipe
     */
    public function updateRecipe(Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];
            $params = $request->getParsedBody();  
            $recipe = new Recipe($this->database);
            $recipe->updateRecipe($id, $params);
            return $response->withJson(['status' => true, 'recipe_updated' => $params], 200);
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Get paginate list of recipes
     */
    public function listRecipes( Request $request, Response $response, array $args) {
        try {
            $page = $request->getQueryParam('page');
            $totalPostPage = 10;
            $totalItems = $page * $totalPostPage;
            $recipeModel = new Recipe($this->database);
            $recipes = $recipeModel->getlistRecipes($totalItems, $totalPostPage);  
            return $response->withJson(['status' => true, 'recipes' =>  $recipes], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Get paginate list of recipes by category
     */
    public function listRecipesByCategory( Request $request, Response $response, array $args) {
        try {
            $page = $request->getQueryParam('page');
            $category = $args['id'];
            $totalPostPage = 10;
            $totalItems = $page * $totalPostPage;
            $recipeModel = new Recipe($this->database);
            $recipes = $recipeModel->getlistRecipesByCategory($category, $totalItems, $totalPostPage);  
            return $response->withJson(['status' => true, 'recipes' =>  $recipes], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Remove Recipe
     */
    public function removeRecipe( Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];

            $recipeModel = new Recipe($this->database);
            $recipe = $recipeModel->removeRecipe($id);  
            return $response->withJson(['status' => true, 'recipes' =>  $recipe], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }

    public function searchRecipes(Request $request, Response $response, array $args) {
        try {
            
            $query = $request->getParsedBody()['query'];
            $page = $request->getQueryParam('page');
            $totalPostPage = 20;
            $totalItems = $page * $totalPostPage;
            $recipeModel = new Recipe($this->database);
            $recipes = $recipeModel->searchRecipes($query, $totalItems, $totalPostPage);  
            return $response->withJson(['status' => true, 'recipes' =>  $recipes], 200);
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
