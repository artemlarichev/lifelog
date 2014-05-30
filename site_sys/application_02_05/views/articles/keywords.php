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
                    <?foreach($articles as $item){
                       
                        ?>
                        <div class="article_l_item">
                            <h2 class="article_l_i_hline">
                                <a title="<?=$item['title']?>" href="/articles/<?=$cats_url[$item['cat_id']]?>/<?=$item['url']?>"><?=$item['title']?></a>
                            </h2>

                            <p>
                            <?=$item['anonce']?></p>
                        </div>
                        <?}?>

                             
                    </div>

                </div>
                <div class="aside base_info">
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
                   
                    $cnt=sizeof($keys); 
                    if($cnt>0)   
                    $i=0;
                    foreach($keys as $key) {
                        $i++;
                    ?>
                        <li>
                        <?if(trim($keyword)==trim($key)){?>
                        <?=trim($key)?> <?if($i<$cnt) echo","?> 
                        <?}else{?>
                        <a title="<?=$key?>" href="/articles/keywords/<?=trim($key)?>"><?=trim($key)?></a><?if($i<$cnt) echo","?> 
                        <?}?>
                        </li>
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