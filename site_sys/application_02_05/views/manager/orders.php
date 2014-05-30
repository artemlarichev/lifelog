<!DOCTYPE HTML>
<html lang="ru-RU">
<?php  $this->load->view('page_elements/head');  ?>
<body class="main_page">
<div class="wrapper">

	<div class="base" id="wrapper">
	<?php  $this->load->view('manager/header');  ?>

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
    <div class="search_hold">
 
                    <ul class="search_tabs">
                        <li class="search_t_item  selected" data-search-tab="11" ><span class="search_t_i_text">Заказы</span></li>        
                        <li class="search_t_item "  ><a  href="/client/balance" class="search_t_i_text">Баланс</a></li>
                        <li class="search_t_item"  ><span class="search_t_i_text">История поиска</span></li>
                        <li class="search_t_item" ><span class="search_t_i_text">Учетные данные</span></li>
                        <li class="search_t_item"  ><span class="search_t_i_text">Работа с Эмиратами</span></li>
                        <li class="search_t_item"  ><span class="search_t_i_text">Настройки</span></li>
                    </ul>
                    
                    <ul class="search_wraps">
                        <!-- Orders -->
                        <li class="search_w_item  selected bg_white" data-search-wrap="11">
                                
                            <div class="main_row">
 
         <div class="search_block">
            <?if (isset($show_parts)) { ?>
            <ul class="search_category">
                <li><label for="order"><input type="radio" id="order" name="radio1"
                        onclick='location.replace("/manager/orders/<?=$status ?>/0")'    <?if ($show_parts == 0) { ?>checked<? }?>>
                    Заказы</label></li>
                <li><label for="spare"><input type="radio" id="spare" name="radio1"
                        onclick='location.replace("/manager/orders/<?=$status ?>/1")'
                    <?if ($show_parts == 1) { ?>checked<? }?>> Запчасти</label></li>
            </ul>
            <? }?>
            <ul class="manager_search_list">
                <li><a title="Импорт/экспорт" href="">Импорт/экспорт</a></li>
                <li><a title="Распечатать" href="">Распечатать</a></li>
            </ul>
            <div class="search_form">
                <ul class="order_category">
                    <li><a title="Новые" href="/manager/orders/0<?if ($is_parts == '1') {
                        echo"/1";
                    } ?>" <?if ($status == '0') {
                        print('class="mark"');
                    }?> >Новые</a></li>
                    <li><a title="В обработке" href="/manager/orders/1<?if ($is_parts == '1') {
                        echo"/1";
                    } ?>" <?if ($status == '1') {
                        print('class="mark"');
                    }?>>В обработке</a></li>
                    <li><a title="Выполненные" href="/manager/orders/2<?if ($is_parts == '1') {
                        echo"/1";
                    } ?>" <?if ($status == '2') {
                        print('class="mark"');
                    }?>>Выполненные</a></li>
                </ul>
                <?
                if($is_parts=='0') {$is_parts!='22';}
                if($is_parts!=''){ ?>
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
                        <?if($is_parts=='1'){?> <label for="n_order">№ запчасти</label>
                        <input class="o_s_f_text_f" type="text" name="p_order" id="p_order" value="<?if(isset($_POST['p_order'])) print($_POST['p_order']);?>"><?}else{?>
                        <label for="n_order">№ заказа</label>
                       <input class="o_s_f_text_f" type="text" name="n_order" id="n_order" value="<?if(isset($_POST['n_order'])) print($_POST['n_order']);?>"> <?}?>

                    </li>
                    <li class="o_s_f_item">
                        <label for="n_card">№ карты</label>
                        <input class="o_s_f_text_f" type="text" name="n_card" id="n_card" value="<?if(isset($_POST['n_card'])) print($_POST['n_card']);?>">
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
 
 
 
<?if($status=='0'){?>
 <a href="/manager/sup_export">Експорт списка запчастей украинских поставщиков</a>
  
<?}?>

<?if($status==2){?>   
Отображены выполненные заказы за неделю <a href='/manager/orders/3/<?=$show_parts?>'>Показать все</a>
  
<?}?>
<div class=" ">
  <div class="search_block">
  <div class="search_form" style="margin-bottom: 10px;">
                <ul class="order_category">
                    <li><a title="Новые" href="/manager/orders/<?=$status?>/<?=$is_parts?>/<?=$type?>/0_sklad"
                     <?if ($type_order == '0_sklad') {
                        print('class="mark"');
                    }?> >Наличие</a></li>
                    <li><a title="В обработке" href="/manager/orders/<?=$status?>/<?=$is_parts?>/<?=$type?>/1_ukr" <?if ($type_order == '1_ukr') {
                        print('class="mark"');
                    }?>>Украина</a></li>
                    <li><a title="Выполненные" href="/manager/orders/<?=$status?>/<?=$is_parts?>/<?=$type?>/2_mp" <?if ($type_order == '2_mp') {
                        print('class="mark"');
                    }?>>Эмираты</a></li>
                </ul>
</div>                
</div>  

                <div class="main_table_wrap">
                    <div class="big_table_wrap">
                    <?if(sizeof($orders)>0){?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <a title="№ заказа" href="">№ заказа</a>
                                    </th>
                                    <th>
                                         <a title="Поставщик" href="">Поставщик</a>
                                    </th>
                                    <th><a title="№ накладной" href="">№ накладной</a></th>
                                    <th><a title="№ накладной" href="">№ декларации</a></th>


                                    <th><a title="Дата" href="">Дата</a></th>
                                    <th><a title="Время" href="">Время</a></th>
                                    <th><a title="№ карты" href="">№ карты</a></th>
                                    <th><a title="Название фирмы" href=""> Название фирмы</a></th>
                                    <th><a title="ФИО" href="">ФИО</a></th>
                                     <th class="sum"><a title="Сумма" href="">Сумма</a></th>  </tr>
                            </thead>

                            <tbody>
                            <?foreach($orders as $order){?>
                                <tr >
                                    <td>
                                    <a   href="/manager/order/<?=$order['id']?>"><?=$order['id']?></a>
                                    <!--<img src='/i/down.png' onclick='ShowTabOrder(<?=$order['id']?>)' style='cursor:pointer'  id='show_im_<?=$order['id']?>'>   -->
                                    </td>
                                    <td>
                                    <?if($order['type']=='0_sklad') echo 'наличие';?>
                                    <?if($order['type']=='1_ukr') echo 'Украина';?>
                                    <?if($order['type']=='2_mp') echo '"Эмираты"';?>
                                    </td>
                                    <td>
                                    <span id='n_t_<?=$order['id']?>'><?=$order['nakladna']?></span>
                                    <DIV style="display: none;" id='n_f_<?=$order['id']?>'>
                                    <input id='nakl_edit_<?=$order['id']?>' value='<?=$order['nakladna']?>'>
                                   
                                    <button onclick='SaveNakl(<?=$order['id']?>);return false'>>></button>
                                    </DIV>
                                     
                                    <a title="" href="#" class="edit_ico" onclick='EditNakl(<?=$order['id']?>);return false'></a>
                                     
                                    </td>

                                    <td>
                                    
                                    <span id='d_t_<?=$order['id']?>'><?=$order['dekl']?></span>
                                    <DIV style="display: none;" id='d_f_<?=$order['id']?>'>
                                    <input id='decl_edit_<?=$order['id']?>' value='<?=$order['dekl']?>'>
                                  
                                    <button onclick='SaveDecl(<?=$order['id']?>);return false'>>></button>
                                    </DIV>
                                     
                                    <a title="" href="#" class="edit_ico" onclick='EditDekl(<?=$order['id']?>);return false'></a>
                                    
                                    </td>


                                    <td><?=russian_date($order['data'])?></td>
                                    <td><?=$order['time']?></td>
                                    <td><?=$order['card']?></td>
                                    <td><?=$order['name']?></td>
                                    <td><?=$order['fullname']?></td>
                                    <td class="numeric"><?=$order['summ']?></td>

                                </tr>

                                <?if(isset($orders_details[$order['id']])){?>
                                <tr  >
                                <td colspan='10' style='padding:2px; Display:none' id='order_tab_<?=$order['id']?>'>
                                 <?$this->load->view('manager/_sub_order',array('order'=>$order,'orders_details'=>$orders_details) );?>

                                </tr>
                                <?}
                            }?>

                            </tbody>
                        </table>
                    <?}?>
                    </div>
                </div>
            </div>
                            </div>
                            
                        </li><!-- End Orders -->
                         
                    </ul>
                </div>






 					</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>