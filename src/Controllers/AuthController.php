<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;


class AuthController
{
    public function __construct($c) {

        $c->logger->info("Slim-Skeleton '/' route");
        $this->settings = $c;
        $this->secret = $c->settings['jwt']['secret'];
        $this->algorithm = $c->settings['jwt']['algorithm'];
    }

    public function getToken( Request $request, Response $response, array $arg ){

        $input = $request->getParsedBody();
        $sql = "SELECT * FROM users WHERE email= :email";
        $sth = $this->settings->db->prepare($sql);
        $sth->bindParam("email", $input['email']);
        $sth->execute();
        $user = $sth->fetchObject();

        // verify email address.
        if(!$user) {
            return $response->withJson(['error' => true, 'message' => 'These credentials do not match our records user.']);  
        }
        // verify password.
        if (!password_verify($input['password'], $user->password)) {
            return $response->withJson(['error' => true, 'message' => 'These credentials do not match our records password.']);  
        }
        $token = JWT::encode(['id' => $user->id, 'email' => $user->email], $this->secret, $this->algorithm );
        return $response->withJson(['token' => $token]);
    }
}
