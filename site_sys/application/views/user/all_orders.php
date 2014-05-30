<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('user/header');  ?>

 	<div class="main_row">
    <?if($status==2){?>   
Отображены выполненные заказы за неделю <a href='/client/orders/3/<?=$show_parts?>'>Показать все</a>
<br /><br />
<?}?>

  <div class="content_row">
				<div class="main_table_wrap order">

					<div class="big_table_wrap">

					<table class="big_table table">
							<thead>
								<tr>
									<th class="marking">
										 Артикул
									</th>
									<th class="maker"> № заказа </th>
                                    <th class="maker">Статус </th>    
									<th class="maker"> № накладной </th>
									<th class="maker"> № декларации </th>
									<th class="maker"> Дата </th>
									<th class="maker"> Производитель </th>	
									<th class="price"> цена </th>
									<th class="col"> шт. </th>
									<th class="sum"> Сумма </th>
									<!--<th class="edit_col"><span class="edit_ico"></span></th>-->

								</tr>
							</thead>

							<tbody>
						<? $count=0;
							$group='';
							foreach($order_parts as $val){
								$count++;
								$cu_group=$val['group'];
								if(!($val['group_1']=='')) {$cu_group.=' » '.$val['group_1'];}
								if(!($val['group_2']=='')) {$cu_group.=' » '.$val['group_2'];}
								if(!($group==$cu_group))
								{
									$group=$cu_group;
								?>
							<tr>
									<td class="table_hline_row" colspan="12">
										<h2 class="table_hline"><?=$group?></h2>
									</td>
								</tr>

							<?}

							 ?>

								<tr>
									<td>
                                    <?if($val['type']=='0_sklad' AND $val['hidden']<1){?>
                                        <a title="<?=$val['article']?>" href="/parts/<?=$val['prod_id']?>"><?=$val['article']?></a>
                                        <?}else{?>
                                           <?=$val['article']?> 
                                        <?}?>
										 
									</td>
								 	<td><?=$val['num']?></td>
                                    <td>
                                    <span id='status_name_<?=$count?>'><?=$this->mp_status[$val['status']]?>  </span>
                                     
                                    </td>   
								 	<td><?=$val['nakladna']?></td>
							 	<td><?=$val['dekl']?></td>
								 	<td><?=russian_date($val['o_data'])?></td>
								 	<td><?=$val['manuf']?>
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
								 	<td class="numeric">
								  <?=$val['price']?>

								  </td>

									 <td class="f_buy">
									 <?=$val['count']?>
									 <input type="hidden" name='price_uah_<?=$count?>'  id='price_uah_<?=$count?>' value='<?=$val['price_uah']?>'>
									 <input type="hidden" name='price_usd_<?=$count?>'  id='price_usd_<?=$count?>' value='<?=$val['price_usd']?>'>
									 <input type="hidden" name='id_<?=$count?>'  id='id_<?=$count?>' value='<?=$val['id']?>'>
									 <input type="hidden" name='amount_<?=$count?>'  id='amount_<?=$count?>' value='<?=$val['amount']?>'></td>

									 <td class="numeric"><div id='suma_<?=$count?>'>
									   <?  print ($val['count']*$val['price']);  ?></div>

									  </td>
								<!--	 <td> <a title="" href="#" onclick='Show_add_block_sclad(<?=$count?>);return false' class="edit_ico2"></a></td>-->

								</tr>
								<tr id='add_block_<?=$count?>'
								<?if(!($val['add1']>0 or $val['add2']>0or $val['add3']>0or $val['add4']>0or $val['add5']>0)) {?>
								style='display:none' <?}?>>
									<td colspan="11" class="table_check_row">
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

								<?}?>
	 						</tbody>
						</table>



						<div class="basket_info">

						</div>
					</div>
				</div>
			</div>



 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>