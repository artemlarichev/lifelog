<?session_start();
header('Content-Type: text/html; charset=UTF-8');
?>

 function SubmitLink(url,id)
 {
       $("#"+id).html('<img src="/i/loader.gif">') ;     
      $.post(url,{
            data:'' },function(data){
                
                $("#"+id).html(data) ;
            });   
 }
 
 
 function Show_add_block_sclad(num)
 {
    if ($("#add_block_"+num).is(":hidden")) {
                                 $("#add_block_"+num).show();
                        } else {
                               $("#add_block_"+num).hide();
                        }

 }
 

function Show_add_block(num,type)
{
    if(type=='ukr' ){
    
    $('.hide_element').hide();
    
    }else{
    
    $('.hide_element').show();
    }

popup_size();
$('.order_box_w').fadeIn();
    $('.wrapper').addClass('opacity');

         $('#obf_title').html($('#text_'+type+'_'+num).val());
        $('#part_id').val($('#id_'+type+'_'+num).val());
        $('#part_type').val(type);
        $('#part_num').val(num);
        $('#part_price').val($('#price_'+type+'_'+num).val());
        $('#obf_summ').html($('#price_'+type+'_'+num).val());

        $('#bitOnly').removeAttr("checked");
        $('#OnlyThisBrand').removeAttr("checked");
        $('#bitAgree').removeAttr("checked");
        $('#bitWait').removeAttr("checked");
       // $('#bitAgree').attr("checked","checked"); 
       // $('#bitWait').attr("checked","checked");

   
}

function AddToBassNew()
{
   
   var gropData = {};
   var add1='';
    var add2='';
    var add3='';
    var add4='';
    var add5='';
    var type='0_sklad';
    
    if($('#part_type').val()=='ukr' ){
    type='1_ukr';
   
    }
    if($('#part_type').val()=='mp' ){
   
    
    
    type='2_mp';
    }
    
    $('.wrapper').removeClass('opacity');

    
    $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});     
           if($('#bitOnly').is(':checked')) {add1=1;}else{ add1='';}
           if($('#OnlyThisBrand').is(':checked')) {add2=1;}else{ add2='';}
           if($('#bitAgree').is(':checked')) {add4=1;}else{ add3='';}
           if($('#bitWait').is(':checked')) {add5=1;}else{ add4='';}


           gropData[0] = {
                "id":$('#part_id').val(),    
                "type":type,
                "price":$('#part_price').val(),
                "add1":add1,"add2":add2,"add3":add3,"add4":add4,"add5":add5,
                "count":$('#obf_count').val()*1
             };
           $.post(" /catalog/add_to_basket/",{
            data: $.toJSON(gropData) },function(data){
               $.unblockUI();
                $("#basket_block").html(data) ;
            });   

    }



function RefreshPrice()
{
 $('#obf_summ').html($('#price_'+$('#part_type').val()+'_'+$('#part_num').val()).val()*$('#obf_count').val());
}

function Buy(number)
{
if( $('#count_'+number).val()>0 ){}else {$('#count_'+number).focus(); return false; }
var gropData = {};
var amount_=0;
var cnt=0;
var hidden=0;
var add1='';
var add2='';
var add3='';
var add4='';
var add5='';
$.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});

