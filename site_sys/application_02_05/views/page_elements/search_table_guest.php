				<table class="big_table table">
							<thead>
								<tr>
									<th class="marking">
										 �������
									</th>
									 <th class="maker"> ������������� </th>
									 <th class="important"> ���������� </th>
									 <th class="price"> ���. </th>
									 <th class="col"> ��. </th>
									 <th><input type="submit" value="������" id="buy" name="buy"></th>
									<th class="sum"><a title="�����" href="">����� </th>
									<th class="del_row">�</th>
									<th class="check"><input type="checkbox"></th>
								</tr>
							</thead>

							<tbody>
							<? $count=0;
							$group='';
							foreach($result as $val){
								$count++;
								$cu_group=$val['group'];
								if(!($val['group_1']=='')) {$cu_group.=' � '.$val['group_1'];}
								if(!($val['group_2']=='')) {$cu_group.=' � '.$val['group_2'];}
								if(!($group==$cu_group))
								{
									$group=$cu_group;
								?>
							<tr>
									<td class="table_hline_row" colspan="20">
										<h2 class="table_hline"><?=$group?></h2>
									</td>
								</tr>

							<?}

							 ?>

								<tr>
									<td>
										<a title="<?=$val['article']?>" href="/parts/<?=$val['article']?>"><?=$val['article']?></a>
									</td>
								 	<td><?=$val['manuf']?></td>
								 	<td><?=$val['note']?></td>
								 	<td class="numeric"><?=$val['price_uah']?></td>
								 	<td class="numeric"><?=$val['amount']?></td>
									 <td class="f_buy"><input type="text"> <a title="" href="" class="edit_ico"></a></td>
									<td class="numeric" ></td>
									<td><span class="t_del">�</span></td>
									<td><input type="checkbox"></td>
								</tr>
								<tr>
									<td colspan="6" class="table_check_row">
										<div class="lable_wrap">
											<label><input type="checkbox"> ������ ���� �������</label>
										</div>
										<div class="lable_wrap"><label><input type="checkbox"> ������ ���� �������������</label></div>
										<div class="lable_wrap"><label><input type="checkbox"> ������ ��� ����������</label></div>
										<div class="lable_wrap"><label><input type="checkbox"> �������� ��������� ���������</label></div>
										<div class="lable_wrap"><label><input type="checkbox"> ���� ����� �����</label></div>
										<div class="lable_wrap_last">
											<label><input type="checkbox"> ��������� �� ����</label>
										</div>
									</td>
								</tr>
								<?}?>
							</tbody>
						</table>
