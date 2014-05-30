<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Megaparts_model extends Model
{
     var $user= array('id'=>'0','MP_CODE'=>'872','MP_PASS'=>'GOSTь','MP_LOGIN'=>'GOST');
     
        var $mp_status=array(0=>'Новый',
                        'InWork'=>'В работе',
                        'NotAvailable'=>'Нет в наличии ',
                        'Purchased'=>'Закуплено',
                        'ReadyToSend'=>'Готово к отправке',
                        'Send'=>'Отправлено поставщиком',
                        'ReadyMy'=>'Готово к выдаче',
                        'SendMy'=>'Выдано',
                        'AGREE'=>'Превишение цены'); 
    function Megaparts_model()
    {
        
        parent::Model();
        $this->load->database();
        if(isset($_SESSION['user']['id'])) $this->user= $_SESSION['user'];
         
    }
    
    function ajax_find($key)
    {                                                
           
           if($this->user['MP_CODE']=='') return "error";
           $url="http://emexonline.com:3000/MaximaWS/service.wsdl";
           $client = new SoapClient($url);  
           $zaproz =array(
                            
                            'Customer'=>array(
                                'Password' =>$this->user['MP_PASS'],
                                'CustomerId'=>$this->user['MP_CODE'],
                                'UserName' =>$this->user['MP_LOGIN']),
                            'ShowSubsts' =>'true',    
                            'DetailNum'=>$key);
         $result = $client->SearchPart ($zaproz);
       
         
         if(empty($result->SearchPartResult->FindByNumber)) return "empty";  
         
          $find_data =  $result->SearchPartResult->FindByNumber; 
          error_reporting(0);
          //mp_searh` ( `id` , `user_id` , `Make` , `DetailNum` , `PriceLogo` , `PartNameRus` , `PartNameEng` , `MakeName` , `Price` , `dump` )
         foreach($find_data as $key=>$val){
           $data=array( 'user_id'=>$this->user['id'], 
                        'date'=>Date("Y-m-d"), 
                        'Make'=>"".$val->Make." ", 
                        'DetailNum'=>$val->DetailNum, 
                        'PriceLogo'=>$val->PriceLogo, 
                        'PartNameRus'=>$val->PartNameRus, 
                        'WeightGr'=>$val->WeightGr, 
                        'PartNameEng'=>$val->PartNameEng, 
                        'MakeName'=>$val->MakeName, 
                        'Price'=>str_replace(',','',$val->Price), 
                        'dump'=>serialize($val)); 
          if(!empty($data['DetailNum'])) {$this->db->insert('mp_searh',$data);
          $id= $this->db->insert_id();
          $find_data[$key]->PriceId =  $id;                                                 
          }else{
              unset($find_data[$key]);
          }
         }
         $tmp_arr =array();
         $tmp_arr2 =array();
         $mp_ok =array('EMIR','FAST','KORA','EUSA');
         foreach($find_data as $val){
             if(!in_array($val->PriceLogo,$mp_ok))continue;
             if($val->DetailNum==$key)$tmp_arr[]=$val; else $tmp_arr2[]=$val; 
         }
         $find_data = array_merge($tmp_arr,$tmp_arr2);
         if(sizeof($find_data)<1) $find_data=array();
       return  $find_data; 
          
    }
    
    
    function sent_to_basket($val,$order_id){
         
            $url="http://emexonline.com:3000/MaximaWS/service.wsdl";
           $client = new SoapClient($url); 
           
           
           if($val['add1']) $bitOnly =true; else $bitOnly ='';
           if($val['add2']) $OnlyThisBrand =true; else $OnlyThisBrand ='';
           if($val['add4']) $bitAgree =true; else $bitAgree ='';
           if($val['add5']) $bitWait =true; else $bitWait ='';
                   
                 $zaproz =array(
                                                      
                        'Customer'=>array(          
                                'Password' =>$this->user['MP_PASS'],
                                'CustomerId'=>$this->user['MP_CODE'],
                                'UserName' =>$this->user['MP_LOGIN']),
                        'ShowSubsts' =>'true',    
                        'Array'=> array('partstobasket'=>array(
                            'MakeLogo' =>$val['Make'],
                            'DetailNum'=>$val['DetailNum'], 
                            'CoeffMaxAgree'=>'',
                          'UploadedPrice'=>'',
                          'bitAgree'=>$bitAgree,
                          'OnlyThisBrand'=>$OnlyThisBrand,
                          'Confirm'=>'',
                          'Delete'=>'',
                          'BasketId'=>'',
 
                          'Destinationlogo'=>'',
                          'PriceLogo'=>$val['PriceLogo'],  
                         
                          'bitOnly'=>$bitOnly,
                          'bitquantity'=>'',
                          'DetailWeight'=>'',
                          'EmExWeight'=>'',
                          'bitWait'=>$bitWait,
                          'Reference'=>$this->user['card'].'::'.$order_id."::JP",
                          'CustomerSubId'=>'',
                          'TranspotPack'=>'',
                            'Quantity'=>  $val['bascet_count'] ))); 
                 $result = $client->InsertPartToBasket ($zaproz);
                 
    }
    
    function cron_status_mp(){
           $mp_status=array(0=>'Новый',
                        'InWork'=>'В работе',
                        'NotAvailable'=>'Нет в наличии ',
                        'Purchased'=>'Закуплено',
                        'ReadyToSend'=>'Готово к отправке',
                        'Send'=>'Отправлено',
                        'AGREE'=>'Превишение цены'); 
                        
             $mp_result =array();
             
            
            $url="http://emexonline.com:3000/MaximaWS/service.wsdl";
            $client = new SoapClient($url);         
                      $zaproz =array( 'Customer'=>array(
                            'Password' =>'476hrq',
                            'UserName' =>'QPOL'),
                            ); 
                               
            
            $selected_status =array('Send','InWork','NotAvailable','Purchased','ReadyToSend','AGREE'); 
            $selected_status2 =array('0','new','Send','InWork','NotAvailable','Purchased','ReadyToSend','AGREE'); 
            $details_id=array();
            $details = $this->db->where('type','2_mp')->where_in('status',$selected_status2)->select('id')->get('order_details')->result_array();
            foreach($details as $detail){
                   $details_id[]=$detail['id'];
                   $mp_result[$detail['id']]['detail'] = $detail;
                   $mp_result[$detail['id']]['mp_status'] = array('Send'=>0,'InWork'=>0,'NotAvailable'=>0,'Purchased'=>0,'ReadyToSend'=>0,'Send'=>0); 
                   $mp_result[$detail['id']]['status_cnt'] =0; 
                   $mp_result[$detail['id']]['curent_status'] =''; 
            }                         
            $zaproz =array( 'Customer'=>array(
                            'Password' =>'476hrq',
                            'UserName' =>'QPOL'),
                            );  
          //$result = $client->GetInvoicesList($zaproz);   // список всех инвойсов
         // var_dump($result);exit;  
          $data=array();    
            $Invoicelist =$result-> GetInvoicesListResult->Invoicelist;  
           // echo sizeof($Invoicelist); exit;
            $Invoicelist=array();              
            foreach($Invoicelist as $invoice){
                $inv_num = $invoice->InvoiceNumber;
                $zaproz =array( 'Customer'=>array(
                            'Password' =>'476hrq',
                            'UserName' =>'QPOL' 
                            ),"InvoiceNumber"=>$inv_num
                            );  
                $result = $client->GetInvoiceDetails($zaproz);
                //   var_dump($result);
                 
                $InvDetails =$result-> GetInvoiceDetailsResult->InvDetails; // список деталей ивойса       
                foreach($InvDetails as $iDet){
                         $val = explode('::',$iDet->Reference);
                         if(!isset($val[1])) continue;
                         if((int)$val[1]==0) continue;
                         $id=(int)$val[1];   

                     //  $id = (int)$pos->Reference; // eto menat
                       
                       if(isset($mp_result[$id])){
                           $mp_result[$id]['status_cnt']++;    
                           $mp_result[$id]['invoice'] = $inv_num;    
                           $mp_result[$id]['mp_status']['Send']+=$iDet->Quantity;
                           $mp_result[$id]['curent_status']='Send';
                       }       
                }
            
            
            }
                  
            
            
            $zaproz =array( 'Customer'=>array(
                            'Password' =>'476hrq',
                            'UserName' =>'QPOL'),
                            );
            $result = $client->MovementInWork($zaproz);$data=array(); 
            $data =$result-> MovementInWorkResult->Movement;
            //  var_dump($data);exit;  
            if(!is_array($data)) die("ошибка оновления!!!!");
      
            foreach($data as $pos){
                 $val = explode('::',$pos->Reference);
                 if(!isset($val[1])) continue;
                 if((int)$val[1]==0) continue;
                 $id=(int)$val[1];   

             //  $id = (int)$pos->Reference; // eto menat
               
               if(isset($mp_result[$id])){
                   $mp_result[$id]['status_cnt']++;
                   $mp_result[$id]['mp_status']['InWork']+=$pos->Quantity;
                   $mp_result[$id]['curent_status']='InWork';
               }
            }  
           $result = $client->MovementAGREE ($zaproz);
           
           
           
              $data=array(); 
           $data =$result-> MovementAGREEResult->Movement;
           foreach($data as $pos){
                    $val = explode('::',$pos->Reference);
                 if(!isset($val[1])) continue;
                 if((int)$val[1]==0) continue;
                 $id=(int)$val[1];   
               
               if(isset($mp_result[$id])){
                   $mp_result[$id]['status_cnt']++;
                   $mp_result[$id]['mp_status']['AGREE']+=$pos->Quantity;
                   $mp_result[$id]['curent_status']='AGREE';
               }
            }
            
           // var_dump($data);exit;   
           $result = $client->MovementPurchased($zaproz);  $data=array();  
           $data =$result-> MovementPurchasedResult->Movement;
           foreach($data as $pos){
                  $val = explode('::',$pos->Reference);
                 if(!isset($val[1])) continue;
                 if((int)$val[1]==0) continue;
                 $id=(int)$val[1];   
               
               if(isset($mp_result[$id])){
                   $mp_result[$id]['status_cnt']++;
                   $mp_result[$id]['mp_status']['Purchased'] +=$pos->Quantity;
                   $mp_result[$id]['curent_status']='Purchased';
               }
            }
                     
           $result = $client->MovementNotAvailable($zaproz);   
          
           $data =$result-> MovementNotAvailableResult->Movement;
            foreach($data as $pos){
                 $val = explode('::',$pos->Reference);
                 if(!isset($val[1])) continue;
                 if((int)$val[1]==0) continue;
                 $id=(int)$val[1];  
          //     var_dump($pos);
               if(isset($mp_result[$id])){
                   $this->NullPrice($id);
                   $mp_result[$id]['status_cnt']++;
                   $mp_result[$id]['mp_status']['NotAvailable'] +=(int)$pos->Quantity;
                   $mp_result[$id]['curent_status']='NotAvailable';
               }
            }
            
          
           $result = $client->MovementReadyToSend($zaproz);  
          $data=array(); 
           $data =$result-> MovementReadyToSendResult->Movement;
        var_dump($data);  
       //    exit;
           foreach($data as $pos){
                $val = explode('::',$pos->Reference);
                 if(!isset($val[1])) continue;
                 if((int)$val[1]==0) continue;
                 $id=(int)$val[1];  
               
               if(isset($mp_result[$id])){
                   $mp_result[$id]['status_cnt']++;
                   $mp_result[$id]['mp_status']['ReadyToSend'] +=$pos->Quantity;
                   $mp_result[$id]['curent_status']='ReadyToSend';
               }
            }             
    echo"<pre>";
    var_dump($mp_result);
  echo"</pre>";
 //   echo"<h2>Оновление статусов</h2>";exit;   
     // Анализ полученых даных с мегапартса, и оновление статусов.
// echo"<pre>";
 //   var_dump($mp_result);
// echo"</pre>";
    echo"<h2>Оновление статусов</h2>";
 //   var_dump($mp_result);
     foreach($mp_result as $key =>$mp_detail){
         
  // if($mp_detail['status_cnt']<1) {// в результате от мегапартса нет даных значит отправлено 
 //         echo "запчасть № $key - в результате от мегапартса нет даных значит отправлено   <br /> <br />";
 //        $this->db->where('id',$key)->set('status','Send')->set('add_status','')->update('order_details'); 

 //    }else
     
     if($mp_detail['status_cnt']==1) {// в результате от мегапартса один статус - значи нет дополнителыних уточнений
        
        echo "запчасть № $key - в результате от мегапартса один статус {$mp_result[$key]['curent_status']}  <br /><br />";
        if($mp_result[$key]['curent_status']=='Send')   $this->db->set('invoice',$mp_result[$key]['invoice']);
        $this->db->where('id',$key)->set('status',$mp_result[$key]['curent_status'])->update('order_details'); 
    
     }else{// больше одного статуса, тяжелый случай
        
        //формируем дополнительные статусы
        $add_status ='';
        foreach( $selected_status as $status){
            
            if($mp_result[$key]['mp_status'][$status]>0){
                 $add_status .=$this->$mp_status[$status].': 
                 
                 '.$mp_result[$key]['mp_status'][$status].'<br>';
            } 
        }      
    echo "запчасть № $key - в результате от мегапартса больше одного статуса основной:{$mp_result[$key]['curent_status']} 
    <br />
    дополнительные: $add_status<br /><br />  <br />";    
        $this->db->where('id',$key)->set('status',$mp_result[$key]['curent_status'])->set('add_status',$add_status)->update('order_details');  
     }
  }
     
}  
    
    
    function NullPrice($id){
        return;
        
         $detail=$this->data->get_row($id,'order_details');      
         
         $this->db->where('id',$id)->set('price','0')->set('start_price     ','0')->update('order_details'); 
         
       $order_parts= $this->data->get_orders_detail($detail['order_id']);
        $order=$this->data->get_row($detail['order_id'],'orders');
        $cnt=0;
        $sum=0;
          foreach($order_parts as $part)
         {
             $cnt=$cnt+ $part['count'];
            $price=$part['price'];
            $sum=$sum+$part['count']*$price;
           }
        $SQL="UPDATE  `orders` set `count`='$cnt',`summ`='$sum' where  id='".(int)$detail['order_id']."'";
       $query = $this->db->query($SQL);         
        
        
        
       
       
     
        $pay=$this->data->get_row($detail['order_id'],'pay_in_out','order_id');
         if($order and $pay)
         {
           if($order['summ']!=$pay['suma'])
           {
               $rizn=$order['summ']-$pay['suma'];
              $SQL="UPDATE  `users` set `balans`=`balans`-$rizn where  id='".$order['user']."'";
              $query = $this->db->query($SQL);
              $SQL="UPDATE  `pay_in_out` set `suma`= `suma`+$rizn  where  order_id='".(int)$id."'";
              $query = $this->db->query($SQL);
           }

           }
    }



    function megeparts_get_orders(){
        exit;
                    $url="http://emexonline.com:3000/MaximaWS/service.wsdl";
            $client = new SoapClient($url);         
                      $zaproz =array( 'Customer'=>array(
                            'Password' =>'476hrq',
                            'UserName' =>'QPOL'),
                            );  
            $result = $client->MovementInWork($zaproz);$data=array(); 
            $data =$result-> MovementInWorkResult->Movement;                       
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
///$selected_status =array('Send','InWork','NotAvailable','Purchased','ReadyToSend','AGREE'); 
           // $selected_status2 =array('0','new','Send','InWork','NotAvailable','Purchased','ReadyToSend','AGREE'); 
           // $details_id=array();
           // $details = $this->db->where('type','2_mp')->where_in('status',$selected_status2)->select('id')->get('order_details')->result_array();
            
    }

}
?>
