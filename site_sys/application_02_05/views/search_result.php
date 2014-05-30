<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<?php  $this->load->view('page_elements/order_box');  ?>

<div class="wrapper">
	<div class="base" id="wrapper">
	<?php  $this->load->view('page_elements/header');  ?>
      <script type="text/javascript" >f_id='<?if(isset($f_id)){print($f_id);}?>';//'</script>
		<div class="main_row">
	 <div class="content_row">
				<div class="main_table_wrap">
				<?if($search_type=='code'){?>
				<form method='post' action='' id='forma' name='forma'>
					<dl class="table_filter">
						<dt>Уточните группу:</dt>
						<dd>
							<select id="group" name="group" onchange='Change_group()'>
							<option value=""></option>
							<?foreach($res_group as $val){?>
								<option <?if($search['group']==$val['group']){echo" selected "; }?> value="<?=$val['group']?>"><?=$val['group']?></option>
							<?}?>
							</select>
						</dd>
						<dd>
							<select id="group_1" name="group_1" onchange='Change_group()'>
                             <option value=""></option> <?foreach($res_group_1 as $val){?>

								<option <?if($search['group_1']==$val['group']){echo" selected "; }?> value="<?=$val['group']?>"><?=$val['group']?></option>
							<?}?>
							</select>
						</dd>
						<dd>
							<select id="group_2" name="group_2" onchange='Change_group()' >
							<option value=""></option>
                            <?foreach($res_group_2 as $val){?>
								<option <?if($search['group_2']==$val['group']){echo" selected "; }?> value="<?=$val['group']?>"><?=$val['group']?></option>
							<?}?>
							</select>
						</dd>
					</dl>
					</form>
                   <?}?>
					 <div class="basket_block" id = "basket_block">
					<!--	<?php  $this->load->view('page_elements/basket_block');  ?>-->

					</div>

					<div class="big_table_wrap">
                    <div class="scroll_hor">
                  <?if(!isset($makelogo) ){$makelogo=1;}?>
                  <?if(sizeof($makelogo)>1){?>
<h2>Найдено несколько производителей. Уточните производителя</h2>

        
<table class="big_table table">
            <thead>
                <tr>
                        
    

    


                     <th class="maker"> MakeLogo </th>
                      <th class="maker"> name </th> 
                     <th class="maker"> state </th> 
                     <th class="maker"> поиск </th> 
                      

                </tr>
            </thead>

            <tbody>
             <?foreach($makelogo as $row){?>
                <tr class="table_check_row_prepare">
                    
                   <td><?=$row['MakeLogo']?></td>
                   <td><?=$row['name']?></td>
                   <td><?=$row['state']?></td>
                    <td><a href='/search/result/<?=$f_id?>/<?=$row['MakeLogo']?>'>Поиск>>></td> 
                   
                   </tr>
                   <?}?>
                    
         
                    
            </tbody>
        </table>
        <?}else{   
                   if(!isset($s_sklad)){
                   if(sizeof($result)>0)
                   {

                   if(isset($_SESSION['manager']))
                   {  
                   	$this->load->view('page_elements/search_table_manager');
                   }
                   elseif(isset($_SESSION['user']))
                   {   
                     $fields=explode(',',$_SESSION['user']['fields']);
                     if(sizeof($fields)>1){
                     $data['user_fields']  =$fields;
					$this->load->view('page_elements/search_table_user',$data);
                    	}
                   else{
                   	$this->load->view('page_elements/search_table');
                   	}
                   }
                   else
                   {
                   	$this->load->view('page_elements/search_table');
                   }
                    } else
                    {
                        echo"<br><h2>В наличии товара нет</h2><br>";
                     }    
                       
                   } 
                    if($search['type']=='code') 
                     {
                         $this->load->view('page_elements/add_result');
                     } 
                    
                    
                     ?>
      
             <?}?>  
                 <?  
          
           //$this->load->view('search_desc');
          ?>                 
					</div>
                    </div>
				</div>
			</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>