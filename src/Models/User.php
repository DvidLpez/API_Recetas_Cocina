<?php

namespace App\Models;
use Firebase\JWT\JWT;
use App\Services\UserService;

class User{

    public function __construct($c) {
        $this->settings = $c;
        $this->secret =  $c->get('settings')['jwt']['secret'];
        $this->algorithm = $c->get('settings')['jwt']['algorithm'];
    }
    /**
     * Add new user if not exist
     */
    public function createUser( $pass_crypt, $input ){
        UserService::addInProfiles($this->settings, $input);
        UserService::addInUsers($this->settings, $pass_crypt, $input);
        $input['id'] = $this->settings->db->lastInsertId();      
        return $input;    
    }
    /**
     * Evalue username and password and return token
     */
    public function getToken( $input ) {        
        $user = UserService::token($this->settings, $input);
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
        return UserService::userExists($this->settings, $email);
    }

    public function getUserProfile( $email ) {
        return UserService::getUserProfile($this->settings, $email);
    }
}