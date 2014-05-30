<?if(!isset($action)){$action='';}
?>
 <div class="main_row top_menu">

                <div class="content_row mod_3">
                    
                    <div class="profile_head">
                        <ul class="func_menu mod_2">
                            <li class="func_m_item <?if($action=='orders' and (!isset($this->conf['client']))) {?>   selected<?}?>">
                                <a title="Заказы" href="/manager/orders" class="func_m_i_butt">Заказы</a></li>
                            <li class="func_m_item <?if($action=='clients'
                        or(($_SESSION['user']['id']!=$_SESSION['manager_id'])and ($_SESSION['user']['user_type']=='user') )) {?> selected<?}?>">
                                <a title="Клиенты" href="/manager/clients" class="func_m_i_butt">Клиенты</a>
                            </li>
                            <li class="func_m_item <?if($action=='managers'
                        or(($_SESSION['user']['id']!=$_SESSION['manager_id'])and ($_SESSION['user']['user_type']=='manager') )) {?>   selected<?}?>">
                                <a title="Менеджеры" href="/manager/managers" class="func_m_i_butt">Менеджеры</a>
                            </li>
                            <li class="func_m_item  <?if($action=='suppliers') {?> selected<?}?>">
                                <a title="Поставщики" href="/manager/suppliers" class="func_m_i_butt">Поставщики</a>
                            </li>
                            <li class="func_m_item<?if($action=='margins') {?> selected<?}?>">
                                <a title="Наценки" href="/manager/margins" class="func_m_i_butt">Наценки</a>
                            </li>
                            <li class="func_m_item<?if($action=='history') {?> selected<?}?>">
                                <a title="История поиска"  href="/manager/history" class="func_m_i_butt">История поиска</a>
                            </li>
                            <li class="func_m_item<?if($action=='AddImage') {?> selected<?}?>">
                                <a title="Импорт и экспорт" href="/manager/AddImage/" class="func_m_i_butt">Добавить фото</a>
                            </li> <li class="func_m_item<?if($action=='price') {?> selected<?}?>">
                                <a title="Импорт и экспорт" href="/manager/price" class="func_m_i_butt">Импорт/экспорт</a>
                            </li>
                            <li class="func_m_item<?if($action=='banners') {?> selected<?}?>">
                                <a title="Реклама"  href="/manager/banners" class="func_m_i_butt">Реклама</a>
                            </li>
                            <li class="func_m_item<?if($action=='fields') {?> selected<?}?>">
                                <a title="Настройки" href="<?if($_SESSION['user']['id']!=$_SESSION['manager_id']){?>/manager/user_fields/<?=$_SESSION['user']['id']?><?}else{?>/manager/fields<?}?>" class="func_m_i_butt">Отображение полей</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
 <!-- New manager panel
 <div class="main_row" id="main_row_man">
    <ul class="manager_panel float_l">
        <li><a class="man_1" href="#">
	    <span class="tooltip_1 m_1">Заказы</span></a></li> 
	    <li><a class="man_2" href="#">
	    <span class="tooltip_2 m_2">Клиенты</span></a></li> 
	    <li><a class="man_3" href="#">
	    <span class="tooltip_3 m_3">Менеджеры</span></a></li> 
	    <li><a class="man_4" href="#">
	    <span class="tooltip_4 m_4">Поставщики</span></a></li> 
	    <li><a class="man_5" href="#">
	    <span class="tooltip_5 m_5">Наценки</span></a></li> 
	    <li><a class="man_6" href="#">
	    <span class="tooltip_6 m_6">История поиска</span></a></li> 
	    <li><a class="man_7" href="#">
	    <span class="tooltip_7 m_7">Реклама</span></a></li> 
	    <li><a class="man_8" href="#">
	    <span class="tooltip_8 m_8">Добавить фото</span></a></li> 
	    <li><a class="man_9" href="#">
	    <span class="tooltip m_9">Настроить</span></a></li> 
    </ul>	
 </div> -->
				 