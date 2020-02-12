<?php

namespace App\Models;
use Firebase\JWT\JWT;

class UserModel{

    private $db;

    public function __construct($database) {    
        $this->db = $database;
    }
    /**
     * Add new user if not exist - add account
     */
    public function createUser( $pass_crypt, $input ) {
        $this->addInProfiles($input);
        $this->addInUsers($input, $pass_crypt);
        $input['id'] = $this->db->lastInsertId();      
        return $input;    
    }
    /**
     * Evalue username and password and return token with expiration - login 
     */
    public function getToken( $input, $jwt ) {        
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject(); 
        $token_create = date(time());
        $token_expires = strtotime('+1 day', $token_create);
        return JWT::encode(
            [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'iat' => (string) $token_create,
                'exp' => (string) $token_expires
            ],
            $jwt['secret'],
            $jwt['algorithm']
        );
    }
    /**
     * Evalue if exist user
     */
    public function userExists($email) {
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
        return $sth->fetchObject();        
    }
    /**
     * get user profile
     */
    public function getUserProfile( $email ) {
        $sql = "SELECT * FROM profiles WHERE email= :email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
        return $sth->fetchObject();
    }
    /**
     * update user profile
     */
    public function updateUserProfile( $email, $params ) {
        $this->updateInProfile($email, $params);
        $this->updateInUsers($email, $params);
        $params['email'] = $email;
        return $this->getToken($params); 
    }
    /**
     * delete user profile
     */
    public function deleteUserProfile( $email ) {
        $this->deleteInProfile($email);
        $this->deleteInUsers($email);
    }
    /**
     * Set image profile
     */
    public function setImageProfile($filename, $email) {
        $sql = "UPDATE profiles SET profile_image=:profile_image WHERE email=:email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("profile_image", $filename);
        $sth->bindParam("email", $email);
        $sth->execute();
    }
    /**
     *          PRIVATE METHODS
     *          ===============
     */

    /**
     *  Add new profile in BBDD - profiles
     */
    private function addInProfiles($input) {
        $sql = "INSERT INTO profiles (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->execute();
    }
    /**
        *  Add new profile in BBDD - users
        */
    private function addInUsers ($input, $pass_crypt) {
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->bindParam("password", $pass_crypt);
        $sth->execute();
    }
   /**
     *  Update profile in BBDD - profiles
     */
    private function updateInProfile($email, $input) {
        $sql = "UPDATE profiles 
        SET 
        first_name=:first_name, last_name=:last_name, phone=:phone, country=:country, city=:city,postal_code=:postal_code
        WHERE 
        email=:email";

        $sth = $this->db->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->bindParam("phone", $input['phone']); 
        $sth->bindParam("country", $input['country']); 
        $sth->bindParam("city", $input['city']); 
        $sth->bindParam("postal_code", $input['postal_code']);
        $sth->bindParam("email", $email);
        $sth->execute();
    }
    /**
     *  Update profile in BBDD - users
     */
    private function updateInUsers($email, $input) {
        $sql = "UPDATE users 
        SET 
        first_name=:first_name, last_name=:last_name
        WHERE 
        email=:email";

        $sth = $this->db->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $email);
        $sth->execute();
    }
    /**
     *  Delete profile from BBDD - profiles
     */
    private function deleteInProfile($email) {
        $sql = "DELETE FROM profiles WHERE email=:email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
    }
    /**
     *  Delete profile from BBDD - users
     */
    private function deleteInUsers($email) {
        $sql = "DELETE FROM users WHERE email=:email";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
    }
}
