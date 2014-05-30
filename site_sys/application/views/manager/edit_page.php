<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('manager/header');  ?>

 	<div class="main_row">
    <form action='' method='post'>
    <input name='title' value='<?=$page['title']?>' style='width:800px;'> <br><br>
        <input name='id' value='<?=$page['id']?>' type='hidden'>
    <textarea name='text' style='width:800px;height:700px'><?=$page['text']?></textarea>
    <br><br> <input  value='Сохранить' type='submit'>
    </form>

 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	 <?php  $this->load->view('manager/tiny_mce');  ?>
	</div>
</div>
</body>
</html>