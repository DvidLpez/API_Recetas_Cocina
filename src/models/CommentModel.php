<?php

namespace App\Models;

class CommentModel{

    private $db;

    public function __construct($database) {    
        $this->db = $database;
    }

    public function createComment( $input ){
           
    }

    public function getComment($category_name) {
       
    }

    public function updateComment( $id ) {
          
    }

    public function deleteComment() {
         
    }
    
    public function listCommentsByRecipe( $id, $params ) {
    
    }
}
