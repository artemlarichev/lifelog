 <?if(!isset($action)){$action='';}?>
<?if(isset($_SESSION['manager'])){$this->load->view('page_elements/manager_menu');}?>

<!---------------New header--
	<div class="header_new">
	    <div class="header_block">		    
		        <h1 class="float_l">
			        <a class="logo" href="#" title="Джапан Авто"></a>
			    </h1>
				<div class="contacts">
				    <span class="telefon"><span>(044)</span> 540-52-08, 540-79-55</span>
					<a class="shops" href="#">Магазины</a><a class="orders" href="#">Заказ/Доставка</a>
				</div>
				<div class="enter_new float_r">
				    <a class="vhod float_l" href="#">Вход</a>
					<a class="reg float_l" href="#">Регистрация</a>					
					<a class="float_r bag">0</a>
				</div>
		</div>	
        <div class="search_new">
		    <form class="form_search">
			    <select class="choose_s">
				    <option selected>По номеру</option>
					<option>По группам</option>
					<option>Пo автомобилю</option>
				</select>
				<input class="text_s" type="text" name="search" value="" placeholder="Введите номер запчасти">
				<input class="text_b" type="button" value="Найти">
				<div class="bg_option to-be-changed"><a class="option" href="#">
				    <div class="to-be-changed opt_menu">
					   <label class="float_l">Наличие</label>
					   <input class="float_r" type="checkbox">
					   <label class="float_l">Под заказ</label>
					   <input class="float_r row_i" type="checkbox">
					   <label class="float_l">Дальний заказ</label>
					   <input class="float_r" type="checkbox">
					</div>
				</a></div>
				<a class="manager_q float_r gallery" title="Простая HTML" href="../content.html">Запросить у менеджера</a>
				<div class="man"></div>				
			</form>
		</div>
		//Панель после входа
		<div class="header_block">		    
		        <h1 class="float_l">
			        <a class="logo" href="#" title="Джапан Авто"></a>
			    </h1>
				<div class="contacts">
				    <span class="telefon"><span>(044)</span> 540-52-08, 540-79-55</span>
					<a class="shops" href="#">Магазины</a><a class="orders" href="#">Заказ/Доставка</a>
				</div>
				<div class="enter_new_on float_r">
				    <div class="avatar float_l"></div>
					<div class="on float_l"><a class="name_link" href="#">02158 СПД Лихаченкович
					<span class="info_name to-be-changed">1000 ГПЛ Токарев Валерий Константинович Отришко Евгений Валериевич, г.Полтава</span></a>
					<a class="exit" href="#"></a>	
                    <a class="pay" href="#">56 325 &#8372;</a></div>					
					<a class="float_r bag_full" href="#">0/0
					    <div class="to-be-changed bag_things">
						   <div class="data_bag"> 
						   <span  class="float_l padd">Товаров</span>
						   <span  class="float_r">5</span>
						   <span  class="float_l padd">Артикулов</span>
						   <span  class="float_r">18</span>
						   <span  class="float_l padd">На сумму, &#8372;</span>						  
						   <span  class="float_r">250 744</span>
						   </div>
						   <div class="but_bag">
						       <input class="text_b" type="button" value="Оформить">
						   </div>
						</div>
					</a>
				</div>
		</div>
		// При смене селектора на второй пункт
        <div class="search_new">
		    <form class="form_search">
			    <select class="choose_s">
				    <option>По номеру</option>
					<option selected>По группам</option>
					<option>Пo автомобилю</option>
				</select>
				<select class="choose_group">				    
					<option selected>Все группы</option>
					<option>Все группы</option>
				</select>
				<select class="choose_group">
					<option selected>Все подгруппы</option>
					<option>Все подгруппы</option>
				</select>
				<select class="choose_group">				    
					<option selected>Все подгруппы</option>
					<option>Все подгруппы</option>
				</select>
				<input class="text_b" type="button" value="Найти">
				<a class="option" href="#"></a>
				<a class="manager_q float_r" href="#">Запросить у менеджера</a>
				<div class="man"></div>
			</form>
		</div>
		// При смене селектора на третий пункт
        <div class="search_new">
		    <form class="form_search">
			    <select class="choose_s">
				    <option>По номеру</option>
					<option>По группам</option>
					<option selected>Пo автомобилю</option>
				</select>
				<input class="text_s" type="text" name="search" value="" placeholder="Введите марку автомобиля">
				<input class="text_b" type="button" value="Найти">
				<a class="option" href="#"></a>
				<a class="manager_q float_r" href="#">Запросить у менеджера</a>
				<div class="man"></div>
			</form>
		</div>			
	</div>
------New header------------------->	
            
<div class="header" style="background: url('<?=$this->data->rand_banner()?>') no-repeat scroll 50% 86px transparent !important;">
			<div class="header_wrap" 
            <?if(isset($top_image)){?>style='background: url('<?=$this->data->rand_banner()?>') no-repeat scroll 50% 86px transparent;'<?}?>>

				<h1 class="logo_w"><a class="logo" href="/" title="Джапан Авто">Джапан Авто</a></h1>

				<div id='login'>
				<?php  $this->load->view('page_elements/login_box');  ?>
                </div>
				<div class="tel">
					<span>(044)</span> 540-51-08, 540-79-55
				</div>
				<ul class="list_link">
					<li><a href="/shops" title="Наши магазины">Наши магазины</a>
                         <?php if(isset($_SESSION['manager'])){?>     <a class="edit_ico" href="/manager/edit_page/shops" title=""></a> <?}?>
                    </li>
					<li><a href="/order" title="Заказ и доставка">Заказ и доставка</a>
                         <?php if(isset($_SESSION['manager'])){?>   <a class="edit_ico" href="/manager/edit_page/order" title=""></a><?}?>

                    </li>





                    </ul>




            <?php  $this->load->view('page_elements/search_menu');  ?>

			<?php 
			 if(isset($_SESSION['user'])){?>
<div class="manager_menu" style='margin-top:30px;'>
					<ul class="m_m1_category">
						<!--<li><a  <?if($action==''   ) {?> class="mark"<?}?> href="/" title="Запчасти">Запчасти</a></li>-->
						<li><a  <?if($action=='orders' and  isset($this->conf['client']) ) {?> class="mark"<?}?> href="/client/orders/0/1" title="Заказы">Заказы</a></li>
						<li><a  <?if($action=='balance') {?> class="mark"<?}?> href="/client/balance" title="Баланс">Баланс</a></li>

						<li><a  <?if($action=='search_history') {?> class="mark"<?}?> href="/client/search_history" title="История поиска">История поиска</a></li>
						<li><a <?if($action=='account') {?> class="mark"<?}?>  href="/client/account" title="Карточка клиента">Карточка клиента</a></li>
                         
                        <?if($_SESSION['user']['price']>0){?>
 
                        <li><a title="Прайс" href="/catalog/price"  <?if($action=='price') {?> class="mark"<?}?>  >Скачать прайс</a></li>
                       
                            <?} ?>
					</ul>
				</div>
<?}?>


	</div>
		</div>		