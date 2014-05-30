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
       <h2 class="content_h2">Добавления изображения к артикулу</h2>
        <form method="post" enctype="multipart/form-data">
       <table>
   <tr>
      <td>
        Артикул
      </td>
      <td>
        <input type="text" name="article">
      </td>
   </tr>
   <tr>
      <td>
         Изображение №1<br />
         <small>
         Загрузить файл или по ссылке
         </small>
      </td>
      <td>
         <input type="file" name="file_1"> URL - 
         <input type="text" name="url_1"> 
      </td>
   </tr>
   <tr>
      <td>
         Изображение №2<br />
         <small>
         Загрузить файл или по ссылке
         </small>
      </td>
      <td>
                 <input type="file" name="file_2"> URL - <input type="text" name="url_2">
      </td>
   </tr>
    <tr>
      <td>
         Изображение №3<br />
         <small>
         Загрузить файл или по ссылке
         </small>
      </td>
      <td>
                 <input type="file" name="file_3"> URL - <input type="text" name="url_3">
      </td>
   </tr>
       <tr>
      <td>
         Изображение №4<br />
         <small>
         Загрузить файл или по ссылке
         </small>
      </td>
      <td>
                 <input type="file" name="file_4"> URL - <input type="text" name="url_4">
      </td>
   </tr>
    <tr>
      <td>
         Изображение №5<br />
         <small>
         Загрузить файл или по ссылке
         </small>
      </td>
      <td>
                 <input type="file" name="file_5"> URL - <input type="text" name="url_5">
      </td>
   </tr>
    <tr>
      <td>
         Изображение №6<br />
         <small>
         Загрузить файл или по ссылке
         </small>
      </td>
      <td>
                 <input type="file" name="file_6"> URL - <input type="text" name="url_6">
      </td>
   </tr>
   
   <tr>
      <td>
         &nbsp;
      </td>
      <td>
        <input type="submit" value="Добавить">
      </td>
   </tr>
</table>
       
       </form>
       
       
         </div>
	 		</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>