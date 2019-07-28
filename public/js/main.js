// Обновляем список групп
function updateGroupList() {
   $.ajax({
      method: "GET",
      url: "group/showlist",
    })
   .done(function( rslt ) {
      $(".js-group-list").html(rslt);
   });
}

// Обновить всю историю 
function updateHistoryList() {
   $.ajax({
      method: "GET",
      url: "history/all",
    })
   .done(function( rslt ) {
      $(".js-history-list").html(rslt);
   });
}
 
$(document).ready(function() {

   // Контейнер групп
   var groupContainer = $(".js-group-list");
   // Контейнер истории
   var historyContainer = $(".js-history-list");

   // Маска для ip
   $('.ip_address').mask('099.099.099.099');

   // Добавляем список групп при загрузке страницы
   updateGroupList();

   // Добавляем всю историю при загрузке страницы
   updateHistoryList();

   // Обновить историю
   $(".js-refresh-history").on("click", function() {
      historyContainer.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
      setTimeout(updateHistoryList, 200);
   })

   // Показать историю группы
   groupContainer.on("click", ".js-show-group-history", function () {
      var groupid = $(this).closest(".item").data('id');

      $.ajax({
         method: "POST",
         url: "history/group",
         data: { group_id: groupid } ,
         dataType: "json",
         beforeSend : function(){ 
            groupContainer.fadeTo('fast',.6);
            groupContainer.append('<div id="overlay" style="position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
            historyContainer.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
         },
         
      }).done(function(rslt) {
         historyContainer.html(rslt.result);
         groupContainer.fadeTo('fast',1);
         groupContainer.find("#overlay").remove();
      });
   })

   // Показать Ip's в группе
   groupContainer.on("click", ".js-show-ips", function () {
      var item = $(this).closest(".item");
      if (item.next(".child-ip-box").css("display") == "block") {
         item.next(".child-ip-box").hide(100);
      } else {
         item.next(".child-ip-box").show(100);
      }
     

   })

   // Форма добавить группу
   $(".addGroupForm").on("submit",function(e) {
      e.preventDefault();
      var dialogform = $(this);
      var activebtn = dialogform.find(".btn-js-add-group");
      var dialogbox = dialogform.closest("#add-group-modal");

      $.ajax({
         method: "POST",
         url: "group/add",
         data: dialogform.serialize(),
         dataType: "json",
         beforeSend : function(){
            activebtn.prop("disabled", true);
            activebtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
         },
      })
      .done(function( rslt ) {
         activebtn.prop("disabled", false);
         activebtn.html('Добавить');
         if (rslt.success == "true") {
            dialogform.find("input").val("");
            dialogbox.modal('hide');
            groupContainer.append(rslt.result);
         } else if(rslt.success == "false"){
            
         }
      });
   });

   // Перед вызовом окна удаления группы пробрасываем id в форму
   $(".js-group-list").on("click", ".js-delete-group-item", function() {
       var elementId = $(this).closest('.item').data('id');
       $(".js-delete-group-item-btn").data('id', elementId);
   })

   // Удаление группы
   $(".js-delete-group-item-btn").on("click", function(e) {
      e.preventDefault();
       var elementId = $(this).data('id');
       var activebtn = $(this);
       var dialogbox = $(this).closest("#delete-group-modal");
       $.ajax({
         method: "POST",
         url: "group/delete",
         data: { id: elementId } ,
         dataType: "json",
         beforeSend : function(){
            activebtn.prop("disabled", true);
            activebtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
         },
      })
      .done(function( rslt ) {
         activebtn.prop("disabled", false);
         activebtn.html('Удалить');
         if (rslt.success == "true") {
            dialogbox.modal('hide');
            groupContainer.find(".item[data-id='"+elementId+"']").closest(".group-item-box").remove();
            updateHistoryList();
         } else if(rslt.success == "false"){
            
         }
      });
   })

   // Перед вызовом окна добавления ip - пробрасываем group_id в форму
   groupContainer.on("click", ".js-add-ip", function() {
      var groupId = $(this).closest('.item').data('id');
      $(".addIpForm input[name='group_id']").val(groupId);
   })

   // Кнопка добавить ip адрес к группе
   $(".addIpForm").on("submit",function(e) {
      e.preventDefault();
      var dialogform = $(this);
      var activebtn = dialogform.find(".btn-js-add-ip");
      var dialogbox = dialogform.closest("#add-ip-modal");
      var group_id = dialogform.find("input[name='group_id']").val();
     
      $.ajax({
         method: "POST",
         url: "ip/add",
         data: dialogform.serialize(),
         dataType: "json",
         beforeSend : function(){
            activebtn.prop("disabled", true);
            activebtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
         },
      })
      .done(function( rslt ) {
         activebtn.prop("disabled", false);
         activebtn.html('Добавить');
         if (rslt.success == "true") {
            dialogform.find("input[name='ip']").val("");
            dialogbox.modal('hide');            
            if ($(".list-group-item[data-id='"+group_id+"']").next(".child-ip-box").css('display')=="none") {
               $(".list-group-item[data-id='"+group_id+"']").next(".child-ip-box").show(100);
            }
            $(".list-group-item[data-id='"+group_id+"']").next(".child-ip-box").append(rslt.result);
         };
      });
   });

   // Перед вызовом окна удаления IP пробрасываем id в форму
   groupContainer.on("click", ".js-delete-ip-item", function() {
      var elementId = $(this).closest('.child-item').data('id');
      $(".js-delete-ip-item-btn").data('id', elementId);
   })

   // Удаление IP
   $(".js-delete-ip-item-btn").on("click", function() {
      var elementId = $(this).data('id');
      var activebtn = $(this);
      var dialogbox = $(this).closest("#delete-ip-modal");
      $.ajax({
         method: "POST",
         url: "ip/delete",
         data: { id: elementId } ,
         dataType: "json",
         beforeSend : function(){
            activebtn.prop("disabled", true);
            activebtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
         },
      })
      .done(function( rslt ) {
         activebtn.prop("disabled", false);
         activebtn.html('Удалить');
         if (rslt.success == "true") {
            dialogbox.modal('hide');
            groupContainer.find(".child-item[data-id='"+elementId+"']").remove();
            updateHistoryList();
         } else if(rslt.success == "false"){
            
         }
      });
   })

   // Пинг ip
   groupContainer.on("click" , ".js-ip-ping", function() {
      var ipid = $(this).closest(".child-item").data("id");
      var modal = $("#ping-result");
      $.ajax({
         method: "POST",
         url: "ip/ping",
         data: { id: ipid } ,
         dataType: "json",
         beforeSend : function(){ 
            groupContainer.fadeTo('fast',.6);
            groupContainer.append('<div id="overlay" style="position: absolute;top:0;left:0;width: 100%;height:100%;z-index:2;opacity:0.4;filter: alpha(opacity = 50)"></div>');
            historyContainer.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>');
         },
         success : function(rslt) {
            updateHistoryList();
            groupContainer.fadeTo('fast',1);
            groupContainer.find("#overlay").remove();
            modal.modal('show');
            modal.find('.modal-body').html(rslt.result);
         }
      });
   })

   // Получить историю группы CSV
   groupContainer.on("click" , ".js-get-group-history", function() {
      var groupId = $(this).closest('.item').data('id');
      var modalbox = $("#csv-group-history");
      $.ajax({
         method: "POST",
         url: "csv/group",
         data: { id: groupId } ,
         dataType: "json",
         beforeSend : function(){ 
            
         },
         success : function(rslt) {
            if (rslt.success == "true") {
               modalbox.find(".modal-body").html('<a href="'+rslt.url+'">'+rslt.url+'</a>');
            } else if  (rslt.success == "false") {
               modalbox.find(".modal-body").html('<p>'+rslt.problem[0]+'</p>');
            }
         }
      });
   })
 
})