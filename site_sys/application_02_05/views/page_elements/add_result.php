<? 
 
// если не менеджер и есть в наличии то остальное не ищем
   if(!isset($_SESSION['manager']) and sizeof($result)>0   ) {}
   else{ 
 if(!isset($s_ukr)){                   
if(sizeof($result_add['sup'])>0 or sizeof($result_add['sup_analog'])>0 ){?>
<br><h3>Под заказ</h3>
 <br>
<table class="big_table table">
<thead>
    <tr>
        <th class="marking">
             Артикул
        </th>
        <? if(isset($_SESSION['manager'])) {?><th class="maker"> Поставщик </th> <?}?>
         
          <th class="maker"> Производитель </th> 
         <th class="maker"> Описание </th> 
         <th class="maker"> Срок поставки </th> 
         <th class="maker"> к-во </th> 
         <th class="price">
         <?=$_SESSION['valuta']?> </th>

         <th width="40px"> </th>

    </tr>
</thead>

    <tbody>
    <? $count2=0;
    if(!isset($no_art)){$no_art=0;}
    $group='';
    foreach($result_add['sup'] as $val){
        $count2++;
          ?>

    <tr  class="table_check_row_prepare">
        
         <td>
            <?=$val['product']?>
        </td>
        <? if(isset($_SESSION['manager'])) {?> <td>
            <?=$val['cod']?>
        </td> <?}?>
       
        <td><?=$val['producer']?></td>
        <td><?=$val['desc']?></td>
        <td><?=$val['post_1']?> - <?=$val['post_2']?></td>              
        <td><?=$val['count']?></td>
          
         <td class="numeric">
       <?=get_price_ukr($val,$this->conf['kurs'],$this->conf['discont'])?>
       
        </td>

                                             <td class="f_buy">
                                
                                     <input type="hidden" name='id_ukr_<?=$count2?>'  id='id_ukr_<?=$count2?>' value='<?=$val['id']?>'>
                                     <input type="hidden" name='price_ukr_<?=$count2?>'  id='price_ukr_<?=$count2?>' value='<?=get_price_ukr($val,$this->conf['kurs'],$this->conf['discont'])?>'>
                                     <input type="hidden" name='text_ukr_<?=$count2?>'  id='text_ukr_<?=$count2?>'
                                      value='<?echo str_replace("'",'',$val['product'].' '.$val['producer'].' '.$val['desc'])?>'>
                                      <input type="hidden" name='amount_ukr_<?=$count2?>'  id='amount_ukr_<?=$count2?>' value='<?=$val['count']?>'>
                                     <a title="" href="#" onclick='Show_add_block(<?=$count2?>,"ukr");return false' class="edit_ico"></a></td>
                                     
        
        

    </tr>
     
         
    <?}?>

<?if(sizeof($result_add['sup_analog'])>0){?> <tr>
         <td colspan="8" class="table_check_row">
         <b>АНАЛОГИ</b>
        </td>    </tr>
    <?  
    foreach($result_add['sup_analog'] as $val){
        
        $count2++;
          ?>

    <tr  class="table_check_row_prepare">
        
         <td>
            <?=$val['product']?>
        </td>
                <? if(isset($_SESSION['manager'])) {?> <td>
            <?=$val['cod']?>
        </td> <?}?>
        <td><?=$val['producer']?></td>
        <td><?=$val['desc']?></td>
         <td><?=$val['post_1']?> - <?=$val['post_2']?></td>      
        <td><?=$val['count']?></td>
          
         <td class="numeric">
       <?=get_price_ukr($val,$this->conf['kurs'],$this->conf['discont'])?>
        </td>

         
                                             <td class="f_buy">
                                
                                     <input type="hidden" name='id_ukr_<?=$count2?>'  id='id_ukr_<?=$count2?>' value='<?=$val['id']?>'>
                                     <input type="hidden" name='price_ukr_<?=$count2?>'  id='price_ukr_<?=$count2?>' value='<?=get_price_ukr($val,$this->conf['kurs'],$this->conf['discont'])?>'>
                                     <input type="hidden" name='text_ukr_<?=$count2?>'  id='text_ukr_<?=$count2?>'
                                      value='<?echo str_replace("'",'',$val['product'].' '.$val['producer'].' '.$val['desc'])?>'>
                                      <input type="hidden" name='amount_ukr_<?=$count2?>'  id='amount_ukr_<?=$count2?>' value='<?=$val['count']?>'>
                                     <a title="" href="#" onclick='Show_add_block(<?=$count2?>,"ukr");return false' class="edit_ico"></a></td>

    </tr>
 
    <?}?>        
        
<?}?>    
   
    </tbody>
</table>  
<?}?>
<?}?>

 <?if(!isset($s_emir)){   ?>
<br>
 <div align="center" id='mp_res'><h3>Подождите. Идет поиск по дальнему заказу.</h3>
 <br>
 <img src="/i/ajax.gif" alt="">
 </div>
                        
                        
<script type="text/javascript" >
$(document).ready(function(){
  $.post("/catalog/ajax_find_mp", { DetailNum: "<?=$code_key?>"  },
  function(data){
    $('#mp_res').html(data);
  } );
});

</script>
<?}?> 
<?}?> 