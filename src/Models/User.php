<?php

namespace App\Models;
use Firebase\JWT\JWT;

class User{

    public function __construct($c) 
    {
        $this->settings = $c;
        $this->secret =  $c->get('settings')['jwt']['secret'];
        $this->algorithm = $c->get('settings')['jwt']['algorithm'];
    }
    /**
     * Add new user if not exist
     * @param String $pass_crypt
     * @param Array $input     
     * @return Array $input
     */
    public function createUser( $pass_crypt, $input ){
                    
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->bindParam("password", $pass_crypt);
        $sth->execute();
        $input['id'] = $this->settings->db->lastInsertId();      
        return $input;    
    }
    /**
     * Evalue username and password and return token
     * @param Array $input     
     * @return String $token
     */
    public function getToken( $input )
    {        
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject(); 
        $token = JWT::encode(['id' => $user->id, 'email' => $user->email], $this->secret, $this->algorithm );
        return $token;
    }
    /**
     * Evalue if exist user
     * @param Array $input     
     * @return Array $user
     */
    public function userExists($input)
    {
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject();
        return $user;
    }
}