<?php

namespace App\Services;

class UserService {

   public function addInProfiles($settings, $input)
    {
        $sql = "INSERT INTO profiles (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
        $sth = $settings->db->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->execute();
    }

    public function addInUsers ($settings, $pass_crypt, $input)
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $sth = $settings->db->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->bindParam("password", $pass_crypt);
        $sth->execute();
    }

    public function token ($settings, $input) {

        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $settings->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        return $sth->fetchObject(); 
    }

    public function userExists ($settings, $email) {
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $settings->db->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
        $user = $sth->fetchObject();
        return $user;
    }

    public function getUserProfile($settings, $email) {
        $sql = "SELECT * FROM profiles WHERE email= :email";
        $sth = $settings->db->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
        return $sth->fetchObject();
    }
    
}