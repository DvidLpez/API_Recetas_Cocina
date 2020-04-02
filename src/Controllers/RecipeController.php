<?php

namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\UserModel as User;
use App\Models\RecipeModel as Recipe;
use App\Providers\UploadFilesService as UploadFile;

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
    * Get paginate list of recipes by user
    */
   public function listRecipesByUser( Request $request, Response $response, array $args) {
      try {
         $page = $request->getQueryParam('page');
         $user_id = $args['id'];
         $totalPostPage = 10;
         $totalItems = $page * $totalPostPage;
         $recipeModel = new Recipe($this->database);
         $recipes = $recipeModel->getlistRecipesByUser($user_id, $totalItems, $totalPostPage);  
         return $response->withJson(['status' => true, 'recipes' =>  $recipes], 200);

      } catch (\Exception $e) {
         return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
      }
   }
   /**
    * Get paginate list of favourites user recipes
    */
   public function getfavouritesRecipesUser( Request $request, Response $response, array $args) {
      try {
         $user_id = $args['id'];
         $recipeModel = new Recipe($this->database);
         $recipes = $recipeModel->getfavouritesRecipesUser($user_id);
         return $response->withJson(['status' => true, 'recipes' => $recipes], 200);

      } catch (\Exception $e) {
         return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
      }
   }
   /**
    * Get paginate list of favourites user recipes
    */
   public function setfavouritesRecipesUser( Request $request, Response $response, array $args) {
      try {
         $user_id = $args['id'];
         $params = $request->getParsedBody();
         $recipeModel = new Recipe($this->database);
         $recipeModel->setfavouritesRecipesUser($user_id, $params['recipe']);
         return $response->withJson(['status' => true, 'favourite' => $params['recipe']], 200);

      } catch (\Exception $e) {
         return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
      }
   }
   /**
    * Get paginate list of favourites user recipes
    */
   public function removefavouritesRecipesUser( Request $request, Response $response, array $args) {
      try {
         $user_id = $args['id'];
         $params = $request->getParsedBody();
         $recipeModel = new Recipe($this->database);
         $recipe = $recipeModel->removefavouritesRecipesUser($user_id, $params['recipe']);
         return $response->withJson(['status' => true, 'deleted' => $recipe], 200);

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
         
         $query = trim($request->getQueryParam('query'));
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

   /**
    * Upload profile image
    */
   public function UploadImagesRecipe( Request $request, Response $response, Array $args ) {
      try {
         $uploadedFiles = $request->getUploadedFiles();
         $params = $request->getParsedBody();
         $id_recipe = $params['id_recipe'];
         if(!UploadFile::checkImages($uploadedFiles) ) {
             throw new \Exception('Image invalid', 400);
         }
         $user_loged = $request->getAttribute("decoded_token_data");
         $user = new User($this->database);
         $user_profile = $user->getUserProfile($user_loged['email']);
         $directory = UploadFile::createPathRecipeImagesUser($user_profile->id, $id_recipe);
         $all_images = array();
         foreach ($uploadedFiles as $uploadedFile) {
               if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                  $path_image = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/images/". $user_profile->id."/recipes/".$id_recipe."/".$filename;   
                  $filename = UploadFile::moveUploadedFile($directory, $uploadedFile);
                  $objectFile = array(
                     'id_recipe' => $id_recipe,
                     'id_user' => $user_profile->id,
                     'file_name' => $filename,
                     'file_path' => $path_image.$filename
                  );   
                  array_push($all_images, $objectFile);
               }
         }
         $imageurl = $path_image.$filename;
         $recipeModel = new Recipe($this->database);
         $recipeModel->setImageRecipe($imageurl, $id_recipe);

         return $response->withJson(['status' => true, 'files_uploaded' => ['files' =>  $all_images]], 200);
      } catch (\Exception $e) {
         return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
      }  
   }
}
