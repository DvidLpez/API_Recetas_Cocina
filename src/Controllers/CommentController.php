<?php

namespace App\Controllers;
use App\Models\Car;

class CommentController
{
   private $settings;

    public function __construct($c) {
        $this->settings = $c;
        $this->logger = $c['logger'];
        $this->logger->info('Comment controller: '. $user_loged['email'] );
    }
}