<?php

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\Comment;

class CommentController
{
   private $settings;

    public function __construct($c) {
        $this->settings = $c;
        $this->logger = $c['logger'];
        $this->logger->info('Comment controller: '. $user_loged['email'] );
    }

    public function registerComment(Request $request, Response $response, array $args) {
        
    }
    public function getComment(Request $request, Response $response, array $args) {

    }
    public function updateComment(Request $request, Response $response, array $args) {

    }
    public function deleteComment(Request $request, Response $response, array $args) {

    }
    public function listCommentsByRecipe(Request $request, Response $response, array $args) {

    }
}