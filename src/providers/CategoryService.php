<?php

namespace App\Providers;

class CategoryService {
    /**
     *  Create a new category in Table categories
     */
    public function createCategory($con, $input)
    {
        $sql = "INSERT INTO categories (name, description, popularity ) VALUES (:name, :description, :popularity)";
        $sth = $con->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("popularity", $input['popularity']);
        $sth->execute();   
    }
    /**
     *  Check if exist category in Table categories
     */
    public function categoryExists ($con, $name) 
    {  
        $sql = "SELECT * FROM categories WHERE name= :name_category";
        $sth = $con->prepare($sql);
        $sth->bindParam("name_category", $name);
        $sth->execute();
        $user = $sth->fetchObject();
        return $user;     
    }
    /**
     *  Select category in Table categories by id
     */
    public function getCategory ($con, $id) 
    {
        $sql = "SELECT * FROM categories WHERE id=:id";
        $sth = $con->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        return $sth->fetchObject(); 
    }
    /**
     *  Select category in Table categories order popularity
     */
    public function getCategories($con) 
    {
        $sql = "SELECT * FROM categories ORDER BY popularity";
        $sth = $con->prepare($sql);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }
    /**
     *  Update category in Table categories
     */
    public function updateCategory($con, $id, $input) 
    {
        $sql = "UPDATE categories SET name=:name, description=:description, popularity=:popularity WHERE id=:id";
        $sth = $con->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("popularity", $input['popularity']);
        $sth->bindParam("id", $id);
        $sth->execute();
    }
    /**
     *  Remove category in Table categories
     */
    public function removeCategory($con, $id)
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
