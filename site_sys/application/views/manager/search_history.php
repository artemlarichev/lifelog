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
				<div class="small_table_wrap">
					<table class="small_table table">
						<thead>
							<tr>
								<th><a title="Фраза" href="">Фраза</a></th>
								<th class="amount"><a title="Количество" href="">Количество</a></th>
							</tr>
						</thead>

						<tbody>
						     <?foreach($result as $val){?>
							<tr>
								<td>
									<a title="Количество" href="/client/user_search/<?=$val['id']?>"><?=$val['title']?> </a>
								</td>
								<td class="numeric"><?=$val['cnt']?></td>
							</tr>
                               <?}?>
						</tbody>
					</table>

				</div>
			</div>

 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>