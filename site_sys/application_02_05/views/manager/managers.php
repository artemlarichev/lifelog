<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
<script type="text/javascript">
function Save()
{
  var gropData = {};
   $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});

for (var num = 1; num < user_count+1; num++)
 {
  if( $('#id_'+num).length )
  	{
   			 gropData[num] = {
	            "id":$('#id_'+num).val(),
                  "MP_CODE":$('#MP_CODE_'+num).val(),
                  "MP_LOGIN":$('#MP_LOGIN_'+num).val(),
                "DostPtrice":$('#DostPtrice_'+num).val(),
                  "MP_PASS":$('#MP_PASS_'+num).val(),
	            "name":$('#name_'+num).val(),
	            "fullname":$('#fullname_'+num).val(),
	            "tel":$('#tel_'+num).val(),
                "discont":$('#discont_'+num).val(),
	            "email":$('#email_'+num).val(),
	            "pass":$('#pass_'+num).val(),
                 "disc_type_sup":$('#disc_type_sup_'+num).val(),
  	            "user_type":'manager',
  	            "number":num

             };
 	}
 }
<?if(isset($new)){?>
    			 gropData[user_count+1] = {
	            "id":0,
	            "name":$('#name').val(),
                   "MP_CODE":$('#MP_CODE').val(),
                   "MP_LOGIN":$('#MP_LOGIN').val(),
                   "MP_PASS":$('#MP_PASS').val(),
                "DostPtrice":$('#DostPtrice').val(),
	            "card":$('#card').val(),
	            "valuta":$('#valuta').val(),
	            "balans":$('#balans').val(),
                "discont":$('#discont').val(),
	            "fullname":$('#fullname').val(),
	            "tel":$('#tel').val(),
	            "email":$('#email').val(),
	            "pass":$('#new_pass').val(),
	            "user_type":'manager', 
                 "disc_type_sup":$('#disc_type_sup').val(),
  	            "number":user_count+1

             };

<?}?>

	 $.post(" /manager/ajax_save_users/",{
			data: $.toJSON(gropData) },function(data){
		 	  $.unblockUI();
	  	  location.replace("/manager/managers");
	  	  });
}
var user_count =<?=sizeof($users)?>;
</script>
	<div class="base" id="wrapper">
	<?php  $this->load->view('manager/header');  ?>

 	<div class="main_row">
   <div class="content_row">
				<div class="main_table_wrap ">
					<div class="usep_list_options">
						<input type="submit" value="Создать менеджера" id="add_user" name="add_user"  onclick='location.replace("/manager/new_client/manager")' >
						<input type="submit" value="Сохранить" name="user_save" id="user_save"  onclick='Save()'>
					</div>
					<div class="big_table_wrap">
						<table class="big_table table usep_list_table"  id='main_tab'>
						<thead>
								<tr>
									<th class="card_num"><a href='/manager/managers/card/<?if($order_==''){echo"DESC";}?>'> № карты</a></a></th>
									<th class="u_n"> <a href='/manager/managers/name/<?if($order_==''){echo"DESC";}?>'>Название фирмы</a></th>
                                    <th class="u_n"> <a href='/manager/managers/MP_CODE/<?if($order_==''){echo"DESC";}?>'>ID MP</a></th>
                                    <th class="u_n"> <a href='/manager/managers/MP_LOGIN/<?if($order_==''){echo"DESC";}?>'>лог. MP</a></th>
                                    <th class="u_n"> <a href='/manager/managers/MP_PASS/<?if($order_==''){echo"DESC";}?>'>пар. MP</a></th>
									   <th class="u_n"> <a href='/manager/managers/DostPtrice/<?if($DostPtrice_==''){echo"DESC";}?>'>Ст. дост.</a></th>     
                                    <th class="u_f"> <a href='/manager/managers/fullname/<?if($order_==''){echo"DESC";}?>'>Фамилия, Имя, Отчество</a></th>
									<th class="t_share"><a href='/manager/managers/discont/<?if($order_==''){echo"DESC";}?>'> Скидка</a></th>
									<th class="t_bal"> <a href='/manager/managers/balans/<?if($order_==''){echo"DESC";}?>'>Баланс</a></th>
								 	<th class="u_tel"> <a href='/manager/managers/tel/<?if($order_==''){echo"DESC";}?>'>Телефон</a></th>
									<th class="u_mail"><a href='/manager/managers/email/<?if($order_==''){echo"DESC";}?>'> Почта</a></th>
									<th class="u_pass"> Пароль </th>
								 	<th class="u_pr"> <a href='/manager/clients/disc_type_sup/<?if($order_==''){echo"DESC";}?>'>Тип(для пост.)</a></th>	<th class="del_row">x </th>
								</tr>
							</thead>



							<tbody>
							<?if(isset($new)){?>
								<tr class="add_user_row">
									<td>
										<div><input id='card' type="text">
										</div>
									</td>
									<td>
										<div><input  id='name' type="text"></div>
									</td>
                                         <td>
                                        <div><input  id='MP_CODE' type="text"></div>
                                    </td>
                                         <td>
                                        <div><input  id='MP_LOGIN' type="text"></div>
                                    </td>
                                         <td>
                                        <div><input  id='MP_PASS' type="text"></div>
                                    </td>
                                       <td>
                                        <div><input  id='DostPtrice' type="text"></div>
                                    </td>
                                    
									<td>
										<div><input id='fullname'  type="text"></div>
									</td>
									<td class="numeric"><input id='discont'  type="text"></td>
									<td class="numeric">
										<input type="text" id='balans' disabled="disabled">
										<select id='valuta'>
											<option value="грн">грн</option>
											<option value="<?=USD?>"><?=USD?></option>
										</select>
									</td>
									<td>
										<div><input id='tel' type="text"></div>
									</td>
									<td>
										<div><input id='email' type="text"></div>
									</td>
									<td>
										<div><input id='new_pass' type="text"></div>
									</td><td>    <div><select id='disc_type_sup' >
                            <option value="rozn" >Розница</option>
                            <option value="sto"  >СТО и магазины</option>
                            <option value="l_opt"  >Мелкий опт</option>
                            <option value="m_opt" >Средний опт</option>
                            <option value="s_opt"  >Крупный опт</option>
                            </select>
                          
                           
                                    </div>
                                    </td>
									<td><span class="t_del"   onclick='location.replace("/manager/clients")' >x</span></td>
								</tr>
                               <?}?>

							    <?
							    $count=0;
							    foreach($users as $val){
							    $count++;
							    	?>
								<tr>
									<td><?=$val['card']?></td>
											<td>
										<div>
										<span style='display:none'><?=$val['name']?></span>
										<input id='name_<?=$count?>' type="text" value='<?=$val['name']?>'>
										<input id='id_<?=$count?>' type="hidden" value='<?=$val['id']?>'>
										</div>
									</td>
                                   <td>
                                        <div>
                                        <span style='display:none'><?=$val['MP_CODE']?></span>
                                        <input id='MP_CODE_<?=$count?>' type="text" value='<?=$val['MP_CODE']?>'>
                                        
                                        </div>
                                    </td>
                                                                                      <td>
                                        <div>
                                        <span style='display:none'><?=$val['MP_LOGIN']?></span>
                                        <input id='MP_LOGIN_<?=$count?>' type="text" value='<?=$val['MP_LOGIN']?>'>
                                        
                                        </div>
                                    </td>   <td>
                                        <div>
                                        <span style='display:none'><?=$val['MP_PASS']?></span>
                                        <input id='MP_PASS_<?=$count?>' type="text" value='<?=$val['MP_PASS']?>'>
                                        
                                        </div>
                                    </td>
                                       <td>
                                        <div>
                                        <span style='display:none'><?=$val['DostPtrice']?></span>
                                        <input id='DostPtrice_<?=$count?>' type="text" value='<?=$val['DostPtrice']?>'>
                                        
                                        </div>
                                    </td>  
                                                   
									<td>
										<div>
										<span style='display:none'><?=$val['fullname']?></span>
										<input id='fullname_<?=$count?>' type="text" value='<?=$val['fullname']?>'></div>
									</td>
									<td class="numeric">
									<span style='display:none'><?=$val['discont']?></span>
									<input id='discont_<?=$count?>' type="text" value='<?=$val['discont']?>'>%</td>
									<td class="numeric">
									  <?=$val['balans']?>
									<?=$val['valuta']?> .</td>
									<td> <span style='display:none'><?=$val['tel']?></span>
										<div><input id='tel_<?=$count?>' type="text" value='<?=$val['tel']?>'></div>
									</td>
									<td> <span style='display:none'><?=$val['email']?></span>
										<div><input id='email_<?=$count?>' type="text" value='<?=$val['email']?>'></div>
									</td>
									<td>
										<div><input id='pass_<?=$count?>' type="text"  ></div>
									</td>
<td>    <div><select id='disc_type_sup_<?=$count?>' >
                            <option value="rozn" <?if($val['disc_type_sup']=='rozn') echo"selected='selected'";?>>Розница</option>
                            <option value="sto" <?if($val['disc_type_sup']=='sto') echo"selected='selected'";?>>СТО и магазины</option>
                            <option value="l_opt" <?if($val['disc_type_sup']=='l_opt') echo"selected='selected'";?>>Мелкий опт</option>
                            <option value="m_opt" <?if($val['disc_type_sup']=='m_opt') echo"selected='selected'";?>>Средний опт</option>
                            <option value="s_opt" <?if($val['disc_type_sup']=='s_opt') echo"selected='selected'";?>>Крупный опт</option>
                            </select>
                          
                           
                                    </div>
                                    </td>
									<td><span class="t_del"   onclick='location.replace("/manager/managers/<?=$order?>/<?if($order_==''){echo"-";}else{echo"DESC";}?>/del/<?=$val['id']?>")'>x</span></td>
								</tr>
								<?}?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>

</div>
</body>
</html>