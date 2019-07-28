<?php
namespace App\Controllers;

class IndexController {
   public function index() {
      app()->view->show('index');
   }
}