<?php
return [
   '/' => 'App\Controllers\IndexController@index', 
   '/group/add' => 'App\Controllers\GroupController@add', 
   '/group/delete' => 'App\Controllers\GroupController@delete', 
   '/group/showlist' => 'App\Controllers\GroupController@showlist', 
   '/ip/add' => 'App\Controllers\IpServerController@add', 
   '/ip/ping' => 'App\Controllers\IpServerController@ping', 
   '/ip/delete' => 'App\Controllers\IpServerController@delete', 
   '/ip/showlist' => 'App\Controllers\IpServerController@showlist', 
   '/ip/showitem' => 'App\Controllers\IpServerController@showItem', 
   '/history/group' => 'App\Controllers\PingHistoryController@showgroup', 
   '/history/ip' => 'App\Controllers\PingHistoryController@showip', 
   '/history/add' => 'App\Controllers\PingHistoryController@add', 
   '/history/all' => 'App\Controllers\PingHistoryController@all', 
   '/csv/group' => 'App\Controllers\CsvController@savegroup', 
];