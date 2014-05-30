<?php
class Client extends Controller {

   var  $conf=array('client'=>'1');
   var $mp_status=array(0=>'Новый',
                        'InWork'=>'В работе',
                        'NotAvailable'=>'Нет в наличии ',
                        'Purchased'=>'Закуплено',
                        'ReadyToSend'=>'Готово к отправке',
                        'Send'=>'Отправлено поставщиком',
                        'ReadyMy'=>'Готово к выдаче',
                        'SendMy'=>'Выдано',
                        'AGREE'=>'Превишение цены');     
    var  $user_names=array(); var  $group=array();
 	function Client()
	{
        
 


	    session_start();
	 	parent::Controller();
	 	$this->load->model('data_model','data');
		$this->load->helper('my_func');
		header('Content-Type: text/html; charset=UTF-8');
		 		if(!isset($_SESSION['user'])){header("location:/");exit;}
     if(isset($_SESSION['user']['id'])) {$_SESSION['user'] =$this->data->get_row($_SESSION['user']['id'] ,'users');}
     $this->conf['page']='cab';
	if(isset($_SESSION['manager'])) {$this->user_names= $this->data->get_user_names();}
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

	function account()
	{
       $data['top_image']=1; 
	  $data['action']='account';
	  if(isset($_POST['tel']))
	  {

	   	  $data['msg']='1';
	   	  $user_save=array('id'=>$_SESSION['user']['id'],
                             'send_mail'=>(int)$this->input->post('send_mail'),
                             'tel'=>mysql_escape_string($_POST['tel']),
						   'email'=>mysql_escape_string($_POST['email']) ); 
			if(!($_POST['pass']=='')) {$user_save['pass']=md5(md5($_POST['pass'])) ;};

		 $this->data->save($user_save,'users');
         $_SESSION['user']=$this->data->get_row($_SESSION['user']['id'],'users');
	  }

	  $data['user']= $_SESSION['user'];
   	  $this->load->view('user/account',$data);
	}

	function search_history($arh=0)
	{
	  $data['action']='search_history';
      $data['top_image']=1;
	  $data['user']= $_SESSION['user'];
       if($arh=='0'){
       $data['SHORT']=1;   
       
      }
	  $data['result']=$this->data->get_request($_SESSION['user']['id'],$arh);
   	  $this->load->view('user/search_history',$data);
	}


	function balance($edit='',$action='')
	{
     $data['top_image']=1;
      if(isset($_SESSION['manager']))
      {

      if($action=='del') {   $err=$this->pay_model->del_pay((int)$edit); $edit='';}
      
      if(isset($_POST['credit']))
      {
       $this->db->query("update users set credit='".(int)$_POST['credit']."'   where id='".$_SESSION['user']['id']."'  ");
       return header("location:/client/balance");
      }  
      
      if(isset($_POST['id'])) { 
                if($_POST['nakladna']==''){$_POST['nakladna']='&mdash;';}
                 if($_POST['decl']==''){$_POST['decl']='&mdash;';}
                 if($_POST['platig']==''){$_POST['platig']='&mdash;';}
                 if($_POST['perevod']==''){$_POST['perevod']='&mdash;';} 
                     
                     $pay_data=array('data'=>convert_date($this->input->post('data'),2),
                             'suma'=>$this->input->post('suma'),
                             'text'=>$_POST['text'],
                             'nakladna'=>$_POST['nakladna'],
                             'decl'=>$_POST['decl'],
                             'platig'=>$_POST['platig'],
                             'perevod'=>$_POST['perevod'] 
                            );
                           // var_dump($pay_data);exit;
               if($_POST['id']>0){
                   $err=$this->pay_model->edit_pay($pay_data,$_POST['id']);
               }else{
                    $pay_data['user'] = $_SESSION['user']['id'];
                    $pay_data['type'] = $_POST['type'];
                    if($_POST['type']=='in') $pay_data['balans'] = round($_SESSION['user']['balans']+$_POST['suma']);
                        else  $pay_data['balans'] = round($_SESSION['user']['balans']-$_POST['suma']);
                    $err=$this->pay_model->add_pay($pay_data,$_POST['id']);    
               }
               
           	 $pay = $this->data->get_row((int)$_POST['id'],'pay_in_out');
           	 if($pay['order_id']>0)
           	 {
	           	 $this->db->query("update orders set nakladna='".$pay['nakladna']."', dekl='".$pay['decl']."' where id='".$pay['order_id']."'  ");
           	 };
     return header("location:/client/balance");
      }
      if(!($edit==''))   $data['edit_act'] = (int)$edit;
       if(isset($err)) {$data['msg']=$err;}
      }



      $_SESSION['user']=$this->data->get_row($_SESSION['user']['id'],'users');
	  $data['action']='balance';

	  $data['user']= $_SESSION['user'];
	   $query = $this->db->query("SELECT SUM(suma) as suma from pay_in_out where user='".$_SESSION['user']['id']."' and type='in'");
	   $res=$query->result_array();
	   $data['all_payin']=$res[0]['suma'];

	   $query = $this->db->query("SELECT SUm(suma) as suma from pay_in_out where user='".$_SESSION['user']['id']."' and type='out'");
	   $res=$query->result_array();
	   $data['all_payout']=$res[0]['suma'];
	  $data['pay_in_out']=$this->pay_model->get_my_pays();
   	  $this->load->view('user/balance',$data);
	}

	function orders($status=0,$parts='0')
	{
      $find=0;
      $data['top_image']=1;
      if(isset($_POST['n_order'])){$find=1;$status=22;};
	  $data['action']='orders';
      $data['status']=$status;
      $data['show_parts']=$parts;
	  $data['user']= $_SESSION['user'];
	  $data['orders']=$this->data->get_orders($status,$_SESSION['user']['id'],'',$find);
      // $data['orders_details']= $this->data->get_orders_all_details_tab($data['orders']);

	  if($parts>0)
	  {
		  $data['order_parts']= $this->data->get_all_orders_detail($status,$_SESSION['user']['id'],$find);
		  $this->load->view('user/all_orders',$data);
	  }
	  else {
   	  $this->load->view('user/orders',$data);}
	}

	function order($id)
	{
	  $data['action']='orders';
	  $data['order']= $this->data->get_row((int)$id,'orders');
	  $data['order_parts']= $this->data->get_orders_detail((int)$id);
      $data['top_image']=1;
	  $data['status']=$data['order']['status'];
	  $data['user']= $_SESSION['user'];
   	  $this->load->view('user/order',$data);
	}


	function del_order($id,$status=0)
	{
	  
        if($order= $this->data->get_row((int)$id,'orders'))
	  {
        if($order['status']!='1' and  $order['user']==$_SESSION['user']['id'])
        {
        	 $this->db->query("delete from order_details where order_id ='".$order['id']."' ");
             if($order['status']<1) {$this->_refresh_order($order['id']);}
        	 $this->db->query("delete from orders where id='".$order['id']."' ");
        }
	  }
	  header("location:/client/orders/".$status);
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
            $sum=$sum+$part['count']*$price;
 	  	}

		$SQL="UPDATE  `orders` set `count`='$cnt',`summ`='$sum' where  id='".(int)$id."'";
      $query = $this->db->query($SQL);
      $this->pay_model->change_pay_summ_by_order($id);
      $_SESSION['user']=$this->data->get_row($_SESSION['user']['id'],'users');
      //  $this->_refresh_order_pay($id);
	}