for (var num = 1; num < p_count+1; num++)
{
if( $('#count_'+num).val()>0 )
{
amount=$('#amount_'+num).val()*1;
cnt =  $('#count_'+num).val()*1;
 
	       if($('#add1_'+num).is(':checked')) {add1=1;}else{ add1='';}
	       if($('#add2_'+num).is(':checked')) {add2=1;}else{ add2='';}
	       if($('#add3_'+num).is(':checked')) {add3=1;}else{ add3='';}
	       if($('#add4_'+num).is(':checked')) {add4=1;}else{ add4='';}
	       if($('#add5_'+num).is(':checked')) {add5=1;}else{ add5='';}
          
   			 gropData[num] = {
	            "id":$('#id_'+num).val(),
                "type":'0_sklad',
                "hidden":$('#hiden_'+num).val(),
	            "add1":add1,"add2":add2,"add3":add3,"add4":add4,"add5":add5,
	            "count":$('#count_'+num).val()
             };
           $('#count_'+num).val('');
 	}
 }


	 $.post(" /catalog/add_to_basket/",{
			data: $.toJSON(gropData) },function(data){
		 	  $.unblockUI();
	  	      $("#basket_block").html(data) ;
	  	  });
}
 


  var f_id='';
   function Change_group_1()
   {
	$("#group_1").attr("disabled","disabled");
	$("#group_2").attr("disabled","disabled");
   	$("#group_1").empty();
   	$("#group_2").empty();
   	$.post("/catalog/ajax_group/1/",{
    group:$("#group").val(),
    find_id:f_id
	 },function(data){
       if(data=='0'){}
       else
       {
       	  var obj = $.evalJSON(data);
       	  var size=0;
		   for(key in obj)
		   {
		   size=size+1;
		   $("#group_1").append( $('<option value="'+obj[key] +'">' + obj[key] + '</option>'));
 	       }
          $("#group_1").attr("disabled","");

       }

  	  });

   } 

   function Change_group_2()
   {

	$("#group_2").attr("disabled","disabled");
  	$("#group_2").empty();
   	$.post("/catalog/ajax_group/2/",{
    group:$("#group").val(),
    group_1:$("#group_1").val(),
    find_id:f_id
	 },function(data){
       if(data=='0'){}
       else
       {
       	  var obj = $.evalJSON(data);
       	  var size=0;
		   for(key in obj)
		   {
		   size=size+1;
		   $("#group_2").append( $('<option value="'+obj[key] +'">' + obj[key] + '</option>'));
 	       }
          $("#group_2").attr("disabled","");

       }

  	  });

   }

   function SetAddAll(num)
   {
   	if($('#add1_'+num).is(':checked')) {$(".add1").attr("checked", "checked");} else {$(".add1").attr("checked", "");}
   	if($('#add2_'+num).is(':checked')) {$(".add2").attr("checked", "checked");} else {$(".add2").attr("checked", "");}
   	if($('#add3_'+num).is(':checked')) {$(".add3").attr("checked", "checked");} else {$(".add3").attr("checked", "");}
   	if($('#add4_'+num).is(':checked')) {$(".add4").attr("checked", "checked");} else {$(".add4").attr("checked", "");}
   	if($('#add5_'+num).is(':checked')) {$(".add5").attr("checked", "checked");} else {$(".add5").attr("checked", "");}
   }

var balans = <?if (isset($_SESSION['user'])) {
	print((int)($_SESSION['user']['balans'] + $_SESSION['user']['credit']));
} else print(100000000);?> ;
var basket_price=<?=(int)$_SESSION['basket_data']['sum']?>;

 function RefreshOrder()

 {
   var gropData = {};
   var amount_=0;
   var cnt=0;
   var add1='';
   var add2='';
   var add3='';
   var add4='';
   var add5='';
   var price='';
   $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
      
for (var num = 1; num < p_count*1+1; num++)
 {
 var tmp_basket_price=0;
 
  if( $('#count_'+num).val()>=0 )
  	{
  	amount=$('#amount_'+num).val()*1;
  	cnt =  $('#count_'+num).val()*1;


	       if($('#add1_'+num).is(':checked')) {add1=1;}else{ add1='';}
	       if($('#add2_'+num).is(':checked')) {add2=1;}else{ add2='';}
	       if($('#add3_'+num).is(':checked')) {add3=1;}else{ add3='';}
	       if($('#add4_'+num).is(':checked')) {add4=1;}else{ add4='';}
	       if($('#add5_'+num).is(':checked')) {add5=1;}else{ add5='';}
           $('#suma_'+num).html($('#count_'+num).val()*$('#price_'+num).val()) ;
     		 gropData[num] = {
	            "id":$('#id_'+num).val(),
	             "price":$('#price_'+num).val(),

	            "add1":add1,"add2":add2,"add3":add3,"add4":add4,"add5":add5,
	            "count":$('#count_'+num).val()
             };
 	}
 }
         $.post(" /manager/ajax_save_details/"+order_id,{
			data: $.toJSON(gropData) },function(data){
                      //      if(data=='0') alert ('На балансе недостаточно средств!');
                $("#summ2").html(data) ;  basket_price=data;
    	          $("#suma").html(data) ;     $.unblockUI();
       	           $.post(" /catalog/login_box/" ,{data: '' },function(data){$("#login").html(data) ;});

	  	  });


}

 function RefreshUserOrder()

 {
   var gropData = {};
   var amount_=0;
   var cnt=0;
   var add1='';
   var add2='';
   var add3='';
   var add4='';
   var add5='';
   var price='';
   $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});

