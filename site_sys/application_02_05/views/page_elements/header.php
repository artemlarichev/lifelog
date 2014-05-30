 <?if(!isset($action)){$action='';}?>
<?if(isset($_SESSION['manager'])){$this->load->view('page_elements/manager_menu');}?>

             
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
