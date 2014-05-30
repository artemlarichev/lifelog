<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">
	<div class="base shadow" id="wrapper">
	<?php  $this->load->view('page_elements/header');  ?>
		<div class="main_row">
			<div class="content_row">
				<div class="text_content">
					<h1 class="headline">О компании «Джапан Авто»</h1>

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
                                <a title="" href="/manager/edit_baner/<?=$banner['id']?>/del" class="del_ico"></a>
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

	<?php  $this->load->view('page_elements/news');  ?>

	</div>
   <?php 
 
// if(isset($_SESSION['user']))
   //         if($_SESSION['user']['show_gr']> 0 or $_SESSION['user']['user_type']=='manager') 
               $this->load->view('page_elements/index_group_catalog'); 
    
     ?>
 		<div class="index_catalog">
                <h2 class="i_c_hline">Производители запчастей   </h2>
             
           
                <dl class="i_c_dlist">
                    <dt>Под заказ</dt>
<!--Subaru, Suzuki, Mazda, Honda, Mitsubishi, Hyundai, Isuzu, Toyota, Nissan, Kia, Yamagawa, CTR, RBI, Kayaba, Febest, NTN, NSK-->

         
                    <dd><a href="/catalog/suppliers/Subaru" title="Subaru">Subaru</a></dd>
                    <dd><a href="/catalog/suppliers/Suzuki" title="Suzuki">Suzuki</a></dd>
                    <dd><a href="/catalog/suppliers/Mazda" title="Mazda">Mazda</a></dd>
                    <dd><a href="/catalog/suppliers/HONDA" title="HONDA">Honda</a></dd>
                    <dd><a href="/catalog/suppliers/Mitubishi" title="Mitubishi">Mitubishi</a></dd> 
                    <dd><a href="/catalog/suppliers/Hyundai" title="Hyundai">Hyundai</a></dd>
                    <dd><a href="/catalog/suppliers/TOYOTA" title="Toyota">Toyota</a></dd>
                    <dd><a href="/catalog/suppliers/Nissan" title="Nissan">Nissan</a></dd>
                    <dd><a href="/catalog/suppliers/KIA" title="Kia">Kia</a></dd>
                    <dd><a href="/catalog/suppliers/CTR" title="CTR">CTR</a></dd> 
                    <dd><a href="/catalog/suppliers/NSK" title="NSK">NSK</a></dd> 
                    
                                   
                    
                    <dd><a href="/catalog/suppliers/" title="Все производители">Все производители</a></dd>
                    <dt>Дальний заказ</dt>  
                    
                   <dd><a href="/catalog/emir_suppliers/SU" title="Subaru">Subaru</a></dd>
                    <dd><a href="/catalog/emir_suppliers/SZ" title="Suzuki">Suzuki</a></dd>
                    <dd><a href="/catalog/emir_suppliers/MZ" title="Mazda">Mazda</a></dd>
                    <dd><a href="/catalog/emir_suppliers/HO" title="HONDA">Honda</a></dd>
                    <dd><a href="/catalog/emir_suppliers/MC" title="Mitubishi">Mitubishi</a></dd> 
                    <dd><a href="/catalog/emir_suppliers/IS" title="Isuzu">Isuzu</a></dd> 
                    <dd><a href="/catalog/emir_suppliers/HU" title="Hyundai">Hyundai</a></dd>
                    <dd><a href="/catalog/emir_suppliers/TY" title="Toyota">Toyota</a></dd>
                    <dd><a href="/catalog/emir_suppliers/NS" title="Nissan">Nissan</a></dd>
                    <dd><a href="/catalog/emir_suppliers/KI" title="Kia">Kia</a></dd>
                    <dd><a href="/catalog/emir_suppliers/YM" title="Yamaha">Yamaha</a></dd>
                    <dd><a href="/catalog/emir_suppliers/CT" title="CTR">CTR</a></dd> 
                    <dd><a href="/catalog/emir_suppliers/RB" title="RBI">RBI</a></dd> 
                    <dd><a href="/catalog/emir_suppliers/NK" title="NSK">NSK</a></dd> 
                    <dd><a href="/catalog/emir_suppliers/NN" title="NTN">NTN</a></dd> 
                    <dd><a href="/catalog/emir_suppliers/QF" title="Febest">Febest</a></dd> 
                     
                    <dd><a href="/catalog/emir_suppliers/" title="Все производители">Все производители</a></dd>
                    
                </dl>
               
             </div>
        
        
        </div>

	  <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>
