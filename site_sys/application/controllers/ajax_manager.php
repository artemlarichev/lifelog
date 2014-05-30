<?php

//ajax функции для панели менеджера

class Ajax_manager extends Controller {

 	function Ajax_manager()
	{
	    
	 	parent::Controller();
	 	$this->load->model('data_model','data'); 
		if(!isset($_SESSION['manager'])){die("err");}
	}

	function index(){}
    
	function set_value($tab='',$id='',$field='',$value='')
	{
        $this->db->set($field,$value);
        $this->db->where('id',$id);
        $this->db->update($tab);
        echo $value;
        if($tab=='orders' and $field=='nakladna'){
            
            $this->db->set('nakladna',$value);
            $this->db->where('order_id',$id);
            $this->db->update('pay_in_out');       
            
        }
        if($tab=='orders' and $field=='dekl'){
            
            $this->db->set('decl',$value);
            $this->db->where('order_id',$id);
            $this->db->update('pay_in_out');     
        }        
	}
    
    function set_pay_text($id='',$field='',$value='',$order_id='')
    {
        $this->db->set($field,$value);
        $this->db->where('id',$id);
        $this->db->update('pay_in_out');
        echo $value;
        if($order_id>0 and ($field=='nakladna' or $field=='decl')){
        if($field=='decl')$field='dekl';
        $this->db->set($field,$value);
        $this->db->where('id',$order_id);
        $this->db->update('orders');     
        }
       
    }
 }

?>
