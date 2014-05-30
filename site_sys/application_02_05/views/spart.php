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
								 
									 
								</tr>
							</thead>

							<tbody>
								<tr class="table_check_row_prepare">
									<td>
										<a title="<?=hide_value($part['product'])?>" href=""><?=hide_value($part['product'])?></a>
									</td>
									<td><?=$part['producer']?></td>
									<td><?=$part['desc']?> </td>
									<td class="numeric">
                                  <a href="#"  onclick="findRandKey('<?=$part['product']?>')"> Узнать цену</a>
                                    </td>
								 
									 
								</tr>
								 
							</tbody>
						</table>
                       
                        <? $image= $this->data->get_image_by_article($part['product']);
                        
                        if($image){?>
						 <div style="float: left; margin: 10px;">
                         <a href="/i/febest/<?=$image['image_1']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_1']?>" class="spare_part_img">
                         </a>
							
						</div>
                         <?if($image['image_2']!=''){?>
                         <div style="float: left; margin: 10px;">
                                                   <a href="/i/febest/<?=$image['image_2']?>" rel='fancybox_group'>
                         <img alt="" src="/i/febest/th.php?IM=<?=$image['image_2']?>" class="spare_part_img">
                         </a>
                        </div> 
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