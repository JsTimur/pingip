<?php
namespace App\Controllers;

use App\Models\Group;
use App\Models\PingHistory;
use App\Services\CsvService;

class CsvController {

   public function savegroup() {
      $errors = [];
      $id = isset($_POST['id']) && is_numeric($_POST['id']) && Group::checkGroupExist($_POST['id']) ? $_POST['id'] : 0;
       
      if ($id == 0) { 
         $errors['success'] = 'false'; 
         $errors['problem'][] = 'Группа не найдена';
      } else {
         $pingHistory = new PingHistory;
         $groupHistory = $pingHistory->CsvGroupExport($id);

         if (count($groupHistory)==0) {
            $errors['success'] = 'false'; 
            $errors['problem'][] = 'Нет данных';
         }  else {
            $csv = new CsvService('grouphistory');
            $resultArray = [];
   
            foreach ($groupHistory as $k=>$v) {
                $resultArray[$k]['ip'] = $v['ip'];
                $resultArray[$k]['hdate'] = $v['hdate']; 
                $resultArray[$k]['hresult'] = implode('',unserialize($v['hresult']));
            }
   
            $csv->saveToFile($resultArray);
   
            $errors['success'] = 'true';
            $errors['url'] = $csv->getFilePath();
         }  

         
      }
      echo json_encode($errors);
   }

  
}