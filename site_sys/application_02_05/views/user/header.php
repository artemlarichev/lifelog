	
<div class="header" style="background: url('<?=$this->data->rand_banner()?>') no-repeat scroll 50% 86px transparent !important;">
			<div class="header_wrap"
             style="background: url('<?=$this->data->rand_banner()?>') no-repeat scroll 50% 86px transparent; " >

				<h1 class="logo_w"><a class="logo" href="/" title="Джапан Авто">Джапан Авто</a></h1>
                <div id='login'>
				<?php  $this->load->view('page_elements/login_box');  ?>
                </div>
				<div class="tel">
					<span>(044)</span> 540-51-08, 540-79-55
				</div>
				<ul class="list_link">
					<li><a href="/shops" title="Наши магазины">Наши магазины</a></li>
					<li><a href="/order" title="Заказ и доставка">Заказ и доставка</a></li>
				</ul>

				<?php   $this->load->view('page_elements/search_menu');   ?>
				<?php if(isset($_SESSION['manager'])){$this->load->view('page_elements/manager_menu');}?>
    				<div class="manager_menu" style='margin-top:30px;'>
					<ul class="m_m1_category">
						<!--	<li><a  <?if($action==''   ) {?> class="mark"<?}?> href="/" title="Запчасти">Запчасти</a></li>-->
					<li><a  <?if($action=='orders' and isset($this->conf['client'])) {?> class="mark"<?}?> href="/client/orders/0/1" title="Заказы">Заказы</a></li>
						<li><a  <?if($action=='balance') {?> class="mark"<?}?> href="/client/balance" title="Баланс">Баланс</a></li>

						<li><a  <?if($action=='search_history') {?> class="mark"<?}?> href="/client/search_history" title="История поиска">История поиска</a></li>
						<li><a <?if($action=='account') {?> class="mark"<?}?>  href="/client/account" title="Карточка клиента">Карточка клиента</a></li><?if($_SESSION['user']['price']>0){?>
 
                        <li><a title="Прайс" href="/catalog/price"  <?if($action=='price') {?> class="mark"<?}?>  >Скачать прайс</a></li>
                       
                            <?} ?>
					</ul>
				</div>

<? if($action=='orders') { ?>
<div class="search_block">
				<?if(isset($show_parts)){?>	<ul class="search_category">
						<li><label for="order"><input type="radio" id="order" name="radio1"
						onclick='location.replace("/client/orders/<?=$status?>/0")'    <?if($show_parts==0) {?>checked<?}?>> Заказы</label></li>
						<li><label for="spare"><input type="radio" id="spare" name="radio1"
						onclick='location.replace("/client/orders/<?=$status?>/1")'
						<?if($show_parts==1) {?>checked<?}?>> Запчасти</label></li>
					</ul>
					<?}?>
					<? if(isset($_SESSION['manager'])) { ?>
					<ul class="manager_search_list">
						<li><a title="Импорт/экспорт" href="">Импорт/экспорт</a></li>
						<li><a title="Распечатать" href="">Распечатать</a></li>
					</ul>
					<?}?>
                    <?if(!isset($show_parts))$show_parts=0;?>
					<div class="search_form">
						<ul class="order_category">
							<!--<li><a title="Новые" href="/client/orders/0/<?if ($show_parts == '1') echo"1";?>" <?if($status=='0') {?> class="mark"<?}?>>Новые</a></li>-->
							<li><a title="В обработке" href="/client/orders/1/<?if ($show_parts == '1') echo"1";?>" <?if($status=='1') {?> class="mark"<?}?>>В обработке</a></li>
							<li><a title="Выполненные" href="/client/orders/2/<?if ($show_parts == '1') echo"1";?>" <?if($status=='2') {?> class="mark"<?}?>>Выполненные</a></li>
						</ul>

                         <?  if (!isset($show_parts)) {  $show_parts = '';   }
                if($show_parts=='0') {$show_parts!='22';}
                if($show_parts!=''){ ?>
                <link type="text/css" href="/styles/jquery-ui-1.7.3.custom.css" rel="stylesheet" />
                <script type="text/javascript" src="/js/datapicer.js"></script>
               <script type="text/javascript" src="/js/jquery.ui.datepicker-ru.js"></script>
                                <script type="text/javascript">
                    $(function(){
                          // Datepicker
                          $.datepicker.regional[ 'ru' ];

                        $('#o_s_f_date_from').datepicker({  });
                         $('#o_s_f_date_to').datepicker({  });

                    });
                </script>
                 <form action="" method="post">
                <ul class="order_search_form">
                    <li class="o_s_f_item">
                        <?if($show_parts=='1'){?> <label for="n_order">№ запчасти</label>
                        <input class="o_s_f_text_f" type="text" name="p_order" id="p_order" value="<?if(isset($_POST['p_order'])) print($_POST['p_order']);?>"><?}else{?>
                        <label for="n_order">№ заказа</label>
                       <input class="o_s_f_text_f" type="text" name="n_order" id="n_order" value="<?if(isset($_POST['n_order'])) print($_POST['n_order']);?>"> <?}?>

                    </li>
                    <li class="o_s_f_item">
                        <label for="n_card">№ накл.</label>
                        <input class="o_s_f_text_f" type="text" name="n_nacl" id="n_nacl" value="<?if(isset($_POST['n_nacl'])) print($_POST['n_nacl']);?>">
                    </li>
                    <li class="o_s_f_item">
                        <label for="o_s_f_date_from">Дата от</label>
                        <input class="o_s_f_text_f" type="text" name="o_s_f_date_from" id="o_s_f_date_from" value="<?if(isset($_POST['o_s_f_date_from'])) print($_POST['o_s_f_date_from']);?>">
                    </li>
                    <li class="o_s_f_item">
                        <label for="o_s_f_date_to">до</label>
                        <input class="o_s_f_text_f" type="text" name="o_s_f_date_to" id="o_s_f_date_to" value="<?if(isset($_POST['o_s_f_date_to'])) print($_POST['o_s_f_date_to']);?>">
                    </li>
                    <li class="o_s_f_item butt_wrap">
                        <input type="submit" name="o_s_f_submit" id="o_s_f_submit" value="Найти">
                    </li>
                </ul>
                </form>
                <?}?>
					</div>
				</div>


<?}?>
		</div>

		</div>
