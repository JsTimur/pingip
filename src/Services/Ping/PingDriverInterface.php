<?php

namespace App\Services\Ping;

interface PingDriverInterface {
   public function ping($ip):array;
}