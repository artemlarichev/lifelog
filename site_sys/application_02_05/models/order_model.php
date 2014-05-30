<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_model extends Model
{ 
    function Order_model()
    {
        parent::Model();
        $this->load->database();
        $this->load->model('megaparts_model','megaparts');
    }

  
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
   //
        function save_ukr_add_price($id,$arr){
            if(!isset($_SESSION['user'])) return;
           // var_dump($data);die;
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
       // $h =16;
            if($h==16){
                 $suppliers = $this->db->query("select * from suppliers where  send_price=1 and (price_time='{$h}' or price_time='0')")->result_array();
            }    else{
                
              $suppliers = $this->db->query("select * from suppliers where  send_price=1 and price_time='{$h}'")->result_array();
            }
           // echo $h;
           // var_dump($suppliers);
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
}
?>