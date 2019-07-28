<?php
namespace App\Models;

class Group {
   
   public static $tableName = "groups";

   public static function checkGroupExist($id):bool {
      $q = app()->db->query("SELECT gname FROM ".self::$tableName." WHERE id = $id LIMIT 1");
      $q->execute();
      return $q->fetch() ? true : false;
   }

   public function add($name,$parent) {
      $db = app()->db;
      $q = $db->prepare(
         "INSERT INTO ".self::$tableName." (gname, parent_id) VALUES (?, ?)");
      $q->execute(array($name, $parent));
      $lastId = $db->lastInsertId();
      return $q->rowCount() === 1 ? $lastId : false; 
   }

   public function delete($id):bool {
      $q = app()->db->prepare(
         "DELETE FROM ".self::$tableName." WHERE id = $id");
      $q->execute();
      return $q->rowCount() === 1 ? true : false; 
   }

   public function getAll() {
      $q = app()->db->prepare(
         "SELECT * FROM ".self::$tableName);
      $q->execute();
      $groups = $q->fetchAll();
      return count($groups) > 0 ? $groups : false;
   }

   public function find($id) {
      $q = app()->db->prepare(
         "SELECT * FROM ".self::$tableName." WHERE id = $id");
      $q->execute();
      $group = $q->fetch();
      return $group; 
   }

}