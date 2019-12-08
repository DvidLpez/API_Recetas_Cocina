<?php
namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Providers\Validator;

class AuthController {

    private $settings;

    public function __construct($c) {
        $this->settings = $c;
        $this->logger = $c['logger'];
        $this->logger->info('Get User: '. $user_loged['email'] );
        $this->logger->info('login user' );
    }
    /**
     * Description: Add new user if not exist
     */
    public function registerUser($request, $response){
        $params = $request->getParsedBody();
        if(!$this->checkRegisterParams($params))
            return $response->withJson( ['status' => false, 'message'=> 'algo va mal'], 400);

        $user = new User($this->settings);  
        if ($user->userExists($params['email'])) 
            return $response->withJson( ['status' => false, 'message'=> 'algo va mal'], 400);
  
        $user->createUser( password_hash( $params['password'], PASSWORD_DEFAULT), $params);
        return $response->withJson(['status' => true, 'user' => $params], 201);   
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
        $this->logger->info('login user' );
        $input = $request->getParsedBody();
        if(!Validator::emailVal($input['email']))
            return $response->withJson( ['status' => false, 'message'=> 'Email invalid'], 400);
        $user = new User($this->settings);
        $userExist = $user->userExists($input['email']);
        if(!$userExist) 
            return $response->withJson( ['status' => false, 'message'=> 'User not found'], 404); 
        
        if (!password_verify($input['password'], $userExist->password)) 
            return $response->withJson(['status' => false, 'message'=> 'Password invalid'], 400);        
        
        return $response->withJson(['status' => true, 'token' => $user->getToken($input)], 200);
    }
    /**
     * Get Profile user login
     */
    public function getUser ( Request $request, Response $response, array $arg) {
        $user_loged = $request->getAttribute("decoded_token_data");
        $user = new User($this->settings);
        
        if(!$user->userExists($user_loged['email']))
            return $response->withJson(['status' => false, 'message'=> 'algo va mal'], 200);  
        
        $user_profile = $user->getUserProfile($user_loged['email']);
        return $response->withJson( ['status' => true, 'user' => $user_profile], 200 );
    }

    public function updateProfile(Request $request, Response $response, array $arg) {
        $user_loged = $request->getAttribute("decoded_token_data");
        $params = $request->getParsedBody();
        if(!$this->checkProfileParams($params) )
            return $response->withJson( ['status' => false, 'message'=> 'algo va mal'], 400);

        $user = new User($this->settings);
        $token = $user->updateUserProfile($user_loged['email'], $params);
        return $response->withJson(['status' => true, 'token' => $token], 200);
    }

    private function checkProfileParams($params) {
        if( 
            Validator::namesVal($params['first_name']) && 
            Validator::namesVal($params['last_name']) && 
            Validator::phoneVal($params['phone']) && 
            Validator::countryVal($params['country']) && 
            Validator::namesVal($params['city']) && 
            Validator::postalCodeVal($params['country'], $params['postal_code'])
        ) {            
            return true;
        } 
        return false;
    }

    public function deleteProfile(Request $request, Response $response, array $arg) {
        $user_loged = $request->getAttribute("decoded_token_data");
        $user = new User($this->settings);
        $token = $user->deleteUserProfile($user_loged['email']);
        return $response->withJson(['status' => true, 'message' => 'Account deleted' ], 200);
    }
}
