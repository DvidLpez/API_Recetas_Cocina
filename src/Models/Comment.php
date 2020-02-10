<?php

namespace App\Models;
use App\Providers\CommentService;

class Comment{

    private $db;

    public function __construct($c) 
    {    
        $this->db = $c->db;
    }

    public function createComment( $input )
    {
        CommentService::createComment($this->db, $input);
        $input['id'] = $this->db->lastInsertId();      
        return $input;    
    }

    public function getComment($category_name) 
    {
        return CommentService::getComment($this->db, $category_name);       
    }

    public function updateComment( $id )
    {
        return CommentService::updateComment($this->db, $id);   
    }

    public function deleteComment()
    {
        return CommentService::deleteComment($this->db, $id);       
    }
    
    public function listCommentsByRecipe( $id, $params )
    {
        return CommentService::listCommentsByRecipe($this->db, $id);     
    }
}
