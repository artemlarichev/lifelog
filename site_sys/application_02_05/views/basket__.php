<!DOCTYPE HTML>
<html lang="ru-RU">
    <?php $this->load->view('page_elements/head'); ?>
    <body class="main_page">

        <div class="wrapper">
            <div class="base" id="wrapper">
                <?php $this->load->view('page_elements/header'); ?>
                <div class="main_row">
                    <div class="content_row basket_result">
                        <div class="main_table_wrap basket">
                            <div class="big_table_wrap">
                                <table class="big_table table">
                                    <thead>
                                        <tr>
                                            <th class="marking">
                                                Артикул
                                            </th>
                                            <th class="maker"> Производитель  </th>
                                            <th class="important"> Описание автомобиля </th>
                                            <th class="price"> <?= $_SESSION['valuta'] ?> </th>
                                            <th class="hdd" width='20px' style='display:none' >Наличие </th>
                                            <th class="col"> шт. </th>
                                            <th class="sum"> Сумма </th>
                                            <th class="sum"> В заказ </th>
                                            <th class="edit_col"><span class="edit_ico"></span></th>
                                            <th class="del_row">х</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <? $count=0;


                                        $group='';
                                        foreach($result as $val){
                                        $hidden =0;
                                        $count++;
                                        if(!isset($val['in_order'])) $val['in_order']=1;    
                                        if($val['type']=='0_sklad'){

                                        $cu_group=$val['group'];
                                        if(!($val['group_1']=='')) {$cu_group.=' » '.$val['group_1'];}
                                        if(!($val['group_2']=='')) {$cu_group.=' » '.$val['group_2'];}
                                        if(!($group==$cu_group))
                                        {
                                        $group=$cu_group;
                                        ?>
                                        <tr>
                                            <td class="table_hline_row" colspan="9">
                                                <h2 class="table_hline"><?= $group ?></h2>
                                            </td>
                                        </tr>

                                        <?}


                                        ?>

                                        <tr  class="table_check_row_prepare">
                                            <td><?if($val['manuf']=='Оригинал' or $val['manuf']=='Лицензия'){
                                                $price =$val['price_end']; 
                                                $hidden =$val['article'];
                                                ?>
                                                <a title="<?= $val['article'] ?>" ><?= $val['article'] ?></a>

                                                <?}else{
                                                $price =$val['price_end']; 
                                                ?>
                                                <a title="<?= $val['article'] ?>" href="/parts/<?= $val['id'] ?>"><?= $val['article'] ?></a>
                                                <?}?>

                                            </td>
                                            <td><?= $val['manuf'] ?></td>
                                            <td><?= $val['car_desc'] ?></td>
                                            <td class="numeric">
                                                <?= $price ?>
                                            </td>
                                            <td class="hdd" width='20px'  style='display:none;text-align:right' ><span id='nal_<?= $count ?>'></span> </td>

                                            <td class="f_buy">
                                                <input type="text" name='count_<?= $count ?>'  id='count_<?= $count ?>' value='<?= $val['bascet_count'] ?>'>
                                                <input type="hidden" name='id_<?= $count ?>'  id='id_<?= $count ?>' value='<?= $val['id'] ?>'>
                                                <input type="hidden" name='hiden_<?= $count ?>'  id='hiden_<?= $count ?>' value='<?= $hidden ?>'>


                                                <input type="hidden" name='price_<?= $count ?>'  id='price_<?= $count ?>' value='<?= $price ?>'>



                                                <input type="hidden" name='amount_<?= $count ?>'  id='amount_<?= $count ?>' value='<?= $val['amount'] ?>'></td><input type="hidden" name='type_<?= $count ?>'  id='type_<?= $count ?>' value='<?= $val['type'] ?>'>
                                    <input type="hidden" name='amount_<?= $count ?>'  id='amount_<?= $count ?>' value='<?= $val['amount'] ?>'></td><input type="hidden" name='type_<?= $count ?>'  id='type_<?= $count ?>' value='<?= $val['type'] ?>'>


                                    <td class="numeric"><div id='suma_<?= $count ?>'>
                                            <?= $price * $val['bascet_count'] * $val['in_order'] ?>
                                        </div></td>
                                    <td>
                                        <input type="checkbox" value="1" id='in_order_<?= $count ?>' 
                                               <?if($val['in_order']>0){?>
                                               checked="checked" 
                                               <?}?>   >

                                    </td>

                                    <td> <a title="" href="#" onclick='Show_add_block_sclad(<?= $count ?>);
                                            return false' class="edit_ico"></a></td>
                                    <td><a href='/catalog/del/<?= $val['id'] . $val['type'] ?>'><span class="t_del">х</span></a></td>
                                    </tr>
                                    <tr id='add_block_<?= $count ?>'
                                        <?if(!($val['add1']>0 or $val['add2']>0or $val['add3']>0or $val['add4']>0or $val['add5']>0)) {?>
                                        style='display:none' <?}?>>
                                        <td colspan="9" class="table_check_row">
                                            <div class="lable_wrap">
                                                <label>

                                                    <input type="checkbox" <?if($val['add1']>0) {echo " checked ";}?>id='add1_<?= $count ?>' class='add1'> Только этот артикул</label>
                                            </div>
                                            <div class="lable_wrap"><label>
                                                    <input id='add2_<?= $count ?>' <?if($val['add2']>0) {echo " checked ";}?>class='add2' type="checkbox"> Только этот производитель</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add3_<?= $count ?>' <?if($val['add3']>0) {echo " checked ";}?>class='add3'type="checkbox"> Только это количество</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add4_<?= $count ?>' <?if($val['add4']>0) {echo " checked ";}?>class='add4'type="checkbox"> Возможно повышение стоимости</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add5_<?= $count ?>' <?if($val['add5']>0) {echo " checked ";}?>class='add5'type="checkbox" > Могу ждать месяц</label></div>

                                            <div class="lable_wrap_last">		<label>
                                                    <input type="checkbox" onclick='SetAddAll(<?= $count ?>)' > Применить ко всем</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style='display:none'>
                                        <td colspan="6" class="table_check_row">
                                        </td>
                                    </tr>

                                    <?}elseif($val['type']=='1_ukr'){?>
                                    <tr>
                                        <td class="table_hline_row" colspan="9">
                                            <h2 class="table_hline">Под заказ</h2>
                                        </td>
                                    </tr>   
                                    <tr  class="table_check_row_prepare">
                                        <td>
                                            <?= $val['product'] ?> 
                                        </td>
                                        <td><?= $val['producer'] ?></td>
                                        <td>  <?= $val['desc'] ?></td>
                                        <td class="numeric">
                                            <?= get_price_ukr($val, $this->conf['kurs'], $this->conf['discont']) ?></td>
                                        <td class="hdd" width='20px'  style='display:none;text-align:right' ><span id='nal_<?= $count ?>'></span> </td>

                                        <td class="f_buy">
                                            <input type="text" name='count_<?= $count ?>'  id='count_<?= $count ?>' value='<?= $val['bascet_count'] ?>'>
                                            <input type="hidden" name='id_<?= $count ?>'  id='id_<?= $count ?>' value='<?= $val['id'] ?>'>
                                            <input type="hidden" name='type_<?= $count ?>'  id='type_<?= $count ?>' value='<?= $val['type'] ?>'>
                                            <input type="hidden" name='hiden_<?= $count ?>'  id='hiden_<?= $count ?>' value='0'>
                                            <input type="hidden" name='price_<?= $count ?>'  id='price_<?= $count ?>' value='<?= get_price_ukr($val, $this->conf['kurs'], $this->conf['discont']) ?>'>
                                            <input type="hidden" name='amount_<?= $count ?>'  id='amount_<?= $count ?>' value='<?= $val['count'] ?>'></td>


                                        <td class="numeric"><div id='suma_<?= $count ?>'>
                                                <?= get_price_ukr($val, $this->conf['kurs'], $this->conf['discont']) * $val['bascet_count'] * $val['in_order'] ?>
                                            </div></td>
                                        <td>
                                            <input type="checkbox" value="1" id='in_order_<?= $count ?>' 
                                                   <?if($val['in_order']>0){?>
                                                   checked="checked" 
                                                   <?}?>   >
                                        </td>
                                        <td> <a title="" href="#" onclick='Show_add_block_sclad(<?= $count ?>);
                                                return false' class="edit_ico"></a></td>
                                        <td><a href='/catalog/del/<?= $val['id'] . $val['type'] ?>'><span class="t_del">х</span></a></td>
                                    </tr>
                                    <tr id='add_block_<?= $count ?>'
                                        <?if(!($val['add1']>0 or $val['add2']>0or $val['add3']>0or $val['add4']>0or $val['add5']>0)) {?>
                                        style='display:none' <?}?>>
                                        <td colspan="9" class="table_check_row">
                                            <div class="lable_wrap">
                                                <label>

                                                    <input type="checkbox" <?if($val['add1']>0) {echo " checked ";}?>id='add1_<?= $count ?>' class='add1'> Только этот артикул</label>
                                            </div>
                                            <div class="lable_wrap"><label>
                                                    <input id='add2_<?= $count ?>' <?if($val['add2']>0) {echo " checked ";}?>class='add2' type="checkbox"> Только этот производитель</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add3_<?= $count ?>' <?if($val['add3']>0) {echo " checked ";}?>class='add3'type="checkbox"> Только это количество</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add4_<?= $count ?>' <?if($val['add4']>0) {echo " checked ";}?>class='add4'type="checkbox"> Возможно повышение стоимости</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add5_<?= $count ?>' <?if($val['add5']>0) {echo " checked ";}?>class='add5'type="checkbox" > Могу ждать месяц</label></div>

                                            <div class="lable_wrap_last">        <label>
                                                    <input type="checkbox" onclick='SetAddAll(<?= $count ?>)' > Применить ко всем</label>
                                            </div>
                                        </td>
                                    </tr>   
                                    <?}elseif($val['type']=='2_mp'){?>
                                    <tr>
                                        <td class="table_hline_row" colspan="9">
                                            <h2 class="table_hline">Дальний заказ</h2>
                                        </td>
                                    </tr>   
                                    <tr  class="table_check_row_prepare">
                                        <td>
                                            <?= $val['DetailNum'] ?> 
                                        </td>
                                        <td><?= $val['MakeName'] ?></td>
                                        <td>Поставщик: <?= $val['PriceLogo'] ?>

                                            <?= $val['PartNameRus'] ?> 
                                            <?= $val['PartNameEng'] ?>

                                        </td>
                                        <td class="numeric">
                                            <?= $val['price_end'] ?></td>
                                        <td class="hdd" width='20px'  style='display:none;text-align:right' ><span id='nal_<?= $count ?>'></span> </td>

                                        <td class="f_buy">
                                            <input type="text" name='count_<?= $count ?>'  id='count_<?= $count ?>' value='<?= $val['bascet_count'] ?>'>
                                            <input type="hidden" name='id_<?= $count ?>'  id='id_<?= $count ?>' value='<?= $val['id'] ?>'>
                                            <input type="hidden" name='type_<?= $count ?>'  id='type_<?= $count ?>' value='<?= $val['type'] ?>'>
                                            <input type="hidden" name='price_<?= $count ?>'  id='price_<?= $count ?>' value=' <?= $val['price_end'] ?>'>
                                            <input type="hidden" name='hiden_<?= $count ?>'  id='hiden_<?= $count ?>' value='0'>
                                            <input type="hidden" name='amount_<?= $count ?>'  id='amount_<?= $count ?>' value='<?= $val['count'] ?>'></td>


                                        <td class="numeric"><div id='suma_<?= $count ?>'>
                                                <?= number_format($val['price_end'] * $val['bascet_count'] * $val['in_order'], 2) ?>
                                            </div></td>
                                        <td>
                                            <input type="checkbox" value="1" id='in_order_<?= $count ?>' 
                                                   <?if($val['in_order']>0){?>
                                                   checked="checked" 
                                                   <?}?>   >
                                        </td>
                                        <td> <a title="" href="#" onclick='Show_add_block_sclad(<?= $count ?>);
                                                return false' class="edit_ico"></a></td>
                                        <td><a href='/catalog/del/<?= $val['id'] . $val['type'] ?>'><span class="t_del">х</span></a></td>
                                    </tr>
                                    <tr id='add_block_<?= $count ?>'
                                        <?if(!($val['add1']>0 or $val['add2']>0or $val['add3']>0or $val['add4']>0or $val['add5']>0)) {?>
                                        style='display:none' <?}?>>
                                        <td colspan="9" class="table_check_row">
                                            <div class="lable_wrap">
                                                <label>

                                                    <input type="checkbox" <?if($val['add1']>0) {echo " checked ";}?>id='add1_<?= $count ?>' class='add1'> Только этот артикул</label>
                                            </div>
                                            <div class="lable_wrap"><label>
                                                    <input id='add2_<?= $count ?>' <?if($val['add2']>0) {echo " checked ";}?>class='add2' type="checkbox"> Только этот производитель</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add3_<?= $count ?>' <?if($val['add3']>0) {echo " checked ";}?>class='add3'type="checkbox"> Только это количество</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add4_<?= $count ?>' <?if($val['add4']>0) {echo " checked ";}?>class='add4'type="checkbox"> Возможно повышение стоимости</label></div>
                                            <div class="lable_wrap"><label>
                                                    <input  id='add5_<?= $count ?>' <?if($val['add5']>0) {echo " checked ";}?>class='add5'type="checkbox" > Могу ждать месяц</label></div>

                                            <div class="lable_wrap_last">        <label>
                                                    <input type="checkbox" onclick='SetAddAll(<?= $count ?>)' > Применить ко всем</label>
                                            </div>
                                        </td>
                                    </tr>   
                                    <?}}?>

                                    <tr class="last_row">
                                        <td colspan="3" class="no_border" id='ch_colspan'>
                                        </td>
                                        <td colspan="2" class="no_border">
                                            <input type="submit" onclick ='RefreshBasket()' value="Обновить">
                                        </td>
                                        <td class="numeric">
                                            <div id='suma'> <?= $_SESSION['basket_data']['sum'] ?></div></td>
                                        <td colspan="2" class="no_border"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <script type="text/javascript" >p_count = '<?= $count ?>';//'</script>
                                <div class="basket_info">
                                    <dl class="basket_user_form">
                                        <dt><label for="f_n">Имя и фамилия:</label></dt>
                                        <dd><input type="text" name="f_n" id="f_n"
                                                   value='<?if(isset($_SESSION['user']['name'])) {echo $_SESSION['user']['fullname']; ;} else { echo $_SESSION['user']['name']; }?>'></dd>
                                        <dt><label for="tel" >Телефон:</label></dt>
                                        <dd><input type="text" name="tel" id="tel"
                                                   value='<?if(isset($_SESSION['user']['tel'])) {echo $_SESSION['user']['tel'];}?>'></dd>
                                        <dt><label for="mail">Почта:</label></dt>
                                        <dd><input type="text" name="mail" id="mail"
                                                   value="<?php if (isset($_SESSION['user']['email'])) {
                                                    echo $_SESSION['user']['email'];
                                                } ?>"
                                                   ></dd>
                                        <dt><label for="comments">Комментарии и уточнения:</label></dt>
                                        <dd class="texta_wrap"><textarea name="comments" id="comments" cols="4" rows="4"></textarea></dd>

                                    </dl>
                                    <div class="basket_total">
                                        <div class="total">
                                            Итого к оплате: <span id='suma2'><?= $_SESSION['basket_data']['sum'] ?></span>
                                            <?if($_SESSION['valuta']==USD){echo 'долларов';}else {echo 'гривен';}?>

                                        </div>
                                        <input type="submit" value="Оформить заказ" onclick ='SaveOrder()' >


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--
                
                    
                    -->
                </div>
<?php $this->load->view('page_elements/footer'); ?>
            </div>
        </div>
    </body>
</html>
