				<table class="big_table table" style='font-size:12px;border:0px'>
							<thead>
								<tr>
									<th class="marking">
										 Артикул
									</th>
									<th class="maker"> Производитель </th>
									<th class="important"> Примечание </th>
									<th class="price"> <?=$order['valuta']?> </th>
									<th class="col"> шт. </th>
									<th class="sum"> Сумма </th>

								</tr>
							</thead>

							<tbody>
						<? $count=0;
							$group='';
							foreach($orders_details[$order['id']] as $val){
								$count++;
								$cu_group=$val['group'];
								if(!($val['group_1']=='')) {$cu_group.=' » '.$val['group_1'];}
								if(!($val['group_2']=='')) {$cu_group.=' » '.$val['group_2'];}
								if(!($group==$cu_group))
								{
									$group=$cu_group;
								?>
							<tr>
									<td class="table_hline_row" colspan="9">
										 <?=$group?>
									</td>
								</tr>

							<?}

							 ?>

								<tr>
									<td>
										<a title="<?=hide_value($val['article'])?>" href="/parts/<?=$val['prod_id']?>"><?=hide_value($val['article'])?></a>
									</td>
								 	<td><?=$val['manuf']?></td>
								 	<td><?=$val['note']?></td>
								 	<td class="numeric">

									  <?=$val['price']?>

								  </td>

									 <td class="f_buy">
									  <?=$val['count']?>
									  </td>
								 		 <td class="numeric"><div id='suma_<?=$count?>'>
									   <? print ($val['count']*$val['price']);  ?></div>

									  </td>

								<?}?>

							</tbody>
						</table>