for (var num = 1; num < p_count+1; num++)
 {
 var tmp_basket_price=0;
  if( $('#count_'+num).val()>=0 )
  	{
  	amount=$('#amount_'+num).val()*1;
  	cnt =  $('#count_'+num).val()*1;
	   if(val_t=='0') {$('#price_uah_'+num).val($('#price_'+num).val());} else
         {$('#price_usd_'+num).val( $('#price_'+num).val());};
	       if($('#add1_'+num).is(':checked')) {add1=1;}else{ add1='';}
	       if($('#add2_'+num).is(':checked')) {add2=1;}else{ add2='';}
	       if($('#add3_'+num).is(':checked')) {add3=1;}else{ add3='';}
	       if($('#add4_'+num).is(':checked')) {add4=1;}else{ add4='';}
	       if($('#add5_'+num).is(':checked')) {add5=1;}else{ add5='';}
           $('#suma_'+num).html($('#count_'+num).val()*$('#price_'+num).val()) ;
     		 gropData[num] = {
	            "id":$('#id_'+num).val(),"type":$('#type_'+num).val(),
	            "add1":add1,"add2":add2,"add3":add3,"add4":add4,"add5":add5,
	            "count":$('#count_'+num).val()
             };
 	}
 }
         $.post(" /client/ajax_save_details/"+order_id,{
			data: $.toJSON(gropData) },function(data){
                            if(data=='0') alert ('На балансе недостаточно средств!');
                $("#summ2").html(data) ;  basket_price=data;
    	          $("#suma").html(data) ;     $.unblockUI();
    	           $.post(" /catalog/login_box/" ,{data: '' },function(data){$("#login").html(data) ;});
	  	  });


}

 function RefreshBasket()
 {
   var gropData = {};
   var amount_=0;
   var cnt=0;
   var add1='';
   var add2='';
   var hidden='';
   var add3='';
   var add4='';
   var add5='';
   var in_order='1';
   $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
  var tmp_basket_price=0;
for (var num = 1; num < (p_count*1+1); num++)
 {
     
  if( $('#count_'+num).val()>= 0 )
  	{
  	amount=$('#amount_'+num).val()*1;
  	cnt =  $('#count_'+num).val()*1;
 

	       if($('#add1_'+num).is(':checked')) {add1=1;}else{ add1='';}
	       if($('#add2_'+num).is(':checked')) {add2=1;}else{ add2='';}
	       if($('#add3_'+num).is(':checked')) {add3=1;}else{ add3='';}
	       if($('#add4_'+num).is(':checked')) {add4=1;}else{ add4='';}
           if($('#add5_'+num).is(':checked')) {add5=1;}else{ add5='';}
           
           if($('#in_order_'+num).is(':checked')) {in_order='1';}else{ in_order='0';} 
           
           $('#suma_'+num).html($('#count_'+num).val()*$('#price_'+num).val()*in_order) ;
           tmp_basket_price=tmp_basket_price+$('#count_'+num).val()*$('#price_'+num).val()*in_order;
   			 gropData[num] = {
	            "id":$('#id_'+num).val(),
                "type":$('#type_'+num).val(),
                "hidden":$('#hiden_'+num).val(),
                "in_order":in_order,
                "add1":add1,"add2":add2,"add3":add3,"add4":add4,"add5":add5,
	            "count":$('#count_'+num).val()
             };
 	}
 }
         $.post(" /catalog/add_to_basket/0",{
			data: $.toJSON(gropData) },function(data){

	  	      $("#basket_block").html(data) ;
    	       $.post(" /catalog/basket_sum/",{ },function(data){ $("#suma2").html(data) ;
    	          $("#suma").html(data) ;
    	          basket_price=tmp_basket_price;
    	          $.unblockUI();});
	  	  });

}




 function SaveOrder()
 {
 
   //Объявляем переменные
   var gropData = {};
   var amount_=0;
   var cnt=0;
   var add1='';
   var add2='';
   var hidden='';
   var add3='';
   var add4='';
   var add5='';
   var in_order='1';
   
   //Если обязательные поля пусты, ставим предупреждение
   if($('#f_n').val()=='') {alert('Заполните контактные даные!');$('#f_n').focus();return false;}
   if($('#tel').val()=='') {alert('Заполните контактные даные!');$('#tel').focus();return false;}
   if($('#mail').val()=='') {alert('Заполните контактные даные!');$('#mail').focus();return false;}  
   
   //Проверяем баланс
   if(basket_price*1>balans*1) {alert('На балансе недостаточно средств!');;return false;}
   
   //Вызываем диалоговое окно
   $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
   var to_mach=0;
   $('.hdd').css('display','none');
   $('#ch_colspan').attr ('colspan',3);
  
   //Перебераем все эллементы на странице
   for (var num = 1; num < p_count+1; num++){
 
     //Если находим эллемент у которого количество больше нуля
     if($('#count_'+num).val()>0 ){
  	
        amount=$('#amount_'+num).val()*1;
  	cnt =  $('#count_'+num).val()*1;
  	 
        $('#nal_'+num).html('');
       
        if(  $('#type_'+num).val()=='0_sklad' ){
        
           if(amount < cnt){
            
            to_mach=1;
  	    $('#nal_'+num).html(amount);

           } 
        }

     //Ставим признаки "отмечено"
     if($('#add1_'+num).is(':checked')) {add1=1;}else{ add1='';}
     if($('#add2_'+num).is(':checked')) {add2=1;}else{ add2='';}
     if($('#add3_'+num).is(':checked')) {add3=1;}else{ add3='';}
     if($('#add4_'+num).is(':checked')) {add4=1;}else{ add4='';}
     if($('#add5_'+num).is(':checked')) {add5=1;}else{ add5='';}
     if($('#in_order_'+num).is(':checked')) {in_order='1';}else{ in_order='0';} 

     //Собираем данные
     gropData[num] = {
	    "id":$('#id_'+num).val(),"type":$('#type_'+num).val(),
            "in_order":in_order,
            "hidden":$('#hiden_'+num).val(),
	    "add1":add1,"add2":add2,"add3":add3,"add4":add4,"add5":add5,
	    "count":$('#count_'+num).val()
         };
    }
  }
  
  //Если количество заказа больше наличия
  if( to_mach>0 ){
    
   $('#ch_colspan').attr ('colspan',4);
   $('.hdd').css('display','');
   alert('Количество заказа больше наличия!');
   $.unblockUI();  return false;

  }

  //если небыл выбран товар
  if($('#suma2').html()*1<1) {alert('Ничего не выбрано!');$.unblockUI();$('#f_n').focus();return false;}

  $.post(" /catalog/add_to_basket/0",{
      data: $.toJSON(gropData),
      f_n:$('#f_n').val(),
      tel:$('#tel').val(),
      comment:$('#comments').val(),
      email:$('#mail').val()
   },function(data){
       if(data=='end'){  //document.location.href = "/client/orders/0/1";}
   
   //$("#basket_block").html(data);
   
   $.post(" /catalog/login_box/" ,{data: '' },function(data){$("#login").html(data) ;});
   //$(".content_row").html(" <b>Ваш заказ принят.</b>");
   $(".basket_res").html(" <b style='margin-left: 50px;'>Ваш заказ принят.</b>");
   $.unblockUI();
   });


}


function Change_group()
{
	document.forms.forma.submit();
}


function sorted_list(id){for(var c=document.getElementById(id),b=c.options,a=0;a<b.length;)
if(b[a+1]&&b[a].text>b[a+1].text){c.insertBefore(b[a+1],b[a]);a=a>=1?a-1:a+1}else a++;
b[0].selected=true };




 function History_Search(key)
 { 

 	  $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
		 $.post("/catalog/ajax_search/code/",{
		code:key,
		code_group:'',
      
		group:'',
		group_1:'',
		group_2:''
	 },function(data){
  	  $.unblockUI();
  	  if(data=='0') {alert('Not found!');return false;}
  	    document.location.href = "/search/result/"+data;
  	  });
  }

 
function ShowTabOrder(id)
{
    $("#order_tab_"+id).toggle();

    if($("#order_tab_"+id).css('display')=='none')
        {$("#show_im_"+id).attr('src','/i/down.png');}
    else
        {$("#show_im_"+id).attr('src','/i/up.png');}
}


function EditStatus(num)
{
    $("#status_val_"+num).show();
    $("#status_name_"+num).hide();
}
function SaveStatus(num)
{   var all=0;
 if($('#all_'+num).is(':checked') ) all=1;
       $("#st_"+num).css('disabled','disabled'); 
             $.post("/manager/ajax_status/",{  
        id:$('#st_id_'+num).val(),
        all:all,
        status:$('#st_'+num).val() 
     },function(data){                           
           $("#status_name_"+num).html($('#st_'+num+' :selected').text()  );  
          $("#st_"+num).css('disabled','');  
       $("#status_val_"+num).hide();
       $("#status_name_"+num).show();
        });

}

function popup_size() {
	var popup = $(".order_box_w"),
			top_h = $(document).scrollTop(),
			window_h = $(window).height(),
			test_h = window_h + top_h;

	var popup_h = popup.height();


	if (popup_h > test_h) {
	}
	else {
		var popup_top = top_h + (window_h - popup_h) / 2;
		popup.css('top', popup_top);
		popup.animate({
			top:popup_top
		}, 400, "linear");
	}
}




$(document).ready(function() {

//$('.f_buy  .edit_ico').toggle(function(){
//	$('.order_box_w').fadeIn();
//	$('.wrapper').addClass('opacity');
//}, function(){
//	$('.order_box_w').fadeOut();
//	$('.wrapper').removeClass('opacity');
//});

$('.ob_close').click(function(){
$('.order_box_w').fadeOut();
$('.wrapper').removeClass('opacity');
})
popup_size();


});
 

$(window).resize(function() {
	popup_size();
});




