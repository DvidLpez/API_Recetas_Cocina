<?php

namespace App\Models;

// use Illuminate\Database\Query\Builder;

class CategoryModel{

    private $db;

    public function __construct($database)  {    
        $this->db = $database;
    }

    public function createCategory( $input ) {
        $sql = "INSERT INTO categories (name, description, popularity ) VALUES (:name, :description, :popularity)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("popularity", $input['popularity']);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();      
        return $input;    
    }

    public function categoryExists($category_name) {    
        $sql = "SELECT * FROM categories WHERE name= :name_category";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name_category", $category_name);
        $sth->execute();
        $user = $sth->fetchObject();
        return $user;         
    }

    public function getCategory( $id ) {
        $sql = "SELECT * FROM categories WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        return $sth->fetchObject(); 
    }

    public function getCategories() {
        $sql = "SELECT * FROM categories ORDER BY popularity";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }
    
    public function updateCategory( $id, $input ) {
        $sql = "UPDATE categories SET name=:name, description=:description, popularity=:popularity WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("name", $input['name']);
        $sth->bindParam("description", $input['description']); 
        $sth->bindParam("popularity", $input['popularity']);
        $sth->bindParam("id", $id);
        $sth->execute();
    }

    public function removeCategory($id) {
        $sql = "DELETE FROM categories WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $id);
        $sth->execute();
        $sql = "SELECT * FROM categories";
        $sth = $this->db->prepare($sql);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $todos;
    }   
}
