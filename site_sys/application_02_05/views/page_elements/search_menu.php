<?
if(!isset($sel_group)) {$sel_group='';}
if(!isset($sel_group_2)) {$sel_group_2='';}
if(!isset($sel_group_1)) {$sel_group_1='';}
if(!isset($search_type)) {$search_type='code';}
if(!isset($count)) {$count='10';}
if(!isset($action)) {$action='';}
if(!isset($group) and isset($this->group)) {$group=$this->group;}
?>

<script type="text/javascript" src="/js/search.js"></script>
<script type="text/javascript" >
var search_type='<?=$search_type?>';
var search_id='<?if(isset($f_id)){print($f_id);}?>'; //'
</script>
<div class="search_block search_block_v1" >


   <?  if(isset($_SESSION['user'])){
	if($_SESSION['user']['price']>0){?>
<!--<ul class="manager_search_list">
                        <li><a title="Прайс" href="/catalog/price"  <?if($action=='price') {?> class="mark"<?}?>  >Скачать прайс</a></li>
                       </ul>-->
<?}}?>
<?if($action=='history') {?>
	<div class="search_form export">
 

      
      <div id='div_history' style='text-align:left'>
      &nbsp;&nbsp;&nbsp;&nbsp; <span>Отобразить</span>

						<select name="history_field" id="history_field"
						onchange="javascript:location.href='/manager/history/'+getElementById('history_field').value"
						>
							<option value="10" <?if($count==10){echo "selected";}?> >10</option>
							<option value="20"<?if($count==20){echo "selected";}?> >20</option>
							<option value="50"<?if($count==50){echo "selected";}?> >50</option>
							<option value="100"<?if($count==100){echo "selected";}?> >100</option>
							<option value="500"<?if($count==500){echo "selected";}?> >500</option>
						</select>
						<span>последних запросов</span>
		 </div>
         </div>
	<?}?>
	<?if($action=='price') {?>
    <div class="search_form export">
      <div id='div_history' style='text-align:left'>
      	<?php  $this->load->view('manager/price_block');  ?>
		 </div>
         </div>
	<?}?>
	

    <?if(!isset($search_type) or $search_type=='') $search_type='code'; ?>
    <div class="search_hold">
     <?if(isset($_SESSION['user'])) 
     if($_SESSION['user']['discont']<1 and $_SESSION['user']['user_type']!='manager') {?>
     <p class="search_warn">Ваша карточка заблокирована, и скидка на нее не распространяется</p>
     <?}?>
    
        <ul class="search_tabs">
            <li class="search_t_item <?if($search_type=='code') {?> selected<?}?>" data-search-tab="1"><span class="search_t_i_text">По номеру</span></li>
          <?if(isset($_SESSION['user']))
            if($_SESSION['user']['show_gr']> 0 or $_SESSION['user']['user_type']=='manager'){?>
          
           <li class="search_t_item <?if($search_type=='group') {?> selected<?}?>" data-search-tab="2"><span class="search_t_i_text">По группам</span></li>
           <?}?>
            <li class="search_t_item" data-search-tab="3"><span class="search_t_i_text">По автомобилю</span></li>
           <li class="search_t_item" data-search-tab="4"><span class="search_t_i_text">Помощь менеджера</span></li>
        </ul>
        <ul class="search_wraps">
            <li class="search_w_item <?if($search_type=='code') {?> selected<?}?>" data-search-wrap="1">
                <div class="form_hold form_hold_v1">
                    <label for="field_num" class="hide">Введите номер:</label>

                    <div class="field_10">
                        <div class="field_w field_w_find">
                            <input class="inp_field_num" type="text" name="search_field" id="search_field" value='<?if(isset($code_key)){echo $code_key;} ?>' onkeydown='javascript:if(13==event.keyCode){Search("code");}' placeholder="Введите номер">
                        </div>
                    </div>


                    <input class="submit_butt" type="submit" value="Найти" onclick="Search('code');">
                </div>
                <?
                $key1=$this->data->rand_article(); 
                $key2=$this->data->rand_article(); 
                ?>
                <div class="example_line">Например,
                     <a href="#"  class="example_l_link" onclick='findRandKey("<?=$key1?>")' title="<?=$key1?>"><?=$key1?></a>
                    <span class="example_l_or">или</span>
                     <a href="#"  class="example_l_link" onclick='findRandKey("<?=$key2?>")' title="<?=$key2?>"><?=$key2?></a>
                     
                      <input type="checkbox" value="1" id='only' <?if(isset($only)){?> checked="checked" <?}?>>  точное соответствие
                      
                      <span  style="margin-left: 25px;">Искать в разделах:</span>                                           
                       <input type="checkbox" value="1" id='s_sklad' <?if(!isset($s_sklad)){?> checked="checked" <?}?>>  Наличие,
                       <input type="checkbox" value="1" id='s_ukr' <?if(!isset($s_ukr)){?> checked="checked" <?}?>>  Под заказ,
                       <input type="checkbox" value="1" id='s_emir' <?if(!isset($s_emir)){?> checked="checked" <?}?>>  Дальний заказ.
                    
                     
                     
                     </div>
            </li>
            <?if(isset($_SESSION['user']))
            if($_SESSION['user']['show_gr']> 0 or $_SESSION['user']['user_type']=='manager'){?>
            <li class="search_w_item <?if($search_type=='group') {?> selected<?}?>" data-search-wrap="2">
                <div class="form_hold form_hold_v1">
                    <div class="form_h_item mod_1">
                        <div class="field_25">
                            <div class="field_s">
                             <select id="cat1" class="sel_v sel_v1" name="cat1" onchange='Change_1()' onkeydown='javascript:if(13==event.keyCode){Search("group");}'>
                            <option value=""></option>
                            <?foreach($group as $val){?>
                                <option value="<?=$val['group']?>" <?if($sel_group==$val['group']){echo" selected "; }?>><?=$val['group']?></option>
                            <?}?>
                            </select>
                            
                                 
 
                            </div>
                        </div>
                        <div class="field_25">
                            <div class="field_s">
                            <select class="sel_v sel_v1" id="cat2" name="cat2" onchange='Change_2()' onkeydown='javascript:if(13==event.keyCode){Search("group");}'>
                            <option value=""></option>
                                <?foreach($group_1 as $val){?>
                                <option value="<?=$val['group']?>" <?if($sel_group_1==$val['group']){echo" selected "; }?>><?=$val['group']?></option>
                            <?}?>
                            </select>
                            
                                </div>
                        </div>
                        <div class="field_25">
                            <div class="field_s">
                            <select id="cat3" name="cat3" onkeydown='javascript:if(13==event.keyCode){Search("group");}' class="sel_v sel_v1">
                            <option value=""></option>
                                <?foreach($group_2 as $val){?>
                                <option value="<?=$val['group']?>" <?if($sel_group_2==$val['group']){echo" selected "; }?>><?=$val['group']?></option>
                            <?}?>
                            </select>
                            
                            </div>
                        </div>
                        <div class="field_25">
                            <div class="field_w"><label for="field_num_2" class="hide">Номер запчасти</label>
<input type="text" id="search_field_group"  class="inp_field_num_2" value='<? if(isset($group_key)){echo $group_key;} ?>' name="search_field"  onkeydown='javascript:if(13==event.keyCode){Search("group");}'>
                           
                                  </div>
                        </div>
                    </div>
 <input type="submit" value="Найти" onclick='Search("group");return false' id="search_submit" name="search_submit" class="submit_butt" >
                     
                </div>


            </li>
            <?}?>
            <li class="search_w_item" data-search-wrap="3">
            <?php  $this->load->view('page_elements/car_catalog');  ?>
                
            </li>
            <li class="search_w_item" data-search-wrap="4">
                <ul class="form_hold" id='ul_help'>
                    <li class="form_h_item">
                        <div class="field_25">
                            <div class="field_s">
                                <select name="sel_brand" id="sel_brand" class="sel_v sel_v2">
 
    </option><option value="Honda">Honda</option>
    <option value="Hyundai">Hyundai</option>
    <option value="Isuzu">Isuzu
    </option><option value="Kia">Kia</option>
    <option value="Lexus">Lexus
    </option><option value="Mazda">Mazda</option>
    <option value="Mitsubishi">Mitsubishi</option>
    <option value="Nissan">Nissan</option>
    <option value="Subaru">Subaru
    </option><option value="Suzuki">Suzuki
    </option><option value="Toyota">Toyota
