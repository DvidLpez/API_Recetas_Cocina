<?php

namespace App\Core;

use Respect\Validation\Validator as v;

class Validator{

   public function namesVal( $name ) {
      $namesVal = v::alpha('ÁÀÄÉÈËÍÌÏÓÒÖÚÙÜÑáàäéèëíìïóòöúùüñ')->length(3, 20);
      return $namesVal->validate($name);    
   }
   public function emailVal( $email ) {
      $emailVal = v::email();
      return $emailVal->validate($email);
   }
}