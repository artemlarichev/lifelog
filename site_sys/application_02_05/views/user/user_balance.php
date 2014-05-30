<?php $this->load->view('page_elements/head'); ?>
<?php $this->load->view('page_elements/header'); ?>
<form action="/client/balance" method="post">
    <div class="balance_addi_info">
        <div class="balance_in_total">
            Всего закупок на <span><?= (float) $all_payout ?></span> <?= $user['valuta'] ?>.
        </div>
        <?if (isset($_SESSION['manager'])) {
        if(isset($edit_act)){
        ?>

        <input type="submit" id="make_transaction" style='margin-top: 10px;' value="Сохранить">


        <?}else{?>
        <b style="margin-left: 30px;">Кредитный лимит:</b>
        <input type="text" style="text-align: right; width: 50px;" name="credit" value="<?= $_SESSION['user']['credit'] ?>"> грн.
        <input type="submit" value="сохранить">
        <input type="button" name="make_transaction" id="make_transaction" value="Создать транзакцию" onclick="location.href = '/client/balance/0'">
        <? }}?>
    </div>

    <div class="big_table_wrap">
        <table class="big_table table" id='main_tab'>
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
                    <?if (isset($_SESSION['manager'])) { ?>
                    <th class="edit_col"><span class="edit_ico"></span></th>
                    <th class="del_row">х</th>
                    <? }?>
                </tr>
            </thead>

            <tbody>
                <?
                if (!isset($edit_act)) {
                $edit_act = '-';
                }
                if ($edit_act == '0' and isset($_SESSION['manager'])) {
                ?>
                <tr class="table_edit_row">
                    <td>
                        <div class="input_wrap">
                            <input type="text" id='datepicker' name='data' value='<?= Date("d.m.Y") ?>'>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <select name='type' id='type' onchange="SelTypeBal();
                                    return false">
                                <option value="in">Начисление</option>
                                <option value="out">Списание</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="suma">
                            <input type="hidden" name="id" value='0'>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="balans" id="balans"  disabled>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="text" >
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="nakladna" id="nakladna" disabled>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="decl" id="decl" disabled>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="platig" id="platig">
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="perevod" id="perevod">
                        </div>
                    </td>
                    <td><a class="edit_ico" href="/client/balance/0"></a></td>
                    <td><a href="/client/balance/"><span class="t_del">х</span></a></td>
                </tr>

                <?
                }

                foreach ($pay_in_out as $pay) {
                if ($edit_act == $pay['id'] and  isset($_SESSION['manager'])) {
                ?>
                <tr class="table_edit_row">
                    <td>
                        <div class="input_wrap">
                            <input type="text" id='datepicker' name='data' value='<?= convert_date($pay['data'], 1) ?>'>
                            <input type="hidden" name="id" value='<?= $pay['id'] ?>'>
                            <input type="hidden" name="order_id" value='<?= $pay['order_id'] ?>'>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <?if ($pay['type'] == 'in') { ?>Начисление<? }?> 
                            <?if ($pay['type'] == 'out') { ?>Списание<? }?> 
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="suma" value='<?= $pay['suma'] ?>'>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <?= $pay['balans'] ?>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="text" value='<?= $pay['text'] ?>'>

                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="nakladna" id="nakladna" value='<?= $pay['nakladna'] ?>'>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="decl" id="decl" value='<?= $pay['decl'] ?>'>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="platig" id="platig" value='<?= $pay['platig'] ?>'>
                        </div>
                    </td>
                    <td>
                        <div class="input_wrap">
                            <input type="text" name="perevod" id="perevod" value='<?= $pay['perevod'] ?>'>
                        </div>
                    </td>

                    <td><a class="edit_ico" href="/client/balance/<?= $pay['id'] ?>"></a></td>
                    <td>
                        <a href="/client/balance/<?= $pay['id'] ?>/del"><span class="t_del">х</span></a>

                        <script type="text/javascript"  >SelTypeBal();</script>
                    </td>
                </tr>

                <? } else { ?>
                <tr>
                    <td><?= str_replace('.', '.', convert_date($pay['data'], 1)) ?></td>
                    <td class="charge" <?if ($pay['type'] == 'out') { ?>style='color:#980000'<? }?>>
                        <?if ($pay['type'] == 'in') { ?>Начисление<? }?>
                        <?if ($pay['type'] == 'out') { ?>Списание<? }?>
                </td>
                <td class="numeric"><?= $pay['suma'] ?></td>
                <td><?= $pay['balans'] ?></td>
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
                <?if (isset($_SESSION['manager'])) { ?>
                <td><a class="edit_ico" href="/client/balance/<?= $pay['id'] ?>"></a></td>
                <td>
                    <a href="/client/balance/<?= $pay['id'] ?>/del" onclick="return confirm('Удалить?')"><span class="t_del">х</span></a>
                </td>
                <? }?>
            </tr>
            <? }
            }?>

        </tbody>
    </table>

</form>