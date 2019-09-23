<?php
namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Core\ErrorCodes;
use App\Core\Validator;

// $this->settings->logger->info("Get Token - user: " .$input['email']); para llevar los logs

class AuthController
{
    public function __construct($c) {
        $this->settings = $c;
        // $this->logger = $c['logger'];
        // $this->logger->info('Get User: '. $user_loged['email'] );
    }
    /**
     * Description: Add new user if not exist
     */
    public function registerUser($request, $response){
        $params = $request->getParsedBody();
        if(!$this->checkRegisterParams($params))
            return $response->withJson( ErrorCodes::emptyValues(), 400);

        $user = new User($this->settings);  
        if ($user->userExists($params['email']))   
            return $response->withJson( ErrorCodes::mailRegistered(), 400);
  
        $user->createUser( password_hash( $params['password'], PASSWORD_DEFAULT), $params);
        return $response->withJson($params, 201);   
    }
    /**
     * Description: Check params if are isset
     */
    private function checkRegisterParams($params) {  

        if( Validator::namesVal($params['first_name']) && 
            Validator::namesVal($params['last_name']) && 
            Validator::emailVal($params['email'])
        ) {               
            return true;
        }  
        return false;
    }
    /**
     * Description: Evalue username and password
     */
    public function loginUser( Request $request, Response $response, array $arg ){
        $user = new User($this->settings);
        $input = $request->getParsedBody();
        
        if(!Validator::emailVal($input['email']))
            return $response->withJson( ErrorCodes::errorForm(), 400);
        
        $userExist = $user->userExists($input['email']);
        if(!$userExist) 
            return $response->withJson( ErrorCodes::errorLogin(), 400);  
        
        if (!password_verify($input['password'], $userExist->password)) 
            return $response->withJson(ErrorCodes::errorLogin(), 400);        
        
        return $response->withJson(['token' => $user->getToken($input)], 200);
    }
    /**
     * Get Profile user login
     */
    public function getUser ( Request $request, Response $response, array $arg) {

        $user_loged = $request->getAttribute("decoded_token_data");
        $user = new User($this->settings);
        
        if(!$user->userExists($user_loged['email']))
            return $response->withJson(ErrorCodes::errorLogin(), 200);  
        
        $user_profile = $user->getUserProfile($user_loged['email']);
        return $response->withJson( $user_profile, 200 );
    }
}
