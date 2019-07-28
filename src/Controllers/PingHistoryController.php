<?php
namespace App\Controllers;

use App\Models\IpServer;
use App\Models\Group;
use App\Models\PingHistory;

class PingHistoryController {

   public function unserializeResultArray($hArray = []) {
      if (!is_array($hArray)) { return []; }
      if (count($hArray)==0) { return []; }
      foreach ($hArray as $k=>$v) {
         $hArray[$k]['hresultUns'] = unserialize($v['hresult']);
      }
      return $hArray; 
   }
   
   public function showgroup() {
      $errors = [];
      $group_id = (is_numeric($_POST['group_id']) && Group::checkGroupExist($_POST['group_id'])) ? $_POST['group_id'] : 0; 
      if ($group_id == 0) {
         $errors['success'] = 'false';
         $errors['problem'][] = 'Группа не найдена.';
      } else {
         $errors['success'] = 'true';

         $pingHistory = new PingHistory();
         $groupHistory = $pingHistory->getByGroupId($group_id);
         $groupHistory = $this->unserializeResultArray($groupHistory);
         ob_start();      
         app()->view->show('show-history-all',['allHistory'=>$groupHistory]);
         $errors['result'] = ob_get_clean();
      }
      echo json_encode($errors);

   }

   public function showip() {
      $ip_id = (is_numeric($_POST['ip_id']) && IpServer::checkIdExist($_POST['ip_id'])) ? $_POST['ip_id'] : 0; 
      if ($ip_id === 0) return false;

      $pingHistory = new PingHistory();
      $ipHistory = $pingHistory->getById($ip_id);
      app()->view->show('show-history-by-ip',['ipHistory'=>$ipHistory]);
   }

   public function add($ip_id,$pingResult) {
      $ip_id = (is_numeric($ip_id) && IpServer::checkIdExist($ip_id)) ? $ip_id : 0; 
      $pingResult = strlen($pingResult>0) ? $pingResult : "";
      if ($ip_id == 0 || strlen($pingResult) == 0) return false;

      $pingHistory = new PingHistory();
      $pingHistory->add($ip_id,$pingResult);
   }

   public function all() {
      $pingHistory = new PingHistory();
      $allHistory = $pingHistory->getAll();
      $allHistory = $this->unserializeResultArray($allHistory);
      app()->view->show('show-history-all',['allHistory'=>$allHistory]);
   }
}