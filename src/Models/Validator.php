<?php

namespace App\Models;

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
   public function phoneVal( $phone ) {
      $phoneVal = v::regex('/^[0-9]{9,15}$/');
      return $phoneVal->validate($phone);
   }
   public function postalCodeVal( $country, $cp ) {
      $cpVal = v::postalCode($country);
      return $cpVal->validate($cp);
   }
   public function addressVal($address) {
      $addressVal = v::alnum();
      return $addressVal->validate($address);
   }
}