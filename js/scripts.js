
 function Show_add_block(num)
 {
    $("#add_block_"+num).show();

 }


   function Change_group_1()
   {
	$("#group_1").attr("disabled","disabled");
	$("#group_2").attr("disabled","disabled");
   	$("#group_1").empty();
   	$("#group_2").empty();
   	$.post("/catalog/ajax_group/1/",{
    group:$("#cat1").val(),
    find_id:<?if(isset($s_id)){print($s_id);}else{print(0);}?>
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

