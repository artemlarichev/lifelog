<?
$fields=$this->config->item('fields');
$fields_keys=array_keys($fields);
if(strlen($_SESSION['manager'])>3) {$user_fields=explode(',',$_SESSION['manager']);} else {$user_fields=array();}
?>

<a href='#' onclick="ShawEdFoto();return false">Привязка фото</a>
				<h2>В наличии</h2><table class="big_table table">
							<thead>
								<tr>
								<?if(sizeof($user_fields)>0){
									foreach($user_fields as $field){?>
                                   <th ><?=$fields[$field]?></th>
                                    <?}?>

                                <?}else{?>

									<th class="marking">
										 Артикул
									</th>
									 <th class="maker"> Производитель </th>
									 <th class="important">  Описание автомобиля </th>
									 <th class="price"><?=$_SESSION['valuta']?>. </th>
									 <th class="col"> шт. </th>



								<?}?>   
<th style="width: 40px;" >Фото</th> 
<th style="width: 60px;" class="hdn" >Привязка<br>
                                                                                                          
                                    <button id='select_all' >Все</button>      <br><br>
                                    <button onclick="SaveFoto();return false" >Сохранить</button>    
                                    
 </th> 
                                <th > </th> 
								</tr>
							</thead>

							<tbody>
							<? $count=0;
							$group='';
							foreach($result as $val){
								$count++;
								$cu_group=$val['group'];
								if(!($val['group_1']=='')) {$cu_group.=' » '.$val['group_1'];}
								if(!($val['group_2']=='')) {$cu_group.=' » '.$val['group_2'];}
								if(!($group==$cu_group))
								{
									$group=$cu_group;
								?>
							<tr>
									<td class="table_hline_row" colspan="22">
										<h2 class="table_hline"><?=$group?></h2>
									</td>
								</tr>

							<?}

							 ?>
                                <tr  class="table_check_row_prepare">
                                <?if(sizeof($user_fields)>0){
									foreach($user_fields as $field){
                                    if($field=='article'  )
                                    {?><td>
                                     <a title="<?=hide_value(str_replace($search['key'],"<b>{$search['key']}</b>",$val['article']) )?>" href="/parts/<?=$val['id']?>"><?=hide_value(str_replace($search['key'],"<b>{$search['key']}</b>",$val['article']) )?></a></td>
                                     
                                    <?}
                                     elseif($field=='price_uah' or $field=='price_usd')
                                    {
                                                                             if($field=='price_uah'  ){$valuta='грн';}else{$valuta=USD;}
                                     print ("<td>".get_price($val,$valuta,$this->conf['nacenka'])."</td>");
                                    }
                                    elseif($field=='int_inf' and isset($code_key)){
                                        $text = $val[$field];
                                     if(strpos('  '.mb_strtoupper($text),mb_strtoupper($code_key))>0)
                                     {  $text=str_replace(mb_strtoupper($code_key),"<b style='color:#ff0000;background: #fffc00'>".mb_strtoupper($code_key)."</b>",mb_strtoupper($text)); 
                                     }
                                     if(strpos('  '.mb_strtoupper(str_replace('-','',$text)),mb_strtoupper($code_key))>0)
                                     {  $text=str_replace(mb_strtoupper($code_key),"<b style='color:#ff0000;background: #fffc00'>".mb_strtoupper($code_key)."</b>",mb_strtoupper(str_replace('-','',$text))); 
                                     }
                                     if(strpos('  '.mb_strtoupper($text),mb_strtoupper(str_replace('-','',$code_key)))>0)
                                     {  $text=str_replace(mb_strtoupper(str_replace('-','',$code_key)),"<b style='color:#ff0000;background: #fffc00'>".mb_strtoupper(str_replace('-','',$code_key))."</b>",mb_strtoupper($text)); 
                                     }
                                     
                                         ?>
                                        <td  ><?=str_replace(',',', ',$text)?></td>
                                     

                                    <?}else{?>
                                    <td><?=str_replace(',',', ',$val[$field])?></td>
                                    <?}}?>
                                <?}else{ ?>
									<td>
										<a title="<?=hide_value(str_replace($search['key'],"<b>{$search['key']}</b>",$val['article']) )?>" href="/parts/<?=$val['id']?>"><?=hide_value(str_replace($search['key'],"<b>{$search['key']}</b>",$val['article']) )?></a>
									</td>
								 	<td><?=$val['manuf']?></td>
								 	<td><?=$val['car_desc']?></td>
								 	<td class="numeric"> <?=get_price($val,$_SESSION['valuta'],$this->conf['nacenka'])?></td>
                                    
								 	<td class="numeric"><?=$val['amount']?></td>

								<?}?>
								<td>
                                                                          <? $image= $this->data->get_image_by_article($val['article']);
                        
                                    if($image){?>
                                     <a  class="photoaparat imaga" rel="fancybox_group[<?=$val['id']?>]" href="/i/febest/<?=$image['image_1']?>" title = '<?=$val['article']?>'>
<img style="margin: 3px;" src="/i/photoaparat.png" alt="" title = '<?=$val['article']?>'>
<span class="photoaparat_q">
              <i></i>
             <?for($i=6;$i>0;$i--)if($image['image_'.$i]!=''){echo $i; break;}?>
          </span>
</a>
                                    <?for($i=2;$i<7;$i++)if($image['image_'.$i]!=''){?>                                         
                                      <a href="/i/febest/<?=$image['image_'.$i]?>"  class="  imaga" rel="fancybox_group[<?=$val['id']?>]"  title = '<?=$val['article']?>' ></a>
                                       <?}?>  
   
                                      <?}?>
                                    </td> 
                                    <td style="width: 60px;" class="hdn" >
                                      <?if($image){?>
                                      <input type="radio" class="rdio" value="<?=$image['id']?>" name="sel_im">
                                      <?}else{?>
                                       <input type="checkbox" class="ch_im" value="<?=$val['article']?>" name="images_ch">
                                      <?}?>
                                    </td> 
                                    
                                    
 <td class="f_buy_sclad" style="width: 120px !important;" width="120px">         
                                     <input type="text" name='count_<?=$count?>'  id='count_<?=$count?>' style='padding-right:1px; width: 30px;'>   
                                     <input type="hidden" name='id_<?=$count?>'  id='id_<?=$count?>' value='<?=$val['id']?>'>
                                     <input type="hidden" name='amount_<?=$count?>'  id='amount_<?=$count?>' value='<?=$val['amount']?>'>
                                     <input type="hidden" name='hiden_<?=$count?>'  id='hiden_<?=$count?>' value='0'>
                                      <img  style='cursor: pointer;'  src="/i/basket_ico.png" onclick='Buy(<?=$count?>)'>        
                                      <a title="" href="#" onclick='Show_add_block_sclad(<?=$count?>);return false' class="edit_ico"></a>    

                                      </td>
                                      
								</tr>
								<tr id='add_block_<?=$count?>' style='display:none'>
									<td colspan="22" class="table_check_row">
										<div class="lable_wrap">
											<label><input type="checkbox" id='add1_<?=$count?>' class='add1'> Только этот артикул</label>
										</div>
										<div class="lable_wrap"><label><input id='add2_<?=$count?>' class='add2' type="checkbox"> Только этот производитель</label></div>
										<div class="lable_wrap"><label><input  id='add3_<?=$count?>' class='add3'type="checkbox"> Только это количество</label></div>
										<div class="lable_wrap"><label><input  id='add4_<?=$count?>' class='add4'type="checkbox"> Возможно повышение стоимости</label></div>
										<div class="lable_wrap"><label>
										<input  id='add5_<?=$count?>' class='add5'type="checkbox" > Могу ждать месяц</label></div>
										<div class="lable_wrap_last">
											<label><input type="checkbox" onclick='SetAddAll(<?=$count?>)' > Применить ко всем</label>
										</div>
									</td>
								</tr>
									<tr style='display:none'>
									<td colspan="6" class="table_check_row">
									</td>
								</tr>
								<?}?>
                           
                                
