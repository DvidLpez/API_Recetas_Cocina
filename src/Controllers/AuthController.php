<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;


class AuthController
{
    protected $settings;
    protected $secret;
    protected $algorithm;

    public function __construct($c) {

        $this->settings = $c;
        $this->secret = $c->settings['jwt']['secret'];
        $this->algorithm = $c->settings['jwt']['algorithm'];
    }
    /**
     * Name Function: newUser
     * Description: Add new user if not exist
     * Return: User created
     */
    public function newUser($request, $response){
        
        $input = $request->getParsedBody();
        $userExist = $this->userExists($input);

        if ($userExist) {
            
            return $response->withJson(['message' => 'The email is already registered'], 200);
            
        }else{
            $pass_crypt =  password_hash( $input['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (email, password) VALUES (:email, :password)";
            $sth = $this->settings->db->prepare($sql);
            $sth->bindParam("email", $input['email']);
            $sth->bindParam("password", $pass_crypt);
            $sth->execute();
            $input['id'] = $this->settings->db->lastInsertId();
            $this->settings->logger->info("User Created - user: " .$input['email']);
            return $response->withJson($input, 201);
        }
    }
    /**
     * Name function: getToken
     * Description: Evalue username and password
     * Return token if credentials it's correct
     */
    public function getToken( Request $request, Response $response, array $arg ){
        
        $input = $request->getParsedBody();
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject();

        $this->settings->logger->info("Get Token - user: " .$input['email']);

        if(!$user) {
            return $response->withJson(['status' => false, 'message' => 'These credentials are not valid *.'], 200);  
        }

        if (!password_verify($input['password'], $user->password)) {
            return $response->withJson(['status' => false, 'message' => 'These credentials are not valid **.'], 200);  
        }

        $token = JWT::encode(['id' => $user->id, 'email' => $user->email], $this->secret, $this->algorithm );
        return $response->withJson(['token' => $token], 200);
    }
    /**
     * Name Function: userExists
     * Description: Evalue if exist user
     * @input: User by evalue
     * Return: Boolean if user exist
     */
    private function userExists($input){

        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject();

        if(!$user) {
            return false;  
        }else{
            return true;  
        }
    }
}
