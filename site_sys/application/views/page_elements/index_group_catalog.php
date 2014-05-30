			<div class="index_catalog">
				<h2 class="i_c_hline">Каталог запчастей  </h2>
			<?
			 $key1=array_keys($group);
			//if(!isset($_SESSION['namager'])) {shuffle($key1);};
			foreach($key1 as $key){
				  $val= $group[$key];
				  $key2=array_keys($sub_group[$val['group']]);
				  //if(!isset($_SESSION['namager'])) {shuffle($key2);};
				?>
				<dl class="i_c_dlist">
					<dt><?=$val['group']?></dt>
					<?

					foreach($key2 as $key_){
						$sub_val=$sub_group[$val['group']][$key_];
					 ?>
					<dd><a href="/group/<?=$val['group']?>/<?=$sub_val['group']?>" title="<?=$sub_val['group']?>"><?=$sub_val['group']?></a></dd>
					<?}?>
				</dl>
				<?}?>
	 		</div>
