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
      <script type="text/javascript" >f_id='<?if(isset($f_id)){print($f_id);}?>';//'</script>
		<div class="main_row">
		<style>
		.table_filter dd {
    float: left;
    padding: 0 10px 0 0;
    width:auto;
	}
		</style>
<div class="content_row">
				<div class="main_table_wrap">
					<dl class="table_filter">
						<dt>Уточните группу:</dt>
						<?if(!($part['group']=='')){?>
						<dd>
							<a href="/group/<?=$part['group']?>"><?=$part['group']?></a>
						</dd>
						<?}?>
						<?if(!($part['group']=='') and !($part['group_1']=='') ){?>
						<dd>
						»	<a href="/group/<?=$part['group']?>/<?=$part['group_1']?>"><?=$part['group_1']?></a>
						</dd>
						<?}?>

						<?if(!($part['group']=='') and !($part['group_1']=='') and !($part['group_2']=='') ){?>
						<dd>
						»	<a href="/group/<?=$part['group']?>/<?=$part['group_1']?>/<?=$part['group_2']?>"><?=$part['group_2']?></a>
						</dd>
						<?}?>
						<dd class="back_wrap">
							<a title="Назад" href="javascript:history.go(-1)" class="back">Назад<span></span></a>
						</dd>
					</dl>
								 
					<div class="big_table_wrap">
						<table class="big_table table">
							<thead>
								<tr>
									<th class="marking">
										<a title="Артикул" href="">Артикул</a>
									</th>
									<th class="maker"> Производитель </th>
									<th class="important"> Описание автомобиля  </th>
									<th class="price"> цена </th>
									<!--<th class="col"><a title="шт." href="">шт.</a></th>-->
									<th class="buy"><input type="submit" value="Купить" id="buy" name="buy" onclick='Buy()'></th>
								</tr>
							</thead>

							<tbody>
								<tr class="table_check_row_prepare">
									<td>
										<a title="<?=hide_value($part['article'])?>" href=""><?=hide_value($part['article'])?></a>
									</td>
									<td><?=$part['manuf']?></td>
									<td><?=$part['car_desc']?> </td>
									<td class="numeric">
                                    <?=$this->catalog_model->get_price($part,$_SESSION['valuta'],$this->conf['nacenka'])?>
                                    </td>
									<!--<td class="numeric"><?=$part['amount']?></td>-->
									<td class="f_buy">
									<input type="text" name='count_<?=$count?>'  id='count_<?=$count?>'>
									 <input type="hidden" name='id_<?=$count?>'  id='id_<?=$count?>' value='<?=$part['id']?>'>
									 <input type="hidden" name='amount_<?=$count?>'  id='amount_<?=$count?>' value='<?=$part['amount']?>'>
									 <a title="" href="#" onclick='Buy(<?=$count?>);return false' class="edit_ico"></a>
									  
                                    </td>
								</tr>
								<tr style="display: none;">
									<td colspan="6" class="table_check_row">
										<div class="lable_wrap">
											<label><input type="checkbox" id='add1_<?=$count?>' class='add1'> Только этот артикул</label>
										</div>
										<div class="lable_wrap"><label><input id='add2_<?=$count?>' class='add2' type="checkbox"> Только этот производитель</label></div>
										<div class="lable_wrap"><label><input  id='add3_<?=$count?>' class='add3'type="checkbox"> Только это количество</label></div>
										<div class="lable_wrap"><label><input  id='add4_<?=$count?>' class='add4'type="checkbox"> Возможно повышение стоимости</label></div>
										<div class="lable_wrap"><label>
										<input  id='add5_<?=$count?>' class='add5'type="checkbox" > Могу ждать месяц</label></div>

									</td>
								</tr>
							</tbody>
						</table>
                       
                        <? $image= $this->data->get_image_by_article($part['article']);
                        
                        if($image){?>
                      <form method="post" enctype="multipart/form-data">
                      <input type="hidden" name="images_id" value="<?=$image['id']?>">
						 <div style="float: left; margin: 10px;">
                          <?if(isset($_SESSION['manager'])){?> 
                         <a href="/parts/<?=$part['id']?>/1">x</a>
                         <input type="file" name="im_1">
                         <br>
                         <?}?>
                         <a href="/i/febest/<?=$image['image_1']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_1']?>" class="spare_part_img">
                         </a>

							
						</div>  
                         <?if($image['image_2']!=''){?>
                         <div style="float: left; margin: 10px; min-height: 50px;">
                         <?if(isset($_SESSION['manager'])){?> 
                         <a href="/parts/<?=$part['id']?>/2">x</a>
                         <input type="file" name="im_2">
                         <br>
                         <?}?>
                         <a href="/i/febest/<?=$image['image_2']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_2']?>" class="spare_part_img">
                         </a>
                        </div> 
                        <?}?> 
                         <?if($image['image_3']!=''){?>
                       <?if(isset($_SESSION['manager'])){?> 
                         <a href="/parts/<?=$part['id']?>/3">x</a>
                         <input type="file" name="im_3">
                         <br>
                         <?}?>
                           
                         
                         <div style="float: left; margin: 10px;">
                                                   <a href="/i/febest/<?=$image['image_3']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_3']?>" class="spare_part_img">
                         </a>
                      
                       
                           </div> 
                        <?}?> 
                         <?if($image['image_4']!=''){?>
                         <div style="float: left; margin: 10px;">
                         <?if(isset($_SESSION['manager'])){?> 
                         <a href="/parts/<?=$part['id']?>/4">x</a>
                         <input type="file" name="im_4">
                         <br>
                         <?}?>
                         
                                                   <a href="/i/febest/<?=$image['image_4']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_4']?>" class="spare_part_img">
                         </a>
                    
                         </div>
                        <?}?> 
                         <?if($image['image_5']!=''){?>
                         <div style="float: left; margin: 10px;">
                         <?if(isset($_SESSION['manager'])){?> 
                         <a href="/parts/<?=$part['id']?>/5">x</a>
                         <input type="file" name="im_5">
                         <br>
                         <?}?>
                         
                                                   <a href="/i/febest/<?=$image['image_5']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_5']?>" class="spare_part_img">
                         </a>
                       </div> 
                        <?}?> 
                         <?if($image['image_6']!=''){?>
                         <div style="float: left; margin: 10px;">
                         <?if(isset($_SESSION['manager'])){?> 
                         <a href="/parts/<?=$part['id']?>/6">x</a>
                         <input type="file" name="im_6">
                         <br>
                         <?}?>
                         
                         
                                                   <a href="/i/febest/<?=$image['image_6']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_6']?>" class="spare_part_img">
                         </a>
                      </div> 
                        <?}?>  <?if(isset($_SESSION['manager'])){?> <div style="clear: both;"></div>
                         <br><br> <input type="submit" value="Сохранить"> <?}?>
                         </form>
                        
                        <?if(isset($_SESSION['manager'])){?>
                        <div style="clear: both;"></div>
                         <br><br>
                         
                         <b>Привязка фото по артикулах:</b>
                         
                         <form action="" method="POST">
                         <input type="hidden" name="im_id" value="<?=$image['id']?>">
                         <input type="text" name="articles" style="width: 500px;" value='<?=$image['articles']?>'><br>
                         <input type="submit" value="Сохранить">
                         </form>
                        
                        <?}?>
                        <?}?>
					</div>
				</div>
			</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
          <script type="text/javascript">
        $(document).ready(function() {
 
            $("a[rel=fancybox_group]").fancybox({
                'transitionIn'        : 'none',
                'transitionOut'        : 'none',
                'titlePosition'     : 'over',
                'titleFormat'        : function(title, currentArray, currentIndex, currentOpts) {
                    return '<span id="fancybox-title-over">Фото ' + (currentIndex + 1) + ' из ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
                }
            });
   
        });
    </script>  
     
	</div>
</div>
</body>
</html>