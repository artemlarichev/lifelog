<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('manager/header');  ?>

 	<div class="main_row"> 
   <form method="post" action='/manager/edit_baner/<?=(int)$banner['id']?>/save'   class="f_1">
                        <div>
                            <label>
                                <b class="f_1_name">Код баннера</b>
                                <input name='id' value='<?=$banner['id']?>' type='hidden'>
                                <textarea name='text' id='text_banner' style=' height:250px'><?=$banner['text']?></textarea>
                            </label>
                                <label>
                                <b class="f_1_name">№</b>
                                <input type="text" style="width: 30px;" value='<?=$banner['num']?>' name='num'>
                            </label>
                             
                            <div class="button">
                                <button type="submit">Сохранить</button>
                            </div>
                        </div>
                    </form>
 

 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	 <?php  $this->load->view('manager/small_tiny_mce');  ?>
	</div>
</div>
</body>
</html>