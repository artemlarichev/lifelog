<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<script type="text/javascript">
function SelAll()
{
	if($('#all').attr('checked')){
                $('.sel').attr('checked', true);
            } else {
                $('.sel').attr('checked', false);
            }
}
</script>
<div class="wrapper">
<?

	$fields_keys=array_keys($fields);


?>


	<div class="base" id="wrapper">
	<?php  $this->load->view('user/header');  ?>
		<div class="main_row">
			<div class="content_row">
				<div class="tiny_table_wrap">
				<form action='' method='post'>
						<table class="table">
							<thead>
								<tr>
									<th>
										Название
									</th>
									<th class="check">
										<input type="checkbox" id='all' onclick='SelAll()'>
									</th>
								</tr>
							</thead>

							<tbody>
							<?foreach($fields_keys as $key){?>
								<tr>
									<td>
										<?=$fields[$key]?>
									</td>
									<td>
									<input id='<?=$key?>' class='sel'  name='<?=$key?>' type="checkbox" <?if(isset($user_fields[$key])){echo"checked";}?>></td>
								</tr>
                             <?}?>
								 					</tbody>
						</table>
						<br>
							<input type='submit' name='save' value='Сохранить'>
					</div>

			</div>
		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>
