<?php

namespace App\Database;

use PDO;

class SqliteDatabase {
   public $dbname; 
   public $db;

   public function __construct($sqlitedbname)
   {
      $this->dbname = $sqlitedbname;
      $this->db = $this->openBase();
      $this->createTables();
   }

   public function openBase() {
      global $config;
      
      $dbpath = dirname(__DIR__, 2).'\\'.$config['storage_path'].$this->dbname;
      $db = new PDO('sqlite:'.$dbpath.'.db', '', '', array(
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      ));
      $db->exec( 'PRAGMA foreign_keys = ON;' );
      return $db;
   }

   public function createTables() {
      $commands = ['CREATE TABLE IF NOT EXISTS groups (
         id   INTEGER PRIMARY KEY,
         gname TEXT NOT NULL,
         parent_id INTEGER
       )',
      'CREATE TABLE IF NOT EXISTS ip_servers (
         id INTEGER PRIMARY KEY,
         ip  VARCHAR (255) NOT NULL,
         group_id INTEGER NOT NULL,
         FOREIGN KEY (group_id)
         REFERENCES groups(id) ON UPDATE CASCADE
                                          ON DELETE CASCADE)',
      'CREATE TABLE IF NOT EXISTS ping_history (
         id INTEGER PRIMARY KEY,
         hresult TEXT NOT NULL,
         hdate DATETIME,
         ip_id INTEGER NOT NULL,
         FOREIGN KEY (ip_id)
         REFERENCES ip_servers(id) ON UPDATE CASCADE
                                          ON DELETE CASCADE

      )'];
       
      foreach ($commands as $command) {
         $this->db->exec($command);
      }
   }
}