<?if(sizeof($result_add['sklad_analog'])>0){?>
         <td colspan="8" class="table_check_row">
         <b>АНАЛОГИ</b>
        </td>   
    <?  
    foreach($result_add['sklad_analog'] as $val){
                                     $count++;
                                $cu_group=$val['group'];
                                if(!($val['group_1']=='')) {$cu_group.=' » '.$val['group_1'];}
                                if(!($val['group_2']=='')) {$cu_group.=' » '.$val['group_2'];}
                                if(!($group==$cu_group))
                                {
                                    $group=$cu_group;
                                ?>
                            <tr>
                                    <td class="table_hline_row" colspan="22">
                                        <h2 class="table_hline"><?=$group?></h2>
                                    </td>
                                </tr>

                            <?}

                             ?>
                                <tr  class="table_check_row_prepare">
                                <?if(sizeof($user_fields)>0){
                                    foreach($user_fields as $field){
                                    if($field=='price_uah' or $field=='price_usd')
                                    {
                                         if($field=='price_uah'  ){$valuta='грн';}else{$valuta=USD;}
                                     print ("<td>".get_price($val,$valuta,$this->conf['nacenka'])."</td>");
                                    }
                                    elseif($field=='int_inf' and isset($code_key)){
                                        $text = $val[$field];
                                     if(strpos('  '.mb_strtoupper($text),mb_strtoupper($code_key))>0)
                                     {  $text=str_replace(mb_strtoupper($code_key),"<b style='color:#ff0000;background: #fffc00'>".mb_strtoupper($code_key)."</b>",mb_strtoupper($text)); 
                                     }
                                     if(strpos('  '.mb_strtoupper(str_replace('-','',$text)),mb_strtoupper($code_key))>0)
                                     {  $text=str_replace(mb_strtoupper($code_key),"<b style='color:#ff0000;background: #fffc00'>".mb_strtoupper($code_key)."</b>",mb_strtoupper(str_replace('-','',$text))); 
                                     }
                                     if(strpos('  '.mb_strtoupper($text),mb_strtoupper(str_replace('-','',$code_key)))>0)
                                     {  $text=str_replace(mb_strtoupper(str_replace('-','',$code_key)),"<b style='color:#ff0000;background: #fffc00'>".mb_strtoupper(str_replace('-','',$code_key))."</b>",mb_strtoupper($text)); 
                                     }
                                     
                                         ?>
                                        <td  ><?=str_replace(',',', ',$text)?></td>
                                     

                                    <?}else{?>
                                    <td><?=str_replace(',',', ',$val[$field])?></td>
                                    <?}}?>
                                <?}else{ ?>
                                    <td>
                                        <a title="<?=hide_value($val['article'])?>" href="/parts/<?=$val['id']?>"><?=hide_value($val['article'])?></a>
                                    </td>
                                     <td><?=$val['manuf']?></td>
                                     <td><?=$val['car_desc']?></td>
                                     <td class="numeric"> <?=get_price($val,$_SESSION['valuta'],$this->conf['nacenka'])?></td>
                                     <td class="numeric"><?=$val['amount']?></td>

                                <?}?>
                                      
                                      
 <td class="f_buy_sclad" width="120px !important">    
                                     <input type="text" name='count_<?=$count?>'  id='count_<?=$count?>' style='padding-right:1px; width: 30px;'>   
                                     <input type="hidden" name='id_<?=$count?>'  id='id_<?=$count?>' value='<?=$val['id']?>'>
                                     <input type="hidden" name='amount_<?=$count?>'  id='amount_<?=$count?>' value='<?=$val['amount']?>'>
                                     <input type="hidden" name='hiden_<?=$count?>'  id='hiden_<?=$count?>' value='0'>
                                      <img  style='cursor: pointer;'  src="/i/basket_ico.png" onclick='Buy(<?=$count?>)'>        
                                      <a title="" href="#" onclick='Show_add_block_sclad(<?=$count?>);return false' class="edit_ico"></a>
                                                                          <? $image= $this->data->get_image_by_article($val['article']);
                        
                                    if($image){?>
                                      
                                        <a href="/i/febest/<?=$image['image_1']?>"  class="photoaparat imaga" rel="fancybox_group[<?=$val['id']?>]" ><img alt="" src="/i/photo.png"  style="margin: 3px;"></a>
                                    
                                     <?if($image['image_2']!=''){?>
                                     
                                      <a href="/i/febest/<?=$image['image_2']?>"   class="  imaga" rel="fancybox_group[<?=$val['id']?>]" ><img alt="" src="/i/photo.png"  style="margin: 3px;"></a>
                                    
                                    <?}?> 
                                    <?}else{?>
                                      <img src="/i/nofoto.png">
                                      <?}?>
                                      </td>

                                </tr>
                                <tr id='add_block_<?=$count?>' style='display:none'>
                                    <td colspan="22" class="table_check_row">
                                        <div class="lable_wrap">
                                            <label><input type="checkbox" id='add1_<?=$count?>' class='add1'> Только этот артикул</label>
                                        </div>
                                        <div class="lable_wrap"><label><input id='add2_<?=$count?>' class='add2' type="checkbox"> Только этот производитель</label></div>
                                        <div class="lable_wrap"><label><input  id='add3_<?=$count?>' class='add3'type="checkbox"> Только это количество</label></div>
                                        <div class="lable_wrap"><label><input  id='add4_<?=$count?>' class='add4'type="checkbox"> Возможно повышение стоимости</label></div>
                                        <div class="lable_wrap"><label>
                                        <input  id='add5_<?=$count?>' class='add5'type="checkbox" > Могу ждать месяц</label></div>
                                        <div class="lable_wrap_last">
                                            <label><input type="checkbox" onclick='SetAddAll(<?=$count?>)' > Применить ко всем</label>
                                        </div>
                                    </td>
                                </tr>
                                    <tr style='display:none'>
                                    <td colspan="6" class="table_check_row">
                                    </td>
                                </tr>
    <?}?>        
        
<?}?>                                
                                
                                                                       
							</tbody>
						</table>
<script type="text/javascript" >p_count='<?=$count?>';//'</script>
 <script type="text/javascript">
        $(document).ready(function() {
 
          $(".imaga").fancybox({
                'transitionIn'        : 'none',
                'transitionOut'        : 'none',
                'titlePosition'     : 'over',
                'titleFormat'        : function(title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Фото ' + (currentIndex + 1) + ' из ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                }
            });
   
          $("#select_all").click( function() {
           $("input:checkbox").attr('checked', true);
            return false;
        });
        
        
        });
        
        function  ShawEdFoto(){ $(".hdn").show();}
        function  SaveFoto(){ 
            var sel = '';
            
            alert($('.rdio:checked').val());
             $( '.ch_im:checked' ).each(function(){
                sel = sel+'-'+this.value;
            });
            if(sel==''){
                alert('Ничего не выбрано!');return;
            }
             sel = sel+'-';
             alert('Сохранено!');
             $(".hdn").hide();
              $.post(" /manager/save_images_articles/",{
              im:$('.rdio:checked').val(),values: sel },function(data){
            });

        }
    </script>  
    <style type="">
    .hdn {display: none;}
    </style>