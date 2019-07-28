<?php
namespace App\Controllers;

use App\Models\IpServer;
use App\Models\Group;
use App\Models\PingHistory;

class IpServerController {

   public function add() {
      $errors = [];
      $ip = isset($_POST['ip']) ? $_POST['ip'] : "";
      $groupId = isset($_POST['group_id']) && is_numeric($_POST['group_id']) && Group::checkGroupExist($_POST['group_id']) ? $_POST['group_id'] : 0;
 
      if (strlen($ip) == 0 || $groupId == 0) { 
         $errors['success'] = 'false';
         if (strlen($ip) == 0) {
            $errors['problem'][] = 'Укажите корректный ip адрес.';
         } elseif ($groupId == 0) {
            $errors['problem'][] = 'Данной группы не существует.';
         }
      } else {
         $ipServer = new IpServer();
         $lastId = $ipServer->add($ip,$groupId);
         $errors['success'] = 'true';
         $errors['id'] = $lastId;
         ob_start();
         app()->view->show('show-ip',['ip'=>$ipServer->find($lastId)]);
         $errors['result'] = ob_get_clean();
      }
      echo json_encode($errors);      
   }

   public function ping() {
      $errors = [];
      $id = isset($_POST['id']) && is_numeric($_POST['id']) && IpServer::checkIdExist($_POST['id']) ? $_POST['id'] : 0;
      $ping = app()->ping;
      $ipserver = new IpServer;
      $pingHistory = new PingHistory;
      $ipServerItem = $ipserver->find($id);
      $pingResult = serialize($ping->pingIP($ipServerItem['ip']));
      $lastId = $pingHistory->add($id,$pingResult);
      if (!$lastId) {
         $errors['success'] = 'false';
         $errors['problems'][] = 'Не удалось отпинговать IP';
      } else {
            $errors['success'] = 'true';
            $ipHistory = $pingHistory->find($lastId);
            $errors['result'] = implode("<br>", unserialize($ipHistory['hresult']));
      }
      echo json_encode($errors);      
   }
   
   public function delete() {
      $errors = [];
      $id = isset($_POST['id']) && is_numeric($_POST['id']) && IpServer::checkIdExist($_POST['id']) ? $_POST['id'] : 0;
      if ($id == 0)  {
         $errors['success'] = 'false';
         $errors['problem'][] = 'Данный Ip не найден в базе.';
      } else {
         $errors['success'] = 'true';
         $ipServer = new IpServer();
         $ipServer->delete($id);
      }
      echo json_encode($errors);
   }

   public function showListByGroupId() {
      $groupId = isset($_POST['group_id']) && is_numeric($_POST['group_id']) && Group::checkIdExist($_POST['group_id']) ? $_POST['group_id'] : 0;
      if ($groupId == 0) return false; 

      $ipServer = new IpServer();
      $ipServerList = $ipServer->getByGroupId($_POST['group_id']);
      app()->view->show('show-ips',['ips'=>$ipServerList]);
   }

   public function showItem() {
      $id = isset($_POST['id']) && is_numeric($_POST['id']) && IpServer::checkIdExist($_POST['id']) ? $_POST['id'] : 0;
      if ($id == 0) return ""; 

      $ipServer = new IpServer();
      $ipServerItem = $ipServer->find($id);
      app()->view->show('show-ip',['ip'=>$ipServerItem]);
   }
}