<?php
   if (count($groups)>0) {
     foreach ($groups as $group) {
        require(__DIR__.DIRECTORY_SEPARATOR.'show-group-item.php');
     }
   }
?>
 