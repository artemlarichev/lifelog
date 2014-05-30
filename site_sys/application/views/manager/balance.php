<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<script type="text/javascript">
	function Show(type) {
		$("#tab_in").hide();
		$("#tab_out").hide();
		$("#tab_" + type).show();
	}
</script>
<div class="wrapper">

	<div class="base" id="wrapper">
		<?php  $this->load->view('user/header');  ?>
		<div class="main_row">
			<form action="" method='post'>
				<? if (isset($msg)) { ?>	<h3 style='color:red;margin:10px;'>Изменение сохранены</h3> <? }?>
				<div class="content_row">
					<div class="balance_filter">
						<label for="d_f_1">
							<input type="radio" id="d_f_1" name="b_f" checked onclick='Show("in")'>
							Начисления
						</label>
						<label for="d_f_2">
							<input type="radio" id="d_f_2" name="b_f" onclick='Show("out")'>
							Списания
						</label>
					</div>
					<div class="small_table_wrap">
						<table class="small_table table" id='tab_in'>
							<thead>
								<tr>
									<th><a title="Дата" href="">Дата</a></th>
									<th class="sum"><a title="Сумма" href="">Сумма</a></th>
									<th><a title="№ накладной" href="">№ накладной</a></th>
									<th><a title="№ декларации" href="">№ декларации</a></th>
								</tr>
							</thead>

							<tbody>
								<?foreach ($payin as $val) { ?>
								<tr>
									<td>
										<?=russian_date($val['data'])?>
									</td>
									<td class="numeric"><?=$val['value']?></td>
									<td><?=$val['nakladna']?></td>
									<td><?=$val['decl']?></td>
								</tr>
								<? }?>
							</tbody>
						</table>
						<table class="small_table table" style='display:none' id='tab_out'>
							<thead>
								<tr>
									<th><a title="Дата" href="">Дата</a></th>
									<th class="sum"><a title="Сумма" href="">Сумма</a></th>
									<th><a title="№ накладной" href="">№ платежки</a></th>
									<th><a title="№ декларации" href="">№ перевода</a></th>
								</tr>
							</thead>

							<tbody>
								<?foreach ($payout as $val) { ?>
								<tr>
									<td>
										<?=russian_date($val['data'])?>
									</td>
									<td class="numeric"><?=$val['value']?></td>
									<td><?=$val['nakladna']?></td>
									<td><?=$val['decl']?></td>
								</tr>
								<? }?>
							</tbody>
						</table>

					</div>

				<!--	<div class="big_table_wrap">
						<table class="big_table table">
							<thead>
								<tr>
									<th class="marking">
										<a href="" title="Артикул">Артикул</a>
									</th>
									<th class="maker"><a href="" title="Производитель">Производитель</a></th>
									<th class="important"><a href="" title="Примечание">Примечание</a></th>
									<th class="price"><a href="" title="грн.">грн.</a></th>
									<th class="col"><a href="" title="шт.">шт.</a></th>
									<th class="sum"><a href="" title="Сумма">Сумма</a></th>
									<th class="edit_col"><span class="edit_ico"></span></th>
									<th class="del_row">х</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>
										<a href="" title="1500A023">1500A023</a>
									</td>
									<td>JAPAN LINE</td>
									<td>1500A023</td>
									<td class="numeric"><input type="text"></td>
									<td class="numeric"><input type="text"></td>
									<td class="numeric">378</td>
									<td><a class="edit_ico" href="" title=""></a></td>
									<td><span class="t_del">х</span></td>
								</tr>
								<tr>
									<td>
										<a href="" title="1500A023">1500A023</a>
									</td>
									<td>JAPAN LINE</td>
									<td>1500A023</td>
									<td class="numeric"><input type="text"></td>
									<td class="numeric"><input type="text"></td>
									<td class="numeric">378</td>
									<td><a class="edit_ico" href="" title=""></a></td>
									<td><span class="t_del">х</span></td>
								</tr>
								<tr>
									<td colspan="8" class="table_hline_row">
										<h2 class="table_hline">Воздушные</h2>
									</td>
								</tr>
								<tr>
									<td>
										<a href="" title="1500A023">1500A023</a>
									</td>
									<td>JAPAN LINE</td>
									<td>1500A023</td>
									<td class="numeric"><input type="text"></td>
									<td class="numeric"><input type="text"></td>
									<td class="numeric">378</td>
									<td><a class="edit_ico" href="" title=""></a></td>
									<td><span class="t_del">х</span></td>
								</tr>
								<tr class="last_row">
									<td colspan="3" class="no_border">
									</td>
									<td colspan="2" class="no_border">
										<input type="submit" value="Обновить">
									</td>
									<td class="numeric">
										378 520</td>
									<td colspan="2" class="no_border"></td>
								</tr>
							</tbody>
						</table>
					</div>   -->
				</div>

		</div>

		<?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>