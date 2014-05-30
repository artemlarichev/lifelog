<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
	<div class="base" id="wrapper">
	<?php  $this->load->view('page_elements/header');  ?>
      <script type="text/javascript" >f_id='<?if(isset($f_id)){print($f_id);}?>';//'</script>
		<div class="main_row">
	 <div class="content_row">
				<div class="main_table_wrap">
 
 
					<div class="big_table_wrap">
                    
                        <?if($mark=='all'){?>
                    
<table class="big_table table">
<thead>
    <tr>
        <th class="marking">
             Производитель
        </th> 
    </tr>
</thead>

    <tbody>
<?    foreach($result  as $val){      
          ?>

    <tr  class="table_check_row_prepare">
        
         <td>       
            <a href="/catalog/emir_suppliers/<?=$val['MakeLogo']?>"><?=$val['name']?>  (<?=$val['state']?>) </a>
        </td> 
         
    </tr>
 <?}?>  
   
    </tbody>
</table> 
                    
                    <?}else{?>
                     <h2><?=$this->catalog_model->MakeLogoName($mark)?></h2>
                    
<table class="big_table table">
<thead>
    <tr>
        <th class="marking">
             Артикул
        </th> 
          <th class="maker"> Производитель </th>    
         <th class="maker"> Описание </th>   
         <th class="maker" style="width: 60px;"> Фото </th>   

    </tr>
</thead>

    <tbody>
    <?  
    foreach($result  as $val){   
          ?>

    <tr  class="table_check_row_prepare">
        
         <td>
            <a href="/catalog/mpart/<?=$val['id']?>"> <?=$val['DetailNum']?>      </a>
        </td> 
        <td><?=$this->catalog_model->MakeLogoName($val['MakeLogo'])?></td>
        <td><?=$val['DetailName']?></td>       
        <td> <? $image= $this->data->get_image_by_article($val['product']);
                                 
                                    if($image){?>
                                     <a class="photoaparat" rel="fancybox_group" href="/i/febest/<?=$image['image_1']?>">
<img style="margin: 3px;" src="/i/photoaparat.png" alt="">
<span class="photoaparat_q">
              <i></i>
             <?if($image['image_2']!='')echo 2;else echo 1;?>
          </span>
</a>
                                    <?if($image['image_2']!=''){?>
                                     
                                      <a href="/i/febest/<?=$image['image_2']?>" rel='fancybox_group'></a>
                                    
                                    <?}?>  
   
                                      <?}?></td>   
          
      
        
        

    </tr>
     
         
    <?}?>
               
    </tbody>
</table> 

<?if($page_cnt>1){?>
                    <ul class="paginator">
                    <?for($i=1;$i<=$page_cnt;$i++){?>
                        <li class="paginator_item <?if($cur_page==$i) echo "active"?>">
                        <a class="paginator_i_link" href="/catalog/emir_suppliers/<?=$mark?>/<?=$i?>" title=""><?=$i?></a></li>
                        <?}?>
                         
                    </ul>
<?}?>


<?}?>
                          
         

					</div>
				</div>
			</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>