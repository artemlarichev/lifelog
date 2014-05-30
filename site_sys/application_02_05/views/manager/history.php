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
	<?php  $this->load->view('manager/header');  ?>
 		<div class="main_row">
<div class="content_row">
				<div class="small_table_wrap">
                <?if(isset($SHORT)){?>
                <h2>За текущие сутки</h2>
                <a href="/manager/history/arh">Архив</a><br />
                <?}?>
					<table class="small_table table" id='main_tab'>
						<thead>
							<tr>
                                <th style='cursor:pointer;text-decoration:underline' > Фраза </th>
                                <th style='cursor:pointer;text-decoration:underline' >Время </th>
								<th  style='cursor:pointer;text-decoration:underline'  class="amount"> Количество </th>
							</tr>
						</thead>

						<tbody>
						     <?foreach($result as $val){?>
							<tr>
								<td>
									<a   href="#" onclick='History_Search("<?=$val['title']?>");return false'><?=$val['title']?> </a>
								</td>
                                <td class="numeric" width="130px"><?=$val['time']?></td>
								<td class="numeric"><?=$val['cnt']?></td>
							</tr>
                               <?}?>
						</tbody>
					</table>

				</div>
			</div>


		</div>
     <script src="/js/ui.tablesorter.js" type="text/javascript"></script>

<script type="text/javascript">


  $("#main_tab").tablesorter({  widgets: ['zebra']       }) ;

</script>


 	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>