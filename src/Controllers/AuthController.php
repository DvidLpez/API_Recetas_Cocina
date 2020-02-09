<?php
namespace App\Controllers;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\User;
use App\Models\Validator;
use App\Providers\UploadFilesService;

class AuthController {

    private $settings;

    public function __construct($c) {
        $this->settings = $c;
        $this->logger = $c['logger'];
        $this->logger->info('User controller: '. $user_loged['email'] );
    }
    /**
     * Description: Add new user
     */
    public function registerUser($request, $response){
        try {
            $params = $request->getParsedBody();
            if(!$this->checkRegisterParams($params)) {
                throw new \Exception('Los datos introducidos no son correctos', 400);
            }
            $user = new User($this->settings);  
            if ($user->userExists($params['email'])) {
                throw new \Exception('El usuario ya existe', 400);
            }
            $user->createUser( password_hash( $params['password'], PASSWORD_DEFAULT), $params);   
            return $response->withJson(['status' => true, 'user' => $params['email']], 201);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Description: Evalue username and password
     */
    public function loginUser( Request $request, Response $response, array $arg ){
        try {
            $this->logger->info('login user' );
            $input = $request->getParsedBody();
            if(!Validator::emailVal($input['email'])) {
                throw new \Exception('Email invalido', 400);
            }
            $user = new User($this->settings);
            $userExist = $user->userExists($input['email']);
            if(!$userExist) {
                throw new \Exception('User not found', 404);
            }
            if (!password_verify($input['password'], $userExist->password)) {
                throw new \Exception('Password invalid', 400); 
            }
            return $response->withJson(['status' => true, 'token' => $user->getToken($input)], 200);

        } catch ( \Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Description: Get user profile (decode token)
     */
    public function getUser ( Request $request, Response $response, array $arg) {
        try {
            $user_loged = $request->getAttribute("decoded_token_data");
            $user = User($this->settings);     
            if(!$user->userExists($user_loged['email'])) {
                throw new \Exception('Token invalido', 400);
            }     
            $user_profile = $user->getUserProfile($user_loged['email']);
            return $response->withJson( ['status' => true, 'user' => $user_profile], 200 );

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Description: Update user profile (decode token)
     */
    public function updateProfile(Request $request, Response $response, array $arg) {
        try {
            $user_loged = $request->getAttribute("decoded_token_data");
            $params = $request->getParsedBody();
            if(!$this->checkProfileParams($params) ) {
                throw new \Exception('Los datos no son correctos', 400);
            }
            $user = new User($this->settings);
            $token = $user->updateUserProfile($user_loged['email'], $params);
            return $response->withJson(['status' => true, 'token' => $token], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Description: Delete user profile (decode token)
     */
    public function deleteProfile(Request $request, Response $response, array $arg) {
        try {
            $user_loged = $request->getAttribute("decoded_token_data");
            $user = new User($this->settings);
            $token = $user->deleteUserProfile($user_loged['email']);
            return $response->withJson(['status' => true, 'message' => 'Account deleted' ], 200);

        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }
    }
    /**
     * Upload profile image
     */
    public function UploadImageProfile( Request $request, Response $response ) {

        try {
            $uploadedFiles = $request->getUploadedFiles();
            if(!UploadFilesService::checkImage($uploadedFiles['profile']) ) {
                throw new \Exception('Image invalid', 400);
            }
            $user_loged = $request->getAttribute("decoded_token_data");
            $user = new User($this->settings);
            $user_profile = $user->getUserProfile($user_loged['email']);
            $directory = UploadFilesService::createPathImagesUser($user_profile->id);
            $uploadedFile = $uploadedFiles['profile'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = UploadFilesService::moveUploadedFile($directory, $uploadedFile);

                $path_image = "http://".$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/images/profiles/". $user_profile->id."/".$filename;
                return $response->withJson(['status' => true, 'file_uploaded' => ['name_image' => $filename, "path" => $path_image]], 200);
            }
        } catch (\Exception $e) {
            return $response->withJson(['status' => false, 'message' => $e->getMessage()], $e->getCode() );
        }  
    }

    private function createPathImagesUser($id){
        $path = __DIR__ . '/../../public/images/profiles/'. $id .'/';
        if(!is_dir($path)){
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
        return $path;
    }

    private function checkImage($files) {

        $type =  $files['profile']->getClientMediaType();
        $size =  $files['profile']->getSize();
        if(($type == 'image/png' || $type == 'image/jpg') && $size < '10000') { // size en bytes 1000 +- 1kb
            return true;
        }
        return false; 
    }

    private function moveUploadedFile($directory, $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

    /**
     * Description: Check format params in register user
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
     * Description: Check format params in update profile
     */
    private function checkProfileParams($params) {
        if( Validator::namesVal($params['first_name']) && 
            Validator::namesVal($params['last_name']) && 
            Validator::phoneVal($params['phone']) &&  
            Validator::namesVal($params['city']) &&
            Validator::postalCodeVal($params['country'], $params['postal_code'])
        ) {            
            return true;
        } 
        return false;
    }
}
