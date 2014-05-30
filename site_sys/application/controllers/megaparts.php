<?php

// обновление статусов с мегапарста кроном 
class Megaparts extends Controller {
        
 	function Megaparts()
	{
	    
	 	parent::Controller();
	 	$this->load->model('data_model','data');
         $this->load->model('megaparts_model');
         
	}

	function index()
	{       
        error_reporting(1);
        $import_status=array(
                        'NotAvailable'=>'Нет в наличии',
                        'AGREE'=>'Превишение цены',
                        'Purchased'=>'Закуплено',
                        'ReadyToSend'=>'Готово к отправке',
                        'AGREE'=>'Превишение цены',
                        'Send'=>'Отправлено поставщиком',
                        'InWork'=>'В работе',
                        'recalc'=>'пересчет статусов нет вналичии и привышение'); 
                        
                         
         $current_import = $this->db->where('closed','0')->get('megaparts_import')->row_array();
         
         if(!$current_import){
          $this->db->set('data',Time())->insert('megaparts_import');
          $import_id =$this->db-> insert_id();
          echo $import_id;
          return;
         }
         
         foreach($import_status as $status=>$st_name){
            if($current_import[$status]>0) continue;// если статус был оновлен переходим к следуещему             
            echo "<h2>".$status."</h2>";  
            $url="http://emexonline.com:3000/MaximaWS/service.wsdl";
            $client = new SoapClient($url);         
            $zaproz =array( 'Customer'=>array(
            'Password' =>'476hrq',
            'UserName' =>'QPOL'),
            );
            
            switch ($status) {
            case 'InWork':
            
                $result = $client->MovementInWork($zaproz); 
                $data =$result->MovementInWorkResult->Movement;
                foreach($data as $pos ){
                    $val = explode('::',$pos->Reference);// проверяем позицию по нашей базеs
                    if(!isset($val[1])) continue;
                    if(!isset($val[2])) continue;
                    if($val[2]!='JP') continue;
                    if((int)$val[1]==0) continue;
                    $detail_id=(int)$val[1];
                    $detail = $this->db->where('type','2_mp')->where('id',$detail_id)->get('order_details')->row();
                    $this->db->set('status',$status);
                  //  if((int)$detail->count!=(int)$pos->Quantity){
//                        $this->db->set('add_status',$detail->add_status."({$st_name}-{$pos->Quantity})");
  //                  }else $this->db->set('add_status','');
                    $this->db->set('impotr_id',$current_import['id']);
                    $this->db->where('id',$detail_id);
                    $this->db->update('order_details');   
                    echo $this->db->last_query()."<br />";

                }
                $this->db->set($status,Time());
                $this->db->where('id',$current_import['id']);
                $this->db->update('megaparts_import'); 
                return;
                break;
                
            case "NotAvailable":
            
                $result = $client->MovementNotAvailable($zaproz); 
                $data =$result->MovementNotAvailableResult->Movement;
                foreach($data as $pos ){
                    $val = explode('::',$pos->Reference);// проверяем позицию по нашей базеs
                    if(!isset($val[1])) continue;
                    if((int)$val[1]==0) continue;
                    $detail_id=(int)$val[1];
                    $detail = $this->db->where('type','2_mp')->where('id',$detail_id)->get('order_details')->row();
                    $this->db->set('status',$status);
                  //  if((int)$detail->count!=(int)$pos->Quantity){
                        //$this->db->set('add_status',$detail->add_status."({$st_name}-{$pos->Quantity})");
                    //}else $this->db->set('add_status','');
                    $this->db->set('impotr_id',$current_import['id']);
                    $this->db->set('not_av_cnt',$pos->Quantity);
                    $this->db->where('id',$detail_id);
                    $this->db->update('order_details');  
                    echo $this->db->last_query()."<br />";
                    // $this->_refresh_orderNotAvailable($detail_id);

                }
                $this->db->set($status,Time());
                $this->db->where('id',$current_import['id']);
                $this->db->update('megaparts_import'); 
                return;
                break;
            case 'Purchased':
            
                $result = $client->MovementPurchased($zaproz); 
                $data =$result->MovementPurchasedResult->Movement;
                foreach($data as $pos ){
                    $val = explode('::',$pos->Reference);// проверяем позицию по нашей базеs
                    if(!isset($val[1])) continue;
                    if((int)$val[1]==0) continue;
                    $detail_id=(int)$val[1];
                    $detail = $this->db->where('type','2_mp')->where('id',$detail_id)->get('order_details')->row();
                    $this->db->set('status',$status);
                   // if((int)$detail->count!=(int)$pos->Quantity){
                     //   $this->db->set('add_status',$detail->add_status."({$st_name}-{$pos->Quantity})");
                    //}else $this->db->set('add_status','');
                    $this->db->set('impotr_id',$current_import['id']);
                    $this->db->where('id',$detail_id);
                    $this->db->update('order_details');   
                    echo $this->db->last_query()."<br />";

                }
                $this->db->set($status,Time());
                $this->db->where('id',$current_import['id']);
                $this->db->update('megaparts_import'); 
                return;
                break;
                
            case 'ReadyToSend':
            
                $result = $client->MovementReadyToSend($zaproz); 
                $data =$result->MovementReadyToSendResult->Movement; 
                foreach($data as $pos ){
                    $val = explode('::',$pos->Reference);// проверяем позицию по нашей базеs
                    if(!isset($val[1])) continue;
                    if((int)$val[1]==0) continue;
                    $detail_id=(int)$val[1];
                    $detail = $this->db->where('type','2_mp')->where('id',$detail_id)->get('order_details')->row();
                    $this->db->set('status',$status);
                   // if((int)$detail->count!=(int)$pos->Quantity){
                     //   $this->db->set('add_status',$detail->add_status."({$st_name}-{$pos->Quantity})");
                    //}else $this->db->set('add_status','');
                    $this->db->set('impotr_id',$current_import['id']);
                    $this->db->where('id',$detail_id);
                    $this->db->update('order_details');   
                    echo $this->db->last_query()."<br />";

                }
                $this->db->set($status,Time());
                $this->db->where('id',$current_import['id']);
                $this->db->update('megaparts_import'); 
                return;
                break;
                
            case 'AGREE':
            
                $result = $client->MovementAGREE($zaproz); 
                $data =$result->MovementAGREEResult->Movement;
                foreach($data as $pos ){
                    $val = explode('::',$pos->Reference);// проверяем позицию по нашей базеs
                    if(!isset($val[1])) continue;
                    if((int)$val[1]==0) continue;
                    $detail_id=(int)$val[1];
                    $detail = $this->db->where('type','2_mp')->where('id',$detail_id)->get('order_details')->row();
                    $this->db->set('status',$status);
                    //if((int)$detail->count!=(int)$pos->Quantity){
                      //  $this->db->set('add_status',$detail->add_status."({$st_name}-{$pos->Quantity})");
                    //}else $this->db->set('add_status','');
                    $this->db->set('impotr_id',$current_import['id']);
                    $this->db->set('agree_cnt',$pos->Quantity);
                    $this->db->set('agree_cnt',$pos->Quantity);
                    $this->db->set('agree_price',$pos->PriceSale);
                    $this->db->where('id',$detail_id);
                    $this->db->update('order_details');   
                    echo $this->db->last_query()."<br />";
                    $this->_refresh_order($detail_id);
                }
                $this->db->set($status,Time());
                $this->db->where('id',$current_import['id']);
                $this->db->update('megaparts_import'); 
                return;
                break;                                
              
                
            case 'Send':// тут надо искать по ивойсах
                
                $result = $client->GetInvoicesList($zaproz);  
                $Invoicelist =$result-> GetInvoicesListResult->Invoicelist;  
                foreach($Invoicelist as $invoice){
                $invoice_save = $this->db->where('number',$invoice->InvoiceNumber)->get('imvoice_list')->row();
                if($invoice_save) continue;
                $this->db->set('number',$invoice->InvoiceNumber)->set('date',Time())->insert('imvoice_list');
                    $inv_num = $invoice->InvoiceNumber;
                    $zaproz =array( 'Customer'=>array(
                                'Password' =>'476hrq',
                                'UserName' =>'QPOL' 
                                ),"InvoiceNumber"=>$inv_num
                                );  
                    $result = $client->GetInvoiceDetails($zaproz);
                    $InvDetails =$result-> GetInvoiceDetailsResult->InvDetails; // список деталей ивойса       
                    foreach($InvDetails as $iDet){
                        $val = explode('::',$iDet->Reference);
                        if(!isset($val[1])) continue;
                        if((int)$val[1]==0) continue; 
                        $detail_id=(int)$val[1];
                        $detail = $this->db->where('type','2_mp')->where('id',$detail_id)->get('order_details')->row();
                        $this->db->set('status',$status);
                       // if((int)$detail->count!=(int)$pos->Quantity){
                         //   $this->db->set('add_status',$detail->add_status."({$st_name}-{$pos->Quantity})");
                        //}else $this->db->set('add_status','');
                        $this->db->set('impotr_id',$current_import['id']);
                        $this->db->set('invoice',$inv_num);
                        $this->db->where('id',$detail_id);
                        $this->db->update('order_details');   
                        echo $this->db->last_query()."<br />";

                    } 
     
            
             }
                $this->db->set($status,Time());
                $this->db->where('id',$current_import['id']);
                $this->db->update('megaparts_import');   
                return;
                break;    
              
              case 'recalc':
              
              $details = $this->db->where('impotr_id',$current_import['id'])->where('type','2_mp')->where('(agree_cnt>0 or not_av_cnt>0)')->get('order_details')->result();
             
              foreach($details as $detail){
                  if($detail->is_recalc<1)// еще не было пересчета re_calc_cnt - сколько заказал пользователь
                  {
                     $this->db->where('id',$detail->id)->set('is_recalc',1)->set('mp_start_cnt',$detail->count)->update('order_details');
                     $detail->re_calc_cnt = $detail->count;
                  } 
                  // варианты 
                  // 1) все запчати нет вналичии
                  if($detail->not_av_cnt>0 and $detail->not_av_cnt==$detail->re_calc_cnt){
                    if($detail->price>0){
                        $this->db->where('id',$detail->id)->set('price',0)->update('order_details');  
                        $this->order_model->refresh_order($detail->order_id);
                    }    
                  }
                  
                  // 2) все AGREE
                  if($detail->agree_cnt>0 and $detail->agree_cnt==$detail->re_calc_cnt){
                    if($detail->price>0){
                        $this->db->where('id',$detail->id)->set('price',0)->update('order_details');  
                        $this->order_model->refresh_order($detail->order_id);
                    }    
                  }                  
                  // 3) часть AGREE или нет вналичии
                  if($detail->agree_cnt!=$detail->re_calc_cnt and  $detail->not_av_cnt!=$detail->re_calc_cnt){
                      $good_cnt=$detail->re_calc_cnt - $detail->agree_cnt-$detail->not_av_cnt;
                    if($good_cnt!=$detail->count){
                        $this->db->where('id',$detail->id)->set('count',$good_cnt)->update('order_details');  
                        $this->order_model->refresh_order($detail->order_id);
                    }    
                  }                  
                  
              echo $this->db->last_query()."<br />";
              }
             
              $this->order_model->new_status_mp();// меняем статус с нового на "в работе" если запчасти в работе
              $this->db->set('closed','1')->where('id',$current_import['id'])->update('megaparts_import');
              return;
              break;                                               
             }
           
         
         }
         
         
     
	}
   
 }

?>
