<?php
namespace App\Services\Ping;

class PingService {

   private $pingDriver;
 
   public function __construct(PingDriverInterface $pingDriver) {
      $this->pingDriver = $pingDriver;
   }
 
   public function pingIP($ip) {
      return $this->pingDriver->ping($ip);
   }
} 