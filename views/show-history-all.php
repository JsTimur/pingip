<div class="history-list">
   <?php
   if (isset($allHistory)) {
      if (count($allHistory)>0) {
         foreach ($allHistory as $item){
            require(__DIR__.DIRECTORY_SEPARATOR.'show-history-item.php');
         }
      } else {
         ?>
         <p>Данных пока нет.</p>
         <?php
      }
   }
   ?>
</div>