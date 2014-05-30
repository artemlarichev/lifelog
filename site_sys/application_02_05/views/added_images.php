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
       <h2 class="content_h2">Изображение добавлено</h2><br /><br />
       <a href="/manager/AddImage">Добавить следующий</a> <br /><br />
       <table>
   <tr>
      <td>
        Артикул
      </td>
      <td>
        <b><?=$article?></b>
      </td>
   </tr>
   <tr>
     
</table>
<img  src="/i/febest/<?=$image_1?>"><br /><br />   
<img  src="/i/febest/<?=$image_2?>"><br /><br />
<img  src="/i/febest/<?=$image_3?>"><br /><br />
<img  src="/i/febest/<?=$image_4?>"><br /><br />
<img  src="/i/febest/<?=$image_5?>"><br /><br />
<img  src="/i/febest/<?=$image_6?>"><br /><br />
<img  src="/i/febest/<?=$image_7?>"><br /><br />
       
      
       
       
         </div>
	 		</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>