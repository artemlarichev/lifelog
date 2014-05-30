			<div class="aside news">
					<h2 class="headline">Новости компании</h2>
					<?if(isset($_SESSION['manager'])){?>
					<a title="Добавить новость" href="/manager/news/new" class="add">Добавить новость</a>
					<?}?>
					<ul class="news_list">
					<?foreach($news as $val){?>
						<li class="n_l_item">
							<h3 class="n_l_hline"><?=$val['title']?> </h3>
						<div class="n_l_text">
								<?=$val['text']?>
							</div>
						</li>
						<?}?>
					</ul>
                    <div class="base_i_breadcrumbs"><a title="База знаний" href="/articles">База знаний</a> /</div>  
                          <ul class="brand_list">
                    <?foreach($cats as $item){
                     
                        ?>
                        <li><a title="<?=$item['title']?>" href="/articles/<?=$item['url']?>"><?=$item['title']?></a></li>
                        <?}?>
                               
                    </ul>      
                    <h2 class="tags_hline">Ключевые слова</h2>
                    <ul class="tags_list">
                    <?
                     $cnt=sizeof($keys);$i=0;
                    if($cnt>0)   
                    
                    foreach($keys as $key) {
                        $i++;
                    ?>
                        <li><a title="<?=$key?>" href="/articles/keywords/<?=trim($key)?>"><?=trim($key)?></a><?if($i<$cnt) echo","?> </li>
                    <?}?>    
                             
                    </ul>
				</div>
