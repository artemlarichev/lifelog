<?php
    class Manager extends Controller {

        var  $conf=array();
        var $mp_status=array(0=>'Новый',
            'InWork'=>'В работе',
            'NotAvailable'=>'Нет в наличии ',
            'Purchased'=>'Закуплено',
            'ReadyToSend'=>'Готово к отправке',
            'Send'=>'Отправлено поставщиком',
            'ReadyMy'=>'Готово к выдаче',
            'SendMy'=>'Выдано',
            'AGREE'=>'Превишение цены');     
        var  $group=array();
        var  $user_names=array();
        function Manager()
        {
            session_start();
            parent::Controller();
            $this->load->model('data_model','data');
            $this->load->helper('my_func');
            header('Content-Type: text/html; charset=UTF-8');
            if(!isset($_SESSION['manager'])){header("location:/");exit;}
            //$_SESSION['user']=$this->data->get_row(7,'users');
            if(isset($_SESSION['user']['id'])) {$_SESSION['user'] =$this->data->get_row($_SESSION['user']['id'] ,'users');}
            $this->conf['page']='cab';
            $this->user_names= $this->data->get_user_names();
            $this->group=$this->data->get_groups();

            $SQL='SELECT * from  product where article<>"" ORDER BY RAND() limit 1';
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            $this->conf['key'] =  $res[0]['article'];

            $SQL="SELECT * from site_config  ";
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            foreach($res as $val)
            {
                $this->conf[$val['name']] = $val['text'];
            }
            $this->conf['margins'] = unserialize($this->conf['margins'])  ;
            $this->conf['nacenka'] =  1+$this->conf['nacenka'] /100;
            $this->conf['nacenka']=1;
            if(isset($_SESSION['user'])) {$this->conf['nacenka'] =  1-(int)$_SESSION['user']['discont']/100; };
            if(isset($_SESSION['user']['disc_type_sup']))
            {
                if(isset($this->conf['margins'][$_SESSION['user']['disc_type_sup']]))
                    {  $this->conf['discont'] =$this->conf['margins'][$_SESSION['user']['disc_type_sup']] ;}else$this->conf['discont'] = $this->conf['margins']['rozn'];

            }else $this->conf['discont'] = $this->conf['margins']['rozn']; 

            if(isset($_SESSION['basket_data']['val'])){
                if($_SESSION['basket_data']['val']!='грн') $conf['kurs']=1;
            }  

        }
        function index()
        {
            $this->orders();
        }
        function conf()
        {

        }

        function orders($status=0,$parts='0',$type='all',$type_order='all')
        {  $find=0; 
            if(isset($_POST['nakl_id']))
            {

                $SQL="update orders set nakladna='".$_POST['nakl']."' where  id='".(int)$_POST['nakl_id']."'";
                $query = $this->db->query($SQL);
                $SQL="update pay_in_out set nakladna='".$_POST['nakl']."' where  order_id='".(int)$_POST['nakl_id']."' and order_id>0";
                $query = $this->db->query($SQL);

            };

            if(isset($_POST['dekl_id']))
            {

                $SQL="update orders set dekl='".$_POST['dekl']."' where  id='".(int)$_POST['dekl_id']."'";
                $query = $this->db->query($SQL);
                $SQL="update pay_in_out set decl='".$_POST['dekl']."' where  order_id='".(int)$_POST['dekl_id']."' and order_id>0 ";
                $query = $this->db->query($SQL);



            };


            if(isset($_POST['n_card'])){$find=1; };
            if(isset($_POST['n_nacl'])){$find=1; };
            $data['action']='orders';
            $data['find']=$parts;
            $data['manager']='1';
            $data['show_parts']=$parts;
            $data['type']=$type;
            $data['type_order']=$type_order;
            $data['status']=$status;
            $data['is_parts']=$parts;
            $data['user']= $_SESSION['user'];
            $data['orders']= $this->data->get_orders($status,'','',$find,$type_order);

            //  $data['orders_details']= $this->data->get_orders_all_details_tab($data['orders']);


            if($parts>0)
            {
                $data['order_parts']= $this->data->get_all_orders_detail($status,'0',$find,$type,$type_order);
                $this->load->view('manager/all_orders',$data);
            }
            else {
                $this->load->view('manager/orders',$data);}
        }
        function sup_export()
        { $data=array();
            $SQL ="SELECT suppliers.name as s_name,
            order_details.*,
            users.name,
            users.fullname,
            users.card    

            FROM `order_details`
            LEFT JOIN orders ON orders.id = order_details.order_id
            LEFT JOIN users ON users.id = orders.user
            LEFT JOIN suppliers ON order_details.supplier = suppliers.id
            WHERE `supplier` >0
            AND orders.status = '0'
            order by order_details.supplier,order_details.article
            ";
            $query = $this->db->query($SQL);
            $data['order_parts'] =$query->result_array();
            //var_dump( $data['order_parts']);
            $this->load->view('manager/sup_export',$data);
        }   

        function sup_export_csv()
        { 
            $SQL ="SELECT suppliers.name as s_name,
            order_details.*,
            users.name,
            users.fullname,
            users.card    

            FROM `order_details`
            LEFT JOIN orders ON orders.id = order_details.order_id
            LEFT JOIN users ON users.id = orders.user
            LEFT JOIN suppliers ON order_details.supplier = suppliers.id
            WHERE `supplier` >0
            AND orders.status = '0'
            order by order_details.supplier,order_details.article";
            $query = $this->db->query($SQL);
            $data = $query->result_array();

            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-disposition: attachment; filename=parts.csv');
            // mysql_query('SET NAMES cp1251');

            $csv='Артикул; Производитель; Описание;шт.;Заказ;Пользователь; ';
            $sup='';
            foreach($data  as $val)
            {      
                if(!($sup==$val['s_name']))
                {
                    $sup=$val['s_name'];
                    $csv.=";
                    ".$sup ;
                }
                $csv.=";
                ";

                $csv.=trim($val['article']).";".
                trim($val['manuf']).";"
                .trim($val['note']).";"
                .trim($val['count']).";"
                .trim($val['order_id']).";"
                .trim($val['card'])." "
                .trim($val['name'])." "
                .trim($val['fullname']).";";


            }
            echo iconv('UTF-8','windows-1251', $csv);   
        } 


        function order($id)
        {

            if(isset($_POST['nakl_edit']))
            {

                $SQL="update orders set nakladna='".$_POST['nakl_edit']."' where  id='".(int)$_POST['nakl_id']."'";
                $query = $this->db->query($SQL);

                $SQL="update pay_in_out set nakladna='".$_POST['nakl_edit']."' where  order_id='".(int)$_POST['nakl_id']."' and order_id>0";
                $query = $this->db->query($SQL);
                unset($_POST['nakl_edit']);

            };

            if(isset($_POST['dekl_edit']))
            {

                $SQL="update orders set dekl='".$_POST['dekl_edit']."' where  id='".(int)$_POST['dekl_id']."'";
                $query = $this->db->query($SQL);
                $SQL="update pay_in_out set decl='".$_POST['dekl_edit']."' where  order_id='".(int)$_POST['dekl_id']."' and order_id>0";
                $query = $this->db->query($SQL);

                unset($_POST['dekl_edit']);

            };

            $data['action']='orders';
            $data['order']= $this->data->get_row((int)$id,'orders');
            $data['order_parts']= $this->data->get_orders_detail((int)$id);

            $data['status']=$data['order']['status'];
            $data['user']= $_SESSION['user'];
            $this->load->view('manager/order',$data);
        }

        function del_order($id,$status=0)
        {
            if($order= $this->data->get_row((int)$id,'orders'))
            {
                $this->db->query("update  orders set `show`=0 where id='".$order['id']."' ");
            }

            header("location:/manager/orders/".$status);
        }

        function del($tab,$id)
        {

            if($tab=='order_details')
            {
                $part=$this->data->get_row($id,'order_details');
                $SQL="DELETE from  order_details where id='".(int)$id."'";
                $query = $this->db->query($SQL);
                $this->_refresh_order($part['order_id']);
                header("location:/manager/order/".$part['order_id']);
            } elseif($tab=='orders')
            {   $order=$this->data->get_row($id,'orders');
                $SQL="DELETE from  order_details where order_id='".(int)$id."'";
                $query = $this->db->query($SQL);

                if($order['status']<1) {$this->_refresh_order($part['order_id']);}

                $SQL="DELETE from  orders where id='".(int)$id."'";
                $query = $this->db->query($SQL);


                header("location:/manager/orders/".$order['status']);
            } else
            {
                $SQL="DELETE from  $tab where id='".(int)$id."'";
                $query = $this->db->query($SQL);
                header("location:/manager");
            }
        }
        function edit_order($act,$id,$val)
        {
            if($act=='status')
            {
                $order=$this->data->get_row($id,'orders');
                $SQL="UPDATE   orders set status='".(int)$val."'where id='".(int)$id."'";
                 $query = $this->db->query($SQL);

                if((int)$val==1){
                    $SQL="UPDATE   order_details set status='InWork' where order_id='".(int)$id."' and type='0_sklad'";
                    // print($SQL); 
                    $query = $this->db->query($SQL);
                }  elseif((int)$val==2){  
                    $this->order_model->send_order_done($id);
                    $SQL="UPDATE   order_details set status='SendMy' where order_id='".(int)$id."' and type='0_sklad'"; 
                     $query = $this->db->query($SQL);
                   //  print($SQL); 
                }

                header("location:/manager/orders/".$val);
            } else
            {

                header("location:/manager");
            }
        }

        function _refresh_order($id)
        {
            $order_parts= $this->data->get_orders_detail($id);
            $order=$this->data->get_row($id,'orders');
            $cnt=0;
            $sum=0;
            foreach($order_parts as $part)
            {
                $cnt=$cnt+ $part['count'];
                $price=$part['price'];
                $sum=$sum+round($part['count']*$price);
            }
            $SQL="UPDATE  `orders` set `count`='$cnt',`summ`='$sum' where  id='".(int)$id."'";
            $query = $this->db->query($SQL);
            $this->pay_model->change_pay_summ_by_order($id);
            // $this->_refresh_order_pay($id);

        }


        /*   function _refresh_payout_order($id,$sum)
        {
        $order=$this->data->get_row($id,'orders');
        if($sum==$order['summ']) {return false;};
        $delta=$sum-$order['summ'];
        $user=$this->data->get_row($order['user'],'users');
        $balance= $user['balans']-$delta;
        $SQL="UPDATE  `users` set `balans`='$balance'  where  id='".(int)$order['user']."'";
        $query = $this->db->query($SQL);
        $SQL="UPDATE  `payout` set `value`='$sum'  where  id='".(int)$id."'";
        $query = $this->db->query($SQL);

        }  */

        function ajax_save_details($id)
        {
            if(isset($_POST['data']))
            {
                $data_json=$_POST['data'];
                if($data_arr=json_decode($data_json,true))
                {
                    $old_data=array();
                    foreach($data_arr as $val)
                    {
                        $old_data[$val['id']] = $this->data->get_row($val['id'],'order_details');
                        $val['sended_new_price']=0;
                        $this->data->save($val,'order_details');
                    }
                };
            }
            $this->_refresh_order((int)$id);
            $order=$this->data->get_row($id,'orders');
            $user=$this->data->get_row($order['user'],'users');
            if($user['balans']+$user['credit']<0)
            {
                print('0');
                foreach($old_data as $val)
                {
                    $this->data->save($val,'order_details');
                }
                $this->_refresh_order((int)$id);
                $order=$this->data->get_row($id,'orders');
                return false;
            }
            print($order['summ']);

            $this->order_model->send_order_change($id);
        }


        function client($id='')
        {
            if($user= $this->data->get_row($id,'users'))
            {
                $_SESSION['user']=$user;
                header("location:/client");
            }else
            {
                header("location:/manager/clients");
            }


        }

        function to_user($id='')
        {
            if($user= $this->data->get_row((int)$id,'users','card'))
            {
                $_SESSION['user']=$user;
                unset($_SESSION['basket']);
                header("location:/client");
            }else
            {
                header("location:/manager/clients");
            }


        }

        function clients($order='card',$order_='',$act='',$id='')
        {
            if($order_=='-'){$order_='';}
            $data['action']='clients';
            $data['user']= $_SESSION['user'];
            $data['order']=$order;
            $data['order_']=$order_;
            if($act=='del') { $this->data->del($id,'users');};
            $data['users']= $this->data->get_user_table('user',$order,$order_);;

            $this->load->view('manager/clients',$data);
        }

        function managers($order='card',$order_='',$act='',$id='')
        {
            if($order_=='-'){$order_='';}
            $data['action']='managers';
            $data['order']=$order;
            $data['order_']=$order_;
            $data['user']= $_SESSION['user'];
            if($act=='del') { $this->data->del($id,'users');};
            $data['users']= $this->data->get_user_table('manager',$order,$order_);
            $this->load->view('manager/managers',$data);
        }


        function fields()
        {
            $fields=$this->config->item('fields');
            $fields_keys=array_keys($fields);

            if(isset($_POST['save']))
            {
                $field_str='';
                foreach($fields_keys as $field)
                {
                    if(isset($_POST[$field])){$field_str.=','.$field;};
                }
                if(strlen($field_str)>0)
                {
                    $field_str=substr($field_str,1,strlen($field_str)-1);
                    $_SESSION['manager'] =$field_str;
                }
                $SQL="update users set fields='$field_str' where id='".$_SESSION['user']['id']."' ";
                $query = $this->db->query($SQL);
            }

            if(isset($field_str)) {$_SESSION['user']['fields']=$field_str;};
            $data['fields']=$fields;
            $data['action']='fields';
            $fields=explode(',', $_SESSION['user']['fields']);
            $data['user_fields']= array();
            foreach($fields as $field)
            {
                if(!($field=='')){$data['user_fields'][$field]= $field;};
            };
            $this->load->view('manager/fields',$data);
        }


        function user_fields($id)
        {   if($user=$this->data->get_row((int)$id,'users'))
            {
                $fields=$this->config->item('fields');
                $fields_keys=array_keys($fields);

                if(isset($_POST['save']))
                {
                    $field_str='';
                    foreach($fields_keys as $field)
                    {
                        if(isset($_POST[$field])){$field_str.=','.$field;};
                    }
                    if(strlen($field_str)>1) {$field_str=substr($field_str,1,strlen($field_str)-1);};
                    $SQL="update users set fields='$field_str' where id='".(int)$id."' ";
                    $query = $this->db->query($SQL);
                    $user['fields']=$field_str;
                    if(isset($_POST['full_art']))
                    {
                        $SQL="update users set 	full_art='1' where id='".(int)$id."' ";
                        $user['full_art']=1;
                    }
                    else
                    {$SQL="update users set 	full_art='0' where id='".(int)$id."' ";
                        $user['full_art']=0;
                    }
                    $query = $this->db->query($SQL);
                    //  header("location:/manager/clients");
                    //  return;

                }
                if($user['full_art']>0) {$data['full_art']=1;}
                $data['fields']=$fields;
                $data['action']='fields';
                $fields=explode(',', $user['fields']);
                $data['user_fields']= array();
                foreach($fields as $field)
                {
                    if(!($field=='')){$data['user_fields'][$field]= $field;};
                };
                $this->load->view('manager/user_fields',$data);
            }
            else
            {
                header("location:/manager/clients");
            }
        }

        function new_client($type='user')
        {

            $data['new']='clients';
            $data['user']= $_SESSION['user'];
            $data['users']= $this->data->get_user_table($type);
            if($type=='user'){$type='clients';} else {$type='managers';}
            $data['action']=$type;
            $this->load->view('manager/'.$type,$data);
        }

        function ajax_save_users()
        {
            $id='';
            if(isset($_POST['data']))
            {
                $data_json=$_POST['data'];
                $res_arr=array();
                if($data_arr=json_decode($data_json,true))
                {
                    foreach($data_arr as $val)
                    {
                        if($val['pass']==''){unset($val['pass']);} else {$val['pass']=md5(md5($val['pass']));};
                        $id=$this->data->save($val,'users');
                        print_r($val);
                    }
                };
            }
        }

        function parts()
        {
            $data['action']='parts';
            $data['user']= $_SESSION['user'];
            $this->load->view('manager/parts',$data);
        }


        function edit_page($url)
        {
            $data['action']='conf';
            if(isset($_POST['id'])) { $this->data->save_POST('pages');header("location:/$url");return false;}
            $data['page']= $this->data->get_row($url,'pages','url');
            $this->load->view('manager/edit_page',$data);
        }
        function news($act='',$id=0)
        {
            $data['action']='conf';
            if(isset($_POST['id'])) { $this->data->save_POST('news');header("location:/");return false;}
            if($act=='del') {$this->data->del($id,'news'); header("location:/");return false;}
            if($act=='new') {$data['page']= $this->data->make_empty_data('news');}
            if($act=='edit') {$data['page']= $this->data->get_row($id,'news');}
            $this->load->view('manager/edit_page',$data);
        }

        function history($count=10)
        {
            $data['action']='history';
            if($count=='arh' )$count = 1000;
            $data['count']=$count;

            $SQL='SELECT *  FROM user_request   order by  time desc,id desc limit 0,'.(int)$count;
            if($count==10 ){
                $data['SHORT']=$count;   
                $SQL='SELECT *  FROM user_request where time like"'.Date('Y-m-d').'%"  order by  time desc,id desc ' ;
            }
            $data['search_type']='';



            $query = $this->db->query($SQL);
            $data['result']=$query->result_array();
            $this->load->view('manager/history',$data);
        }

        function price($act='')
        {  if($act=='export') {$this->_export_parts();return false;}
            $data['search_type']='';
            if($act=='import')
            {
                $rez= $this->_import_parts() ;
                if($rez=='0') {	$data['res']=1;} else {$data['err']= $rez ;};
            }
            $data['action']='price';
            $this->load->view('manager/price',$data);
        }


        function _export_parts()
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/csv');
            header('Content-disposition: attachment; filename=parts.csv');
            $fields = $this->db->list_fields('product');
            mysql_query('SET NAMES cp1251');
            $query = $this->db->get('product');
            $res=$query->result_array();
            $csv='';
            foreach($fields  as $val)
            {
                $csv.=$val.";";
            }
            foreach($res  as $val)
            {  	$csv.=";
                ";
                foreach($val  as $sub_val)
                {
                    $csv.=trim($sub_val).";";
                }
            }
            echo $csv;
        }


        function _import_parts()
        {  error_reporting(0);
            $msg='0';
            $config['upload_path'] = "./tmp/";
            $config['allowed_types'] = 'csv';
            $config['max_size']	= '10000000';
            $config['max_width']  = '10024';
            $config['max_height']  = '7680';
            $config['overwrite']  = true;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_parts'))
            {
                $data = array('upload_data' => $this->upload->data());
                $new_name = $config['upload_path']."parts_tmp_tmp".$data['upload_data']['file_ext'];
                if(file_exists($new_name)) {unlink($new_name);};
                rename ($config['upload_path'].$data['upload_data']['file_name'], $new_name);

                $page=file_get_contents($new_name);
                $data_1 = explode('
                    ',$page);
                foreach($data_1 as $arr)
                {
                    $var=explode(';',$arr);
                    if(sizeof($var)>2) {$main_data[]=$var;};
                }
                //  print_r($main_data);

            } else {$msg = $this->upload->display_errors() ;}
            //               	exit;
            if(sizeof($main_data)>2)
            {     mysql_query('SET NAMES cp1251');
                $fields = $this->db->list_fields('product');
                $csv_fields = $main_data[0];
                unset($main_data[0]);
                // print_r($main_data[1]);
                foreach($main_data as $val)
                {
                    $data=array();
                    $keys=array_keys($val);
                    //   $data['time_d']= trim($val[14]);
                    //  $data['like_part']= trim($val[16]);
                    foreach($keys as $key)
                    {
                        if(in_array($csv_fields[$key],$fields))  { $data[$csv_fields[$key]]= trim($val[$key]); }
                    }
                    if($data['id']=='')
                    {
                        $this->db->insert('product', $data);
                    }
                    else
                    {
                        $this->db->where('id', $data['id']);
                        $this->db->from('product');
                        $count= $this->db->count_all_results();
                        if($count>0)
                        {
                            $this->db->where('id', $data['id']);
                            $this->db->update('product', $data);
                        }
                        else
                        {
                            $this->db->insert('product', $data);
                        }
                    }
                }

            }
            $sql ="DELETE FROM  `product` WHERE `orig_nums`='-' and `cat_num`='-' and `note`='-'   ";
            $query =  $this->db->query($sql);
            mysql_query('update `product` set price_usd=round(price_usd)');
            mysql_query('update `product` set price_uah=round(price_uah)');
            return $msg;

        }


        function suppliers($type='ukraine')
        {
            if(isset($_POST['id'])) {
            $_POST['send_price'] =(int)$this->input->post('send_price');
             $this->data->save_POST('suppliers');};
            $data['action']='suppliers';
            $data['edit_act']='-';
            $data['type']=$type;
            $this->db->where('type', $type);
            $query = $this->db->get('suppliers');
            $data['suppliers']=$query->result_array();
            $this->load->view('manager/suppliers',$data);
        }

        function supplier_clear($id)
        { 
            $this->db->where('supplier', $id);
            $this->db->delete('suppliers_products'); 
            header("location:/manager/suppliers/ukraine");return false;
        }
        function supplier($id,$act='edit',$type='ukraine')
        {
            if($act=='del') {
                $supplier= $this->data->get_row($id,'suppliers');
                $this->data->del((int)$id,'suppliers');
                $this->db->where('supplier', (int)$id);
                $query = $this->db->delete('suppliers_products');
                header("location:/suppliers/".$supplier['type']);return false;
            };

            if($id==0)
            {
                $data['supplier']=$this->data->make_empty_data('suppliers');
                $data['supplier']['type']=$type;
            }
            elseif($data['supplier']= $this->data->get_row($id,'suppliers'))
            {
                $type= $data['supplier']['type'];

            }  else {header("location:/suppliers");return false;}

            $data['action']='suppliers';
            $data['edit_act']=$id;
            $data['type']=$type;
            $this->db->where('type', $type);
            $query = $this->db->get('suppliers');
            $data['suppliers']=$query->result_array();
            if($act=='edit_all')
            {
                $this->load->view('manager/supplier',$data);
            }
            else
            {
                $this->load->view('manager/suppliers',$data);
            }
        }
        function upload_price()
        {
            $config['upload_path'] = $_SERVER["DOCUMENT_ROOT"].'/tmp_prices/tmp/';
            $config['path'] = $_SERVER["DOCUMENT_ROOT"].'/tmp_prices/';;
            $id=(int)$_POST['supplier_id'];
            $config['allowed_types'] = 'xls';
            $this->load->library('upload', $config);
            $supplier= $this->data->get_row($id,'suppliers');
            $price_list = unserialize($supplier['price_list']);
            if(is_array($price_list)){$data1['price_list']=$price_list;}else {$data1['price_list']=array();}
            if ( ! $this->upload->do_upload('price'))
            {
                print (0) ; return false;
            }
            else
            {
                $new_name= $config['path'].$id.".xls";
                if(file_exists($new_name)) {unlink($new_name);};
                $data = array('upload_data' => $this->upload->data());
                rename ($config['upload_path'].$data['upload_data']['file_name'], $new_name);

                require_once 'Excel/reader.php';
                $data = new Spreadsheet_Excel_Reader();
                $data->setOutputEncoding('UTF-8');
                $data->read($new_name);

                if(!isset($data->sheets[0]['cells'][1] )) { print (0) ; return false;};
                $fields=$data->sheets[0]['cells'][1] ;
                $data1['fields']  = $fields;
                //  var_dump($fields);
                $this->load->view('manager/price_fields',$data1);

            }

        }

        function import_upload_price()
        {
            $id=(int)$_POST['supplier_id'];
            $field_1=(int)$_POST['field_1'];
            $field_2=(int)$_POST['field_2'];
            $field_3=(int)$_POST['field_3'];
            $field_4=(int)$_POST['field_4'];
            $field_5=(int)$_POST['field_5'];
            $price_list=array($field_1,$field_2,$field_3,$field_4,$field_5);
            $price_list_str=serialize($price_list);
            // print_r($price_list);
            $this->db->query("UPDATE suppliers set price_list='$price_list_str' where id='$id'");
            require_once 'Excel/reader.php';
            $data = new Spreadsheet_Excel_Reader();
            $data->setOutputEncoding('UTF-8');
            $data->read($_SERVER["DOCUMENT_ROOT"].'/tmp_prices/'.$id.".xls");
            if(!isset($data->sheets[0]['cells'][1] )) { print (0) ; return false;};
            unset($data->sheets[0]['cells'][1]);
            $sql='';
            $bad=array();
            $this->db->query("delete from suppliers_products where supplier ='{$id}'");

            foreach($data->sheets[0]['cells'] as $val)
            {

                if($field_1>0)
                    {if(isset($val[$field_1])) {$field_1_data=mysql_escape_string($val[$field_1]);}else{$field_1_data='';} }
                else
                    {$field_1_data='';}

                if($field_2>0)
                    {if(isset($val[$field_2])) {$field_2_data=mysql_escape_string($val[$field_2]);}else{$field_2_data='';} }
                else
                    {$field_2_data='';}

                if($field_3>0)
                    {if(isset($val[$field_3])) {$field_3_data=mysql_escape_string($val[$field_3]);}else{$field_3_data='';} }
                else
                    {$field_3_data='';}

                if($field_4>0)
                    {if(isset($val[$field_4])) {$field_4_data=mysql_escape_string($val[$field_4]);}else{$field_4_data='';} }
                else
                    {$field_4_data='';}

                if($field_5>0)
                    {if(isset($val[$field_5])) {$field_5_data=mysql_escape_string($val[$field_5]);}else{$field_5_data='';} }
                else
                    {$field_5_data='';}

                $all_f=array();
                for($i=1;$i<12;$i++) 
                {
                    if(isset($val[$i])) $all_f[$i]=$val[$i];else $all_f[$i]='';
                }
                $field_3_data=number_format(str_replace(',','.',$field_3_data),2,'.','');    
                $cod = str_replace(' ','',$field_1_data);
                $cod = trim(str_replace('-','',$cod));
                $tmp_res = $this->db->query("select DetailNum from emir where DetailNum ='{$cod}'");
                if(sizeof($tmp_res->result_array())>0){
                    $sql =" INSERT INTO `suppliers_products` ( `id` , `supplier` , `product` , `count` , `price` , `producer` , `desc`  
                    ) VALUES ('','$id', '$field_1_data', '$field_2_data', '$field_3_data', '$field_4_data', '$field_5_data'   );
                    ";
                    $this->db->query($sql);   
                }
                else{
                    $bad[] =array($field_1_data,$field_2_data,$field_3_data,$field_4_data,$field_5_data);
                    $sql =" INSERT INTO `suppliers_products` ( `id` , `supplier` , `product` , `count` , `price` , `producer` , `desc`  
                    ) VALUES ('','$id', '$field_1_data', '$field_2_data', '$field_3_data', '$field_4_data', '$field_5_data'   );
                    ";
                    $this->db->query($sql);

                };// ТУТ НАДО ЗАДЕЙСТВОВАТЬ

            };
            if(sizeof($bad)>0) $this->load->view('manager/bad_fields',array('data'=>$bad)); else 
                print('ok');
        }


        function margins()
        {
            if(isset($_POST['rozn'])) {
                $save_data=array('rozn'=>$_POST['rozn'],'sto'=>$_POST['sto'],'l_opt'=>$_POST['l_opt'],'m_opt'=>$_POST['m_opt'],'s_opt'=>$_POST['s_opt']);
                $str=serialize($save_data);
                $query= $this->db->query("update  site_config set text='$str' where name='margins'");
                $query= $this->db->query("update  site_config set text='".(float)$_POST['nacenka_emir']."' where name='nacenka_emir'");
                $query= $this->db->query("update  site_config set text='".(int)$_POST['nacenka']."' where name='nacenka'");
                $query= $this->db->query("update  site_config set text='".str_replace(',','.',$_POST['kurs'])."' where name='kurs'");
                $data['msg']='Изменения сохранены';
            };
            $query= $this->db->query("select * from site_config where name='margins'");
            $arr=$query->result_array();
            $data['margins'] =unserialize($arr[0]['text']);

            
            
            $query= $this->db->query("select * from site_config where name='nacenka'");
            $arr=$query->result_array();
            $data['nacenka'] =$arr[0]['text'];

            $query= $this->db->query("select * from site_config where name='kurs'");
            $arr=$query->result_array();
            $data['kurs'] =$arr[0]['text'];
            
            $query= $this->db->query("select * from site_config where name='nacenka_emir'");
            $arr=$query->result_array();
            $data['nacenka_emir'] =$arr[0]['text'];


            $data['action']='margins';
            $this->load->view('manager/margins',$data);
        }
        function ajax_status()
        {
            $id=(int)$_POST['id'];
            $status=$_POST['status'];
            $all = (int)$_POST['all'];
            $this->db->query("update order_details set status ='{$status}' where id='{$id}'");  
            if($all>0)  {
                $query= $this->db->query("select * from order_details where   id='{$id}'");   
                $row=$query->row_array();
                if($row['invoice']!=''){
                    $this->db->query("update order_details set status ='{$status}' where invoice='{$row['invoice']}' ");                 
                }

            }
            if(in_array($status,array('NotAvailable','AGREE','SendMy'))){// автоматически закрываем заказ 
                $query= $this->db->query("select order_id from order_details where id='{$id}'");          
                $row=$query->row_array(); 
                if($row) $query= $this->db->query("update orders set status='2' where id='{$row['order_id']}'"); 
            }



        }
        // Добавление изображения к арикулу
        function AddImage(){
           // var_dump($_POST);
            $image_1='';
            $image_2='';
            if($this->input->post('article')){
                for($i=1;$i<7;$i++){
                    if($this->input->post('url_'.$i)){
                        //echo $this->input->post('url_'.$i)."===";
                        $file = file_get_contents($this->input->post('url_'.$i));
                        if($file){
                            $image[$i] = "a{$i}_".md5(time()."_image_{$i}").".jpg";
                            file_put_contents("i/febest/{$image[$i]}", $file);    
                        }

                    } else{
                        if (is_uploaded_file($_FILES['file_'.$i]['tmp_name'])) {
                            $image[$i] = "f{$i}_".md5(time()."_image_{$i}").$_FILES['file_'.$i]['name']; 
                            move_uploaded_file( $_FILES["file_{$i}"]["tmp_name"], "i/febest/{$image[$i]}");
                        }

                    }
                }
              //   die();
                $item =   str_replace(' ','',$this->input->post('article'));
                $item =   str_replace('-','',$item);
                $item =   str_replace('neuheit','',$item);
                $item =   str_replace(',','',$item);  

                $this->db->where('article',$item); 
                $query= $this->db->get('items_id');
                $row=$query->row_array(); 
                
                $this->db->set('article',$item); 
                  for($i=1;$i<7;$i++){
                      if(isset($image[$i])){
                        if(is_file("i/febest/{$image[$i]}"))  $this->db->set('image_'.$i,$image[$i]);  
                      } 
                       $data['image_'.$i]=$image[$i];
                  }    
                if($row){
                     $this->db->where('article',$item); 
                     $this->db->update('items_id');
                }else  $this->db->insert('items_id');
                $data['article']=$item;   
                $this->load->view('added_images',$data);
            }else $this->load->view('add_images');
        }

        function edit_baner($id,$act=''){

            if($act=='del'){
                $this->data->del_banner($id);
                return header("location:/"); 
            } 

            if($act=='save'){
                $this->data->save_banner($id,$this->input->post('text'),$this->input->post('num')); 
                return header("location:/"); 
            } 

            if((int)$id>0){
               $data['banner'] = $this->data->get_banner($id); 
            }else{
              $data['banner'] = array('id'=>0,'text'=>'','num'=>'');  
            }
         
            $this->load->view('manager/edit_banner',$data);
        } 
        
        function  save_images_articles() 
        {              
           $this->data->save_images_articles($this->input->post('im'),$this->input->post('values'));
    
             
        } 
        function banners($del_id=0){ 
                if($del_id>0){
                    $this->db->where('id',$del_id);
                    $this->db->delete('catalog_images');  
                }
              // загрузка  изображений
             if(isset($_FILES['images_file'])){       
                $uploaddir = 'i/banners/';  
                $uploadfile='';
                $is_file=false; 
                 for($i=0;$i<20;$i++){
                     if(!isset($_FILES['images_file']['name'][$i])) continue;  
                     if(isset($_FILES['images_file']['name'][$i])) {
                        $f_name =basename($_FILES['images_file']['name'][$i]); 
                        $uploadfile = $uploaddir . $f_name;
                        if( move_uploaded_file($_FILES['images_file']['tmp_name'][$i], $uploadfile)){
                            $this->db->set('image',$f_name);  
                            $is_file = true; 
                        } elseif((int)$_POST['images_id'][$i]<1) continue;     
                     }

                   
                     if($is_file){
                                             
                     if((int)$_POST['images_id'][$i]>0){
                         $this->db->where('id',$_POST['images_id'][$i]);
                         $this->db->update('catalog_images');  
                         $id = $_POST['images_id'][$i];
                     }else {
                        $this->db->insert('catalog_images');  
                        $id = $this->db->insert_id();
                     }
                         
                        if(is_file($uploaddir."{$id}_".$f_name)) unlink($uploaddir."{$id}_".$f_name); 
                        rename($uploadfile,$uploaddir."{$id}_".$f_name);
                        $this->db->where('id',$id);
                        $this->db->set('image',"{$id}_".$f_name);
                         $this->db->update('catalog_images'); 
                     }
                    
                }  
             }
                $query= $this->db->query("select * from catalog_images");   
                $data['images']=$query->result();
                $this->load->view('image_banners',$data);
      
   } 
    
    }
    
?>
