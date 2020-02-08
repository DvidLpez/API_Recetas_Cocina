<?php

namespace App\Providers;

class CategoryService {


    public function createCategory($con, $input)
    {
        $sql = "INSERT INTO categories (name, description, popularity ) VALUES (:name, :description, :popularity)";
        $sth = $con->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("popularity", $input['popularity']);
        $sth->execute();
        
    }

    public function categoryExists ($con, $name) {  
        $sql = "SELECT * FROM categories WHERE name= :name_category";
        $sth = $con->prepare($sql);
        $sth->bindParam("name_category", $name);
        $sth->execute();
        $user = $sth->fetchObject();
        return $user;     
    }
    
    public function getCategories($con) {
      $sql = "SELECT * FROM categories ORDER BY popularity";
      $sth = $con->prepare($sql);
      $sth->execute();
      $todos = $sth->fetchAll();
      return $todos;
   }

   function removeCategory($con, $id)
    {
        $sql = "DELETE FROM categories WHERE id=:id";
        $sth = $con->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        $sql = "SELECT * FROM categories";
        $sth = $con->prepare($sql);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }


}