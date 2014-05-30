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
									<th><a href="" title="№ карты">№ карты</a></th>
									<th><a href="" title="Имя">Имя</a></th>
									<th><a href="" title="Фамилия">Фамилия</a></th>
									<th><a href="" title="Телефон">Телефон</a></th>
									<th><a href="" title="Почта">Почта</a></th>
									<th><a href="" title="Пароль">Пароль</a></th>
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
									<td class="t_field"><input type="password" class="pass_field"   name='pass' value=''></td>
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