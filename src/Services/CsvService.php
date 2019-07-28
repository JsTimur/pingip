<?php
namespace App\Services;

class CsvService {
   private $filename;

   public function __construct($filename)
   {
      $this->filename = $filename;
   }

   public function saveToFile($array = []) {
      if (count($array)==0) { return false; }
      $fp = fopen(dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$this->filename.'.csv', 'w');

      fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

      foreach ($array as $fields) {
         fputcsv($fp, $fields, ';');
      }

      fclose($fp);
   }
   
   public function getFilePath() {
      return 'files'.DIRECTORY_SEPARATOR.$this->filename.'.csv';
   }
} 