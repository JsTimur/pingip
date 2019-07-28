<?php

$config = require_once __DIR__.'/config.php';
$routes = require_once __DIR__.'/routes.php';
require_once __DIR__.'/autoload.php';

use App\Container;
use App\Services\Ping\WindowsPingDriver;
use App\Services\Ping\LinuxPingDriver;

function app() {
   global $config;
   $container = new Container;
   $database  = new App\Database\SqliteDatabase($config['sqlite_basename']);
   $view = new App\Services\ViewService();

   if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
      $pingDriver = new WindowsPingDriver();
   } else {
      $pingDriver = new LinuxPingDriver();
   }

   $ping = new App\Services\Ping\PingService($pingDriver);
   $container->db = $database->db;
   $container->ping = $ping;
   $container->view = $view;
   return $container;
}

$currentRoute = strtok($_SERVER['REQUEST_URI'],'?');
if (strlen($currentRoute)===0) { $currentRoute = "/"; }

// $prefixRouteLength = strlen($config['site_prefix']);
// if (strncmp($currentRoute, $config['site_prefix'], $prefixRouteLength) === 0) {
//    $currentRoute = substr($currentRoute, $prefixRouteLength);
//    if (strlen($currentRoute)===0) { $currentRoute = "/"; }
// }

if (strlen($currentRoute)>0) {
   foreach($routes as $routeName=>$routeAction) {
      if ($routeName==$currentRoute) {
         [$className,$classMethod] = explode('@',$routeAction);
         (new $className)->$classMethod();
         break;
      }
   }
}
 

 

 