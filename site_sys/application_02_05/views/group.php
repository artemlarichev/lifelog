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
				<?if($search_type=='code'){?>
					<dl class="table_filter">
						<dt>Уточните группу:</dt>
						<dd>
							<select id="group" name="group" onchange='Change_group_1()'>
							<option value=""></option>
							<?foreach($res_group as $val){?>
								<option value="<?=$val['group']?>"><?=$val['group']?></option>
							<?}?>
							</select>
						</dd>
						<dd>
							<select id="group_1" name="group_1" onchange='Change_group_2()'>

							</select>
						</dd>
						<dd>
							<select id="group_2" name="group_2" >

							</select>
						</dd>
					</dl>
                   <?}?>
 
					<div class="big_table_wrap">
                 <? if(isset($_SESSION['manager']))
                   {
                   	$this->load->view('page_elements/search_table_manager');
                   }
                   elseif(isset($_SESSION['user']))
                   {   // print_r($_SESSION['user']);
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
                     ?>

					</div>
				</div>
			</div>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>