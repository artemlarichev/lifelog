<?php
if (isset($_SESSION['manager']))
    $this->load->view('page_elements/manager_menu');
?>
<div class="header" style="background: url('<?=$this->data->rand_banner() ?>') no-repeat scroll 50% 86px transparent !important;">

    <!-- Header Wrap -->
    <div class="header_wrap" style="background: url('<?=$this->data->rand_banner() ?>') no-repeat scroll 50% 86px transparent; " >

        <h1 class="logo_w"><a class="logo" href="/" title="Джапан Авто">Джапан Авто</a></h1>

        <!-- Login -->
        <div id='login'>
            <?php $this->load->view('page_elements/login_box'); ?>
        </div><!-- End Login -->

        <!-- Telephone -->
        <div class="tel">
            <span>(044)</span> 540-51-08, 540-79-55
        </div><!-- End Telephone -->

        <!-- Links -->
        <ul class="list_link">
            <li><a href="/shops" title="Наши магазины">Наши магазины</a></li>
            <li><a href="/order" title="Заказ и доставка">Заказ и доставка</a></li>
        </ul><!-- End Links -->

        <div style="clear: both;"></div> 

    </div><!-- End Header Wrap -->
<?php $this->load->view('page_elements/search_menu'); ?>
</div>

<div class="search_block">
    <div class="search_hold">
        <ul class="search_tabs">
            <li class="search_t_item  <?php if($action == 'orders'): ?>selected<?php endif; ?>" onclick="location.replace('/client/orders/1/0');">
                <span class="search_t_i_text">Заказы</span>
            </li>
            
            
            <li class="search_t_item <?php if($action == 'balance'): ?>selected<?php endif; ?>" onclick="location.replace('/client/balance/');">
                <span class="search_t_i_text">Баланс</span>
            </li>
            
            <li class="search_t_item <?php if($action == 'search_history'): ?>selected<?php endif;?>" onclick="location.replace('/client/search_history/');">
                <span class="search_t_i_text">История поиска</span>
            </li>
            
            <li class="search_t_item <?php if($action == 'account'): ?>selected<?php endif;?>" onclick="location.replace('/client/account/');">
                <span class="search_t_i_text">Учетные данные</span>
            </li>
            <?php if(isset($_SESSION['manager'])): ?>
            <li class="search_t_item <?php if($action == 'emir_work'): ?>selected<?php endif;?>" onclick="location.replace('/manager/emir_work/');">
                <span class="search_t_i_text">Работа с Эмиратами</span>
            </li>
            
            <li class="search_t_item <?php if($action == 'fields'): ?>selected<?php endif;?>" onclick="location.replace('/manager/fields/');">
                <span class="search_t_i_text">Настройки</span>
            </li>
            <?php endif; ?>
        </ul>
        
        <ul class="search_wraps">
            
            <li class="search_w_item  selected bg_white">
                <?php if($action == 'orders'): ?>
                <div class="main_row">
                <form id='ed_nakl' action='' method='post'>
                    <input type='hidden' name='nakl_id'  id='nakl_id' value=''>
                    <input type='hidden' name='nakl' id='nakl' value=''>
                </form>

                <form id='ed_dekl' action='' method='post'>
                    <input type='hidden' name='dekl_id'  id='dekl_id' value=''>
                    <input type='hidden' name='dekl' id='dekl' value=''>
                </form>
                <script>
                        function EditNakl(id)
                        {
                                $("#n_t_"+id).toggle();
                                $("#n_f_"+id).toggle();
                        }
                        function SaveNakl(id)
                        {
                                SubmitLink('/ajax_manager/set_value/orders/'+id+'/nakladna/'+$("#nakl_edit_"+id).val(),'n_t_'+id);
                                $("#n_t_"+id).show();
                                $("#n_f_"+id).hide();
                        }

                        function EditDekl(id)
                        {
                                $("#d_t_"+id).toggle();
                                $("#d_f_"+id).toggle();
                        }
                        function SaveDecl(id)
                        {
                                SubmitLink('/ajax_manager/set_value/orders/'+id+'/dekl/'+$("#decl_edit_"+id).val(),'d_t_'+id);
                                $("#d_t_"+id).show();
                                $("#d_f_"+id).hide();
                        }
                </script>
                <?php if($_SESSION['manager']): ?>
                <a href="/manager/sup_export">Експорт списка запчастей украинских поставщиков</a>
                <?php endif; ?>
                <?php if($status==2){?>   
                Отображены выполненные заказы за неделю <a href='/client/orders/3/<?= $show_parts ?>'>Показать все</a>
                <br /><br />
                <?php }?>

                    <div class="content_row">
                        <?php if($_SESSION['manager']): ?>
                        <div class="search_block">
                            <div class="search_form" style="margin-bottom: 10px;">
                                <ul class="order_category">
                                    <li>
                                        <a title="Новые" href="/manager/orders/0/0/all/0_sklad">
                                            Наличие
                                        </a>
                                    </li>
                                    <li>
                                        <a title="В обработке" href="/manager/orders/0/0/all/1_ukr" >
                                            Украина
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Выполненные" href="/manager/orders/0/0/all/2_mp" >
                                            Эмираты
                                        </a>
                                    </li>
                                </ul>
                            </div>                
                        </div>
                        <?php endif; ?>
                        <div class="search_block" style="padding-top:15px">
                            <div class="field_23">
                                <div class="field_h">
                                    <div class="field_w">
                                        <div class="field_s">
                                            <label for="num_carcass" class="bold">Статус заказа</label>
                                            <select class="sel_v sel_v4" name="sel_type_carcass" id="type_carcass">
                                                <option value="Седан">Выполненные</option>
                                                <option value="Внедорожник">В обработке</option>
                                                <option value="Минивэн">Новые</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="field_23" style="padding-left:3%;">
                                <div class="field_h">
                                    <div class="field_w">
                                        <div class="field_s">
                                            <label for="num_carcass" class="bold">Отображение</label>
                                            <select class="sel_v sel_v4" name="sel_type_carcass" id="type_carcass">
                                                <option value="Седан">Запчасти</option>
                                                <option value="Внедорожник">Заказы</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="search_block" style="margin-bottom:30px; padding-top:15px">
                            <div class="field_22">
                                <div class="field_h">
                                    <div class="field_w">
                                        <label for="num_carcass" class="bold">Номер запчасти</label>
                                        <input type="text" id="num_carcass" name="num_carcass" class="inp_num_carcass">
                                    </div>
                                </div> 
                            </div>
                            
                            <div class="field_22 field_p">
                                <div class="field_h">
                                    <div class="field_w">
                                        <label for="num_carcass" class="bold">Номер накладной</label>
                                        <input type="text" id="num_carcass" name="num_carcass" class="inp_num_carcass">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field_22 field_p">
                                <div class="field_h">
                                    <div class="field_w">
                                        <label for="num_carcass" class="bold">От даты</label>
                                        <input type="text" id="num_carcass" name="num_carcass" class="inp_num_carcass">
                                    </div>
                                </div>
                            </div>

                            <div class="field_22 field_p">
                                <div class="field_h">
                                    <div class="field_w">
                                        <label for="num_carcass" class="bold">До даты</label>
                                        <input type="text" id="num_carcass" name="num_carcass" class="inp_num_carcass">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="main_table_wrap order">

                            <div class="big_table_wrap">

                                <table class="big_table table">
                                    <thead>
                                        <tr>
                                            <th class="marking">
                                                Артикул
                                            </th>
                                            <th class="maker"> № заказа </th>
                                            <th class="maker">Статус </th>    
                                            <th class="maker"> № накладной </th>
                                            <th class="maker"> № декларации </th>
                                            <th class="maker"> Дата </th>
                                            <th class="maker"> Производитель </th>	
                                            <th class="price"> цена </th>
                                            <th class="col"> шт. </th>
                                            <th class="sum"> Сумма </th>
                                            <!--<th class="edit_col"><span class="edit_ico"></span></th>-->

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- here is code must be -->
                                    </tbody>
                                </table>



                                <div class="basket_info">

                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <?php endif; ?>
                
                <?php if($action == 'balance'): ?>
                <div class="main_row">
                    <div class="content_row balance_page">
                        <form action="" method="post">
                            <? if (isset($msg)) { ?> <h3 style='color:red;margin:10px;'>Изменение сохранены</h3> <? }?>
                            <div class="search_block" style="padding-top:0px">						
                                <div class="field_23">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <div class="balance_addi_info">
                                                <div class="balance_in_total">
                                                    Всего закупок на <br><span style="font-size:18px"><?=(float)$all_payout;?></span> грн.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if($_SESSION['manager']): ?>
                                <div class="field_23" style="padding-left:3%">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <div class="field_s">
                                                <label for="num_carcass" class="bold">Тип клиента</label>
                                                <select class="sel_v sel_v4" name="sel_type_carcass" id="type_carcass">
                                                    <option value="roznica">Розница</option>
                                                    <option value="sto">СТО</option>
                                                    <option value="m_opt">Мелкий опт</option>
                                                    <option value="s_opt">Средний опт</option>
                                                    <option value="k_opt">Крупный опт</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="field_22" style="padding-left:2%">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <label for="num_carcass" class="bold">Объем закупок в месяц</label>
                                            <input type="text" id="num_carcass" name="num_carcass" class="inp_num_carcass" placeholder="50 000" value="<?=$_SESSION['user']['credit'];?>">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="search_block" style="margin-bottom:30px; padding-top:15px">								
                                
                                <div class="field_22">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <label for="num_carcass" class="bold">Кредитный лимит </label>
                                            <input type="text" id="num_carcass" name="num_carcass" class="inp_num_carcass" <?php if($_SESSION['user_type'] == 'user'): ?>disabled="disabled"<?php endif; ?>>
                                        </div>
                                    </div> 
                                </div>
                                
                                <?php if($_SESSION['manager']): ?>
                                <div class="field_22 field_p">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <label for="num_carcass" class="bold">Скидка, %</label>
                                            <input value="<?=$_SESSION['user']['discont'];?>" type="text" id="num_carcass" name="num_carcass" class="inp_num_carcass" placeholder="15">
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if(isset($_SESSION['manager'])): ?>
                            <div class="balance_addi_info">
                                <input type="button" value="Создать транзакцию">
                                <input type="submit" value="Cохранить">
                            </div>
                            <?php endif; ?>
                            <div class="big_table_wrap">
                                <table class="big_table table" id="main_tab">
                                    <thead>
                                        <tr>
                                            <th style='cursor:pointer'> Дата </th>
                                            <th style='cursor:pointer'>Тип</th>
                                            <th style='cursor:pointer' class="sum"> Сумма </th>
                                            <th style='cursor:pointer'> Баланс </th>
                                            <th style='cursor:pointer'>  Примечание </th>
                                            <th style='cursor:pointer'> № накладной </th>
                                            <th style='cursor:pointer'> № декларации </th>
                                            <th style='cursor:pointer'> № платежки </th>
                                            <th style='cursor:pointer'> № перевода </th>
                                            <?php if(isset($_SESSION['manager'])): ?>
                                            <th class="edit_col"><span class="edit_ico"></span></th>
                                            <th class="del_row">х</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php foreach($pay_in_out as $pay): ?>
                                        <tr>
                                            <td><?=  convert_date($pay['data'], 1)?></td>
                                            
                                            <td class="charge" style='color:#980000'>
                                                <?php if($pay['type'] == 'in'): ?>
                                                Начисление
                                                <?php elseif ($pay['type'] == 'out'): ?>
                                                Списание
                                                <?php endif; ?>
                                            </td>
                                            
                                            <td class="numeric"><?=$pay['suma'];?></td>
                                            
                                            <td><?=$pay['balans'];?></td>
                                            
                                            <td>
                                                <?if($pay['order_id']>0){?><a href='/<?if(isset($_SESSION['manager'])){?>manager<?}else{?>client<?}?>/order/<?= $pay['order_id'] ?>'>Заказ №<?= $pay['order_id'] ?></a> <?}?>


                                                <span id='text_text_<?= $pay['id'] ?>'><?= $pay['text'] ?></span>
                                                <DIV style="display: none;" id='form_text_<?= $pay['id'] ?>'>
                                                    <input id='edit_text_<?= $pay['id'] ?>' value='<?= $pay['text'] ?>'>

                                                    <button onclick="SaveText(<?= $pay['id'] ?>, 'text',<?= $pay['order_id'] ?>);
                                                        return false">>></button>
                                                </DIV>


                                                <a title="" href="#" class="edit_ico" onclick="EditText(<?= $pay['id'] ?>, 'text');
                                                    return false"></a>
                                            </td>
                                            <td>
                                                <span id='text_nakladna_<?= $pay['id'] ?>'><?= $pay['nakladna'] ?></span>
                                                <DIV style="display: none;" id='form_nakladna_<?= $pay['id'] ?>'>
                                                    <input id='edit_nakladna_<?= $pay['id'] ?>' value='<?= $pay['nakladna'] ?>'>

                                                    <button onclick="SaveText(<?= $pay['id'] ?>, 'nakladna',<?= $pay['order_id'] ?>);
                                                        return false">>></button>
                                                </DIV>


                                                <a title="" href="#" class="edit_ico" onclick="EditText(<?= $pay['id'] ?>, 'nakladna');
                                                    return false"></a>

                                            </td>
                                            <td>
                                                <span id='text_decl_<?= $pay['id'] ?>'><?= $pay['decl'] ?></span>
                                                <DIV style="display: none;" id='form_decl_<?= $pay['id'] ?>'>
                                                    <input id='edit_decl_<?= $pay['id'] ?>' value='<?= $pay['decl'] ?>'>
                                                    <button onclick="SaveText(<?= $pay['id'] ?>, 'decl',<?= $pay['order_id'] ?>);
                                                        return false">>></button>
                                                </DIV>
                                                <a title="" href="#" class="edit_ico" onclick="EditText(<?= $pay['id'] ?>, 'decl');
                                                    return false"></a>
                                            </td>
                                            <td>
                                                <span id='text_platig_<?= $pay['id'] ?>'><?= $pay['platig'] ?></span>
                                                <DIV style="display: none;" id='form_platig_<?= $pay['id'] ?>'>
                                                    <input id='edit_platig_<?= $pay['id'] ?>' value='<?= $pay['platig'] ?>'>
                                                    <button onclick="SaveText(<?= $pay['id'] ?>, 'platig',<?= $pay['order_id'] ?>);
                                                        return false">>></button>
                                                </DIV>
                                                <a title="" href="#" class="edit_ico" onclick="EditText(<?= $pay['id'] ?>, 'platig');
                                                    return false"></a>
                                            </td>
                                            <td>
                                                <span id='text_perevod_<?= $pay['id'] ?>'><?= $pay['perevod'] ?></span>
                                                <DIV style="display: none;" id='form_perevod_<?= $pay['id'] ?>'>
                                                    <input id='edit_perevod_<?= $pay['id'] ?>' value='<?= $pay['perevod'] ?>'>
                                                    <button onclick="SaveText(<?= $pay['id'] ?>, 'perevod',<?= $pay['order_id'] ?>);
                                                        return false">>></button>
                                                </DIV>
                                                <a title="" href="#" class="edit_ico" onclick="EditText(<?= $pay['id'] ?>, 'perevod');
                                                    return false"></a>	
                                            </td>
                                            <?php if (isset($_SESSION['manager'])) : ?>
                                            <td><a class="edit_ico" href="/client/balance/<?= $pay['id'] ?>"></a></td>
                                            <td>
                                                <a href="/client/balance/<?= $pay['id'] ?>/del" onclick="return confirm('Удалить?')"><span class="t_del">х</span></a>
                                            </td>
                                            <?php endif;?>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if($action == 'search_history'): ?>
                <div class="main_row">
                    <form action="" method='post'>
                        <? if(isset($msg)){?>	<h3 style='color:red;margin:10px;'>Изменение сохранены</h3> <?}?>
                        <div class="content_row" style="margin-left: 20px; margin-top: 15px; ">
                            <div class="small_table_wrap">

                                <table class="small_table table" id='main_tab'>
                                    <thead>
                                        <tr>
                                            <th style='cursor:pointer;text-decoration:underline'   > Фраза </th>
                                            <? if(isset($_SESSION['manager'])) { ?> <th class="amount" style='cursor:pointer;text-decoration:underline'  >Время</th><th class="amount" style='cursor:pointer;text-decoration:underline'> Количество </th> <?}?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?foreach($result as $val){?>
                                        <tr>
                                            <td>
                                                <a title="Количество" href="#" onclick='History_Search("<?= $val['title'] ?>");
                                                        return false'><?= $val['title'] ?> </a>
                                            </td>
                                            <? if(isset($_SESSION['manager'])) { ?><td><?=$val['time'];?></td><td class="numeric"><?= $val['cnt'] ?></td>   <?}?>
                                        </tr>
                                        <?}?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <script src="/js/ui.tablesorter.js" type="text/javascript"></script>

                        <script type="text/javascript">


                                                    $("#main_tab").tablesorter({widgets: ['zebra']});

                        </script>
                </div>
                <?php endif; ?>
                
                <?php if($action == 'account'): ?>
                <div class="main_row">
                    <form action="" method="post">
                    <?php if(isset($msg) && $msg == 1): ?>
                        <h3 style='color:green;margin:10px; margin-left: 20px;'>Изменение сохранены</h3>
                    <?php endif; ?>
                        
                    <?php if(isset($msg) && $msg == 2): ?>
                        <h3 style='color:red;margin:10px;'>Ошибка сохранения</h3>
                    <?php endif; ?>
                        
                    <div class="search_block" style="padding-top:0px; margin-left: 20px; margin-top: 20px;">								
                        <div class="field_22">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="card_number" class="bold">Номер карты </label>
                                    <input type="text" id="card_number" name="card_number" class="inp_num_carcass" value="<?=$user['card'];?>" <?php if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'user'): ?>disabled="disabled" <?php endif; ?> />
                                </div>
                            </div> 
                        </div>

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="org_name" class="bold">Название ораганизации</label>
                                    <input type="text" id="org_name" name="org_name" class="inp_num_carcass" <?php if(!empty($user['name'])): ?> value="<?=$user['name'];?>" <?php else: ?> placeholder="Название организации" <?php endif; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="org_address" class="bold">Адрес организации</label>
                                    <input type="text" id="org_address" name="org_address" class="inp_num_carcass" <?php if(!empty($user['org_address'])): ?> value="<?=$user['org_address'];?>" <?php else: ?> placeholder="Адрес организации" <?php endif; ?>>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="search_block" style="padding-top:15px; margin-left: 20px;">								
                        <div class="field_22">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="user_password" class="bold">Пароль </label>
                                    <input type="text" id="user_password" name="user_password" class="inp_num_carcass" placeholder="Ваш новый пароль">
                                </div>
                            </div> 
                        </div>

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="user_fullname" class="bold">Контактное лицо (ФИО)</label>
                                    <input type="text" id="user_fullname" name="user_fullname" class="inp_num_carcass" <?php if(!empty($user['fullname'])): ?> value="<?=$user['fullname'];?>" <?php else: ?> placeholder="Ваше ФИО" <?php endif; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w">
                                    <label for="user_city" class="bold">Город</label>
                                    <input type="text" id="user_city" name="user_city" class="inp_num_carcass" <?php if(!empty($user['city'])): ?> value="<?=$user['city'];?>" <?php else: ?> placeholder="Ваш город" <?php endif; ?>>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="search_block" style="margin-left:22%; padding-top:15px">								

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w" style="position:relative; margin-left: 20px;">
                                    <label for="user_tel" class="bold">Телефон</label>
                                    <input type="text" id="user_tel" name="user_tel" class="inp_num_carcass" <?php if(!empty($user['tel'])): ?> value="<?=$user['tel'];?>" <?php else: ?> placeholder="(050)550-40-40" <?php endif;?>>
                                    <button type="button"  class="add_btn" style="background:none; border:none; color:blue;">
                                        <span>x</span>
                                    </button><br>
                                    <a href="" style="cursor:pointer;text-decoration:none; position:relative; top:-15px"> + Добавить телефон </a> 

                                </div>
                            </div>
                        </div>

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w" style="margin-left: 20px;">
                                    <label for="del_service" class="bold">Служба доставки</label>
                                    <input type="text" id="del_service" name="del_service" class="inp_num_carcass" <?php if(!empty($user['delivery_service'])): ?> value="<?=$user['delivery_service'];?>" <?php else: ?> placeholder="Служба доставки" <?php endif; ?>>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="search_block" style="margin-left:22%; padding-top:0px">								

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w" style="margin-left: 20px;">
                                    <label for="user_email" class="bold">Электронная почта</label>
                                    <input type="text" id="user_email" name="user_email" class="inp_num_carcass" <?php if(!empty($user['email'])): ?> value="<?=$user['email'];?>" <?php else: ?>placeholder="Адрес электронной почты" <?php endif; ?>>
                                </div>
                            </div>
                        </div>					
                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w" style="margin-left: 20px;">
                                    <label for="user_recipient" class="bold">ФИО получателя</label>
                                    <input type="text" id="user_recipient" name="user_recipient" class="inp_num_carcass" <?php if(!empty($user['recipient_fio'])): ?> value="<?=$user['recipient_fio'];?>" <?php else: ?>placeholder="ФИО получателя"<?php endif; ?>>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="search_block" style="margin-left:22%; padding-top:15px">								

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w" style="margin-left: 20px;">
                                    <label for="user_skype" class="bold">Скайп</label>
                                    <input type="text" id="user_skype" name="user_skype" class="inp_num_carcass" <?php if(!empty($user['skype'])): ?> value="<?=$user['skype'];?>" <?php else: ?>placeholder="Скайп" <?php endif; ?>>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="search_block" style="margin-left:22%; margin-bottom:30px; padding-top:15px">								

                        <div class="field_22 field_p">
                            <div class="field_h">
                                <div class="field_w" style="margin-left: 20px;">
                                    <label for="user_site" class="bold">Сайт</label>
                                    <input type="text" id="user_site" name="user_site" class="inp_num_carcass" <?php if(!empty($user['site'])): ?> value="<?=$user['site'];?>" <?php else: ?>placeholder="http://your-site.here"<?php endif; ?>>
                                </div>
                            </div>
                        </div>

                    </div>
                    <br>
                    <input type='submit' name='save' value='Сохранить' style="margin-left: 20px;">	
                    </form>
                </div>
                <?php endif; ?>
                
                <?php if($action == 'emir_work'): ?>
                <div class="main_row">
                    <form action="" method="post">
                        
                        <?php if (isset($msg) && $msg == 1): ?>
                            <h3 style='color:green;margin:10px; margin-left: 20px;'>Изменение сохранены</h3>
                        <?php endif; ?>
                            
                        <?php if (isset($msg) && $msg == 2): ?>
                            <h3 style='color:green;margin:10px; margin-left: 20px;'>Ошибка сохранения</h3>
                        <?php endif; ?>
                        <div class="emir_work" style="margin-left: 20px; margin-top: 15px;">
                            <div class="search_block" style="padding-top:0px">								

                                <div class="field_22">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <label for="mp_coef" class="bold">Коэфицент доставки</label>
                                            <input type="text" id="mp_coef" name="mp_coef" class="inp_num_carcass" placeholder="7,5">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="search_block" style="padding-top:15px">								

                                <div class="field_22">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <label for="mp_code" class="bold">Номер Мегпартс</label>
                                            <input type="text" id="mp_code" name="mp_code" class="inp_num_carcass" placeholder="127">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="search_block" style="padding-top:15px">								

                                <div class="field_22">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <label for="mp_login" class="bold">Имя Мегпартс</label>
                                            <input type="text" id="mp_login" name="mp_login" class="inp_num_carcass" placeholder="avtosys">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="search_block" style="margin-bottom:30px; padding-top:15px">								

                                <div class="field_22">
                                    <div class="field_h">
                                        <div class="field_w">
                                            <label for="mp_password" class="bold">Пароль Мегпартс</label>
                                            <input type="text" id="mp_password" name="mp_password" class="inp_num_carcass" placeholder="s0h908w3">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <br>
                            <input type='submit' name='save' value='Сохранить'>
                        </div>
                    </form>
                </div>
                <?php endif; ?>
                
                <?php if($action == 'fields'): ?>
                
                <?php
                    $fields_keys=array_keys($fields);
                ?>
                <div class="main_row">
                    <div class="field_23">
                            <div class="field_h">
                                <div class="field_w" style="padding-bottom:10px">	
                                    <input id='num_carcass' name='num_carcass' type="checkbox"></td>
                                    <label for="num_carcass">Отображать полный артикул при поиске</label>
                                </div>
                                <div class="field_w" style="padding-bottom:10px">
                                    <input id='num_carcass' name='num_carcass' type="checkbox"></td>
                                    <label for="num_carcass">Отображать выбор по группам при поиске</label>
                                </div>
                                <div class="field_w" style="padding-bottom:10px">
                                    <input id='num_carcass' name='num_carcass' type="checkbox"></td>
                                    <label for="num_carcass">Отображать ссылку на прайс в кабинете</label>
                                </div>
                                <div class="field_w" style="padding-bottom:10px">
                                    <input id='num_carcass' name='num_carcass' type="checkbox"></td>
                                    <label for="num_carcass">Отправлять оповещения с сайта по почте</label>
                                </div>
                            </div>
                        </div>
                        <div class="content_row" style="margin-left: 20px; margin-top: 15px;">
                            <div class="tiny_table_wrap">
                                <form action='' method='post'>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Название
                                                </th>
                                                <th class="check">
                                                    <input type="checkbox" id='all' onclick='SelAll()'>
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                                                                        
                                            <?php foreach($fields_keys as $key){?>
                                            
                                            <tr>
                                                <td>
                                                    <?php echo $fields[$key]; ?>
                                                </td>
                                                <td>
                                                    <input id='<?=$key; ?>' class='sel'  name='<?=$key; ?>' type="checkbox" <?if(isset($user_fields[$key])){echo"checked";}?>></td>
                                            </tr> 
                                            <?php }?> 
                                        </tbody>
                                    </table>
                                    <br>
                                    <input type='submit' name='save' value='Сохранить'>
                                    </div>

                                    </div>
                                    </div>
                <?php endif; ?>
                
                <?php if($action == 'margins'): ?>
                <div class="main_row">

                                    <? if (isset($msg)) { ?>	<h3 style='color:red;margin:10px;'><?= $msg ?></h3> <? }?>

                                    <div class="content_row suppliers_page">

                                        <div class="suppliers_addi_info">


                                            <input id="add_provider" type="button"  type="button"style='width:90px' value="Сохранить" onclick='document.forms.forma.submit()'>


                                        </div>

                                    </div>      <form action='/manager/margins/'  name ='forma' method='post'>
                                        <div class="big_table_wrap">

                                            <table class="big_table table" id='main_tab'>
                                                <thead>
                                                    <tr>
                                                        <th> Розница</th>
                                                        <th> СТО и магазины</th>
                                                        <th>Мелкий опт </th>
                                                        <th> Средний опт</th>
                                                        <th> Крупный опт</th>


                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <tr class="table_edit_row">
                                                        <td>

                                                            <input type="text" class='w100' name="rozn"   value="<?= $margins['rozn'] ?>">    %


                                                        </td>
                                                        <td>

                                                            <input type="text" name="sto"  class='w100' value="<?= $margins['sto'] ?>">    %
                                                        </td>
                                                        <td>
                                                            <input type="text" name="l_opt" class='w100'  value="<?= $margins['l_opt'] ?>">  %

                                                        </td>
                                                        <td>
                                                            <input type="text" name="m_opt" class='w100'  value="<?= $margins['m_opt'] ?>">   %


                                                        </td>
                                                        <td>
                                                            <input type="text" name="s_opt" class='w100'  value="<?= $margins['s_opt'] ?>">    %


                                                        </td>
                                                    </tr>



                                                </tbody>
                                            </table>
                                            <BR><br>

                                            <table class="big_table table" id='main_tab'>
                                                <thead>
                                                    <tr>                                                      
                                                        <th width="50px"> Для незарегистрированных</th>
                                                        <th width="20px"> Для незарегистрированных EMIR</th>
                                                        <th width="50px"> Курс валют</th>
                                                        <th>  </th>


                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <tr class="table_edit_row">
                                                        <td>
                                                            <input type="text" class='w100' name="nacenka"  style="width: 50px;"  value="<?= $nacenka ?>">    %



                                                        </td> <td>
                                                            <input type="text" class='w100' name="nacenka_emir"  style="width: 50px;"  value="<?= $nacenka_emir ?>"> 


                                                        </td>  <td> 
                                                            <input type="text" class='w100' name="kurs"  style="width: 50px;"  value="<?= $kurs ?>">  грн


                                                        </td>
                                                        <td>
                                                        </td>

                                                    </tr>



                                                </tbody>
                                            </table>


                                        </div>
                                    </form>

                                    <style>
                                     .w100{width:90%;text-align:right;}
                                    </style>

                                </div>
                <?php endif; ?>
            </li>
            
           
            
        </ul>
    </div>
</div>