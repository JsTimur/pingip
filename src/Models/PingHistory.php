<?php

namespace App\Models;

use App\Models\IpServer;

class PingHistory {

   public $tableName = "ping_history";

   public function appendIptoArray($array = []) {
      if (count($array) === 0) { return false; }
      foreach ($array as $k=>$v) {
         $array[$k]['ip'] = (new IpServer)->find($v['ip_id'])['ip'];
      }
      return $array;
   }

   public function add($ip_id,$hresult) {
      $db = app()->db;
      $q = $db->prepare(
         "INSERT INTO ".$this->tableName." (ip_id, hdate, hresult) VALUES (?, datetime('now'), ?)");
      $q->execute(array($ip_id, $hresult));
      $lastId = $db->lastInsertId();
      return $q->rowCount() === 1 ? $lastId : false; 
      
   }

   public function getByIpId($ip_id) {
      $q = app()->db->prepare(
         "SELECT * FROM ".$this->tableName." WHERE ip_id = $ip_id");
      $q->execute();
      $ipHistory = $q->fetchAll();
      if (count($ipHistory) === 0) { return false; }
      $ipHistory = $this->appendIptoArray($ipHistory);
      return $ipHistory;
   }

   public function getByGroupId($group_id) {
      $q = app()->db->prepare(
         "SELECT * FROM ".$this->tableName." WHERE ip_id IN ( SELECT id FROM ".IpServer::$tableName." WHERE group_id = $group_id ) ORDER BY id DESC");
      $q->execute();
      $groupHistory = $q->fetchAll();
      if (count($groupHistory) === 0) { return false; }
      return $this->appendIptoArray($groupHistory);
   }

   public function CsvGroupExport($group_id) {
      $q = app()->db->prepare(
         "SELECT hresult,hdate,ip_id FROM ".$this->tableName." WHERE ip_id IN ( SELECT id FROM ".IpServer::$tableName." WHERE group_id = $group_id )");
      $q->execute();
      $groupHistory = $q->fetchAll(\PDO::FETCH_ASSOC);
      if (count($groupHistory) === 0) { return false; }
      return $this->appendIptoArray($groupHistory);
      
   }

   public function getAll() {
      $q = app()->db->prepare(
         "SELECT * FROM ".$this->tableName." ORDER BY id DESC");
      $q->execute();
      $history = $q->fetchAll();
      if (count($history) === 0) { return false; }
      return $this->appendIptoArray($history);
   }

   public function find($id) {
      $q = app()->db->prepare(
         "SELECT * FROM ".$this->tableName." WHERE id = $id");
      $q->execute();
      $result = $q->fetch();
      return $result;
   }

}