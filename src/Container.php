<?php 
namespace App;

class Container {
   private $services = [];

   public function __set($id,$value) {
      $this->services[$id] = $value;
   }

   public function __get($id) {
      if ($this->services[$id]) {
         return $this->services[$id];
      } else {
         throw new Exception("Service not found.");
      }
   }
}