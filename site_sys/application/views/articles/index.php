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

		<div class="main_row">
 <div class="content_row">
                <div class="text_content">
 
                    <div class="article_list">
                    <?foreach($last_articles as $item){
                         if($item['id']==$article['id']) continue;
                        ?>
                        <div class="article_l_item">
                            <h2 class="article_l_i_hline">
                                <a title="<?=$item['title']?>" href="/articles/<?=$item['c_url']?>/<?=$item['url']?>"><?=$item['title']?></a>
                            </h2>

                            <p>
                            <?=$item['anonce']?></p>
                        </div>
                        <?}?>

                             
                    </div>

                </div>
                <div class="aside base_info">  
                    <h2 class="headline">База знаний</h2> 
                    <ul class="brand_list">
                    <?foreach($cats as $item){
                      // if($item['id']==$cat['id']) continue;     
                        ?>
                        <li><a title="<?=$item['title']?>" href="/articles/<?=$item['url']?>"><?=$item['title']?></a></li>
                        <?}?>
                               
                    </ul>
                     <?if(isset($_SESSION['manager'])){?>     
                    <div><a class="add" href="/articles/edit_cat/0" title="Добавить тему">Добавить тему</a></div>
                    <div><a class="add" href="/articles/edit_article/0/<?=$cat['id']?>" title="Добавить статью">Добавить статью</a></div>
                    <?}?>
                     <h2 class="tags_hline">Ключевые слова</h2>
                    <ul class="tags_list">
                    <?
                    $cnt=sizeof($keys);
                    $i=0;
                    foreach($keys as $key) {
                        $i++;
                    ?>
                        <li><a title="<?=$key?>" href="/articles/keywords/<?=trim($key)?>"><?=trim($key)?></a><?if($i<$cnt) echo","?> </li>
                    <?}?>    
                             
                    </ul>

                </div>
            </div>
 
 
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>