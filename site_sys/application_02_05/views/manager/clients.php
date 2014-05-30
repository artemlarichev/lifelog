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
var price_=0; var full_art_=0; var disc_type_=0; var show_gr_=0;var to_mail=0;
for (var num = 1; num < user_count+1; num++)
 {
  if( $('#id_'+num).length )
  	{      if($('#full_art_'+num).is(':checked')){full_art_=1;} else {full_art_=0;}
   		    if($('#price_'+num).is(':checked')){price_=1;} else {price_=0;}
                if($('#disc_type_'+num).is(':checked')){disc_type_=1;} else {disc_type_=0;}
                if($('#show_gr_'+num).is(':checked')){show_gr_=1;} else {show_gr_=0;}
                if($('#to_mail_'+num).is(':checked')){to_mail=1;} else {to_mail=0;}

   			 gropData[num] = {
	            "id":$('#id_'+num).val(),
                "name":$('#name_'+num).val(),
                "MP_CODE":$('#MP_CODE_'+num).val(),
                "DostPtrice":$('#DostPtrice_'+num).val(),
                  "MP_LOGIN":$('#MP_LOGIN_'+num).val(),
                  "show_gr":show_gr_,
                  "send_mail":to_mail,
                  "MP_PASS":$('#MP_PASS_'+num).val(),
	            "fullname":$('#fullname_'+num).val(),
	            "discont":$('#discont_'+num).val(),
               "tel":$('#tel_'+num).val(),
	            "email":$('#email_'+num).val(),
	            "pass":$('#pass_'+num).val(),
                "disc_type_sup":$('#disc_type_sup_'+num).val(),
                "price":price_,
	            "full_art":full_art_,
  	             "disc_type":disc_type_,
             "user_type":'user',
  	            "number":num

             };
 	}
 }
