<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('manager/header');  ?>

 	<div class="main_row">
                <div class="main_table_wrap order">
                    <a href="/manager/sup_export_csv">Экспорт в ексель</a><br/><br/>
                    <div class="big_table_wrap">

                    <table class="big_table table">
                            <thead>
                                <tr>
                                    
                                     <th class="marking">
                                         Артикул
                                    </th>
                                    <th class="maker"> Производитель </th>
                                    <th class="important"> Описание  </th>
                                     <th class="col"> шт. </th>
                                     <th class="col"> Заказ </th>
                                     <th class="col"> Пользователь </th>
                                    
                                </tr>
                            </thead>

                            <tbody>
                        <? $sup='';
                            foreach($order_parts as $val){
                              if(!($sup==$val['s_name']))
                                {
                                    $sup=$val['s_name'];
                                ?>
                            <tr >
                                    <td class="table_hline_row" colspan="9">
                                        <h2 class="table_hline"><i>Поставщик</i> "<?=$sup?>" </h2>
                                    </td>
                                </tr>
                                 <?}?>
                             
                                <tr   > <td   ><?=$val['article']?></td>
                                     <td   ><?=$val['manuf']?></td>
                                      <td   ><?=$val['note']?></td>
                                      <td   ><?=$val['count']?></td>
                                      <td   ><?=$val['order_id']?></td>
                                      <td   ><?=$val['card']?>
                                      <?=$val['name']?>
                                      <?=$val['fullname']?>
                                      </td>
                               
 
                                </tr>
                                <?}?>
                                    
                            </tbody>
                        </table>



                   
                    </div>
                </div>
    
 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>