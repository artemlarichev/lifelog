<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
	<div class="base" id="wrapper">
	<?php  $this->load->view('page_elements/header');  ?>
		<div class="main_row">

 <div class="content_row">
				<div class="text_content">
					<h1 class="headline">О компании «Джапан Авто» <a title="" href="/manager/edit_page/index" class="edit_ico"></a></h1>

					 <h2 class="text_hline_sub"><?=$index_page['title']?></h2>

					<div class="static">
						<?=$index_page['text']?>
					</div>
                                <br /><br />     
                                
                                <ul class="banners"> 
                             <?foreach($this->data->get_banners() as $banner){?>
                           <li>
                               <i class="banners_holder"><?=$banner['text']?> </i>
                                <?if(isset($_SESSION['user']) and $_SESSION['user']['user_type']=='manager'){?>
                                <a title="" href="/manager/edit_baner/<?=$banner['id']?>" class="edit_ico"></a>
                                <a title="" href="/manager/edit_baner/<?=$banner['id']?>/del" class="del_ico" onclick="return confirm('Удалить?')"></a>
                                <a title="" href="/manager/edit_baner/0" class="add_ico"></a>
                                <?}?> 
                           </li>
                           <?}?>

                       </ul>  
                                <div class="article_list">
                    <?foreach($articles as $item){
                          
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
				<div class="aside news">
					<h2 class="headline">Новости компании</h2>
					<a title="Добавить новость" href="/manager/news/new" class="add">Добавить новость</a>
					<ul class="news_list">
					<?foreach($news as $val){?>
						<li class="n_l_item">
							<h3 class="n_l_hline"><?=$val['title']?>
							<a title=""  href="/manager/news/edit/<?=$val['id']?>" class="edit_ico"></a>
							 <a title="" href="/manager/news/del/<?=$val['id']?>" class="del_ico"></a></h3>

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
			</div>

   <?php  $this->load->view('page_elements/index_group_catalog');  ?>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>