<?php

namespace App\Providers;


class UserService {


   public function addInProfiles($con, $input)
    {
        $sql = "INSERT INTO profiles (first_name, last_name, email) VALUES (:first_name, :last_name, :email)";
        $sth = $con->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        
    }

    public function addInUsers ($con, $pass_crypt, $input)
    {
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $sth = $con->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $input['email']);
        $sth->bindParam("password", $pass_crypt);
        $sth->execute();
    }

    public function token ($con, $input) {

        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $con->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        return $sth->fetchObject(); 
    }

    public function userExists ($con, $email) {  
            $sql = "SELECT * FROM users WHERE email= :email";
            $sth = $con->prepare($sql);
            $sth->bindParam("email", $email);
            $sth->execute();
            $user = $sth->fetchObject();
            return $user;     
    }

    public function getUserProfile($con, $email) {
        $sql = "SELECT * FROM profiles WHERE email= :email";
        $sth = $con->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
        return $sth->fetchObject();
    }

    public function updateInProfile($con, $email, $input) {
        $sql = "UPDATE profiles 
        SET 
        first_name=:first_name, last_name=:last_name, phone=:phone, country=:country, city=:city,postal_code=:postal_code
        WHERE 
        email=:email";

        $sth = $con->prepare($sql);
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

    public function updateInUsers($con, $email, $input) {
        $sql = "UPDATE users 
        SET 
        first_name=:first_name, last_name=:last_name
        WHERE 
        email=:email";

        $sth = $con->prepare($sql);
        $sth->bindParam("first_name", $input['first_name']);
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("email", $email);
        $sth->execute();
    }

    public function deleteInProfile($con, $email) {
        $sql = "DELETE FROM profiles WHERE email=:email";
        $sth = $con->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
    }
    public function deleteInUsers($con, $email) {
        $sql = "DELETE FROM users WHERE email=:email";
        $sth = $con->prepare($sql);
        $sth->bindParam("email", $email);
        $sth->execute();
    }
    
}