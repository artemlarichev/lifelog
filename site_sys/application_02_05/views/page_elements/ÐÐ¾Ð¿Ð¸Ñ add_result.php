<?

if(sizeof($result_add['sup'])>0 or sizeof($result_add['sup_analog'])>0 ){?>
<br><h3>Под заказ</h3>
 <br>
<table class="big_table table">
<thead>
    <tr>
        <th class="marking">
             Артикул
        </th>
         <th class="maker"> Поставщик </th>
          <th class="maker"> Производитель </th> 
         <th class="maker"> Описание </th> 
         <th class="maker"> Срок поставки </th> 
         <th class="maker"> к-во </th> 
         <th class="price">
         <?=$_SESSION['valuta']?> </th>

         <th width="40px"><input type="submit" value="Купить" id="buy" name="buy" onclick='BuyUkraine()'></th>

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
        <td>
            <?=$val['cod']?>
        </td>
        <td><?=$val['producer']?></td>
        <td><?=$val['desc']?></td>
        <td><?=$val['post_1']?> - <?=$val['post_2']?></td>              
        <td><?=$val['count']?></td>
          
         <td class="numeric">
       <?=get_price_ukr($val,$this->conf['kurs'],$this->conf['discont'])?>
       
        </td>

         <td class="f_buy">
         <input type="text" name='2count_<?=$count2?>'  id='2count_<?=$count2?>' style='padding-right:1px'>
         <input type="hidden" name='2id_<?=$count2?>'  id='2id_<?=$count2?>' value='<?=$val['id']?>'>
          
         <input type="hidden" name='2amount_<?=$count2?>'  id='2amount_<?=$count2?>' value='<?=$val['count']?>'>
         

    </tr>
     
         
    <?}?>

<?if(sizeof($result_add['sup_analog'])>0){?>
         <td colspan="8" class="table_check_row">
         <b>АНАЛОГИ</b>
        </td>   
    <?  
    foreach($result_add['sup_analog'] as $val){
        
        $count2++;
          ?>

    <tr  class="table_check_row_prepare">
        
         <td>
            <?=$val['product']?>
        </td>
        <td>
            <?=$val['cod']?>
        </td>
        <td><?=$val['producer']?></td>
        <td><?=$val['desc']?></td>
         <td><?=$val['post_1']?> - <?=$val['post_2']?></td>      
        <td><?=$val['count']?></td>
          
         <td class="numeric">
       <?=get_price_ukr($val,$this->conf['kurs'],$this->conf['discont'])?>
        </td>

         <td class="f_buy">
         <input type="text" name='2count_<?=$count2?>'  id='2count_<?=$count2?>' style='padding-right:1px'>
         <input type="hidden" name='2id_<?=$count2?>'  id='2id_<?=$count2?>' value='<?=$val['id']?>'>
          
         <input type="hidden" name='2amount_<?=$count2?>'  id='2amount_<?=$count2?>' value='<?=$val['count']?>'>
         

    </tr>
 
    <?}?>        
        
<?}?>    
    <tr>  <td colspan=7 stlyle="text-align:left"></td><td><input type="submit" value="Купить" id="buy" name="buy" onclick='BuyUkraine()'></td></tr>
    </tbody>
</table> 
<?}?>
				
 <?if(sizeof($result_add['emir'])>0 or sizeof($result_add['emir_analog'])>0){?>
<br><h3>Дальний заказ</h3>
<br>

<table class="big_table table">
			<thead>
				<tr>
					<th class="marking">
						 Артикул
					</th>
					 <th class="maker"> Поставщик </th>
                      <th class="maker"> Производитель </th> 
                     <th class="maker"> Описание </th> 
                     <th class="maker"> к-во </th> 
                     <th class="price">
					 <?=$_SESSION['valuta']?> </th>

					 

				</tr>
			</thead>

			<tbody>
			<? 
            foreach($result_add['emir'] as $val){
			 
				  ?>

				<tr  class="table_check_row_prepare">
					
					<td>
                        <?=$val['DetailNum']?>
                    </td>
                    <td>
                        <?=$val['PriceLogo']?>
                    </td>
                    <td><?=$val['name']?></td>
                    <td><?=$val['DetailName']?></td>
                     <td><? if($val['Quantity']>0) echo $val['Quantity'];else echo "-";?></td>
					 
					<td class="numeric">
                    <?if($_SESSION['valuta']==USD) 
                    print get_price_emir($val,1,$conf['discont'],$conf['emir_disc']);
                    else 
                    print get_price_emir($val,$conf['kurs'],$conf['discont'],$conf['emir_disc']);
                    ?>

					 
				</tr>
 
				<?}?>
	
<? 
if(sizeof($result_add['emir_analog'])>0){?>
         <td colspan="8" class="table_check_row">
         <b>АНАЛОГИ</b>
        </td>   
    <?  
    foreach($result_add['emir_analog'] as $val){
    ?>

                     <tr  class="table_check_row_prepare">
                    
                    <td>
                        <?=$val['DetailNum']?>
                    </td>
                    <td>
                        MEGAPARTS
                    </td>
                    <td><?=$val['name']?></td>
                    <td><?=$val['DetailName']?></td>
                    <td><? if($val['Quantity']>0) echo $val['Quantity'];else echo "-";?></td>
                     
                    <td class="numeric">
                    <?if($_SESSION['valuta']==USD) 
                    print get_price_emir($val,1,$conf['discont'],$conf['emir_disc']);
                    else 
                    print get_price_emir($val,$conf['kurs'],$conf['discont'],$conf['emir_disc']);
                    ?>
                    
                    </td>

                     
                </tr>
 
    <?}?>   <?}?>			 
			</tbody>
		</table>
        <?}?>
                        
                        
<script type="text/javascript" >var p_count2='<?=$count2?>';//'</script>