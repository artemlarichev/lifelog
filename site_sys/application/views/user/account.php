<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
	<div class="base" id="wrapper">

	<?php  $this->load->view('user/header');  ?>



		<div class="main_row">
		<form action="" method='post'>
	<? if(isset($msg)){?>	<h3 style='color:red;margin:10px;'>Изменение сохранены</h3> <?}?>
    					<div class="content_row">
				<div class="main_table_wrap">
					<div class="big_table_wrap">
						<table class="big_table table">
							<thead>
								<tr>
									<th> № карты </th>
									<th> Название фирмы </th>
									<th> Фамилия, Имя, Отчество </th>
									<th> Телефон </th>
                                    <th> Почта </th> 
                                    <th> Оповещать по почте </th> 
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>
										<?=$user['card']?>
									</td>
									<td><?=$user['name']?></td>
									<td><?=$user['fullname']?></td>
									<td class="t_field"><input type="text" class="tel_field" name='tel' value='<?=$user['tel']?>'></td>
								    <td class="t_field"><input type="text" class="mail_field" name='email' value='<?=$user['email']?>'></td>    
                                     <td class="t_field">
                                     <input type="checkbox"    name='send_mail'  <?if($user['send_mail']>0){?> checked="checked" <?}?> value="1"></td> 
								</tr>
							</tbody>
						</table>
						<div class="save_after"><input type="submit" value="Сохранить"></div>
					</div>
				</div>
			</div>

 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>