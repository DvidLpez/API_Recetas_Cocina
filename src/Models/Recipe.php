<?php

namespace App\Models;
use Firebase\JWT\JWT;
use App\Providers\RecipeService;

class Recipe{

    private $db;

    public function __construct($c) {    
        $this->db = $c->db;
    }
    public function createRecipe( $input )
    {
        RecipeService::createRecipe($this->db, $input);
        $input['id'] = $this->db->lastInsertId();      
        return $input;    
    }

    public function recipeExists($recipe_name) 
    {
        return RecipeService::recipeExists($this->db, $recipe_name);       
    }
    /**
     * Add new user if not exist - add account
     */
    public function getRecipe( $id ){
        return RecipeService::getRecipe($this->db, $id);   
    }
    /**
     * Evalue username and password and return token with expiration - login 
     */
    public function getlistRecipes($page, $totalPostPage) {  
        $list = RecipeService::listRecipes($this->db, $page, $totalPostPage);
        return $list;    
    }
    /**
     * Evalue username and password and return token with expiration - login 
     */
    public function getlistRecipesByCategory($category, $page, $totalPostPage) {  
        $list = RecipeService::getlistRecipesByCategory($this->db, $category, $page, $totalPostPage);
        return $list;    
    }
    public function updateRecipe( $id, $params )
    {
        return RecipeService::updateRecipe($this->db, $id, $params);     
    }
    function removeRecipe($id)
    {
        $list = RecipeService::removeRecipe($this->db, $id);
        return $list; 
    }
}