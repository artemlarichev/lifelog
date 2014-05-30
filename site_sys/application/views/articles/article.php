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
                <?if($article){?>
                    <h1 class="headline"><?=$article['title']?>
                       <?if(isset($_SESSION['manager'])){?>     
                        <a class="edit_ico" href="/articles/edit_article/<?=$article['id']?>" title=""></a>
                        
                        <a class="del_ico" href="/articles/del/article/<?=$article['id']?>" title=" "  onClick="return window.confirm('Удалить?')"> </a>
                       <?}?>     </h1> 
                     
                    <div class="static static_article">
                        <div class="article_intro">
                            <p>
                                <?=$article['anonce']?>    
                                
                                </p>
                        </div>


                             <?=$article['text']?>     


                        <div class="article_details">
                            <a title="Джапан-Авто" href="<?=$article['link']?> " class="article_d_url"><?=$article['link_title']?> </a>
                        </div>


                        <p>&nbsp;</p>

                        <div style="position: absolute; left: -10000px; top: 686px; width: 1px; height: 1px; overflow-x: hidden; overflow-y: hidden;" class="mcePaste" id="_mcePaste">??</div>
                    </div>
                    <?}?>
                    <div class="article_list">
                    <?foreach($articles as $item){
                         if($item['id']==$article['id']) continue;
                        ?>
                        <div class="article_l_item">
                            <h2 class="article_l_i_hline">
                                <a title="<?=$item['title']?>" href="/articles/<?=$cat['url']?>/<?=$item['url']?>"><?=$item['title']?></a>
                            </h2>

                            <p>
                            <?=$item['anonce']?></p>
                        </div>
                        <?}?>

                             
                    </div>

                </div>
                <div class="aside base_info"> 
                    <div class="base_i_breadcrumbs"><a title="База знаний" href="/articles">База знаний</a> /
                    <a title="<?=$cat['title']?>" href="/articles/<?=$cat['url']?>"><?=$cat['title']?></a>
                    </div>
                    <h2  class="headline"><?=$article['title']?> </h2>
 
                    <ul class="brand_list">
                    <?foreach($articles as $item){
                     //  if($item['id']==$article['id']) continue;     
                        ?>
                        <li><a title="<?=$item['title']?>" href="/articles/<?=$cat['url']?>/<?=$item['url']?>"><?=$item['title']?></a></li>
                        <?}?>
                               
                    </ul>
                     <?if(isset($_SESSION['manager'])){?>     
                    <div><a class="add" href="/articles/edit_cat/0" title="Добавить тему">Добавить тему</a></div>
                    <div><a class="add" href="/articles/edit_article/0/<?=$cat['id']?>" title="Добавить статью">Добавить статью</a></div>
                    <?}?>
                    <h2 class="tags_hline">Ключевые слова</h2>
                    <ul class="tags_list">
                    <?
                    $keys =explode(',',$article['keys']);
                    $cnt=sizeof($keys); 
                    if($cnt>0)   
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