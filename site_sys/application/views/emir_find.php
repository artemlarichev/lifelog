<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
	<div class="base" id="wrapper">
	<?php  $this->load->view('page_elements/header');  ?>
		<div class="main_row">
 		<div class="content_row">
				<div class="main_table_wrap basket">
					 
<div class="search_form export">

  <form action="" method="post">

     <div id="div_code">
        <span class="example">
    Поиск по емиратах (тест)
        </span>
        <input type="text"   value="" id="search_field" name="search_field">
        <input type="submit" value="Найти"   id="search_submit" name="search_submit">
     </div>

              </div>
</form>                          
          <br><br>           
					<div class="big_table_wrap">
                    <br>  <h3>Найдено </h3><br>  
                    <table class="big_table table">
                           <thead>
                                <tr>
                                    <th class="marking">
                                         Артикул
                                    </th>
                                    <th class="maker"> Производитель  </th>
                                    <th   >Описание </th>
                                    <th > страна </th>
                                    <th class="price"> Цена (usd)  </th>
                                        
                                
                                </tr>
                            </thead>  
                            <tbody>
                         <?foreach($result0 as $val){?>
                         <tr>
                         <td><?=$val['DetailNum']?></td> 
                         <td><?=$val['name']?></td>
                         <td><?=$val['DetailName']?></td>
                         
                         <td><?=$val['state']?></td>
                         <td><?=$val['DetailPrice']?></td>
                          
                         </tr>
                         <?}?> 
                            </tbody>
                        </table>
                    <br>  
                    <h3>Аналоги </h3>
                        <br>  <table class="big_table table">
                            <thead>
                                <tr>
                                    <th class="marking">
                                         Артикул
                                    </th>
                                    <th class="maker"> Производитель  </th>
                                    <th   >Описание </th>
                                    <th > страна </th>
                                    <th class="price"> Цена (usd)  </th>
                                        
                                
                                </tr>
                            </thead>

                            <tbody>
                         <?foreach($result1 as $val){?>
                         <tr>
                         <tr>
                         <td><?=$val['detailnums']?></td> 
                         <td><?=$val['name']?></td>
                         <td><?=$val['DetailName']?></td>
                         
                         <td><?=$val['state']?></td>
                         <td><?=$val['DetailPrice']?></td>
                          
                         </tr>
                         </tr>
                         <?}?> 
                            </tbody>
                        </table>
                        
 <h3>Поиск по наличию (коди использованы в поиске (<?=$keys?>)) </h3>
                        <br>  <table class="big_table table">
                            <thead>
                                <tr>
                                    <th class="marking">
                                         Артикул
                                    </th>
                                    <th class="maker"> Производитель  </th>
                                    <th   >Описание </th>
                                    
                                    <th class="price"> Цена (uah)  </th>
                                        
                                
                                </tr>
                            </thead>

                            <tbody>
                         <?foreach($result2 as $val){?>
                         <tr>
                         <tr>
                         <td><?=$val['article']?></td> 
                         <td><?=$val['manuf']?></td>
                         <td><?=$val['car_desc']?></td>
                          
                         <td><?=$val['price_uah']?></td>
                          
                         </tr>
                         </tr>
                         <?}?> 
                            </tbody>
                        </table>                        
						 
	 </div>
				</div>
			</div>

 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>