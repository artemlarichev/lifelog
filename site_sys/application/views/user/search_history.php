<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
	<div class="base" id="wrapper">
	<?php  $this->load->view('user/header');  ?>
		<div class="main_row">
		<form action="" method='post'>
	<? if(isset($msg)){?>	<h3 style='color:red;margin:10px;'>Изменение сохранены</h3> <?}?>
<div class="content_row">
				<div class="small_table_wrap">
                 <?if(isset($SHORT)){?>
                <h2>За текущие сутки</h2>
                <a href="/client/search_history/arh">Архив</a><br />
                <?}?>
                
					<table class="small_table table" id='main_tab'>
						<thead>
							<tr>
								<th style='cursor:pointer;text-decoration:underline'   > Фраза </th>
								<? if(isset($_SESSION['manager'])) { ?><th class="amount" style='cursor:pointer;text-decoration:underline'  > Количество </th>    <?}?>
							</tr>
						</thead>

						<tbody>
						     <?foreach($result as $val){?>
							<tr>
								<td>
									<a title="Количество" href="#" onclick='History_Search("<?=$val['title']?>");return false'><?=$val['title']?> </a>
								</td>
								<? if(isset($_SESSION['manager'])) { ?><td class="numeric"><?=$val['cnt']?></td>   <?}?>
							</tr>
                               <?}?>
						</tbody>
					</table>

				</div>
			</div>
  <script src="/js/ui.tablesorter.js" type="text/javascript"></script>

<script type="text/javascript">


  $("#main_tab").tablesorter({  widgets: ['zebra']       }) ;

</script>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>