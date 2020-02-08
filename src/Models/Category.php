<?php

namespace App\Models;
use App\Providers\CategoryService;

class Category{

    private $db;
    private $secret;
    private $algorithm;

    public function __construct($c) {    
        $this->db = $c->db;
        $this->secret =  $c->get('settings')['jwt']['secret'];
        $this->algorithm = $c->get('settings')['jwt']['algorithm'];
    }

    public function createCategory( $input ){
        CategoryService::createCategory($this->db, $input);
        $input['id'] = $this->db->lastInsertId();      
        return $input;    
    }

    public function categoryExists($category_name) {
        return CategoryService::categoryExists($this->db, $category_name);       
    }

    /**
     * Add new user if not exist - add account
     */
    public function getCategories() {
        return CategoryService::getCategories($this->db);       
    }

    function removeCategory($id)
    {
        $list = CategoryService::removeCategory($this->db, $id);
        return $list; 
    }
    
    
    
}