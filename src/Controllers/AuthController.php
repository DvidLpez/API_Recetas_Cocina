<?php
namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;

class AuthController
{
    public function __construct($c) 
    {
        $this->settings = $c;
    }
    /**
     * Description: Add new user if not exist
     * @param Request $request
     * @param Response $response
     * @return Json $input
     */
    public function newUser($request, $response)
    {
        $userModel = new User($this->settings); 
        $input = $request->getParsedBody();
        $userExist = $userModel->userExists($input);

        if ($userExist) 
        {    
            return $response->withJson(['message' => 'The email is already registered'], 200);   
        }
        else
        {
            $pass_crypt =  password_hash( $input['password'], PASSWORD_DEFAULT);
            $userModel->createUser($pass_crypt, $input);
            $this->settings->logger->info("User Created - user: " .$input['email']);
            return $response->withJson($input, 201);
        }
    }
    /**
     * Description: Evalue username and password
     * @param Request $request
     * @param Response $response
     * @param Array $args 
     * @return Json $token
     */
    public function getToken( Request $request, Response $response, array $arg )
    {
        $userModel = new User($this->settings);
        $input = $request->getParsedBody();
        $userExist = $userModel->userExists($input);

        if(!$userExist) 
            return $response->withJson(['status' => false, 'message' => 'These credentials are not valid *.'], 200);  
        
        if (!password_verify($input['password'], $userExist->password)) 
            return $response->withJson(['status' => false, 'message' => 'These credentials are not valid **.'], 200);  
           
        $this->settings->logger->info("Get Token - user: " .$input['email']);
        return $response->withJson(['token' => $userModel->getToken($input)], 200);
    }
}
