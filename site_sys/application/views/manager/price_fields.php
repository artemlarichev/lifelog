<h2>Согласование полей:</h2>
					<div class="big_table_wrap">
						<table class="big_table table">
							<thead>
								<tr>
									<th>Артикул</th>
									<th>Кол-во</th>
									<th>Цена</th>
									<th>Производитель</th>
									<th>Описание</th>
								</tr>
							</thead>

							<tbody>
									<tr class="table_edit_row">
										<td>
											<div class="input_wrap">
												<select id='field_1'> <option value="0">-</option>
												<?$i=1;
												if(isset($price_list[0])) {$field_1=$price_list[0];}else  {$field_1=0;}
												if(isset($price_list[1])) {$field_2=$price_list[1];}else  {$field_2=0;}
												if(isset($price_list[2])) {$field_3=$price_list[2];}else  {$field_3=0;}
												if(isset($price_list[3])) {$field_4=$price_list[3];}else  {$field_4=0;}
												if(isset($price_list[4])) {$field_5=$price_list[4];}else  {$field_5=0;}


												foreach($fields as $key=>$field){?>

													<option value="<?=$key?>" <?if($field_1==$key){print('selected');}?>><?=$field?></option>
													<?
												$i++;}?>

												</select>
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<select id='field_2'>     <option value="0">-</option>
												<?$i=1;
												foreach($fields as $key=>$field){?>
													<option value="<?=$key?>" <?if($field_2==$key){print('selected');}?>><?=$field?></option>
													<?
												$i++;}?>

												</select>
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<select id='field_3'>   <option value="0">-</option>
												<?$i=1;
												foreach($fields as $key=>$field){?>
													<option value="<?=$key?>" <?if($field_3==$key){print('selected');}?>><?=$field?></option>
													<?
												$i++;}?>

												</select>
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<select id='field_4'>    <option value="0">-</option>
												<?$i=1;
												foreach($fields as $key=>$field){?>
													<option value="<?=$key?>" <?if($field_4==$key){print('selected');}?>><?=$field?></option>
													<?
												$i++;}?>

												</select>
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<select id='field_5'>   <option value="0">-</option>
												<?$i=1;
												foreach($fields as $key=>$field){?>
													<option value="<?=$key?>" <?if($field_5==$key){print('selected');}?>><?=$field?></option>
													<?
												$i++;}?>

												</select>
											</div>
										</td>
									</tr>
							</tbody>
						</table>
						</div>
