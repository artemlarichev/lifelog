<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

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
					<input id="add_provider" type="button" value="Добавить поставщика"  onclick='location.replace("/manager/supplier/0/edit/<?=$type?>")' >
					<?}else{?>
					<input id="add_provider" type="button"  type="button" value="Сохранить" onclick='document.forms.forma.submit()'>

					<?}?>
				</div>

			</div>
           				<div class="big_table_wrap">
           				<form action='/manager/suppliers/<?=$type?>'  name ='forma' method='post'>
						<table class="big_table table" id='main_tab'>
						<thead>
								<tr>
									<th> Название</th>
                                    <th class="small_field"> очистить</th>
                                    <th class="small_field"> Шифр</th>
									<th class="t_field"> Корр. цены</th>
									<th class="tel_field"> Телефон</th>
									<th> Почта</th>
									<th> Контактное лицо</th>
									<th class="middle_field"> Срок поставки</th>
                                    <th> Почта (заказы)</th>
                                    <th> Время</th>
                                    <th>Отправлять<br>
                                    </th>
									<th class="edit_col"><span class="edit_ico"></span></th>
									<th class="del_row">х</th>
								</tr>
							</thead>

							<tbody>
								<? if ($edit_act == '0' and isset($_SESSION['manager'])) {
									?>
<tr class="table_edit_row">
										<td>
											<div class="input_wrap">
												 <input type="text" name="name" value="<?=$supplier['name']?>">
												 <input type="hidden" name="id" value="<?=$supplier['id']?>">
												 <input type="hidden" name="type" value="<?=$supplier['type']?>">
											</div>
										</td>
                                        <td></td>
                                            
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
                                          <td>          
                                            <div class="input_wrap">
                                                <input type="text" name="price_mail" value="<?=$supplier['price_mail']?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_wrap">
                                                <input type="text" name="price_time" value="<?=$supplier['price_time']?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_wrap">
                                                <input type="checkbox" name="send_price" value="1"
                                                <?if($supplier['send_price']>0){?> checked="checked" <?}?>>
                                            </div>
                                        </td>
                                        
										<td><a class="edit_ico" href="/manager/supplier/<?=$supplier['id']?>"></a></td>
											<td>
												<a href="/manager/supplier/<?=$supplier['id']?>/del"><span class="t_del">х</span></a>
											</td>
									</tr>

									<?
								}

								foreach ($suppliers as $supplier) {
									if ($edit_act == $supplier['id']   ) {
										?>
										<tr class="table_edit_row">
										<td>
											<div class="input_wrap">
												 <input type="text" name="name" value="<?=$supplier['name']?>">
												 <input type="hidden" name="id" value="<?=$supplier['id']?>">
												 <input type="hidden" name="type" value="<?=$supplier['type']?>">
											</div>
										</td>
                                        <td>
                                                <a href="/manager/supplier_clear/<?=$supplier['id']?>" onclick="return confirm('Удалить?')"><span class="t_del">х</span></a>
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
                                        <td>          
                                            <div class="input_wrap">
                                                <input type="text" name="price_mail" value="<?=$supplier['price_mail']?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_wrap">
                                                <input type="text" name="price_time" value="<?=$supplier['price_time']?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input_wrap">
                                                <input type="checkbox" name="send_price" value="1"
                                                <?if($supplier['send_price']>0){?> checked="checked" <?}?>>
                                            </div>
                                        </td>
                                        
										<td><a class="edit_ico" href="/manager/supplier/<?=$supplier['id']?>"></a></td>
											<td>
												<a href="/manager/supplier/<?=$supplier['id']?>/del"><span class="t_del">х</span></a>
											</td>
									</tr>

										<? }
										 else
										 { ?>
										<tr>
										<td>
											<a href="/manager/supplier/<?=$supplier['id']?>/edit_all" title="<?=$supplier['id']?>"><?=$supplier['name']?></a>
										</td>
                                         <td>
                                                <a href="/manager/supplier_clear/<?=$supplier['id']?>" onclick="return confirm('Удалить?')"><span class="t_del">х</span></a>
                                            </td>
										<td>
											<?=$supplier['cod']?>
										</td>
										<td class="numeric">
											<?=$supplier['discont']?>%
										</td>
										<td>
											<?=$supplier['phone']?>
										</td>
										<td>
											<?=$supplier['manager']?>
										</td>
										<td>
											<?=$supplier['email']?>
										</td>
										<td>
											<?=$supplier['post_1']?>—<?=$supplier['post_2']?>
										</td>
                                        <td>
                                            <?=$supplier['price_mail']?>          
                                        </td>
                                        <td>
                                            <?=$supplier['price_time']?>
                                        </td>
                                        <td>
                                            <?if($supplier['send_price']>0) echo "+";else echo "-";?>
                                        </td>
										<td><a class="edit_ico" href="/manager/supplier/<?=$supplier['id']?>"></a></td>
											<td>
												<a href="/manager/supplier/<?=$supplier['id']?>/del"><span class="t_del">х</span></a>
											</td>
 									</tr>
										<?
								}}?>

							</tbody>
						</table>

				</form>
			</div>

<script src="/js/ui.tablesorter.js" type="text/javascript"></script>

<script type="text/javascript">

$.tablesorter.addParser({
    id: "datetime",
    is: function(s) {
        return false;
    },
    format: function(s,table) {
        s = s.replace(/\-/g,"/");
        s = s.replace(/(\d{1,2})[\.\-](\d{1,2})[\.\-](\d{4})/, "$3/$2/$1");
        return $.tablesorter.formatFloat(new Date(s).getTime());
    },
	    type: "numeric"
});

  $("#main_tab").tablesorter({  widgets: ['zebra']  }) ;

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