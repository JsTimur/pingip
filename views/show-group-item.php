<div class="group-item-box mb-2">
<li class="item list-group-item" data-id="<?=$group['id']?>">
   <i class="fa cursor-pointer fa-chevron-down js-show-ips" title="Показать IP адреса" aria-hidden="true"></i>
   <span><?=$group['gname']?> </span>
   <span class="pull-right">
   <i class="fa cursor-pointer fa-plus-square-o js-add-ip" data-toggle="modal" title="Добавить IP адрес" data-target="#add-ip-modal" aria-hidden="true"></i>
   <i class="fa cursor-pointer fa-bars js-show-group-history" aria-hidden="true" title="Отобразить историю группы"></i>
   <i class="fa cursor-pointer fa-list-alt js-get-group-history" aria-hidden="true" title="Скачать CSV" data-target="#csv-group-history" data-toggle="modal"></i>
   <i class="fa cursor-pointer fa-trash-o js-delete-group-item" title="Удалить группу" data-toggle="modal" data-target="#delete-group-modal"   aria-hidden="true"></i>  
   </span>
</li>
<div class="child-ip-box">
<?php
if (isset($group['childsCount'])) {
   if ($group['childsCount']>0) {
      foreach ($group['childs'] as $ip) {
            require(__DIR__.DIRECTORY_SEPARATOR.'show-ip.php');
      }
   } 
}
?>
</div>
</div>