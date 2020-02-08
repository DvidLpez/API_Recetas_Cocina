<?php

namespace App\Models;
use Firebase\JWT\JWT;
use App\Providers\RecipeService;

class Recipe{

    private $db;
    private $secret;
    private $algorithm;

    public function __construct($c) {    
        $this->db = $c->db;
        $this->secret =  $c->get('settings')['jwt']['secret'];
        $this->algorithm = $c->get('settings')['jwt']['algorithm'];
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
    public function getlistRecipes() {        
        $list = RecipeService::listRecipes($this->db);
        return $list;    
    }

    function removeRecipe($id)
    {
        $list = RecipeService::removeRecipe($this->db, $id);
        return $list; 
    }
}