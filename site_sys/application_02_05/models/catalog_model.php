<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Catalog_model extends Model
    { 
        function Catalog_model()
        {
            parent::Model();
            $this->load->database();
        }
 
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