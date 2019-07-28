<?php

namespace App\Services\Ping;

class LinuxPingDriver implements PingDriverInterface {
   public function ping($ip):array {
      exec("ping -c 3 ".$ip, $output, $status);
      return $output;
   }
}