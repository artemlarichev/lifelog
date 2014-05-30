<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('user/header');  ?>

 	<div class="main_row">
  <div class="content_row">
				<div class="main_table_wrap order">
					<dl class="order_block">
						<dt>Заказ <span>№<?=$order['id']?></span></dt>
						<dd><span><?=russian_date($order['data'])?></span> в <span><?=$order['time']?></span></dd>
						<dd>№ накладной: <span><?=$order['nakladna']?></span></dd>
					</dl>
					<div class="big_table_wrap">

					<table class="big_table table">
							<thead>
								<tr>
									<th class="marking">
                                         Артикул
                                    </th><th class="marking">
                                         Статус
                                    </th>
									<th class="maker"> Производитель </th>
									<th class="important"> Описание автомобиля </th>
									<th class="price"> <?=$order['valuta']?> </th>
									<th class="col"> шт. </th>
									<th class="sum"> Сумма </th>
								<!--	<th class="edit_col"><span class="edit_ico"></span></th>-->
									 <?if($order['status']<1){?><th class="del_row">х</th><?}?>
								</tr>
							</thead>

							<tbody>
						<? $count=0;
							$group='';
 
							foreach($order_parts as $val){
								$count++;
                                // пРОВЕРКА НА ИЗМЕНЕНИЯ ОТ МЕНЕДЖЕРА
                                $is_msg=0; 
                                $over_count=0;
                                 $msg='';
                                 $msg2='';
                                if($val['start_price']<$val['price']){$is_msg=1; $msg ='Нет в наличии по такой цене. Вы можете сделать повторный заказ по новой цене'; }
                                if($val['start_count']>$val['count']){ $is_msg=1;$over_count=1; $msg2='Нет в наличии'; }
                                
                                  if($val['type']=='0_sklad'){
								$cu_group=$val['group'];



								if(!($val['group_1']=='')) {$cu_group.=' » '.$val['group_1'];}
								if(!($val['group_2']=='')) {$cu_group.=' » '.$val['group_2'];}
								if(!($group==$cu_group))
								{
									$group=$cu_group;


								?>
							<tr >
									<td class="table_hline_row" colspan="9">
										<h2 class="table_hline"><?=$group?></h2>
									</td>
								</tr>

							<?}}else {echo'<tr >
                                    <td class="table_hline_row" colspan="9">
                                        <h2 class="table_hline">Под заказ</h2>
                                    </td>
                                </tr>';}

							 ?>

								<tr   >
									<td  ><?if($val['type']=='0_sklad' AND $val['hidden']<1){?>
										<a title="<?=$val['article']?>" href="/parts/<?=$val['prod_id']?>"><?=$val['article']?></a>
                                        <?}else{?>
                                           <?=$val['article']?> 
                                        <?}?>
									</td>
                                                                        <td>
                                    <span id='status_name_<?=$count?>'><?=$this->mp_status[$val['status']]?>  </span>
                                    
                                    
                                    </td>  
								 	<td   ><?=$val['manuf']?></td>
								 	<td <?if($is_msg>0){?>style='color:white; background:  #c80404 !important;'<?}?>  >
								 	<?if(!$msg==""){?>
 									<b>(<?=$msg?>)</b>
                                    <?}?>

								 	<?if($over_count>0){?>
 									<b>(Нет в наличии в количестве: <?=$val['start_count']?> шт.)</b>
                                    <?}?>


								 	<?=$val['car_desc']?>
                                    <?if(($val['agree_cnt']>0 and $val['agree_cnt']!=$val['mp_start_cnt'])
                                        or($val['not_av_cnt']>0 and $val['not_av_cnt']!=$val['mp_start_cnt'])){?>
                                    <br />
                                    
                                    <div style="border: 1px solid red; padding: 5px;">
                                        <?if($val['agree_cnt']>0 ){?>
                                        Превышение цены <?=$val['agree_cnt']?> из <?=$val['mp_start_cnt']?> (Новая цена <?=$val['agree_price']?> $)
                                         <br />
                                        <?}?>
                                        <?if($val['not_av_cnt']>0 ){?>
                                        Нет в наличии <?=$val['not_av_cnt']?> из <?=$val['mp_start_cnt']?> 
                                         <br />
                                        <?}?> 
                                    </div> 
                                    <?}?>
                                    </td>
								 	<td class="numeric"  >
								 	 <?=$val['price']?>

								  </td>

									 <td class="f_buy"  >
									 <?if($order['status']<1){?>
									 <input type="text" name='count_<?=$count?>'  id='count_<?=$count?>' value='<?=$val['count']?>'>
									 <input type="hidden" name='price_<?=$count?>'  id='price_<?=$count?>' value='<?=$val['price']?>'>
									 <input type="hidden" name='id_<?=$count?>'  id='id_<?=$count?>' value='<?=$val['id']?>'>
                                     <input type="hidden" name='amount_<?=$count?>'  id='amount_<?=$count?>' value='<?=$val['amount']?>'></                                     <input type="hidden" name='type_<?=$count?>'  id='type_<?=$count?>' value='<?=$val['type']?>'></td>
									 <?}else{?>
									 <?=$val['count']?>
									 <?}?>
                                     </td>
									 <td class="numeric"><div id='suma_<?=$count?>'>
									   <?    print ($val['count']*$val['price']);  ?></div>

									  </td>
								<!--	 <td> <a title="" href="#" onclick='Show_add_block(<?=$count?>);return false' class="edit_ico"></a></td>-->
                                     <?if($order['status']<1){?>
                                      <td><a href='/client/del/order_details/<?=$val['id']?>'<span class="t_del">х</span></a></td>
                                      <?}?>
								</tr>


							<!--	<?if($over_count>0){?>
								<tr   >
									<td  style=' background:  #FF3300 !important;' >
										<a title="<?=hide_value($val['article'])?>" href="/parts/<?=$val['prod_id']?>"><?=hide_value($val['article'])?></a>
									</td>
								 	<td  style=' background:  #FF3300 !important;' ><?=$val['manuf']?></td>
								 	<td style=' background:  #FF3300 !important;' ><b> (Нет в наличии) <b><?=$val['note']?></td>
								 	<td style=' background:  #FF3300 !important;' >
								 	 <?=$val['price']?>

								  </td>

									 <td style=' background:  #FF3300 !important;' >

									 <?=($val['start_count']-$val['count'])?>
	                                 </td>
									 <td class="numeric"><div id='suma_<?=$count?>'>
									   <?    print (($val['start_count']-$val['count'])*$val['price']);  ?></div>

									  </td>
									 <td> <a title="" href="#" onclick='Show_add_block(<?=$count?>);return false' class="edit_ico"></a></td>
                                     <?if($order['status']<1){?>
                                      <td> </td>
                                      <?}?>
								</tr>
								<?}?>

                                   -->

								<tr id='add_block_<?=$count?>'
								<?if(!($val['add1']>0 or $val['add2']>0or $val['add3']>0or $val['add4']>0or $val['add5']>0   )) {?>
								style='display:none' <?}?>>
									<td colspan="9" class="table_check_row">
										<div class="lable_wrap">
											<label>

										<input type="checkbox" <?if($val['add1']>0) {echo " checked ";}?>id='add1_<?=$count?>' class='add1'> Только этот артикул</label>
										</div>
										<div class="lable_wrap"><label>
										<input id='add2_<?=$count?>' <?if($val['add2']>0) {echo " checked ";}?>class='add2' type="checkbox"> Только этот производитель</label></div>
										<div class="lable_wrap"><label>
										<input  id='add3_<?=$count?>' <?if($val['add3']>0) {echo " checked ";}?>class='add3'type="checkbox"> Только это количество</label></div>
										<div class="lable_wrap"><label>
										<input  id='add4_<?=$count?>' <?if($val['add4']>0) {echo " checked ";}?>class='add4'type="checkbox"> Возможно повышение стоимости</label></div>
										<div class="lable_wrap"><label>
										<input  id='add5_<?=$count?>' <?if($val['add5']>0) {echo " checked ";}?>class='add5'type="checkbox" > Могу ждать месяц</label></div>

										<div class="lable_wrap_last">		<label>
											<input type="checkbox" onclick='SetAddAll(<?=$count?>)' > Применить ко всем</label>
										</div>

									</td>
								</tr>
									<tr style='display:none'>
									<td colspan="6" class="table_check_row">
									</td>
								</tr>
								<?}?>
									<tr class="last_row">
									<td colspan="3" class="no_border">
									</td>
									<td colspan="2" class="no_border">     <?if($order['status']<1){?>
										<input type="submit" onclick ='RefreshUserOrder()' value="Обновить"><?}?>
									</td>
									<td class="numeric">
										<div id='suma'> <?=$order['summ']?></div></td>
									<td colspan="2" class="no_border"></td>
								</tr>
							</tbody>
						</table>



						<div class="basket_info">
							<dl class="basket_user_form">
								<dt><span>Имя и фамилия:</span></dt>
								<dd><?=$order['name']?> <?=$order['fullname']?></dd>
								<dt><span>Телефон:</span></dt>
								<dd><?=$order['tel']?></dd>
								<dt><span>Почта:</span></dt>
								<dd><?=$order['email']?></dd>
								<dt><span>Комментарии и уточнения:</span></dt>
								<dd class="texta_wrap"><?=$order['comment']?></dd>

							</dl>
							<div class="basket_total">
								<div class="total">
									Итого к оплате: <span id='summ2'><?=$order['summ']?></span> <?=$order['valuta']?>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
    <script type="text/javascript" >p_count='<?=$count?>'; var order_id="<?=$order['id']?>";
    var val_t ='<?if($order['valuta']==USD){print(1);}else {print(0);}?>';
     var valuta="<?=$order['valuta']?>";//'</script>


 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>
