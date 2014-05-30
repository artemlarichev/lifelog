<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<script type="text/javascript">
function Show(type)
{
	$("#tab_in").hide();
    $("#tab_out").hide();
    $("#tab_"+type).show();
}
</script>
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('manager/header');  ?>
 		<div class="main_row">
			<div class="content_row">
								<div class="export_result">
						<?if(isset($res)){?><span class="success">Выполнено</span>  <?}?>
						<!--<span class="with_errors">Выполнено с ошибками</span> -->
						<?if(isset($err)){?><span class="fail">Не выполнено - <?=$err?></span>   <?}?>
					</div>
			</div>
		</div>



 	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>