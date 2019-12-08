<?php

namespace App\Models;
use Firebase\JWT\JWT;
use App\Providers\UserService;

class User{

    private $db;
    private $secret;
    private $algorithm;

    public function __construct($c) {    
        $this->db = $c->db;
        $this->secret =  $c->get('settings')['jwt']['secret'];
        $this->algorithm = $c->get('settings')['jwt']['algorithm'];
    }
    /**
     * Add new user if not exist - add account
     */
    public function createUser( $pass_crypt, $input ){
        UserService::addInProfiles($this->db, $input);
        UserService::addInUsers($this->db, $pass_crypt, $input);
        $input['id'] = $this->db->lastInsertId();      
        return $input;    
    }
    /**
     * Evalue username and password and return token - login
     */
    public function getToken( $input ) {        
        $user = UserService::token($this->db, $input);
        return JWT::encode(
            ['first_name' => $user->first_name, 'last_name' => $user->last_name,'email' => $user->email],
            $this->secret,
            $this->algorithm
        );
    }
    /**
     * Evalue if exist user
     */
    public function userExists($email) {
        return UserService::userExists($this->db, $email);       
    }
    /**
     * get user profile
     */
    public function getUserProfile( $email ) {
        return UserService::getUserProfile($this->db, $email);
    }
    /**
     * update user profile
     */
    public function updateUserProfile( $email, $params ) {
        UserService::updateInProfile($this->db, $email, $params);
        UserService::updateInUsers($this->db, $email, $params);
        $params['email'] = $email;
        return $this->getToken($params);
        
    }
    /**
     * delete user profile
     */
    public function deleteUserProfile( $email ) {
        UserService::deleteInProfile($this->db, $email);
        UserService::deleteInUsers($this->db, $email);
    }
}