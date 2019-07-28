<?php
namespace App\Services;

class ViewService {
   private $path;

   public function __construct()
   {
      $this->path = dirname(__DIR__, 2).'/views/';
   }

   public function show($template = "index", $data = []) {
      if (count($data)>0) {
         extract($data);
      }
      return require_once($this->path.$template.'.php');
   }
}