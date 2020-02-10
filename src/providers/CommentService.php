<?php

namespace App\Providers;

class CommentService {
    /**
     *  Create a new comment in Table comments
     */
    public function createComment($con, $input)
    {
      //   $sql = "INSERT INTO comments (name, description, popularity ) VALUES (:name, :description, :popularity)";
      //   $sth = $con->prepare($sql);
      //   $sth->bindParam("name", $input['name']);
      //   $sth->bindParam("description", $input['description']); 
      //   $sth->bindParam("popularity", $input['popularity']);
      //   $sth->execute();   
    }
    /**
     *  Check if exist category in Table categories
     */
    public function getComment ($con, $name) 
    {  
      //   $sql = "SELECT * FROM comments WHERE name= :name_category";
      //   $sth = $con->prepare($sql);
      //   $sth->bindParam("name_category", $name);
      //   $sth->execute();
      //   $user = $sth->fetchObject();
      //   return $user;     
    }
    /**
     *  Select category in Table categories by id
     */
    public function updateComment ($con, $id) 
    {
      //   $sql = "SELECT * FROM comments WHERE id=:id";
      //   $sth = $con->prepare($sql);
      //   $sth->bindParam("id", $id);
      //   $sth->execute();
      //   return $sth->fetchObject(); 
    }
    /**
     *  Select category in Table categories order popularity
     */
    public function deleteComment($con) 
    {
      //   $sql = "SELECT * FROM comments ORDER BY popularity";
      //   $sth = $con->prepare($sql);
      //   $sth->execute();
      //   $todos = $sth->fetchAll();
      //   return $todos;
    }
    /**
     *  Update category in Table categories
     */
    public function listCommentsByRecipe($con, $id, $input) 
    {
      //   $sql = "UPDATE comment SET name=:name, description=:description, popularity=:popularity WHERE id=:id";
      //   $sth = $con->prepare($sql);
      //   $sth->bindParam("name", $input['name']);
      //   $sth->bindParam("description", $input['description']); 
      //   $sth->bindParam("popularity", $input['popularity']);
      //   $sth->bindParam("id", $id);
      //   $sth->execute();
    }
}
