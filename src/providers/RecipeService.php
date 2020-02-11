<?php

namespace App\Providers;

class RecipeService {
    /**
     *  Create a new recipe in Table recipes
     */
    public function createRecipe($con, $input)
    {
        $sql = "INSERT INTO recipes (
            name, description, category, ingredients, price, preparate, comensals, time, alergens, user, state, validate 
        ) VALUES (
            :name, :description, :category, :ingredients, :price, :preparate, :comensals, :time, :alergens, :user, :state, :validate)";
        $sth = $con->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("category", $input['category']);
        $sth->bindParam("ingredients", $input['ingredients']);
        $sth->bindParam("price", $input['price']); 
        $sth->bindParam("preparate", $input['preparate']);
        $sth->bindParam("comensals", $input['comensals']);
        $sth->bindParam("time", $input['time']); 
        $sth->bindParam("alergens", $input['alergens']);
        $sth->bindParam("user", $input['user']);
        $sth->bindParam("state", $input['state']); 
        $sth->bindParam("validate", $input['validate']);
        $sth->execute(); 
    }
    /**
     *  Check if exist recipe in Table recipes
     */
    public function recipeExists ($con, $name) 
    {  
        $sql = "SELECT * FROM recipes WHERE name= :name_recipe";
        $sth = $con->prepare($sql);
        $sth->bindParam("name_recipe", $name);
        $sth->execute();
        $user = $sth->fetchObject();
        return $user;     
    }
    public function listRecipes($con, $page, $totalPostPage)
    {    
         $sql = "SELECT recipes.*, categories.name as cat_name FROM recipes INNER JOIN categories ON recipes.category=categories.id LIMIT $totalPostPage OFFSET $page";
         $sth = $con->prepare($sql);
         $sth->execute();
         $todos = $sth->fetchAll();
         return $todos;
    }
    public function getlistRecipesByCategory($con, $category, $page, $totalPostPage)
    {    
         $sql = "SELECT recipes.*, categories.name as cat_name FROM recipes INNER JOIN categories ON recipes.category=categories.id WHERE category=:category LIMIT $totalPostPage OFFSET $page";
         $sth = $con->prepare($sql);
         $sth->bindParam("category", $category);
         $sth->execute();
         $todos = $sth->fetchAll();
         return $todos;
    }
    public function getRecipe ($con, $id) {
        $sql = "SELECT * FROM recipes WHERE id=:id";
        $sth = $con->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        return $sth->fetchObject(); 
    }

    /**
     *  Update recipe in Table recipes
     */
    public function updateRecipe($con, $id, $input) 
    {
        $sql = "UPDATE recipes SET 
        name=:name, description=:description, category=:category, 
        ingredients=:ingredients, price=:price, preparate=:preparate, 
        comensals=:comensals, time=:time, alergens=:alergens, 
        user=:user, state=:state, validate=:validate
        WHERE 
        id=:id";

        $sth = $con->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("category", $input['category']);
        $sth->bindParam("ingredients", $input['ingredients']);
        $sth->bindParam("price", $input['price']); 
        $sth->bindParam("preparate", $input['preparate']);
        $sth->bindParam("comensals", $input['comensals']);
        $sth->bindParam("time", $input['time']); 
        $sth->bindParam("alergens", $input['alergens']);
        $sth->bindParam("user", $input['user']);
        $sth->bindParam("state", $input['state']); 
        $sth->bindParam("validate", $input['validate']);
        $sth->bindParam("id", $id);
        $sth->execute();
    }

    public function removeRecipe($con, $id)
    {
        $sql = "DELETE FROM recipes WHERE id=:id";
        $sth = $con->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        $sql = "SELECT * FROM recipes";
        $sth = $con->prepare($sql);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    } 
    
    public function searchRecipes($con, $query, $page, $totalPostPage) 
    {
        $searchTerms = explode(' ', $query);
        $search = array();
        foreach ($searchTerms as $value) {      
            if( strlen($value) > 2 )  array_push($search, $value);
        }

        $searchTermBits = array();
        foreach ($search as $term) {
            $term = trim($term);
            if (!empty($term)) {
                $searchTermBits[] = "name LIKE '%$term%'";
            }
        }
        
        $sql = "SELECT * FROM recipes WHERE ".implode(' OR ', $searchTermBits)." LIMIT $totalPostPage OFFSET $page";
        $sth = $con->prepare($sql);
        $query = '%'.$query.'%';
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();

        print_r($todos); die();
        return $todos;
    }
}
