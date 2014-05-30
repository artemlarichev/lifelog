<h2>В наличии</h2>				<table class="big_table table">
							<thead>
								<tr>
									<th class="marking">
										 Артикул
									</th>
									 <th class="maker"> Производитель </th>
									 <th class="important"> Описание автомобиля </th>
									 <th class="price">
									 <?=$_SESSION['valuta']?> </th>
  <th style="width: 40px;" >Фото</th> 
									  <th></th> 

								</tr>
							</thead>

							<tbody>
							<? $count=0;
							if(!isset($no_art)){$no_art=0;}
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
									<td class="table_hline_row" colspan="6">
										<h2 class="table_hline"><?=$group?></h2>
									</td>
								</tr>

							<?}

							 ?>

								<tr  class="table_check_row_prepare">
                                <?
                                $hidden =0;
                                $produsers =explode(', ',strtolower('mazda, subaru, nissan, toyota, honda, mitsubishi, suzuki, daihatsu, hyhdai, kia, isuzu'));
                                 
                                if(strpos(" ".strtolower($val['int_inf']),strtolower($search['key']))>0 and $search['key']!=$val['article']){// поиск по внутреней инф?>
                                    <td>
                                        <a title="<?=$search['key']?>" >
                                        
                                        <?=$search['key']?></a>
                                    </td>
                                     <td>
                                     <?if(in_array(strtolower($val['manuf']),$produsers))echo "Оригинал"; else echo "Лицензия";?>
                                      </td>
                                     <td>-</td>
                                     <td class="numeric">
                                    <?=$this->catalog_model->get_price($val,$_SESSION['valuta'],'hidden')?>
                                    </td>
                                <?
                                $hidden =$search['key'];
                                }else{?>
                                    <td>
                                        <a title="<?=hide_value(str_replace($search['key'],"<b>{$search['key']}</b>",$val['article']) ,$no_art)?>" href="/parts/<?=$val['id']?>">
                                        
                                        <?=hide_value(str_replace($search['key'],"<b>{$search['key']}</b>",$val['article']) ,$no_art)?></a>
                                    </td>
                                     <td><?=$val['manuf']?></td>
                                     <td><?=$val['car_desc']?></td>
                                     <td class="numeric">
                                    <?=$this->catalog_model->get_price($val,$_SESSION['valuta'],$this->conf['nacenka'])?>
                                    </td>
                                <?}?>
                                                            

                                    <td>
                                                                          <? $image= $this->data->get_image_by_article($val['article']);
                        
                                    if($image and $hidden=='0'){?>
                                     <a class="photoaparat imaga" rel="fancybox_group[<?=$val['id']?>]" href="/i/febest/<?=$image['image_1']?>" title = '<?=$val['article']?>'>
<img style="margin: 3px;" src="/i/photoaparat.png" alt="" title = '<?=$val['article']?>'>
<span class="photoaparat_q">
              <i></i>
             <?for($i=6;$i>0;$i--)if($image['image_'.$i]!=''){echo $i; break;}?>
          </span>
</a>
                                    <?for($i=2;$i<7;$i++)if($image['image_'.$i]!=''){?>                                         
                                      <a href="/i/febest/<?=$image['image_'.$i]?>"class=" imaga" href rel='fancybox_group[<?=$val['id']?>]' title = '<?=$val['article']?>' ></a>
                                       <?}?>  
   
                                      <?}?>
                                    </td>
                                    
 <td class="f_buy_sclad" width="100px">    
                                     <input type="text" name='count_<?=$count?>'  id='count_<?=$count?>' style='padding-right:1px; width: 30px;'>
                                     <input type="hidden" name='id_<?=$count?>'  id='id_<?=$count?>' value='<?=$val['id']?>'>
                                     <input type="hidden" name='amount_<?=$count?>'  id='amount_<?=$count?>' value='<?=$val['amount']?>'>
                                     <input type="hidden" name='hiden_<?=$count?>'  id='hiden_<?=$count?>' value='<?=$hidden?>'>
                                      <img  style='cursor: pointer;'  src="/i/basket_ico.png" onclick='Buy(<?=$count?>)'> 
                                                                  <!-- <a title="" href="#" onclick='Show_add_block_sclad(<?=$count?>);return false' class="edit_ico"></a>-->
                                    
                                   </td>  
								</tr>

								<tr id='add_block_<?=$count?>' style='display:none'>
									<td colspan="5" class="table_check_row">
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
									<td colspan="5" class="table_check_row">
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
                                    <td class="table_hline_row" colspan="7">
                                        <h2 class="table_hline"><?=$group?></h2>
                                    </td>
                                </tr>

                            <?}

                             ?>

                                <tr  class="table_check_row_prepare">
                                    <td>
                                        <a title="<?=hide_value($val['article'],$no_art)?>" href="/parts/<?=$val['id']?>"><?=hide_value($val['article'],$no_art)?></a>
                                    </td>
                                     <td><?=$val['manuf']?></td>
                                     <td><?=$val['car_desc']?></td>
                                     <td class="numeric">
                                    <?=$this->catalog_model->get_price($val,$_SESSION['valuta'],$this->conf['nacenka'])?>
                                    </td>
                                    
                                    
                                                                    <td>
                                                                          <? $image= $this->data->get_image_by_article($val['article']);
                        
                                    if($image){?>
                                     <a class="photoaparat" rel="fancybox_group[<?=$val['id']?>]" href="/i/febest/<?=$image['image_1']?>" title = '<?=$val['article']?>' >
<img style="margin: 3px;" src="/i/photoaparat.png" alt="">
<span class="photoaparat_q">
              <i></i>
             <?if($image['image_2']!='')echo 2;else echo 1;?>
          </span>
</a>
                                    <?if($image['image_2']!=''){?>
                                     
                                      <a href="/i/febest/<?=$image['image_2']?>" rel='fancybox_group[<?=$val['id']?>]' title = '<?=$val['article']?>'></a>
                                    
                                    <?}?>  
   
                                      <?}?>
                                    </td>
 <td class="f_buy_sclad"      width="100px">  
                                     <input type="text" name='count_<?=$count?>'  id='count_<?=$count?>'  style='padding-right:1px; width: 30px;'>  
                                     <input type="hidden" name='id_<?=$count?>'  id='id_<?=$count?>' value='<?=$val['id']?>'>
                                     <input type="hidden" name='amount_<?=$count?>'  id='amount_<?=$count?>' value='<?=$val['amount']?>'>    
                                     <input type="hidden" name='hiden_<?=$count?>'  id='hiden_<?=$count?>' value='0'>
                                     <img  style='cursor: pointer;'  src="/i/basket_ico.png" onclick='Buy(<?=$count?>)'>
                                     <!--<a title="" href="#" onclick='Show_add_block_sclad(<?=$count?>);return false' class="edit_ico"></a>-->
                                        
                                     </td>

                                </tr>

                                </tr>
                                <tr id='add_block_<?=$count?>' style='display:none'>
                                    <td colspan="5" class="table_check_row">
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
                                    <td colspan="5" class="table_check_row">
                                    </td>
                                </tr>

    <?}?>        
        
