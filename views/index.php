<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Ping ip</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
   <link rel="stylesheet" href="css/font-awesome.css" >
   <link rel="stylesheet" href="css/main.css">
</head>
<body>

<div class="content m-5">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-6">
          <p class="h4">Группы 
             <i class="fa fa-plus-square-o js-add-group cursor-pointer" title="Добавить группу" data-toggle="modal" data-target="#add-group-modal" aria-hidden="true"></i>
          </p>
          <div class="js-group-list list-group"></div>
         </div>
         <div class="col-md-6">
          <p class="h4">История
          <i class="fa fa-refresh js-refresh-history cursor-pointer" title="Обновить историю" aria-hidden="true"></i>
          </p>
          <div class="js-history-list"></div>
         </div>
      </div>
   </div>
</div>

<?php
require_once(__DIR__.DIRECTORY_SEPARATOR.'show-forms.php');
?>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="js/jquery.mask.js"></script>
<script src="js/main.js"></script>

</body>
</html>