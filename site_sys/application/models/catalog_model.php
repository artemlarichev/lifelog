<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Catalog_model extends Model
    { 
        function Catalog_model()
        {
            parent::Model();
            $this->load->database();
        }
 // Функции формирования цены 
 
  
function get_price_ukr($val,$kurs, $discont)
{ 
    
 $price=$val['price']*$kurs*(100+$discont)/100*(100+$val['discont'])/100; 
 return (int)$price;
    
}  
   function get_price($val,$valuta, $nacenka=1)
{   // print_r($val);
    if($valuta==USD)
    {
        $price=$val['price_usd'];
    }
    else
    {
       $price=$val['price_uah'];
    }
    if($nacenka=='hidden'){
      if(isset($_SESSION['user']))
        return round($price); 
     else  
        return round($price*1.2);     
    }
     $k= $val['price_uah']/$val['price_usd'];

     if(isset($_SESSION['user']['disc_type']))
     {
         if($_SESSION['user']['disc_type']>0)
         {
              $tmp_price=($val['price_usd']*(100-$_SESSION['user']['discont']*$val['discount_m'])/100);
              $kk=(100-$_SESSION['user']['discont']*$val['discount_m'])/100;
             //  print($kk.'-22--');
         }
         else
         {
              $tmp_price=($val['price_usd']*(100-$_SESSION['user']['discont']*$val['discount'])/100);
              $kk=(100-$_SESSION['user']['discont']*$val['discount'])/100;
            //  print($kk.'-33--');
         }
         $tmp_price2=($val['buy_price']*1.1);
     }
     else
     {
         $tmp_price=($val['price_usd']*$nacenka); $kk=$nacenka;
         $tmp_price2=($val['buy_price']*1.1);
     }
    // print(" --  $tmp_price  -   $tmp_price2      -- ");
     if($tmp_price>$tmp_price2)   {$price=$price*$kk;}
     else
      { 
       if($valuta==USD)
          {
            $price=$val['buy_price']*1.1;
          }else
          {
            $price = $val['buy_price']*1.1*$k;
          }

      }
     //   print("  - ".$price);
    return round($price);
}


// работа с украинскими поставщиками
        function suppliers($mark='all',$page=1)
        {
           if((int)$page<1) $page =1;
            if($mark=='all'){ 
                  $SQL='SELECT DISTINCT producer
                    FROM `suppliers_products`
                    WHERE count >0
                     order by producer'; 
                  $query = $this->db->query($SQL);
                  return $query->result_array(); 
            }else{                                                                      
                $mark = mysql_escape_string(urldecode(str_replace('_',' ',$mark)));
                $mark = str_replace('&#40;','(',str_replace('&#41;',')',$mark)) ;
            
                 $SQL="SELECT *
                    FROM `suppliers_products`
                    WHERE  producer='{$mark}'
                     order by id
                     LIMIT ".(((int)$page-1)*50)." , 50
                     "; 
                  $query = $this->db->query($SQL);
                  return $query->result_array();   
            } 
        }        
         function suppliers_page_cnt($mark)
        {                                                                    
                $mark = mysql_escape_string(urldecode(str_replace('_',' ',$mark)));
                $mark = str_replace('&#40;','(',str_replace('&#41;',')',$mark)) ;
                 $SQL="SELECT count(id) as cnt
                    FROM `suppliers_products`
                    WHERE  producer='{$mark}'
                     "; 
                  $query = $this->db->query($SQL);
                  $rez =  $query->row_array();   
                  return ceil($rez['cnt']/50);
         
        } 
        function emir_suppliers($mark='all',$page=1)
        {
           if((int)$page<1) $page =1;
            if($mark=='all'){ 
                  $SQL='SELECT *
                    FROM  emir_company
                     order by name'; 
                  $query = $this->db->query($SQL);
                  return $query->result_array(); 
            }else{
                $mark = mysql_escape_string(urldecode($mark));
                 $SQL="SELECT *
                    FROM `emir`
                    WHERE  MakeLogo='{$mark}'
                     order by id
                     LIMIT ".(((int)$page-1)*50)." , 50
                     "; 
                  $query = $this->db->query($SQL);
                  return $query->result_array();   
            } 
        }
         function emir_suppliers_page_cnt($mark)
        {                                                                    
                $mark = mysql_escape_string($mark);
                 $SQL="SELECT count(id) as cnt
                   FROM `emir`
                    WHERE  MakeLogo='{$mark}'
                     "; 
                  $query = $this->db->query($SQL); 
                  $rez =  $query->row_array();   
                  return ceil($rez['cnt']/50);
           
        } 
            function MakeLogoName($mark )
        {
 
              $SQL="SELECT *
                FROM  emir_company WHERE  MakeLogo='{$mark}'
                 order by name";  
              $query = $this->db->query($SQL);
              $row =  $query->row_array();   
              return $row['name']." ({$row['state']})"; 
            
        }  

    }
?>