<?php
namespace App\Controllers;

use App\Models\Group;
use App\Models\IpServer;

class GroupController {

   public function add() {
      $errors = [];
      $gname = isset($_POST['gname']) && strlen($_POST['gname'])>0 ? $_POST['gname'] : '';
      $parent =  0;
      if (isset($_POST['parent']) && is_numeric($_POST['parent']) && Group::checkGroupExist($parent)) { 
         $parent = $_POST['parent'];
      };
      if (strlen($gname) == 0) {
         $errors['name'] = "Укажите корректное название.";
      }
      if (count($errors)>0) {
         $errors['success'] = 'false';
         echo json_encode($errors);
      } else {
         $group = new Group;
         $lastId = $group->add($gname,$parent);
         if (!$lastId) {  
            $errors['success'] = 'false';
            $errors['problems'][] = 'Не удалось создать группу.';
         } else {
            $errors['success'] = 'true';
            ob_start();
            app()->view->show('show-group-item',['group'=>$group->find($lastId)]);
            $errors['result'] = ob_get_clean();
            echo json_encode($errors);
         }
      }
       
   }

   public function delete() {
      $errors = [];
      $id = isset($_POST['id']) && is_numeric($_POST['id']) && Group::checkGroupExist($_POST['id']) ? $_POST['id'] : 0;
      
      if ($id == 0) { 
         $errors['success'] = 'false'; 
      } else {
         $group = new Group;
         $group->delete($id);
         $errors['success'] = 'true';
      }
      echo json_encode($errors);
   }

   public function showlist() {
      $group = new Group;
      if (!$groups = $group->getAll()) { return false; }

      foreach ($groups as $k=>$v) {
         if ($childs = (new IpServer)->getByGroupId($groups[$k]['id'])) {
            $groups[$k]['childs'] = $childs;
            $groups[$k]['childsCount'] = count($childs);
         } else {
            $groups[$k]['childs'] = [];
            $groups[$k]['childsCount'] = 0;
         }
      }
      app()->view->show('show-groups',['groups'=>$groups]);
   }
}