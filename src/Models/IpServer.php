<?php

namespace App\Models;

class IpServer {

   public static $tableName = "ip_servers";

   public static function checkIdExist($id):bool {
      $q = app()->db->query("SELECT id FROM ".self::$tableName." WHERE id = $id LIMIT 1");
      $q->execute();
      return $q->fetch()!==false;
   }

   public static function checkIpExist($ip):bool {
      $q = app()->db->query("SELECT id FROM ".self::$tableName." WHERE ip = $ip LIMIT 1");
      $q->execute();
      return $q->fetch()!==false;
   }

   public function add($ip,$groupId) {
      $db = app()->db;
      $q = $db->prepare(
         "INSERT INTO ".self::$tableName." (ip, group_id) VALUES (?, ?)");
      $q->execute(array($ip, $groupId));
      $lastId = $db->lastInsertId();
      return $q->rowCount() === 1 ? $lastId : false; 
   }

   public function delete($id):bool {
      $q = app()->db->prepare(
         "DELETE FROM ".self::$tableName." WHERE id = $id");
      $q->execute();
      return $q->rowCount() === 1 ? true : false;
   }

   public function getByGroupId($groupId) {
      $q = app()->db->prepare(
         "SELECT * FROM ".self::$tableName." WHERE group_id = $groupId");
      $q->execute();
      $ips = $q->fetchAll();
      return count($ips) > 0 ? $ips : false;
   }

   public function find($id) {
      $q = app()->db->prepare(
         "SELECT * FROM ".self::$tableName." WHERE id = $id");
      $q->execute();
      $ip = $q->fetch();
      return $ip;
   }
}