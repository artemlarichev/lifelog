<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    // функции управления заказми

    class Order_model extends Model
    { 
        function Order_model()
        {
            parent::Model(); 
            $this->load->model('megaparts_model','megaparts');
        }

        // оповещение пользователя о изменении в заказе

        function send_order_change($order_id)
        { 
            $this->db->where('id',$order_id); 
            $query = $this -> db -> get ( 'orders' );
            $order =  $query -> row();  
            if(!$order) return false; //получаем заказ 
            $this->db->where('order_id',$order_id);  
            $query = $this -> db -> get ( 'order_details' );
            $order_details =  $query -> result(); 
            if(!$order_details) return false; 
            $is_ch=false; 
            $this->db->where('id',$order->user);  
            $query = $this -> db -> get ( 'users' );
            $user =  $query -> row();          
            if(!$user) return false; // получаем пользователя
            if($user->send_mail<1) return false; // получаем пользователя

            foreach($order_details as $detail){
                if(($detail->count!=$detail->start_count or   $detail->price!=$detail->start_price) and $detail->sended_new_price<1   )    {
                    $is_ch=true;
                    $this->db->set('sended_new_price',1); 
                    $this->db->where('id',$detail->id);  
                    $this -> db -> update ( 'order_details' );
                }

            }

            if($is_ch) {// шлем сообщенио о изменении

                $text="
                <h2>  В вашем заказе №".$order->id." произошли изменения.</h2>
                <div class='big_table_wrap'>
                <table  bordeer='1'>
                <thead>
                <tr>
                <th class='marking'>
                Артикул
                </th>
                <th class='maker'> Производитель </th>
                <th class='important'> Примечание </th>
                <th class='price'> ".$order->valuta." </th>
                <th class='col'> шт. </th>
                <th class='sum'> Сумма </th>

                </tr>
                </thead>

                <tbody>";

                foreach($order_details as $detail){

                    $text.="<tr>
                    <td>
                    ".$detail->article."</a>
                    </td>
                    <td>".$detail->manuf."</td>
                    <td>".$detail->car_desc."</td>
                    <td class='numeric'>";
                    if($detail->start_price!=$detail->price ){
                        $text.="<b> Измененно с ".$detail->start_price.' на '.$detail->price."</b>";   
                    }else $text.=$detail->price;
                    $text.="</td>";

                    $text.="<td class='f_buy'>";

                    if($detail->scount!=$detail->start_count ){
                        $text.="<b> Измененно с ".$detail->start_count.' на '.$detail->count."</b>";   
                    }else $text.=$detail->count;
                    $text.="</td>
                    <td class='numeric'> ";
                    $text.=$detail->count*round($detail->price);

                    $text.=" </td>

                    </tr>";
                }    




                $text.="</tbody>
                </table><br /><br />
                <h2>На сумму: ".$order->summ." ".$order->valuta."</h2>
                ";



                $title="Изменения в заказе №".$order->id." на сайте Джапан АВТО"; 
                send_mail_msg($title,$text,$user->email);  

            }


        }  

        // оповещение пользователя о выполении заказа
        function send_order_done($order_id)
        {

            $this->db->where('id',$order_id); 
            $query = $this -> db -> get ( 'orders' );
            $order =  $query -> row();  
            if(!$order) return false; //получаем заказ

            $this->db->where('order_id',$order_id);  
            $query = $this -> db -> get ( 'order_details' );
            $order_details =  $query -> result(); 
            if(!$order_details) return false; 


            $this->db->where('id',$order->user);  
            $query = $this -> db -> get ( 'users' );
            $user =  $query -> row();          
            if(!$user) return false; // получаем пользователя

            if($user->send_mail<1) return false; // получаем пользователя
            $text="
            <h2>  Ваш заказ №".$order->id." выполнен.</h2>
            <div class='big_table_wrap'>
            <table  bordeer='1'>
            <thead>
            <tr>
            <th class='marking'>
            Артикул
            </th>
            <th class='maker'> Производитель </th>
            <th class='important'> Примечание </th>
            <th class='price'> ".$order->valuta." </th>
            <th class='col'> шт. </th>
            <th class='sum'> Сумма </th>

            </tr>
            </thead>

            <tbody>";

            foreach($order_details as $detail){

                $text.="<tr>
                <td>
                ".$detail->article."</a>
                </td>
                <td>".$detail->manuf."</td>
                <td>".$detail->car_desc."</td>
                <td class='numeric'>";
                $text.=$detail->price;
                $text.="</td>";

                $text.="<td class='f_buy'>";

                $text.=$detail->count;
                $text.="</td>
                <td class='numeric'> ";
                $text.=$detail->count*round($detail->price);

                $text.=" </td>

                </tr>";

            }   

            $text.="</tbody>
            </table><br /><br />
            <h2>На сумму: ".$order->summ." ".$order->valuta."</h2>
            ";


            // print($text);exit();
            $title="Ваш заказ №".$order->id." выполнен (Джапан АВТО)"; 
            send_mail_msg($title,$text,$user->email);  




        }  

        // пересчет заказа
        function refresh_order($id)
        {
            $this->db->where('id',$id); 
            $query = $this -> db -> get ( 'orders' );
            $order =  $query -> row_array();  
            if(!$order) return false; //получаем заказ

            $this->db->where('order_id',$id);  
            $query = $this -> db -> get ( 'order_details' );
            $order_details =  $query -> result_array(); 
            if(!$order_details) return false; 
            $is_ch=false;

            $cnt=0;
            $sum=0;
            foreach($order_details as $part)
            {
                $cnt=$cnt+ $part['count'];
                $price=$part['price'];
                $sum=$sum+number_format($part['count']*$price,2,'.','');
            }
            if($order['valuta']=='грн')   $sum = round($sum);
            $SQL="UPDATE  `orders` set `count`='$cnt',`summ`='$sum' where  id='".(int)$id."'";

            $query = $this->db->query($SQL);
            $this->pay_model->change_pay_summ_by_order($id);

        }

        // сохранение корзыни в заказе
        function basket_to_order($order_data,$order_details,$mp_data=array()){ 
            $sklad= array();   
            $ukr= array();    
            $mp= array();    
            foreach($order_details as $detail){// делим детали в заказы потипу
                if($detail['type']=='0_sklad') $sklad[] =$detail;
                if($detail['type']=='1_ukr') $ukr[] =$detail;
                if($detail['type']=='2_mp') $mp[] =$detail;
            }



            if(sizeof($ukr)>0){
                $data = $order_data;
                $data['type']= '1_ukr';
                $this->db->insert('orders',$data);
                $order_id = $this->db->insert_id();
                foreach($ukr as $k=>$item){
                    $item['order_id'] = $order_id;
                    $this->db->insert('order_details',$item);
                    $ukr[$k]['id'] = $this->db->insert_id();
                }
                $this->refresh_order($order_id);   
                $this->pay_model->add_pay_order($order_id); 
                $this->save_ukr_add_price($order_id,$ukr);
            }     
            if(sizeof($sklad)>0){
                $data = $order_data;
                $data['type']= '0_sklad';
                $this->db->insert('orders',$data);
                $order_id = $this->db->insert_id();
                foreach($sklad as $item){
                    $item['order_id'] = $order_id;
                    $this->db->insert('order_details',$item);
                }
                $this->refresh_order($order_id);   
                $this->pay_model->add_pay_order($order_id);   
            } 


            if(sizeof($mp_data)>0){ 

                $data = $order_data;
                $data['type']= '2_mp';
                $this->db->insert('orders',$data);
                $order_id = $this->db->insert_id();  
                foreach($mp_data as $item){

                    $item['order_detail']['order_id'] = $order_id;
                    $item['order_detail']['mp_start_cnt'] = (int)$item['order_detail']['count'];


                    $this->db->insert('order_details',$item['order_detail']);
                    $this->megaparts->sent_to_basket($item,$this->db->insert_id()); 
                }
                $this->refresh_order($order_id);   
                $this->pay_model->add_pay_order($order_id);   
            }          

        }

        //работа с укр поставщиками 

        function save_ukr_add_price($id,$arr){
            if(!isset($_SESSION['user'])) return;
            foreach($arr as $data){
                $row = $this->db->query("select * from suppliers_products where id = '".$data['prod_id']."'")->row_array();
                if(!$row) continue;
                $this->db->set('Order',$id);
                $this->db->set('supplier',$data['supplier']);
                $this->db->set('Descript',$data['note']);
                $this->db->set('PartNo',$data['article']);
                $this->db->set('Firmname',$data['manuf']);
                $this->db->set('Vol',$data['count']);
                $this->db->set('Price',$row['price']); 
                $this->db->set('BarCode',$data['id']);
                $this->db->set('Way','курьерская служба');
                $this->db->set('Box',$_SESSION['user']['city']);
                $this->db->insert('supliers_orders');
            }
        }

        function cron_ukr_supliers(){
            $h = Date('H'); 
            if($h==16){
                $suppliers = $this->db->query("select * from suppliers where  send_price=1 and (price_time='{$h}' or price_time='0')")->result_array();
            }    else{

                $suppliers = $this->db->query("select * from suppliers where  send_price=1 and price_time='{$h}'")->result_array();
            }
            foreach($suppliers as $sup){
                $rows = $this->db->query("select * from  supliers_orders where supplier ='".$sup['id']."' and sended =0")->result_array();
                var_dump($rows);
                if($rows){
                    $file=  'Order; Descript; PartNo;Firmname  ; Vol;Price;BarCode;Way;Box;
                    ';
                    /*1. Order
                    2. Descript - название запчасти
                    3. PartNo - номер запчасти
                    4. Firmname - производитель
                    5. Vol - количество
                    6. Price - цена (в долларах?)
                    7. BarCode - штрихкод (откуда брать?)
                    8. Way 
                    9. Box
                    */
                    foreach($rows as $item){  

                        $file.=$item['Order'].";".$item['Descript'].";".$item['PartNo'].";".$item['Firmname'].";".$item['Vol'].";".$item['Price'].";".$item['BarCode'].";".$item['Way'].";".$item['Box'].";
                        ";
                        $this->db->query("update  supliers_orders set sended='1' where id ='".$item['id']."'");
                    }
                    $file = iconv("UTF-8","windows-1251",$file);
                    $this->db->set('text',$file);
                    $this->db->set('s_id',$item['supplier']);
                    $this->db->set('data',Date('d.m.Y H:i'));
                    $this->db->insert('supliers_sended_orders');
                    $mail_id = $this->db->insert_id();  
                    $topic = "Заказ № {$mail_id} от ".Date('d.m.Y H:i');
                    $name="order_{$mail_id}_".date('d.m.Y').".csv";




                    $EOL="\n";
                    $boundary = "--".md5(uniqid(time()));
                    $html ='';
                    $headers ="MIME-Version: 1.0;$EOL";
                    $headers .="Content-Type: multipart/mixed; boundary=\"$boundary\"$EOL";
                    $headers .="From: root@japan-auto.kiev.ua";


                    $multipart  = "--$boundary$EOL";   
                    $multipart .= "Content-Type: text/html; charset=utf-8$EOL";   
                    $multipart .= "Content-Transfer-Encoding: base64$EOL";   
                    $multipart .= $EOL; // раздел между заголовками и телом html-части 
                    $multipart .= chunk_split(base64_encode($name));   

                    $multipart .=  "$EOL--$boundary$EOL";   
                    $multipart .= "Content-Type:text/csv; charset=utf-8$EOL";
                    $multipart .= "Content-Transfer-Encoding: base64$EOL";
                    $multipart .= "Content-Disposition: attachment; filename=\"$name\"$EOL";
                    $multipart .= $EOL;
                    $multipart .= chunk_split(base64_encode($file));

                    $multipart .= "$EOL--$boundary--$EOL";


                    var_dump(mail($sup['price_mail'], $topic, $multipart, $headers));
                    mail('9991@bk.ru', $topic, $multipart, $headers);
                    echo    $sup['price_mail']. $topic. $multipart. $headers ;
                }
            }
        }

        //работа с заказами через мегапартс 

        function new_status_mp(){// меняем статус с нового на "в работе" если запчасти в работе

            $this->db->where('status',0); 
            $query = $this -> db -> get ( 'orders' );
            $orders =  $query -> result_array();  
            foreach($orders as $order){
                $this->db->where('order_id',$order['id']); 
                $this->db->where('status !=',0); 
                $query = $this -> db -> get ( 'order_details' );
                $details =  $query -> result_array();  
                if($details){// в закезе есть запчасти в не новом статусе
                    $this->db->where('id',$order['id']); 
                    $this->db->set('status',1); 
                    $this -> db -> update ( 'orders' );   
                } 
            } 
        }

        // письмо с заказом 
        function send_order_mail($email,$data,$from_mail,$nacenka=1)
        {
            $text="
            <div class='big_table_wrap'>
            <table  border='1'>
            <thead>
            <tr>
            <th class='marking'>
            Артикул
            </th>
            <th class='maker'> Производитель </th>
            <th class='important'> Примечание </th>
            <th class='price'> ".$_SESSION['basket_data']['val']." </th>
            <th class='col'> шт. </th>
            <th class='sum'> Сумма </th>

            </tr>
            </thead>

            <tbody>";

            $count=0;
            $group='';

            foreach($_SESSION['basket'] as $val){
                if($val['in_order']<1) continue;
                $count++;
                if($val['type']=='0_sklad'){
                    $cu_group=$val['group'];
                    if(!($val['group_1']=='')) {$cu_group.=' >> '.$val['group_1'];}
                    if(!($val['group_2']=='')) {$cu_group.=' >> '.$val['group_2'];}
                    if(!($group==$cu_group))
                    {
                        $group=$cu_group;
                        $text.="<tr>
                        <td class='table_hline_row' colspan='9'>
                        <b>".$group."</b>
                        </td>
                        </tr>";
                    }
                    $text.="<tr>
                    <td>
                    ".$val['article']."</a>
                    </td>
                    <td>".$val['manuf']."</td>
                    <td>".$val['car_desc']."</td>
                    <td class='numeric'>";
                    $text.=round($val['price_end']); 

                    $text.="</td>

                    <td class='f_buy'>".$val['bascet_count']."</td>
                    <td class='numeric'> ";
                    $text.=$val['bascet_count']*round($val['price_end']);

                    $text.=" </td>

                    </tr>";
                }elseif($val['type']=='1_ukr'){
                    $text.="<tr>
                    <td class='table_hline_row' colspan='9'>
                    <b>Под заказ</b>
                    </td>
                    </tr>";

                    $text.="<tr>
                    <td>
                    ".$val['product']."</a>
                    </td>
                    <td>".$val['producer']."</td> 
                    <td> </td>
                    <td class='numeric'> 
                    ".$val['price_end']."
                    </td>

                    <td class='f_buy'>".$val['bascet_count']."</td>
                    <td class='numeric'> ";
                    $text.=$val['bascet_count']*$val['price_end'];

                    $text.=" </td>

                    </tr>";

                }   elseif($val['type']=='2_mp'){
                    $text.="<tr>
                    <td class='table_hline_row' colspan='9'>
                    <b>дальний заказ</b>
                    </td>
                    </tr>";

                    $text.="<tr>
                    <td>
                    ".$val['DetailNum']."</a>
                    </td>
                    <td>".$val['MakeName']."</td> 
                    <td>Поставщик ".$val['PriceLogo']."</td>
                    <td class='numeric'> 
                    ".$val['price_end']."
                    </td>

                    <td class='f_buy'>".$val['bascet_count']."</td>
                    <td class='numeric'> ";
                    $text.=$val['bascet_count']*$val['price_end'];

                    $text.=" </td>

                    </tr>";

                }    


                $text.="<tr   <td colspan='9' class='table_check_row'>
                ";

                if($val['add1']>0) {$text.="Только этот артикул   "; }
                if($val['add2']>0) {$text.="Только этот производитель   "; }
                if($val['add3']>0) {$text.="Только это количество  ";   }
                if($val['add4']>0) {$text.="Возможно повышение стоимости  ";}
                if($val['add5']>0) {$text.=" Могу ждать месяц  ";}


                $text.="</td>";
            }

            $text.="</tbody>
            </table>";




            $text.="<div class='basket_info'>
            <dl class='basket_user_form'>
            <dt><label for='f_n'>Имя и фамилия:</label></dt>
            <dd>".$data['name']."</dd>
            <dt><label for='tel' >Телефон:</label></dt>
            <dd>".$data['tel']."</dd>
            <dt><label for='mail'>Почта:</label></dt>
            <dd>".$data['email']."</dd>
            <dt><label for='comments'>Комментарии и уточнения:</label></dt>
            <dd class='texta_wrap'>".$data['comment']."</dd>

            </dl>
            <div class='basket_total'>
            <div class='total'>
            Итого к оплате: <span id='suma2'>".$_SESSION['basket_data']['sum']."</span>
            ".$_SESSION['basket_data']['val']."

            </div>

            </div>
            </div>
            </div>




            "; 
            $title='Новий заказ на сайте Джапан АВТО';
            if(!isset($_SESSION['user'])) { $title.=' (незарегистрированный пользователь)';}
            send_mail_msg($title,$text,$email);
            return $text;
        }        
        // оповещение менеджера о запросе            
        function send_manager_help_mail()
        {




            $text.="<div class='basket_info'>
            <dl class='basket_user_form'>
            <dt><label for='f_n'>ФИО:</label></dt>
            <dd>".$_POST['full_name']."</dd>
            <dt><label for='tel' >Телефон:</label></dt>
            <dd>".$_POST['phone_num']."</dd>
            <dt><label for='mail'>Почта:</label></dt>
            <dd>".$_POST['email']."</dd>

            <dt><label for='mail'>Марка:</label></dt>
            <dd>".$_POST['sel_brand']."</dd>
            <dt><label for='mail'>Модель и модификация:</label></dt>
            <dd>".$_POST['car_model']."</dd>
            <dt><label for='mail'>Год:</label></dt>
            <dd>".$_POST['sel_year']."</dd>
            <dt><label for='mail'>Тип кузова:</label></dt>
            <dd>".$_POST['type_carcass']."</dd>
            <dt><label for='mail'>Топливо:</label></dt>
            <dd>".$_POST['sel_type_fuel']."</dd>
            <dt><label for='mail'>Объем:</label></dt>
            <dd>".$_POST['volume_motor']."</dd>
            <dt><label for='mail'>Коробка передач:</label></dt>
            <dd>".$_POST['sel_transmission']."</dd>
            <dt><label for='mail'>Номер кузова:</label></dt>
            <dd>".$_POST['num_carcass']."</dd>
            <dt><label for='mail'>VIN-код:</label></dt>
            <dd>".$_POST['vin_code']."</dd>

            <dt><label for='mail'>Текст запроса:</label></dt>
            <dd>".$_POST['text']."</dd>



            </dl>

            </div>
            </div>
            </div>




            "; 
            $title='Запрос менеджеру на сайте Джапан АВТО';

            send_mail_msg($title,$text,'japan-auto_bumer@ukr.net'); 
        }
        }


?>