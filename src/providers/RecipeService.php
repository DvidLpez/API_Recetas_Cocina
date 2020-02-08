<?php

namespace App\Providers;

class RecipeService {


   public function listRecipes($con)
    {
         $sql = "SELECT * FROM recipes";
         $sth = $con->prepare($sql);
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

    function removeRecipe($con, $id)
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
   
}
