<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Article_model extends Model
    { 
        function Article_model()
        {
            parent::Model(); 
        }

        function save_article($data) {  
            if(isset($data['id'])){
                if((int)$data['id']>0){
                    $this->db->where('id',$data['id']);  
                    $this->db->update('articles',$data);  
                } else {
                    $this->db->insert('articles',$data);  
                    return $this->db->insert_id(); 
                }
            }else{
                $this->db->insert('articles',$data);  
                return $this->db->insert_id(); 
            }
        }

        function get_article($id) {  
            $this->db->where('id',$id);  
            $query = $this -> db -> get ( 'articles' );
            return $query -> row_array();  
        }

        function get_article_url($url) { 
            $this->db->where('url',$url);  
            $query = $this -> db -> get ( 'articles' );
            return $query -> row_array();   
        }

        function del_article($id) {  
            $this->db->where('id',$id);  
            $this->db->delete('articles');          
        }

        function get_cat($id) {  
            $this->db->where('id',$id);  
            $query = $this -> db -> get ( 'articles_cats' );
            return $query -> row_array();  
        } 

        function get_cat_url($url) {  
            $this->db->where('url',$url);  
            $query = $this -> db -> get ( 'articles_cats' );
            return $query -> row_array();  
        }

        function get_cats() {    
            $this->db->order_by('title');          
            $query = $this -> db -> get ( 'articles_cats' );
            return $query -> result_array();  
        }

        function get_cats_url() {    
            $this->db->order_by('title');          
            $query = $this -> db -> get ( 'articles_cats' );
            $data =  $query -> result_array();  
            $names = array();
            foreach($data as $val) $names[$val['id']]=$val['url']  ;
            return $names;
        }

        function save_cat($data) {  
            if(isset($data['id'])){
                if((int)$data['id']>0){
                    $this->db->where('id',$data['id']);  
                    $this->db->update('articles_cats',$data);  
                } else {
                    $this->db->insert('articles_cats',$data);  
                    return $this->db->insert_id(); 
                }
            }else{
                $this->db->insert('articles_cats',$data);  
                return $this->db->insert_id(); 
            }
        }


        function del_cat($id) {  
            $this->db->where('id',$id);  
            $this->db->delete('articles_cats');          
            $this->db->where('cat_id',$id);  
            $this->db->delete('articles');          
        }


        function get_articles_by_cat($cat_id)  {  
            $this->db->where('cat_id',$cat_id);          
            $this->db->order_by('id','desc');          
            $query = $this -> db -> get ( 'articles' );
            return $query -> result_array();       
        }   


        function last_articles($cnt=5)  {  
            $this->db->limit($cnt);          
            $this->db->select('articles.*, articles_cats.url as c_url');          

            $this->db->join('articles_cats','articles_cats.id = articles.cat_id');          
            $this->db->order_by('id','desc');          
            $query = $this -> db -> get ( 'articles' );
            return $query -> result_array();       
        }   

        function get_articles_by_keywords($keyword)  {     

            $this->db->like('keys', "{$keyword}", 'after');
            $this->db->or_like('keys', "{$keyword}", 'before');
            $this->db->or_like('keys', "{$keyword}", 'both'); 
            $this->db->order_by('id','desc');          
            $query = $this -> db -> get ( 'articles' );   
            return $query -> result_array();       
        } 

        function get_keywords($where=array())  {     

            $this->db->where($where);
            $query = $this -> db -> get ( 'articles' );   
            $items =  $query -> result_array();  
            $key_str = '';
            foreach($items as $item){
                if($item['keys']!='')$key_str .= ",".$item['keys'];
            } 
            $keys=explode(',',$key_str);
            $keys =  array_unique($keys);
            foreach($keys as $k=>$val) if(trim($val)=='') {unset($keys[$k]);}

                return $keys;
        } 

    }
?>