<?if(isset($new)){?>
		 if($('#full_art').is(':checked')){full_art_=1;} else {full_art_=0;}
 		 if($('#price').is(':checked')){price_=1;} else {price_=0;}
    if($('#disc_type').is(':checked')){disc_type_=1;} else {disc_type_=0;}
                if($('#show_gr').is(':checked')){show_gr_=1;} else {show_gr_=0;}
                if($('#to_mail').is(':checked')){to_mail=1;} else {to_mail=0;}

    			 gropData[user_count+1] = {
	            "id":0,
                "name":$('#name').val(),
                "MP_CODE":$('#MP_CODE').val(),
                   "MP_LOGIN":$('#MP_LOGIN').val(),
                   "MP_PASS":$('#MP_PASS').val(),
                   "DostPtrice":$('#DostPtrice').val(),
                  "show_gr":$('#show_gr').val(),
                  "send_mail":to_mail,
	            "card":$('#card').val(),
	            "valuta":$('#valuta').val(),
	            "discont":$('#discont').val(),
                "balans":$('#balans').val(),
	            "fullname":$('#fullname').val(),
	            "tel":$('#tel').val(),
	            "email":$('#email').val(),
	            "pass":$('#new_pass').val(),
                
                "disc_type_sup":$('#disc_type_sup').val(),
	            "user_type":'user',
	            "price":price_,
	            "disc_type":disc_type_,
                

  	           "full_art":full_art_,
                 "show_gr":show_gr_,
  	            "number":user_count+1

             };

<?}?>

	 $.post(" /manager/ajax_save_users/",{
			data: $.toJSON(gropData) },function(data){
		 	  $.unblockUI();
	  	   window.location.reload();
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
						<input type="submit" value="Создать клиента" id="add_user" name="add_user"  onclick='location.replace("/manager/new_client")' >
						<input type="submit" value="Сохранить" name="user_save" id="user_save"  onclick='Save()'>
					</div>
					<div class="big_table_wrap">
						<table class="big_table table usep_list_table"  id='main_tab'>
                              <thead>
								<tr>
									<th class="card_num"><a href='/manager/clients/card/<?if($order_==''){echo"DESC";}?>'> № карты</a></a></th>
                                    <th class="u_n"> <a href='/manager/clients/name/<?if($order_==''){echo"DESC";}?>'>Название фирмы</a></th>
                                     <th class="u_n"> <a href='/manager/clients/MP_CODE/<?if($order_==''){echo"DESC";}?>'>ID MP</a></th>
                                    <th class="u_n"> <a href='/manager/clients/MP_LOGIN/<?if($order_==''){echo"DESC";}?>'>лог. MP</a></th>
                                    <th class="u_n"> <a href='/manager/clients/MP_PASS/<?if($order_==''){echo"DESC";}?>'>пар. MP</a></th>     
                                     <th class="u_n"> <a href='/manager/clients/DostPtrice/<?if($DostPtrice_==''){echo"DESC";}?>'>Ст. дост.</a></th>     
                                    <th class="u_f"> <a href='/manager/clients/fullname/<?if($order_==''){echo"DESC";}?>'>Фамилия, Имя, Отчество</a></th>
									<th class="t_share"><a href='/manager/clients/discont/<?if($order_==''){echo"DESC";}?>'> Скидка</a></th>
									<th class="t_bal"> <a href='/manager/clients/balans/<?if($order_==''){echo"DESC";}?>'>Баланс</a></th>

									<th class="u_tel"> <a href='/manager/clients/tel/<?if($order_==''){echo"DESC";}?>'>Телефон</a></th>
                                    <th class="u_mail"><a href='/manager/clients/email/<?if($order_==''){echo"DESC";}?>'> Почта</a></th>
									<th class="u_pass"> Пароль </th>
									<th class="u_pr" width='15px'>  Поля </th>
									<th class="u_pr"><a href='/manager/clients/price/<?if($order_==''){echo"DESC";}?>'> Прайс</a></th>
									<th class="u_pr"> <a href='/manager/clients/show_gr/<?if($order_==''){echo"DESC";}?>'>Группы</a></th>
                                    
                                    <th class="u_pr"> <a href='/manager/clients/full_art/<?if($order_==''){echo"DESC";}?>'>Полн. арт.</a></th>
									<th class="u_pr"> <a href='/manager/clients/disc_type/<?if($order_==''){echo"DESC";}?>'>Рын ск.</a></th>
                                    <th class="u_pr"> <a href='/manager/clients/disc_type_sup/<?if($order_==''){echo"DESC";}?>'>Тип(для пост.)</a></th>
									  
                                    <th class="u_pr"> <small>на EMAIL</small></th>
                                    <th class="del_row">x </th>
								</tr>
							</thead>

							<tbody>
							<?if(isset($new)){?>
								<tr class="add_user_row">
									<td>
										<div><input id='card' type="text"></div>
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
									</td>
									<td>
										&nbsp;
									</td>
									<td>
										<div><input id='price' type="checkbox"></div>
									</td>
                                    <td>
                                        <div><input id='show_gr' type="checkbox"></div>
                                    </td>
                                    <td>
                                        <div><input id='full_art' type="checkbox"></div>
                                    </td>
									<td>
										<div><input id='to_mail' type="checkbox"></div>
									</td>
<td>    <div><select id='disc_type_sup' >
                            <option value="rozn" >Розница</option>
                            <option value="sto"  >СТО и магазины</option>
                            <option value="l_opt"  >Мелкий опт</option>
                            <option value="m_opt" >Средний опт</option>
                            <option value="s_opt"  >Крупный опт</option>
                            </select>
                          
                           
                                    </div>
                                    </td>
                                    <td>
                                        <div><input id='disc_type' type="checkbox"></div>
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
									<td><a href="/manager/client/<?=$val['id']?>"><?=$val['card']?></a></td>
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
                                    </td>
                                        <td>     
                                                                                                   
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
									<td width='15px'>
										<a title="" href="/manager/user_fields/<?=$val['id']?>" class="edit_ico"  ></a>
									</td>
									<td>
										<div><input id='price_<?=$count?>' type="checkbox" <?if($val['price']>0) {?>checked = 'checked'<?}?>></div>
									</td>
<td>    <div><input id='show_gr_<?=$count?>' type="checkbox" <?if($val['show_gr']>0) {?>checked = 'checked'<?}?>></div>
                                    </td>
									<td>	<div><input id='full_art_<?=$count?>' type="checkbox" <?if($val['full_art']>0) {?>checked = 'checked'<?}?>></div>
									</td>
                                    <td>    <div><input id='disc_type_<?=$count?>' type="checkbox" <?if($val['disc_type']>0) {?>checked<?}?>></div>
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
                                    <td>    <div><input id='to_mail_<?=$count?>' type="checkbox" <?if($val['send_mail']>0) {?>checked = 'checked'<?}?>></div>
                                    </td>
                                    
                                    
									<td><span class="t_del"   onclick='location.replace("/manager/clients/<?=$order?>/<?if($order_==''){echo"-";}else{echo"DESC";}?>/del/<?=$val['id']?>")'>x</span></td>
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