</option> 
                                </select>
                            </div>
                        </div>


                        <div class="field_38">
                            <div class="field_h">
                                <div class="field_w mod_dib car_model_w">
                                    <label for="car_model" class="hide">Модель и модификация</label>
                                    <input type="text" id="car_model" name="car_model" placeholder="Модель и модификация" class="inp_car_model">
                                </div>
                            </div>

                        </div>
                        <div class="field_12">
                            <div class="field_s">
                                <select class="sel_v sel_v3" name="sel_year" id="sel_year">
                                <?for($i=Date('Y');$i>1950;$i--){?>
                                    <option value="<?=$i?>"><?=$i?></option>
                                    <?}?> 
                                </select></div>
                        </div>

                        <div class="field_25">
                            <div class="field_s"><select class="sel_v sel_v4" name="sel_type_carcass" id="type_carcass">
 
                                            <option value="Седан">Седан</option>
                                            <option value="Внедорожник">Внедорожник / Кроссовер</option>
                                            <option value="Минивэн">Минивэн</option>
                                            <option value="Хэтчбек">Хэтчбек</option>
                                            <option value="Универсал">Универсал</option>
                                            <option value="Купе">Купе</option>
                                            <option value="Легковий фургон">Легковий фургон (до 1,5 т)</option>
                                            <option value="Кабриолет">Кабриолет</option>
                                            <option value="Пикап">Пикап</option>
                                            <option value="Лимузин">Лимузин</option>
                                            <option value="Другой">Другой</option>
                                    
                            </select></div>
                        </div>


                    </li>
                    <li class="form_h_item">
                        <div class="field_15">
                            <div class="field_s"><select name="sel_brand" id="sel_type_fuel" class="sel_v sel_v5">  
                            <option  value="Бензин">Бензин</option>
                            <option  value="Дизель">Дизель</option>
                            <option  value="Газ">Газ</option>
                            <option  value="Газ метан">Газ метан</option>
                            <option  value="Газ пропан-бутан">Газ пропан-бутан</option>
                            <option  value="Газ/бензин">Газ/бензин</option>
                            <option  value="Гибрид">Гибрид</option>
                            <option  value="Электро">Электро</option>
                            <option  value="Другое">Другое</option>
 
                            </select></div>
                        </div>

                        <div class="field_1">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="volume_motor" class="hide">Объем</label>
                                    <input type="text" id="volume_motor" name="volume_motor" placeholder="Объем" class="inp_volume_motor">
                                </div>
                            </div>

                        </div>
                        <div class="field_25">
                            <div class="field_s">
                                <select class="sel_v sel_v6" name="sel_transmission" id="sel_transmission"> 
                    <option value="Ручная / Механика">Ручная / Механика</option> 
                    <option  value="Автомат">Автомат</option>
                    <option  value="Адаптивная">Адаптивная</option>
                    <option  value="Вариатор">Вариатор</option> 
                    <option  value="Типтроник">Типтроник</option>

             
                                </select></div>
                        </div>
                        <div class="field_25">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="num_carcass" class="hide">Объем</label>
                                    <input type="text" id="num_carcass" name="num_carcass" placeholder="Номер кузова" class="inp_num_carcass">
                                </div>
                            </div>
                        </div>
                        <div class="field_25">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="vin_code" class="hide">VIN-код</label>
                                    <input type="text" id="vin_code" name="vin_code" placeholder="VIN-код" class="inp_vin_code">
                                </div>
                            </div>
                        </div>


                    </li>
                    <li class="form_h_item">
                        <div class="field_10">
                            <div class="field_h">
                                <div class="field_w"><input type="text" class="inp_name_details" id='text'></div>
                            </div>

                        </div>

                    </li>
                    <li class="form_h_item mod_2">
                        <div class="form_lbl">Ваши контактные реквизиты</div>
                        <div class="field_5">
                            <div class="field_h">
                                <div class="field_w"><input type="text" placeholder="Ваше ФИО" id="full_name"  ></div>
                            </div>
                        </div>
                        <div class="field_25">
                            <div class="field_h">
                                <div class="field_w"><input type="text" placeholder="Номер телефона" id="phone_num"></div>
                            </div>
                        </div>
                        <div class="field_25">
                            <div class="field_h">
                                <div class="field_w"><input type="text" placeholder="Эл. Почта" id="email"></div>
                            </div>
                        </div>

                    </li>
                    <li class="form_h_item mod_1" id='bbb'>
                        <div class="field_10">
                            <input type="submit" value="Запросить" class="form_query" onclick="manager_help()">
                        </div>
                    </li>
                </ul>

            </li>

        </ul>
    </div>
</div>
<div id="basket_block" class="basket_block basket_block_header" style="font-size: 11px;">
   <?php  $this->load->view('page_elements/basket_block');  ?>
</div>
<div style="clear: both;"></div> 

