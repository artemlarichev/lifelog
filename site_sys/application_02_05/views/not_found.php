<!DOCTYPE HTML>
<html lang="ru-RU">
<?php
$count=1;
 $this->load->view('page_elements/head');  ?>
 <script type="text/javascript" >p_count='<?=$count?>';//'</script>
<body class="main_page">
<div class="wrapper">
	<div class="base" id="wrapper">
	<?php  $this->load->view('page_elements/header');  ?>

		<div class="main_row">
<div class="content_row">
<div class="text_content">
       <h2 class="content_h2">Страница не найдена</h2>
       
       <a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)" >назад </a>
         </div>
	 		</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>