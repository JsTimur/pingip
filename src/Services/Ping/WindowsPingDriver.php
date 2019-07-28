<?php

namespace App\Services\Ping;

class WindowsPingDriver implements PingDriverInterface {

   private function fixCharset($array = []) {
      foreach ($array as $k=>$v) {
         $array[$k] = iconv("CP866", "UTF-8", $v);
      };
      return $array;
   }

   public function ping($ip):array {
      exec("ping -n 3 ".$ip, $output, $status);
      $output = $this->fixCharset($output);
      return $output;
   } 
}