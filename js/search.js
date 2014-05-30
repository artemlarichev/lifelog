
   function manager_help()
   {

    $(".red_border").removeClass('red_border'); 
       if($("#full_name").val()=='') {
           $("#full_name").addClass('red_border');
           return false;
       };
       
     if($("#phone_num").val()=='') {
           $("#phone_num").addClass('red_border');
           return false;
       };
       
     if($("#email").val()=='') {
           $("#email").addClass('red_border');
           return false;
       };
       
        
       $.post("/catalog/ajax_manager_help/",{
            full_name:$("#full_name").val(),
            email:$("#email").val(),
            phone_num:$("#phone_num").val(),
            vin_code:$("#vin_code").val(),
            num_carcass:$("#num_carcass").val(),
            sel_transmission:$("#sel_transmission").val(),
            volume_motor:$("#volume_motor").val(),
            sel_type_fuel:$("#sel_type_fuel").val(),
            type_carcass:$("#type_carcass").val(),
            text:$("#text").val(),
            sel_year:$("#sel_year").val(),
            car_model:$("#car_model").val(),
            sel_brand:$("#sel_brand").val() 
     },function(data){
        $("#ul_help").html('<li class="form_h_item">Ваш запрос отправлен. В ближайшее время наш менеджер свяжится с вами.</li>')

        });
       $("#bbb").html('<img src="/i/loader.gif">')     ;
   }

function key(type)
{

 if(event.keyCode==13)Search(type);
}

function findRandKey(key)
{
    $("#search_field").val(key);
    Search('code');
}

 function SelType(type)
 {
  $("#link_code").removeClass("mark");
  $("#link_auto").removeClass("mark");
  $("#link_group").removeClass("mark");

    $("#div_code").hide();
    $("#div_group").hide();
    $("#div_auto").hide();
    $("#div_history").hide();
   $("#link_"+type).addClass("mark");
    $("#div_"+type).show();
 }

 function Search(type)
 {   var cod =$("#search_field").val();
                  
   var only=0;    
   var s_ukr=0;    
   var s_sklad=0;    
   var s_emir=0;                          
 if($('#only').is(':checked') ) only=1; 
 if($('#s_ukr').is(':checked') ) s_ukr=1; 
 if($('#s_sklad').is(':checked') ) s_sklad=1; 
 if($('#s_emir').is(':checked') ) s_emir=1; 
 	  if(type=='code' & cod.length<3) {alert('Введите минимум 3 символа для поиска!');return false;};
 	  $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
		 $.post("/catalog/ajax_search/"+type+'/',{
		code:$("#search_field").val(), 
        only_key:only,
        ukr:s_ukr,
        sklad:s_sklad,
        emir:s_emir,    
		code_group:$("#search_field_group").val(),
		group:$("#cat1").val(),
		group_1:$("#cat2").val(),
		group_2:$("#cat3").val()
	 },function(data){
  	  $.unblockUI();
  	  if(data=='0') {
  	  $(".main_row").html('<div class="export_result"><span class="fail">Ваш запрос не дал результатов</span></div>');
;}
  	  else {document.location.href = "/search/result/"+data;}
  	  });
  }


   function Change_1()
   {
	$("#cat2").attr("disabled","disabled");
	$("#cat3").attr("disabled","disabled");
   	$("#cat2").empty();
   	$("#cat3").empty();
   	$("#cat2").append( $('<option value=""></option>'));
   	$.post("/catalog/ajax_group/1/",{
    group:$("#cat1").val(),
	 },function(data){
       if(data=='0'){}
       else
       {
       	  var obj = $.evalJSON(data);
       	  var size=0;
		   for(key in obj)
		   {
		   size=size+1;
		   $("#cat2").append( $('<option value="'+obj[key] +'">' + obj[key] + '</option>'));

           }
          $("#cat2").attr("disabled","");
       }

  	  });

   }


   function Change_2()
   {

	$("#cat3").attr("disabled","disabled");
   	$("#cat3").empty();
   	$("#cat3").append( $('<option value=""></option>'));
   	$.post("/catalog/ajax_group/2/",{
    group:$("#cat1").val(),
    group_1:$("#cat2").val()
	 },function(data){
       if(data=='0'){}
       else
       {
       	  var obj = $.evalJSON(data);
       	  var size=0;
		   for(key in obj)
		   {
		   size=size+1;
		   $("#cat3").append( $('<option value="'+obj[key] +'">' + obj[key] + '</option>'));

           }
          $("#cat3").attr("disabled","");
       }

  	  });

   }

$(function () {
			var tab_butt = $('.search_t_item');
			var tab_wrap = $('.search_w_item');

			tab_butt.bind('click', function () {
				var tab = $(this), tab_index = tab.attr("data-search-tab");
				if (tab.hasClass('selected')) {

				}
				else {
					tab_butt.removeClass('selected');
					tab.addClass('selected');
					tab_wrap.removeClass('selected');
					$('.search_w_item[data-search-wrap = ' + tab_index + ']').addClass('selected');
				}
			})
		});