	function _refresh_order_pay($id)
	{
		$order=$this->data->get_row($id,'orders');
        $pay=$this->data->get_row($id,'pay_in_out','order_id');
 	    if($order and $pay)
 	    {
 	      if($order['summ']!=$pay['suma'])
 	      {
	 	      $rizn=$order['summ']-$pay['suma'];
			  $SQL="UPDATE  `users` set `balans`=`balans`-$rizn where  id='".$_SESSION['user']['id']."'";
		      $query = $this->db->query($SQL);
			  $SQL="UPDATE  `pay_in_out` set `suma`= `suma`+$rizn  where  order_id='".(int)$id."'";
		      $query = $this->db->query($SQL);
 	      }
 	  	}

	}
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

                             $value=array('id'=>$val['id'],
                             'count'=>$val['count'],
                             'start_count'=>$val['count'],
                             'add1'=>$val['add1'],
			  		     'add2'=>$val['add2'],
                         'add3'=>$val['add3'],
                         'add4'=>$val['add4'],
                         'add5'=>$val['add5']
                     );
		      			$this->data->save($value,'order_details');
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
		}

   function del($tab,$id)
	{

 	    if($tab=='order_details')
 	    {
 	    	$part=$this->data->get_row($id,'order_details');
			$SQL="DELETE from  order_details where id='".(int)$id."'";
	 	    $query = $this->db->query($SQL);
	 	    $this->_refresh_order($part['order_id']);
	 	    header("location:/client/order/".$part['order_id']);
 	  	}    else
 	  	{

 	     header("location:/manager");
 	 	}
	}

	function logout()
	{
 	  if(isset($_SESSION['user'])){unset($_SESSION['user']);};
 	  if(isset($_SESSION['valuta'])){unset($_SESSION['valuta']);};
 	  if(isset($_SESSION['basket'])){unset($_SESSION['basket']);};
 	  if(isset($_SESSION['basket_data'])){unset($_SESSION['basket_data']);};
 	  if(isset($_SESSION['manager'])){unset($_SESSION['manager']);};
      header("location:/");
	}

 }

?>