<?}?>                                
                                
								
							</tbody>
						</table>
				<div class="block_v1_wrap">
					<div class="filter_block">
						<select name="filter_b_all" id="filter_b_all" class="filter_b_all">
							<option value="1">Все</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select><select name="filter_b_all_months" id="filter_b_all_months" class="filter_b_all_months">
						<option value="1">Все месяца</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
					</div>
					<div class="big_table_wrap">
						<table class="table table_v1">
							<thead>
							<tr>
								<th><a class="table_v1_link" href="#" title="Артикул">Артикул</a></th>
								<th><a class="table_v1_link" href="#" title="Закупочный №">Закупочный №</a></th>
								<th><a class="table_v1_link" href="#" title="Производитель">Производитель</a></th>
								<th><a class="table_v1_link" href="#" title="Каталожный №">Каталожный №</a></th>
								<th><a class="table_v1_link" href="#" title="Примечание">Примечание</a></th>
								<th><a class="table_v1_link" href="#" title="Оригинальные №№">Оригинальные №№</a></th>
								<th><a class="table_v1_link" href="#" title="Вспомог. №">Вспомог. №</a></th>
								<th><a class="table_v1_link" href="#" title="Внутр. инф.">Внутр. инф.</a></th>
								<th><a class="table_v1_link" href="#" title="Описание автомобиля">Описание автомобиля</a></th>
								<th><a class="table_v1_link" href="#" title="Схожесть">Схожесть</a></th>
								<th><a class="table_v1_link" href="#" title="грн.">грн.</a></th>
								<th>$</th>
								<th><a class="table_v1_link" href="#" title="Закуп.">Закуп.</a></th>
								<th><a class="table_v1_link" href="#" title="шт.">шт.</a></th>
								<th><a class="table_v1_link" href="#" title="Ож.">Ож.</a></th>
								<th>
									<button class="butt_pay">Купить</button>
								</th>
								<th><a class="table_v1_link" href="#" title="Сумма">Сумма</a></th>
								<th>х</th>
								<th><input type="checkbox" name="all_check"></th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td><a href="#" title="">BJ2-560</a>
								</td>
								<td>1500A023</td>
								<td>FRAM</td>
								<td>B25015 @,B25009</td>
								<td>Lancer X CYL</td>
								<td>Lancer X CYLancer</td>
								<td>1500A023</td>
								<td>Lancer X CY</td>
								<td>626 GC 82-87 пер</td>
								<td>1500A023</td>
								<td>879</td>
								<td>110</td>
								<td>80</td>
								<td>5</td>
								<td>15</td>
								<td><input type="text" name="count_unit"><a href="#" class="edit_ico"></a></td>
								<td>1758</td>
								<td><a href="#" title="">x</a>
								</td>
								<td><input type="checkbox" name="check_unit_1"></td>
							</tr>
							<tr>
								<td><a href="#" title="">SWT20054STD</a>
								</td>
								<td>1500A023</td>
								<td>FRAM</td>
								<td>B25015 @,B25009</td>
								<td>Lancer X CYL</td>
								<td>Lancer X CYLancer</td>
								<td>1500A023</td>
								<td>Lancer X CY</td>
								<td>626 GC 82-87 пер</td>
								<td>1500A023</td>
								<td>879</td>
								<td>110</td>
								<td>80</td>
								<td>5</td>
								<td>15</td>
								<td><input type="text" name="count_unit"><a href="#" class="edit_ico"></a></td>
								<td>1758</td>
								<td><a href="#" title="">x</a>
								</td>
								<td><input type="checkbox" name="check_unit_1"></td>
							</tr>
							<tr>
								<td><a href="#" title="">BJ2-560</a>
								</td>
								<td>1500A023</td>
								<td>FRAM</td>
								<td>B25015 @,B25009</td>
								<td>Lancer X CYL</td>
								<td>Lancer X CYLancer</td>
								<td>1500A023</td>
								<td>Lancer X CY</td>
								<td>626 GC 82-87 пер</td>
								<td>1500A023</td>
								<td>879</td>
								<td>110</td>
								<td>80</td>
								<td>5</td>
								<td>15</td>
								<td><input type="text" name="count_unit"><a href="#" class="edit_ico"></a></td>
								<td>1758</td>
								<td><a href="#" title="">x</a>
								</td>
								<td><input type="checkbox" name="check_unit_1"></td>
							</tr>

							</tbody>
						</table>
					</div>
					<ul class="paginator">
						<li class="paginator_item active"><a class="paginator_i_link" href="#" title="">1</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">2</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">3</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">4</a></li>
						<li class="paginator_item active"><a class="paginator_i_link" href="#" title="">5</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">6</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">7</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">8</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">9</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">10</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">11</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">12</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">13</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">14</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">15</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">16</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">17</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">18</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">19</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">20</a></li>

						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">21</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">22</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">23</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">24</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">25</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">26</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">27</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">28</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">29</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">30</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">31</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">32</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">33</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">34</a></li>
						<li class="paginator_item"><a class="paginator_i_link" href="#" title="">35</a></li>
					</ul>
				</div>

<script type="text/javascript" >p_count='<?=$count?>';//'</script>
 <script type="text/javascript">
        $(document).ready(function() {
 
            $(".imaga").fancybox({
                'transitionIn'        : 'none',
                'transitionOut'        : 'none',
                'titlePosition'     : 'over',
                'titleFormat'        : function(title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Фото ' + (currentIndex + 1) + ' из ' + currentArray.length  + '</span>';
                }
            });
   
        });
    </script>  
