<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Avtoparts_model extends Model
    {
        var $user= array('login'=>'mazda.','pass'=>'e1230npu' );


        function Avtoparts_model()
        {

            parent::Model();
            $this->load->database();                                               

        }

        function load_price()
        {                                                

            $url="http://www.avtoparts.com.ua/Price.asmx/GetPrice?login={$this->user['login']}&password={$this->user['pass']}";
           // echo $url;
            $result = file_get_contents($url);  
            // $result = substr($result,0,10000); 
            $xml = simplexml_load_string($result);    
            if(isset($xml->Item)){// даные получены
                $this->db->where('supplier','19');
                $this->db->delete('suppliers_products');   
                $curs =   $xml->USDRate;
                foreach ($xml->Item as $item) { 
                
                    echo $item->part_number." $item->count_pos  -  $item->cost -  $item->cost_usd   <br>";  
                    if($item->count_pos=='0')  continue;                                                     
                    if($item->count_pos=='> 5')  $item->count_pos=5;;
                    
                    if((int)$item->cost_usd>0) $price=$item->cost_usd; else  $price  = number_format($item->cost/$curs,2,'.','')  ;
                    $this->db->set('supplier','19');
                    $this->db->set('product',"$item->part_number");                       
                    $this->db->set('price',"$price");
                    $this->db->set('producer',"$item->type");
                    $this->db->set('desc',"$item->element_name");
                    $this->db->set('count',"$item->count_pos");
                    $this->db->insert('suppliers_products');      
                }          
            }


        }

    }
?>
