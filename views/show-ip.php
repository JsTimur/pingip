<li  class="child-item list-group-item py-1 pl-5" data-groupid="<?=$ip['group_id']?>"  data-id="<?=$ip['id']?>">
      <span>IP: <?=$ip['ip']?> </span>
      <span class="pull-right">
        <span><i class="fa fa-bolt js-ip-ping cursor-pointer" title="Пинг IP" aria-hidden="true"></i> </span>
        <i class="fa fa-trash-o js-delete-ip-item cursor-pointer" title="Удалить IP"  data-toggle="modal" data-target="#delete-ip-modal" aria-hidden="true"></i>  
      </span>
</li>