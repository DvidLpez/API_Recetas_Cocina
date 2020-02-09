<?php

namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Category;

class CategoryController
{
    private $settings;

    public function __construct($c) {
        $this->settings = $c;
        $this->logger = $c['logger'];
        $this->logger->info('Category controller: '. $user_loged['email'] );
    }
    /**
     *  Register a new cateogry
     */
    public function registerCategory(Request $request, Response $response){
        try {
            $params = $request->getParsedBody();
            $category = new Category($this->settings);  
            if ($category->categoryExists($params['name'])) {
                throw new \Exception('La categoria ya existe', 400);
            }
            $category->createCategory($params);   
            return $response->withJson(['status' => true, 'category' => $params], 201);
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     *  select a new cateogry
     */
    public function getCategory( Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];
            $categoryModel = new Category($this->settings);
            $category = $categoryModel->getCategory($id);  
            return $response->withJson(['status' => true, 'category' =>  $category], 200);
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     *  Update cateogry
     */
    public function updateCategory(Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];
            $params = $request->getParsedBody();  
            $category = new Category($this->settings);
            $category->updateCategory($id, $params);
            return $response->withJson(['status' => true, 'category_updated' => $params], 200);
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     *  List cateogries
     */
    public function listCategories ( Request $request, Response $response, array $arg) {
        try {
            $categoryModel = new Category($this->settings);
            $categories = $categoryModel->getCategories();  
            return $response->withJson(['status' => true, 'categories' =>  $categories], 200);
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     *  Remove cateogry
     */
    public function deleteCategory( Request $request, Response $response, array $args) {
        try {
            $id = $args['id'];
            $categoryModel = new Category($this->settings);
            $categories = $categoryModel->removeCategory($id);  
            return $response->withJson(['status' => true, 'categories' =>  $categories], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
}
