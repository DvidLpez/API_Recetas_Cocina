<?php

namespace App\Models;
use Firebase\JWT\JWT;

class RecipeModel{

    private $db;

    public function __construct($database) {    
        $this->db = $database;
    }
    
    public function createRecipe( $input ) {
        $sql = "INSERT INTO recipes (
            name, description, category, ingredients, price, preparate, comensals, time, alergens, user, state, validate 
        ) VALUES (
            :name, :description, :category, :ingredients, :price, :preparate, :comensals, :time, :alergens, :user, :state, :validate)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("category", $input['category']);
        $sth->bindParam("ingredients", serialize($input['ingredients']));
        $sth->bindParam("price", $input['price']); 
        $sth->bindParam("preparate", $input['preparate']);
        $sth->bindParam("comensals", $input['comensals']);
        $sth->bindParam("time", $input['time']); 
        $sth->bindParam("alergens", serialize($input['alergens']));
        $sth->bindParam("user", $input['user']);
        $sth->bindParam("state", $input['state']); 
        $sth->bindParam("validate", $input['validate']);
        $sth->execute(); 
        $input['id'] = $this->db->lastInsertId();      
        return $input;    
    }

    public function recipeExists($recipe_name) { 
        $sql = "SELECT * FROM recipes WHERE name= :name_recipe";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name_recipe", $recipe_name);
        $sth->execute();
        $recipe = $sth->fetchObject();
        return $recipe; 
             
    }
    /**
     * Add new user if not exist - add account
     */
    public function getRecipe( $id ){
        $sql = "SELECT * FROM recipes WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        $recipe = $sth->fetchObject();
        if($recipe) {
            $recipe->ingredients = unserialize($recipe->ingredients); 
            $recipe->alergens = unserialize($recipe->alergens); 
        } 
        return $recipe;
    }
    /**
     * Evalue username and password and return token with expiration - login 
     */
    public function getlistRecipes($page, $totalPostPage) {  
        $sql = "SELECT recipes.*, categories.name as cat_name FROM recipes INNER JOIN categories ON recipes.category=categories.id LIMIT $totalPostPage OFFSET $page";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;       
    }
    /**
     * Evalue username and password and return token with expiration - login 
     */
    public function getlistRecipesByCategory($category, $page, $totalPostPage) {  
        $sql = "SELECT recipes.*, categories.name as cat_name FROM recipes INNER JOIN categories ON recipes.category=categories.id WHERE category=:category LIMIT $totalPostPage OFFSET $page";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("category", $category);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;  
    }
    /**
     * Return list recipes from user 
     */
    public function getlistRecipesByUser($user_id, $page, $totalPostPage) {  
        $sql = "SELECT recipes.*, categories.name as cat_name FROM recipes INNER JOIN categories ON recipes.category=categories.id WHERE user=:user LIMIT $totalPostPage OFFSET $page";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("user", $user_id);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;  
    }
    /**
     * Return list recipes from user 
     */
    public function getfavouritesRecipesUser($user) {
        $sql = "SELECT recipe FROM favourites WHERE user=:user";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("user", $user);
        $sth->execute();
        $todos = $sth->fetchAll();
        $recipes = array();
        foreach ($todos as $key => $value) {
            array_push( $recipes, $this->getRecipe($value['recipe']) );
        }
        return $recipes;  
    }
    /**
     * Return list recipes from user 
     */
    public function setfavouritesRecipesUser($user, $recipe) {
        $sql = "INSERT INTO favourites (user, recipe) VALUES (:user, :recipe)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("user", $user);
        $sth->bindParam("recipe", $recipe);
        $sth->execute();    
    }
    /**
     * Return list recipes from user 
     */
    public function removefavouritesRecipesUser($user, $recipe) {
        $sql = "DELETE FROM favourites WHERE user=:user AND recipe=:recipe";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("user", $user);
        $sth->bindParam("recipe", $recipe);
        $sth->execute(); 
        return $recipe; 
 
    }

    public function updateRecipe( $id, $input ) {
        $sql = "UPDATE recipes SET 
        name=:name, description=:description, category=:category, ingredients=:ingredients, price=:price, preparate=:preparate, comensals=:comensals, time=:time, alergens=:alergens, user=:user, state=:state, validate=:validate
        WHERE 
        id=:id";

        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("category", $input['category']);
        $sth->bindParam("ingredients", serialize($input['ingredients']));
        $sth->bindParam("price", $input['price']); 
        $sth->bindParam("preparate", $input['preparate']);
        $sth->bindParam("comensals", $input['comensals']);
        $sth->bindParam("time", $input['time']); 
        $sth->bindParam("alergens", serialize($input['alergens']));
        $sth->bindParam("user", $input['user']);
        $sth->bindParam("state", $input['state']); 
        $sth->bindParam("validate", $input['validate']);
        $sth->bindParam("id", $id);
        $sth->execute();
    }

    public function removeRecipe($id) {
        $sql = "DELETE FROM recipes WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        $sql = "SELECT * FROM recipes";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos; 
    }

    public function searchRecipes($query, $page, $totalPostPage) {
        $searchTerms = explode(' ', $query);
        $search = array();
        foreach ($searchTerms as $value) {      
            if( strlen($value) > 2 )  array_push($search, $value);
        }
        $searchTermBits = array();
        foreach ($search as $term) {
            $term = trim($term);
            if (!empty($term)) {
                $searchTermBits[] = "recipes.name LIKE '%$term%'";
            }
        } 
        $sql = "SELECT recipes.*, categories.name as cat_name FROM recipes INNER JOIN categories ON recipes.category=categories.id WHERE ".implode(' OR ', $searchTermBits)." LIMIT $totalPostPage OFFSET $page";
        $sth = $this->db->prepare($sql);
        $query = '%'.$query.'%';
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }

    /**
     * Set image recipe
     */
    public function setImageRecipe($imageurl, $id_recipe) {
        $sql = "UPDATE recipes SET image_recipe=:image_recipe WHERE id=:id_recipe";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("image_recipe", $imageurl);
        $sth->bindParam("id_recipe", $id_recipe);
        $inserted = $sth->execute();
    }
}
