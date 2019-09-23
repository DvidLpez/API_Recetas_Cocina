<?php

namespace App\Core;

class ErrorCodes{

   public function notFound() {
      return ['status'=> '404', 'statusTxt'=>'Sorry... Resource not found'];
   }
   public function emptyValues() {
      return ['status'=> '400', 'statusTxt'=>'All fields is required'];
   }
   public function mailRegistered() {
      return ['status'=> '400', 'statusTxt'=>'The email is already registered'];
   }
   public function errorLogin() {
      return ['status'=> '400', 'statusTxt'=>'These credentials are not valid'];
   }
   public function errorForm() {
      return ['status'=> '400', 'statusTxt'=>'Incorrect values, please check it!!'];
   }
}
