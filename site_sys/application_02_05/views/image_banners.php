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
       <h2 class="content_h2">Баннеры</h2>
        <form method="post" enctype="multipart/form-data">
 <table>
     <? if(!isset($images)) $images=array();
    foreach($images as $image){?>
    <tr>
    <td ><img src="/i/banners/<?=$image->image?>"  width="400px"></td>
    <td>загрузить файл <input  name="images_file[]" type="file"> <a href="/manager/banners/<?=$image->id?>">X</a><br> 
      <input  name="images_id[]" value="<?=$image->id?>"  type="hidden"><br>
    </td>
    </tr> 
    <?}?>
    <tr>
    <td > </td>
    <td>загрузить файл <input  name="images_file[]" type="file"><br> 
      <input  name="images_id[]"  type="hidden"><br>
    </td>
    </tr> 
    
     <tr id='pre_im' ><td colspan="2"><button onclick="AddImage();return false" type="button">Добавить изображение</button></td></tr>  
    <tr>
     <tr   ><td colspan="2"><input type="submit" value="Сохранить"></td></tr>  
 </table>
 
 
 
       
       </form>
        <script type=""> 
    
    function AddImage(){
        var  cont ='<tr><td > </td>    <td>загрузить файл <input  name="images_file[]" type="file"><br>  <input  name="images_id[]"  type="hidden"><br>    </td>    </tr> ';
         $('#pre_im').before(cont);
    }
     
    function DelParent(el){
         $(el).parent().remove();
    }
    </script>   
       
         </div>
	 		</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>