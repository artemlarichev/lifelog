<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('manager/header');  ?>

 	<div class="main_row">
    <form action='/manager/edit_baner/<?=(int)$banner['id']?>/save' method='post'>
    
        <input name='id' value='<?=$banner['id']?>' type='hidden'>
    <textarea name='text' style='width:800px;height:700px'><?=$banner   ['text']?></textarea>
    <br><br> <input  value='Сохранить' type='submit'>
    </form>

 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	 <?php  $this->load->view('manager/tiny_mce');  ?>
	</div>
</div>
</body>
</html>