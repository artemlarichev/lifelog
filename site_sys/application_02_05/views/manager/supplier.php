<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
<script type="text/javascript" src="/js/upload.js"></script>
	<div class="base" id="wrapper">
		<?php  $this->load->view('user/header');  ?>
		<div class="main_row">

			<? if (isset($msg)) { ?>	<h3 style='color:red;margin:10px;'><?=$msg?></h3> <? }?>

      		<div class="content_row suppliers_page">

				<div class="suppliers_addi_info">
					<ul class="suppliers_menu">
						<li><a href="/manager/suppliers/ukraine" <?	if ($type == 'ukraine' ) {?>class="mark"<?}?> title="Украина">Украина</a></li>
						<li><a  href="/manager/suppliers/ects" <?	if ($type == 'ects' ) {?>class="mark"<?}?> title="Зарубеж">Зарубеж</a></li>
					</ul>
					<?	if ($edit_act == '-' ) {?>
					<input id="add_provider" type="button" value="Добавить поставщика"  onclick='location.replace("/manager/suppliers/0/<?=$type?>")' >
					<?}else{?>
					<input id="add_provider" type="button"  type="button" value="Сохранить" onclick='document.forms.forma.submit()'>

					<?}?>
				</div>

			</div>      <form action='/manager/suppliers/<?=$type?>'  name ='forma' method='post'>
           				<div class="big_table_wrap">

						<table class="big_table table" id='main_tab'>
						<thead>
								<tr>
									<th> Название</th>
									<th class="small_field"> Шифр</th>
									<th class="t_field"> Корр. цены</th>
									<th class="tel_field"> Телефон</th>
									<th> Почта</th>
									<th> Контактное лицо</th>
									<th class="middle_field"> Срок поставки</th>
									<th class="edit_col"><span class="edit_ico"></span></th>
									<th class="del_row">х</th>
								</tr>
							</thead>

							<tbody>

							<tr class="table_edit_row">
										<td>
											<div class="input_wrap">
												 <input type="text" name="name"   value="<?=$supplier['name']?>">
												 <input type="hidden" name="id" id='id' value="<?=$supplier['id']?>">
												 <input type="hidden" name="type" value="<?=$supplier['type']?>">
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<input type="text" name="cod" value="<?=$supplier['cod']?>">
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<input type="text" name="discont" value="<?=$supplier['discont']?>">
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<input type="text" name="phone" value="<?=$supplier['phone']?>">
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<input type="text" name="email" value="<?=$supplier['email']?>">
											</div>
										</td>
										<td>
											<div class="input_wrap">
												<input type="text" name="manager" value="<?=$supplier['manager']?>">
											</div>
										</td>
										<td>
											<div class="two_inputs_wrap">
												<input type="text" name="post_1" value="<?=$supplier['post_1']?>"><span>&#151;</span><input type="text"name="post_2" value="<?=$supplier['post_2']?>">
											</div>
										</td>
										<td><a class="edit_ico" href="/manager/supplier/<?=$supplier['id']?>"></a></td>
											<td>
												<a href="/manager/supplier/<?=$supplier['id']?>/del"><span class="t_del">х</span></a>
											</td>
									</tr>



							</tbody>
						</table>


			</div>
 	<div class="content_row suppliers_page">


				<dl class="suppliers_form">
					<dt>
						<label for="additional_tel">Дополнительные телефоны:</label>
					</dt>
					<dd>
						<textarea  name="add_phone"  id="additional_tel" cols="30" rows="10"><?=$supplier['add_phone']?></textarea>
					</dd>
					<dt>
						<label for="address">Адрес:</label>
					</dt>
					<dd>
						<textarea  name="addres"  id="address" cols="30" rows="10"><?=$supplier['addres']?></textarea>
					</dd>
					<dt>
						<label for="details">Реквизиты:</label>
					</dt>
					<dd>
						<textarea  name="inf"   id="details" cols="30" rows="10"><?=$supplier['inf']?></textarea>
					</dd>
					<dt>
						<label for="recipient">Получатель:</label>
					</dt>
					<dd>
						<textarea  name="resiver"   id="recipient" cols="30" rows="10"><?=$supplier['resiver']?></textarea>
					</dd>
					<dt>
						<label for="note">Примечание:</label>
					</dt>
					<dd>
						<textarea  name="desc"   id="note" cols="30" rows="10"><?=$supplier['desc']?></textarea>
					</dd>

				</dl>
		  	<div class="suppliers_aside">
					<div class="suppliers_import">
					<!--<p class="import_info">Цены импортируются автоматически ежедневно в 2:00</p>-->
					</div>
					<div class="suppliers_matching_fields">

							<label for="import_field">Загрузка прайса:</label>
							<input type="button" name="import_field" id="import_field" value="Выбрать файл">
							<span class="import_file_name"></span>
							<input type="button" onclick='GoPrice()' value="Загрузить" id='btn' style='display:none' >

						<div class="export_result">
							<span class="fail"  id="fail"  style='display:none' >Не выполнено</span>
							<span class="success"  id="success"  style='display:none' >Выполнено</span>
						</div>
					</div>
					<div id='price_fields'>

					</div>

                    <div class="export_result" id='bad' style="display: none;">
                             
                        </div>
                    
							</div>
			 </div>
  </form>
<script type="text/javascript">



function AddUploader()
{
	new AjaxUpload('#import_field', {
								  action: '/manager/upload_price/',
								  // имя файла
								  name: 'price',
								  // дополнительные данные для передачи
								  data: {
								    supplier_id : $('#id').val()
								  },
								  // авто submit
								  autoSubmit: true,
								  responseType: false,
								  // отправка файла сразу после выбора
								  // удобно использовать если  autoSubmit отключен
								  onChange: function(file, extension)
								  {   $('.fail').hide();$('.success').hide();$('#btn').hide();
								  	  $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
								  	  },
								  // что произойдет при  начале отправки  файла
								  onSubmit: function(file, extension) { },
								  // что выполнить при завершении отправки  файла
								  onComplete: function(file, response) {
								  if(response==0) {$('.fail').show(); $.unblockUI();return false;}
                                      $('.import_file_name').html(file) ;
								    $('#price_fields').html(response); $('#price_fields').show();
								    $('.success').show();
								    $('#btn').show();
								    $.unblockUI();

								    }
								});

     }

	function GoPrice()
	{    
        $('#bad').hide();
        $('.fail').hide();$('.success').hide();
	 	 $.blockUI({message: $('#modal_dialog'), css: {width: '200px'}});
 	 	 $.post("/manager/import_upload_price/",{
		supplier_id:$('#id').val() ,
		field_1:$('#field_1').val() ,
		field_2:$('#field_2').val() ,
		field_3:$('#field_3').val() ,
		field_4:$('#field_4').val() ,
		field_5:$('#field_5').val()


		},function(data){
	      if(data=='ok') {$('.success').show();$('#price_fields').hide();}
	      else {$('.success').show(); $('#bad').html(data);$('#bad').show();}

	    $.unblockUI();  });
    }
     AddUploader();
  </script>

<style>
 th{cursor:pointer}
</style>

 	 	</div>

	</div>
	<?php  $this->load->view('page_elements/footer');  ?>
</div>
</body>
</html>