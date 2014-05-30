<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<script type="text/javascript">
function Show(type)
{
	$("#tab_in").hide();
    $("#tab_out").hide();
    $("#tab_"+type).show();
}
</script>
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('user/header');  ?>

 	<div class="main_row">

  <br />
  <?if($status==2){?>   
Отображены выполненные заказы за неделю <a href='/client/orders/3/<?=$show_parts?>'>Показать все</a>
<br /><br />
<?}?>  
    
    
 <div class="content_row">  	<div class="main_table_wrap">
					<div class="big_table_wrap">
						<?if(sizeof($orders)>0){?>
						<table class="table" id='orders_new' >
							<thead>
								<tr>
                                    <th>
                                         № заказа
                                    </th>
                                    <th>
                                         Поставщик
                                    </th>
									<th> № накладной </th>
									<th> № декларации </th>
									<th> Дата </th>
									<th> Время </th>
									<th> № карты </th>
									<th> Имя </th>
									<th> Фамилия </th>
									<th class="sum"><a title="Сумма" href="">Сумма </th>

								</tr>
							</thead>

							<tbody>
							<?foreach($orders as $val){?>
								<tr>
									<td>
										<a href='/client/order/<?=$val['id']?>'><?=$val['id']?></a>
										<!--<img src='/i/down.png'   id='show_im_<?=$val['id']?>'
										onclick='ShowTabOrder(<?=$val['id']?>)' style='cursor:pointer'>-->
									</td>
                                    <td>
                                    <?if($val['type']=='0_sklad') echo 'наличие';?>
                                    <?if($val['type']=='1_ukr') echo 'укр. пост.';?>
                                    <?if($val['type']=='2_mp') echo 'дальний заказ';?>
                                    </td>
                                    <td><?=$val['nakladna']?></td>
									<td><?=$val['dekl']?></td>
									<td><?=russian_date($val['data'])?></td>
									<td><?=$val['time']?></td>
									<td><?=$val['card']?></td>
									<td><?=$val['name']?> </td>
									<td><?=$val['fullname']?></td>
									<td class="numeric"><?=$val['summ']?></td>
					 </tr>

								<?if(isset($orders_details[$val['id']])){ ?>
								<tr >
								<td colspan='9' style='padding:0px;border:0px;Display:none' id='order_tab_<?=$val['id']?>'>
	                             <?$this->load->view('manager/_sub_order',array('order'=>$val,'orders_details'=>$orders_details) );?>

								</tr>
								<?}

							 }?>
							</tbody>
						</table>
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