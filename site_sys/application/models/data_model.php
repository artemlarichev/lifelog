<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Data_model extends Model
    {
        var $table='';
        var $user= array('id'=>'0','MP_CODE'=>'872','MP_PASS'=>'GOSTь','MP_LOGIN'=>'GOST');
        function Data_model()
        {
            parent::Model();
            $this->load->database();
        }
        function _clear_text($text)
        {
            $text=str_replace('&nbsp;',' ',$text);
            $text = str_replace('\r\n', '', $text);
            $text = str_replace('\n', '', $text);
            while(strpos($text,'  ')>0) {$text=str_replace('  ',' ',$text);};
            $text=str_replace('<p></p>','',$text);
            $text=str_replace('<p> </p>','',$text);
            $text=strip_tags($text,'<a>,<img>,<table>,<tr>,<th>,<td>,<h1>,<h2>,<h3>,<h4>,<p>,<em>,<li>,<ul>,<strong>,<i>');
            return $text;
        }



        function set_table($table)
        {
            $this->table=$table;
        }

        function get_table()
        {
            return $this->table;
        }

        function get_row($id,$table='curent',$field_name='id') // вибір запису з таблиці по ИД
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where($field_name,  $id);
            $query = $this->db->get($table);
            $data = $query->result_array();
            if(sizeof($data)>0) {return $data[0];} else {return false;};
        }

        function get_row_url($url,$where=array(),$table='curent') // вибір запису з таблиці по url
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where($where);
            $this->db->where('url', mysql_escape_string($url));
            $query = $this->db->get($table);
            $data = $query->result_array();
            if(sizeof($data)>0) {return $data[0];} else {return false;};
        }
        function get_row_url_parent($url,$parent_id=0,$table='curent') // вибір запису з таблиці по url
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where('parent',$parent_id);
            $this->db->where('url', mysql_escape_string($url));
            $query = $this->db->get($table);
            $data = $query->result_array();
            if(sizeof($data)>0) {return $data[0];} else {return false;};
        }
        function get_first_row($order='',$where=array(),$table='curent') // вибір запису з таблиці по url
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where($where);
            $this->db->limit(1);
            if(!($order=='')){$this->db->order_by($order);};
            $query = $this->db->get($table);
            $data = $query->result_array();
            if(sizeof($data)>0) {return $data[0];} else {return false;};
        }

        function del($id,$table='curent') // видалення з таблиці по ИД
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where('id', (int)$id);
            $query = $this->db->delete($table);
        }

        function del_where($umova, $table='curent') // видалення з таблиці по ИД
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where($umova);
            $query = $this->db->delete($table);
        }

        function insert($data,$table='curent')  //  занесення нового запису в таблицю
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->insert($table, $data);
            $id=$this->db->insert_id();
            return $id;
        }

        function save($data,$table='curent' )  //  занесення нового запису в таблицю
        {
            if(!isset($data['id'])){$data['id']=0;}
            if($table=='curent') {$table=$this->table;};
            $fields=$this->db->list_fields($table);
            if(isset($data['text'])) {$data['text']=$this->_clear_text($data['text']);}
            $keys=array_keys($data);
            foreach ($keys as $key)
            {
                if(!(in_array($key,$fields))) {unset($data[$key]);}  ;
            }
            $id=$data['id'];
            if($id>0)
            {
                unset($data['id']);
                $this->db->where('id', $id);
                $this->db->update($table, $data);
            }
            else
            {
                $this->db->insert($table, $data);
                $id=$this->db->insert_id();
            }
            return $id;
        }
        function update_umova($table='curent',$data,$umova)   // зміна зиписівв по умові
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where($umova);
            return $this->db->update($table, $data);
        }
        function save_POST($table='curent')  //  занесення нового запису в таблицю
        {
            if($table=='curent') {$table=$this->table;};
            $data=array();
            $fields=$this->db->list_fields($table);
            if(isset($data['text'])) {$data['text']=$this->_clear_text($data['text']);}
            foreach ($fields as $field)
            {
                if(isset($_POST[$field])) {$data[$field]=$_POST[$field];}  ;
            }
            if(isset($data['id'])) {$id=(int)$data['id'];}else {$id=0;}

            if($id>0)
            {
                unset ($data['id']);
                $this->db->where('id', $id);
                $this->db->update($table, $data);
            }
            else
            {
                $this->db->insert($table, $data);
                $id=$this->db->insert_id();
            }
            return $id;
        }
        function count_all($table='curent')       //
        {
            if($table=='curent') {$table=$this->table;};
            return $this->db->count_all($table);
        }
        function count_umova($umova=array(),$table='curent' )      //
        {
            if($table=='curent') {$table=$this->table;};
            $this->db->where($umova);
            $this->db->select('id');
            $query = $this->db->get($table);
            return $query->num_rows();
        }
        function make_empty_data($table='curent')       //
        {
            if($table=='curent') {$table=$this->table;};
            $fields=$this->db->list_fields($table);
            foreach ($fields as $field)
            {
                $data[$field]='';
            }
            return $data;
        }

        function get_array($umova=array(),$order='',$select='',$limit='',$from=0,$table='curent')      //побудова масиву   з таблиці словника  вибір по назві поля
        {
            $this->db->where($umova);
            if($table=='curent') {$table=$this->table;};

            if(!($limit=='')){$this->db->limit($limit,$from);};
            if(!($order=='')){$this->db->order_by($order);};
            if(!($select=='')){$this->db->select($select);};
            $query = $this->db->get($table);
            $res=$query->result_array();
            return $res;
        }


        // JAPAN FUNCTIONS

        function get_full_table($table='',$order='')
        {
            if(!($order=='')){$this->db->order_by($order);};
            $query = $this->db->get($table);
            return $query->result_array();
        }

        function get_user_table($type='user',$order='card',$order_='' )
        {
            $this->db->order_by($order,$order_) ;
            $this->db->where('user_type',$type);
            $query = $this->db->get('users');
            return $query->result_array();
        }
        function get_groups($level='',$parent='',$parent_1='',$key='',$only=0)
        {
            $where='';
            if(!($parent==''))
            {
                if($level=='1') {$where =" and `group`='$parent' ";}
                if($level=='2') {  $where =" and `group`='$parent' and `group_1`='$parent_1' ";}
            }
            if(!($key==''))
            {
                $where .=' and '.$this->_sql_code($key,$only) ;

            }
            if(!($level=='')) {$level ='_'.$level;}
            $query = $this->db->query('SELECT DISTINCT `group'.$level.'` as `group` FROM product where `group'.$level.'`<>"" '.$where.' order by `group`');
            $data=$query->result_array();

            return $data;


        }
        function get_groups_key($key)
        {
            $where2='';
            if(!($key==''))
            {
                $where2 =' where '.$this->_sql_code($key) ;
            }
            $query = $this->db->query("SELECT DISTINCT `group` as `group` FROM product $where2 order by `group`");

            return $query->result_array();


        }


        function select_groups($group='',$group_1='',$group_2='')
        {
            $where='where id>0 ';
            $group=str_replace('_',' ',$group);
            $group_1=str_replace('_',' ',$group_1);
            $group_2=str_replace('_',' ',$group_2);
            if(isset($_SESSION['manager'])){ $where .=" and `group`='$group' ";}
            if(!($group=='')){ $where .=" and `group`='$group' ";}
            if(!($group_1=='')){ $where .=" and `group_1`='$group_1' ";}
            if(!($group_2=='')){  $where .=" and `group_2`='$group_2' ";}
            $order='';
            if(isset($_SESSION['manager'])){ $order =   " , sim  ";}
            $query = $this->db->query("SELECT * FROM product $where order by `group`,`group_1`,`group_2`$order limit 0,500");
            return $query->result_array();


        }
        function _sql_code($code='',$only=0) // запрос пошуку по коду
        {
         

            $code=str_replace('"','',$code);
            $code=str_replace("'",'',$code);
            $code=str_replace(' ','',$code);
            $code=str_replace('-','',$code);
            if($only>0){
                if(isset($_SESSION['manager']))
                {

                    $SQL=' (REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "") = "'.$code.'"


                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "'.$code.',%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%,'.$code.',%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%,'.$code.'"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  = "'.$code.'"

                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "'.$code.',%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%,'.$code.',%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%,'.$code.'"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  = "'.$code.'"                


                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  like "'.$code.',%"
                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  like "%,'.$code.',%"
                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  like "%,'.$code.'"
                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  = "'.$code.'"                


                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "'.$code.',%"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "%,'.$code.',%"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "%,'.$code.'"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  = "'.$code.'"                





                    or REPLACE(REPLACE(product.article,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.note,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.buy_num,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.sim ,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.expected,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.orig_nums_clear,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.int_inf_clear,"-", ""),  " ", "")  = "'.$code.'"

                    )';      //orig_nums int_inf
                }
                else
                {   //для клиента:Артикул,каталожній номер,примечание,оригинальніе номера,описание автомобиля.                                                
                
               
                
                    $SQL=' (REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  = "'.$code.'"

                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "'.$code.',%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%,'.$code.',%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%,'.$code.'"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  = "'.$code.'"

                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "'.$code.',%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%,'.$code.',%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%,'.$code.'"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  = "'.$code.'"                


                    or REPLACE(REPLACE(product.article,"-", ""),  " ", "")    = "'.$code.'"

                    or REPLACE(REPLACE(product.article,"-", ""),  " ", "")  = "'.$code.'" 

                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  like "'.$code.',%"
                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  like "%,'.$code.',"
                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  like "%,'.$code.'%"
                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  = "'.$code.'"




                    )';

                }  

            }
            else {
                if(isset($_SESSION['manager']))
                {

                    //         cat_num  orig_nums int_inf  

                    //[14:55:15] Slider: в них через запятую
                    //[14:55:59] Slider: article  aux_num  sim  buy_num
                    //для клиента:Артикул,каталожній номер,примечание,оригинальніе номера,описание автомобиля.


                    //  для менеджера: теже колонки + производитель и внутренняя информация.

                    //  REPLACE(REPLACE(product_name, '-', ''), ' ', '')
                    $SQL=' (REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "") = "'.$code.'"


                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%'.$code.'%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%'.$code.'"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  = "'.$code.'"

                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%'.$code.'%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%'.$code.'"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  = "'.$code.'"                


                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  like "%,'.$code.'%"
                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  like "%'.$code.'"
                    or REPLACE(REPLACE(product.manuf,"-", ""),  " ", "")  = "'.$code.'"                


                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "%'.$code.'%"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "%'.$code.'"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  = "'.$code.'"                





                    or REPLACE(REPLACE(product.article,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.note,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.buy_num,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.sim ,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.expected,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.orig_nums_clear,"-", ""),  " ", "")  = "'.$code.'"
                    or REPLACE(REPLACE(product.int_inf_clear,"-", ""),  " ", "")  = "'.$code.'"

                    )';      //orig_nums int_inf
                }
                else
                {   //для клиента:Артикул,каталожній номер,примечание,оригинальніе номера,описание автомобиля.                                                
                          
                    $SQL=' (REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  = "'.$code.'"

                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%'.$code.'%"
                    or REPLACE(REPLACE(product.orig_nums,"-", ""),  " ", "")  like "%'.$code.'"

                    
                    
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "%'.$code.'%"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  like "%'.$code.'"
                    or REPLACE(REPLACE(product.int_inf,"-", ""),  " ", "")  = "'.$code.'"       
                    
                    
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%'.$code.'%"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  like "%'.$code.'"
                    or REPLACE(REPLACE(product.cat_num,"-", ""),  " ", "")  = "'.$code.'"                




                    or REPLACE(REPLACE(product.article,"-", ""),  " ", "")    like "%'.$code.'%"

                    or REPLACE(REPLACE(product.article,"-", ""),  " ", "")  = "'.$code.'" 

                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  like "'.$code.'%"
                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  like "%'.$code.'"
                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  like "%'.$code.'%"
                    or REPLACE(REPLACE(product.car_desc,"-", ""),  " ", "")  like "'.$code.'"




                    )';
                    //echo $SQL;
                }  
            }    
            /*
            if(isset($_SESSION['manager']))
            {


            //  REPLACE(REPLACE(product_name, '-', ''), ' ', '')
            $SQL=' (REPLACE(REPLACE(product.orig_nums,"-", ""),  "", "") like "%'.$code.'%"
            or REPLACE(REPLACE(product.aux_num,"-", ""),  "", "") like "%'.$code.'%"
            or REPLACE(REPLACE(product.manuf,"-", ""),  "", "") like "%'.$code.'%"
            or REPLACE(REPLACE(product.cat_num,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.cat_num,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.car_desc,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.orig_nums,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.article,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.int_inf,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.note,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.buy_num,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.sim ,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.expected,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.orig_nums_clear,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.int_inf_clear,"-", ""),  "", "")  like "%'.$code.'%"

            )';
            }
            else
            {
            $SQL=' (REPLACE(REPLACE(product.orig_nums,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.aux_num,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.manuf,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.cat_num,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.cat_num,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.car_desc,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.orig_nums,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.article,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.buy_num,"-", ""),  "", "")  like "%'.$code.'%"
            or REPLACE(REPLACE(product.orig_nums_clear ,"-", ""),  "", "") like "%'.$code.'%"


            )';

            }*/   //      print($SQL); 
            return $SQL;
        }
        
        
        function find_code_id($code='', $all = 0)
        {
            if(!isset($_POST['only_key'])) $_POST['only_key']=0;  ;
            if($all>0)  {
                $_POST['sklad'] = 1;
                $_POST['ukr'] = 1;
                $_POST['emir'] = 1;
                
            }
            if(isset($_SESSION['manager']))  {
                $_POST['sklad'] = 1;
                $_POST['ukr'] = 1;
                $_POST['emir'] = 1;
                
            }
            
            $code=mysql_escape_string($code);
            $cnt=0;
            if((int)$this->input->post('sklad')>0){// опшук по складу 
                $SQL="SELECT * FROM product where id>0 and ".$this->_sql_code($code,(int)$_POST['only_key']).' order by `group`,group_1,group_2';   
                $query = $this->db->query($SQL);

                $res =$query->result_array();
                $cnt=$cnt+(int)sizeof($res); // количество в наличии
            }

            // ищем аналоги по emir_substs
            $code1=$code;
            $code = clear_code($code);
            $SQL="SELECT detailnums FROM Substs where detailnum ='{$code}'";
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            $analogs_list=array();
            $analog_sql =''; 
            $analog_sql_sup = '';
            if(sizeof($res)>0)
            {   
                $analog_sql=" REPLACE(REPLACE(product_name, '-', ''), ' ', '') IN  ('_____";
                foreach($res as $val)
                {
                    $analog_sql.="','".trim(str_replace("'",'',$val['detailnums']));
                }
                $analog_sql.="')";

                $analog_sql_sclad= str_replace('product_name','article',$analog_sql);
                $analog_sql_sup= trim(str_replace('product_name','product',$analog_sql));
                $analog_sql_emir= str_replace('product_name','DetailNum',$analog_sql);

                // ищем аналоги по наличии
                if((int)$this->input->post('sklad')>0){
                    $SQL="SELECT id FROM product where  {$analog_sql_sclad} order by `group`,group_1,group_2";
                    $query = $this->db->query($SQL);
                    $res =$query->result_array();
                    $cnt=$cnt+(int)sizeof($res);
                }
                // ищем аналоги по поставщикам
                if((int)$this->input->post('ukr')>0){
                    $SQL="SELECT product FROM suppliers_products where  {$analog_sql_sup} order by supplier ";
                    $query = $this->db->query($SQL);
                    $res =$query->result_array();
                    $cnt=$cnt+(int)sizeof($res);
                }
                // ищем аналоги по емиратам
                
                if((int)$this->input->post('emir')>0){
                    $SQL="SELECT DetailNum FROM emir where  {$analog_sql_emir} order by MakeLogo";
                    $query = $this->db->query($SQL);
                    $res =$query->result_array();
                    $cnt=$cnt+(int)sizeof($res);
               }
            }
            if($analog_sql_sup!='') $analog_sql_sup = "or ".$analog_sql_sup;
            // ищем по поставщикам
              if((int)$this->input->post('ukr')>0){// опшук по складу 
                 $SQL="SELECT * FROM suppliers_products where product = '{$code}' or   product = '{$code1}' or REPLACE(REPLACE(product, '-', ''), ' ', '')='{$code1}'   $analog_sql_sup order by supplier";
                 $query = $this->db->query($SQL);
                 
                 $res =$query->result_array();
                 $cnt=$cnt+(int)sizeof($res);
            }
            // ищем по емиратам
            if((int)$this->input->post('emir')>0){// опшук по складу 
                    $SQL="SELECT DetailNum FROM emir where DetailNum = '{$code}' or   DetailNum = '{$code1}'  order by MakeLogo ";
                    $query = $this->db->query($SQL);
                    $res =$query->result_array();
                    $cnt=$cnt+(int)sizeof($res);
            
                    // ищем по емиратах SOAP        
                    $fp=fsockopen('http://emexonline.com',3000); 
                    if($fp){
                    $url="http://emexonline.com:3000/MaximaWS/service.wsdl";
                    $client = new SoapClient($url);  
                    $zaproz =array(

                        'Customer'=>array(
                            'Password' =>$this->user['MP_PASS'],
                            'CustomerId'=>$this->user['MP_CODE'],
                            'UserName' =>$this->user['MP_LOGIN']),
                        'ShowSubsts' =>'true',    
                        'DetailNum'=>$code);
                    $result = $client->SearchPart ($zaproz);


                    if(!empty($result->SearchPartResult->FindByNumber)) $cnt++;  
                    }
              }

            if($cnt>0)
            {
                $data=array('key'=>$code,'type'=>'code','date'=>date('Y-m-d'),
                'only'=>(int)$_POST['only_key'],
                'ukr'=>(int)$_POST['ukr'],
                'emir'=>(int)$_POST['emir'],
                'sklad'=>(int)$_POST['sklad'],
                'lik'=>$analog_sql_sup );
                $this->db->insert('search_result', $data);
                $id=$this->db->insert_id();
                $this->_save_user_code($code);
                return $id;
            }else {return 0;}

            
        }
     /*   function find_code_id($code='')
        {
            if(!isset($_POST['only_key'])) $_POST['only_key']=0;
            $code=mysql_escape_string($code);
            $cnt=0;
            $SQL="SELECT * FROM product where id>0 and ".$this->_sql_code($code,(int)$_POST['only_key']).' order by `group`,group_1,group_2';   
            $query = $this->db->query($SQL);

            $res =$query->result_array();
            $cnt=$cnt+(int)sizeof($res); // количество в наличии


            // ищем аналоги по emir_substs
            $code1=$code;
            $code = clear_code($code);
            $SQL="SELECT detailnums FROM emir_substs where detailnum ='{$code}'";
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            $analogs_list=array();
            $analog_sql =''; 
            if(sizeof($res)>0)
            {   
                $analog_sql=" REPLACE(REPLACE(product_name, '-', ''), ' ', '') IN  ('_____";
                foreach($res as $val)
                {
                    $analog_sql.="','".$val['detailnums'];
                }
                $analog_sql.="')";

                $analog_sql_sclad= str_replace('product_name','article',$analog_sql);
                $analog_sql_sup= str_replace('product_name','product',$analog_sql);
                $analog_sql_emir= str_replace('product_name','DetailNum',$analog_sql);

                // ищем аналоги по наличии
                $SQL="SELECT id FROM product where  {$analog_sql_sclad} order by `group`,group_1,group_2";
                $query = $this->db->query($SQL);
                $res =$query->result_array();
                $cnt=$cnt+(int)sizeof($res);

                // ищем аналоги по поставщикам
                $SQL="SELECT product FROM suppliers_products where  {$analog_sql_sup} order by supplier ";
                $query = $this->db->query($SQL);
                $res =$query->result_array();
                $cnt=$cnt+(int)sizeof($res);

                // ищем аналоги по емиратам
                $SQL="SELECT DetailNum FROM emir where  {$analog_sql_emir} order by MakeLogo";
                $query = $this->db->query($SQL);
                $res =$query->result_array();
                $cnt=$cnt+(int)sizeof($res);

            }

            // ищем по поставщикам
            $SQL="SELECT * FROM suppliers_products where product = '{$code}' or   product = '{$code1}' or REPLACE(REPLACE(product, '-', ''), ' ', '')='{$code1}' order by supplier";
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            $cnt=$cnt+(int)sizeof($res);

            // ищем по емиратам
            $SQL="SELECT DetailNum FROM emir where DetailNum = '{$code}' or   DetailNum = '{$code1}'  order by MakeLogo ";
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            $cnt=$cnt+(int)sizeof($res);


            // ищем по емиратах SOAP 







            $url="http://emexonline.com:3000/MaximaWS/service.wsdl";
            $client = new SoapClient($url);  
            $zaproz =array(

                'Customer'=>array(
                    'Password' =>$this->user['MP_PASS'],
                    'CustomerId'=>$this->user['MP_CODE'],
                    'UserName' =>$this->user['MP_LOGIN']),
                'ShowSubsts' =>'true',    
                'DetailNum'=>$code);
            $result = $client->SearchPart ($zaproz);


            if(!empty($result->SearchPartResult->FindByNumber)) $cnt++;  


            if($cnt>0)
            {
                $data=array('key'=>$code,'type'=>'code','date'=>date('Y-m-d'),'only'=>(int)$_POST['only_key'] );
                $this->db->insert('search_result', $data);
                $id=$this->db->insert_id();
                $this->_save_user_code($code);
                return $id;
            }else {return 0;}


        }
        */
        function find_group_id()
        {
            $code=mysql_escape_string($_POST['code_group']);
            $only=(int)mysql_escape_string($_POST['only_key']);

            $group=mysql_escape_string($_POST['group']);
            $group_1=mysql_escape_string($_POST['group_1']);
            $group_2=mysql_escape_string($_POST['group_2']);
            if($group=='null') {$group='';};
            if($group_1=='null') {$group_1='';};
            if($group_2=='null') {$group_2='';};
            $SQL='select id from product where  id>0';



            if(!($code=='')) {$this->db->where('orig_nums',$code); $SQL.=" and ".$this->_sql_code($code);};
            if(!($group=='')) {$this->db->where('group',$group); $SQL.=' and `group` = "'.$group.'"  ';};
            if(!($group_1=='')) {$this->db->where('group_1',$group_1); $SQL.=' and `group_1` = "'.$group_1.'"  ';};
            if(!($group_2=='')) {$this->db->where('group_2',$group_2); $SQL.=' and `group_2` = "'.$group_2.'"  ';};

            $query = $this->db->query($SQL);//print( $this->db->last_query());

            $count = $query->num_rows();
            if($count<1){return 0;}
            $this->_save_user_code($code);
            $data=array('group'=>$group,'group_1'=>$group_1,'group_2'=>$group_2,'type'=>'group','key'=>$code,'only'=>$only,'date'=>date('Y-m-d'));
            $this->db->insert('search_result', $data);
            $id=$this->db->insert_id();
            return $id;


        }

        function get_find_res($search)
        {


            $page=1;
            $code=$search['key'];
            $group=$search['group'];
            $group_1=$search['group_1'];
            $group_2=$search['group_2'];
            $SQL='SELECT *  FROM product where  id>0';
            if(!($code=='')) {$SQL.=' and  '.$this->_sql_code($code,$search['only']). '  ';};
            if(!($group=='')) { $SQL.=' and `group` = "'.$group.'"  ';};
            if(!($group_1=='')) { $SQL.=' and `group_1` = "'.$group_1.'"  ';};
            if(!($group_2=='')) { $SQL.=' and `group_2` = "'.$group_2.'"  ';};
            $order='';
            if(isset($_SESSION['manager'])){ $order =   " , sim  ";}
            $SQL=$SQL.' order by `group`,group_1,group_2 '.$order.'  LIMIT '.(($page-1)*500).' , 500 ';
            //print($SQL);
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return $res;
        }

        function get_find_res_add($search,$analog)// дополнительные результаты, поставщики и аналоги
        {
            $code=$search['key'];
            $code1=$code;
            $code = clear_code($code);

            $page=1;
            $SQL='SELECT *  FROM product where  id>0 ';
            if(!($code=='')) {
                if(sizeof($analog)>0)
                    $SQL.=' and ( '.$this->_sql_code($code)." ) or  REPLACE(REPLACE(article, '-', ''), ' ', '') in (".implode(',',$analog).")  ";
                else 
                    $SQL.=' and  '.$this->_sql_code($code)."  ";
            };
            $order='';
            if(isset($_SESSION['manager'])){ $order =   " , sim  ";}
            $result =array('sklad_analog'=>array(),'sup'=>array(),'sup_analog'=>array(),'emir'=>array(),'emir_analog'=>array());


            if(sizeof($analog)>0)
            {   

/*

                // ищем аналоги по наличии
                $SQL="SELECT * FROM product where REPLACE(REPLACE(article, '-', ''), ' ', '')     in (".implode(',',$analog).")   order by `group`,group_1,group_2";
                $query = $this->db->query($SQL);
                $res =$query->result_array();
                if(sizeof($res)>0) $result['sklad_analog'] =$res;

                // ищем аналоги по поставщикам
               // $SQL="SELECT suppliers_products.*,suppliers.cod,suppliers.discont,suppliers.post_1 ,suppliers.post_2  FROM suppliers_products left join suppliers
              //  on suppliers.id = suppliers_products.supplier where  REPLACE(REPLACE(product, '-', ''), ' ', '')   in (".implode(',',$analog).")    order by supplier ";
             //   $query = $this->db->query($SQL);

             //   $res =$query->result_array();
              //  if(sizeof($res)>0) $result['sup_analog'] =$res;

                // ищем аналоги по емиратам

                $SQL="SELECT * FROM emir   left join emir_company
                on emir_company.MakeLogo = emir.MakeLogo
                where DetailNum  in  (".implode(',',$analog).")    order by emir.MakeLogo";
                $query = $this->db->query($SQL);
                $res =$query->result_array();
                if(sizeof($res)>0) $result['emir_analog'] =$res;
*/
            }

            // ищем по поставщикам
            
            
            $SQL="SELECT suppliers_products.*,suppliers.cod,suppliers.discont ,suppliers.post_1   ,suppliers.post_2 FROM suppliers_products left join suppliers
            on suppliers.id = suppliers_products.supplier
            where product = '{$code}' or   product = '{$code1}'  or  REPLACE(REPLACE(product, '-', ''), ' ', '') = '{$code}'   order by supplier";
            $query = $this->db->query($SQL);
            $res =$query->result_array();

            if(sizeof($res)>0) $result['sup'] =$res;
              
                // ищем аналоги по поставщикам
                $SQL="SELECT suppliers_products.*,suppliers.cod,suppliers.discont,suppliers.post_1 ,suppliers.post_2  FROM suppliers_products left join suppliers
                on suppliers.id = suppliers_products.supplier where product='ч' {$search['lik']}   order by supplier ";
                $query = $this->db->query($SQL);

                $res =$query->result_array();
                if(sizeof($res)>0) $result['sup_analog'] =$res;

            // ищем по емиратам
            $SQL="SELECT * FROM emir left join emir_company
            on emir_company.MakeLogo = emir.MakeLogo
            where DetailNum = '{$code}' or   DetailNum = '{$code1}' order by  emir.MakeLogo ";

            $query = $this->db->query($SQL);
            $res =$query->result_array();
            if(sizeof($res)>0) $result['emir'] =$res;



            return $result;
        }

        function get_find_res_sup($search,$res,$add_analog=array())
        {


            $page=1;
            $code=$search['key'];
            $SQL="SELECT suppliers_products.*,suppliers.cod,suppliers.discont FROM suppliers_products
            LEFT JOIN suppliers on suppliers.id = suppliers_products.supplier
            where product like '%".str_replace('-','',$code)."%' or   product like '%{$code}%'

            "; 
            if($search['lik']!='') {
                
             $SQL = $SQL." ".$search['lik'];   
            }
          //  echo $SQL;
           // if(sizeof($add_analog)>0)  $SQL=$SQL." or product in (".implode(',',$add_analog).")";
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            //var_dump($res);
            return $res;
        }    

        function get_request($user,$day=0)
        {   
            if($day=='0'){

                $SQL='SELECT *  FROM user_request where user="'.$user.'" and time like"'.Date('Y-m-d').'%" order by title';     
            }else {
                $SQL='SELECT *  FROM user_request where user="'.$user.'" order by title';
            }


            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return $res;
        }
        function get_pay()
        {
            $SQL='SELECT *  FROM pay_in_out where user="'.$_SESSION['user']['id'].'" order by data desc,id desc';
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return $res;
        }
        function del_pay($id)
        {
            if($pay=$this->get_row($id,'pay_in_out'))
            {
                $user=$this->get_row($pay['user'],'users');
                if($pay['type']=='in')
                {
                    $SQL='UPdate users set balans=balans-'.(float)$pay['suma'].' where id='.$pay['user'];
                    if($pay['suma']>$user['balans']) {return 'Ошибка. Не сохранено. Результат минусовый баланс';}
                } else
                {
                    $SQL='UPdate users set balans=balans+'.(float)$pay['suma'].' where id='.$pay['user'];
                }
                $query = $this->db->query($SQL);
                $query = $this->db->query("DELETE from pay_in_out where id=$id");

            }
            return 'Сохранено';

        }
        function save_pay_post()
        {
            $id=(int)$_POST['id'];
            $_POST['user']=$_SESSION['user']['id'];
            $user=$this->get_row($_SESSION['user']['id'],'users');
            $pay_sum=$_POST['suma'];
            $rez=1;
            if($id>0)
            {
                $pay=$this->get_row($id,'pay_in_out');
                $pay_sum= $_POST['suma']-$pay['suma'];
            }
            $_POST['data']=convert_date($_POST['data'],2);
            if($_POST['type']=='in')
            {
                $rez= $user['balans']+(float)$pay_sum+$user['credit'];
            }
            else
            {
                $rez= $user['balans']-(float)$pay_sum+$user['credit'];;
            }
            if($_POST['type']=='in')
            {
                $SQL='UPdate users set balans=balans+'.(float)$pay_sum.' where id='.$_SESSION['user']['id'];
                if($rez<0  ) {return 'Ошибка. Не сохранено. Результат минусовый баланс';}
            } else
            {
                $SQL='UPdate users set balans=balans-'.(float)$pay_sum.' where id='.$_SESSION['user']['id'];
                if($rez<0) {return 'Ошибка. Не сохранено. Результат минусовый баланс';}
            }
            $keys=array_keys($_POST);
            $fields=$this->db->list_fields('pay_in_out');
            foreach($fields as $key)
            {
                if(!isset($_POST[$key]) ) {$_POST[$key]='&mdash;';}
                elseif($_POST[$key]==''){$_POST[$key]='&mdash;';}
            }
            $new_id= $this->save_POST('pay_in_out');
            $this->db->query($SQL);
            if($id=='0')
            {
                $user=$this->get_row($_SESSION['user']['id'],'users');
                $SQL="update pay_in_out set balans='".$user['balans']."' where id=$new_id";
                $this->db->query($SQL);

            }else
            {
                if($_POST['type']=='in') {$balance=$_POST['balans']+$pay_sum;} else  {$balance=$_POST['balans']-$pay_sum;}
                $SQL="update pay_in_out set balans='".$balance."' where id=$id";
                $this->db->query($SQL);
            }
            return 'Сохранено';
        }


        function get_user_orders($user_id, $status='0')
        {
            $SQL='SELECT *  FROM orders where user="'.$user_id.'" and status="'.$status.'" order by   data desc';
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return $res;
        }
        function get_orders( $status='0',$user='',$show='',$find=0,$type='all')
        {
            if($show==''){$add='';} else{$add=' and `show`>0 ';}    
            if($type!='all') $add_where ="  and (type='{$type}')  ";  
            if($status==3) $status=2; elseif($status==2)$add_where ='  and (data>"'.Date('Y-m-d',(Time()-86400*7)).'") and (status="2")  ';  
            else{
                $add_where=' and status="'.$status.'"  ';                                        
                if($status==1 and (int)$user>0)$add_where ='  and (status="1" or status="0")  ';
            }                                                                                  

            if($type!='all') $add_where .="  and (type='{$type}')  ";
            if($find>0)
            { $add_where='';

                if($this->input->post('n_order'))  {$add_where.=" and id='".$_POST['n_order']."' ";}
                if($this->input->post('n_card'))  {$add_where.=" and card like '%".$_POST['n_card']."%' ";}
                if($this->input->post('n_nacl'))  {$add_where.=" and nakladna like '%".$_POST['n_nacl']."%' ";}
                if($this->input->post('o_s_f_date_from'))  {$add_where.=" and data>=  '".convert_date($_POST['o_s_f_date_from'],2)."' ";}
                if($this->input->post('o_s_f_date_to'))  {$add_where.=" and data<=  '".convert_date($_POST['o_s_f_date_to'],2)."' ";}
            }
            if($user=='') {$SQL='SELECT *  FROM orders where id>0 '.$add.$add_where.'  order by   data desc,id desc';}
            else   {$SQL='SELECT *  FROM orders where  user="'.(int)$user.'"  '.$add.$add_where.' order by   data desc,id desc';}
            // print($SQL);
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return $res;
        }
        function get_orders_all_details_tab( $orders)
        {
            $data=array();
            foreach($orders as $order)
            {
                $data[$order['id']] = $this->get_orders_detail($order['id']);
            }
            return $data;
        }
        function get_orders_detail($id)
        {
            $SQL='SELECT product.group,
            product.group_1,
            product.group_2,
            orders.name,
            orders.fullname,
            orders.card,

            order_details.*  FROM order_details left join product on product.id=order_details.prod_id
            left join orders on orders.id=order_details.order_id
            where order_id ="'.(int)$id.'" order by   id desc';
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return $res;
        }
        function get_all_orders_detail($status,$user=0,$find=0,$type='all',$type_order='all')
        {
            // if($status==3) $status=2; 
            $add_where='';
            if($find>0)
            {
                if($this->input->post('p_order'))  {$add_where.=" and order_details.article like '%".$_POST['p_order']."%'";}
                if($this->input->post('n_card'))  {$add_where.=" and orders.card like '%".$_POST['n_card']."%' ";}
                if($this->input->post('o_s_f_date_from'))  {$add_where.=" and orders.data>=  '".convert_date($_POST['o_s_f_date_from'],2)."' ";}
                if($this->input->post('o_s_f_date_to'))  {$add_where.=" and orders.data<=  '".convert_date($_POST['o_s_f_date_to'],2)."' ";}
            }

            if($type_order!='all')  {$add_where.=" and order_details.type = '".$type_order."' ";}
            if($type!='all')  {$add_where.=" and   orders.data>'".Date('Y-m-d',(Time()-86400*7))."'";}
            $status_str = 'where order_details.status>0 ';
            if($status==0){
                $status_str = " where order_details.status='0'  ";
            }elseif($status==1){
                $status_str = " where (
                order_details.status='0' or
                order_details.status='InWork' or 
                order_details.status='Purchased' or
                order_details.status='ReadyToSend' or
                order_details.status='Send' or 
                order_details.status='ReadyMy'  )  ";


            }elseif($status==2){
                $status_str = " where (order_details.status='NotAvailable' or 
                order_details.status='SendMy' or
                order_details.status='AGREE'   )
                ";
            }elseif($status==3){
                $status_str = " where (order_details.status='NotAvailable' or 
                order_details.status='SendMy' or
                order_details.status='AGREE'   )


                ";
            }
            if($user>0){$user='and orders.user='.(int)$user;}else {$user=' ';};
            $SQL='SELECT product.group,
            product.group_1,
            orders.id as num,
            orders.data as o_data,
            orders.name,
            orders.fullname,
            orders.card,
            orders.nakladna	,orders.dekl	,
            orders.valuta,
            product.group_2,
            order_details.*  FROM order_details left join product on product.id=order_details.prod_id
            left join orders on orders.id=order_details.order_id
            '.$status_str.$user.$add_where.'  order by product.group,
            product.group_1,
            product.group_2';
            //print($SQL);
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return $res;
        }



        function _save_user_code($code)
        {
            if($code==''){return false;};
            if(isset($_SESSION['user']))  {$user=$_SESSION['user']['id'];$user_name=$_SESSION['user']['name'];} else {$user_name='Гость';$user='Гость';};
            $query=   $this->db->query("SELECT id from  user_request  where title='$code' and user='$user'");
            if($ress=$query->result_array())
            {
                $this->db->query("UPDATE  user_request set `time`='".Date("Y-m-d H:i")."',`cnt`=cnt+1  where title='$code' and user='".$user."' ");
            }
            else
            {
                $this->db->query("INSERT INTO user_request values ('','$code','".Date("Y-m-d H:i")."','1','$user','".$user_name."')");
            }

        }
        function get_user_names()
        {
            $query = $this->db->query("select * from users order by card");
            $data=array();
            $res =$query->result_array();
            foreach($res as $val)
            {
                $str=$val['card']." ".$val['name']." ".$val['fullname'];
                if($val['user_type']=='manager') {$str.=' - менеджер';}
                $data[]=$str;
            }
            return $data;
        }

        function get_row_ukr($id) // вибір запису з таблиці по ИД
        {

            $query = $this->db->query("select suppliers_products.*, suppliers.discont,suppliers.cod    from suppliers_products 
                left join suppliers on suppliers.id =  suppliers_products.supplier
                where suppliers_products.id='".(int)$id."' ");
            $data = $query->result_array();
            if(sizeof($data)>0) {return $data[0];} else {return false;};
        }

        function get_row_mp($id) // вибір запису з таблиці по ИД
        {

            $query = $this->db->query("select *   from mp_searh where id='".(int)$id."' ");
            return   $query->row_array();

        }

        function rand_article(){
            $SQL='SELECT * from  product where article<>"" ORDER BY RAND() limit 1';
            $query = $this->db->query($SQL);
            $res =$query->result_array();
            return  $res[0]['article'];
        }  
        function get_image_by_article($item)
        {

            $item =   str_replace(' ','',$item);
            $item =   str_replace('-','',$item);
            $item =   str_replace('neuheit','',$item);
            $item =   str_replace(',','',$item);            
            $SQL='SELECT * from  items_id where article="'.$item.'" or articles like"%-'.$item.'-%" ORDER BY RAND() limit 1'; 
            $query = $this->db->query($SQL);
            $res =$query->row_array();
            return $res;    
        }
                    
        function save_images_articles($item_id,$articles)
        {
             
            echo $item_id.$articles;
            $query = $this->db->query("select *   from items_id where id='".(int)$item_id."' ");
             var_dump($row);
            $row =    $query->row_array();
            if($row){
               $this->db->set('articles',$row['articles'].$articles); 
               $this->db->where('id',$item_id);
               $this->db->update('items_id');
            }   
        }

        function get_banners()
        {   $this->db->order_by('num');
            $query = $this->db->get('banners');
            return $query->result_array();
        }
        
        function get_banner ($id)
        {   $this->db->where('id',$id);
            $query = $this->db->get('banners');
            return $query->row_array();
        }
        
        function del_banner ($id)
        {   $this->db->where('id',$id);
            $query = $this->db->delete('banners');  
        } 
        
        function save_banner($id,$text,$num)
        {   
            $this->db->set('text',$text);
            $this->db->set('num',$num);
            if((int)$id<1)$this->db->insert('banners');  
            else{
                $this->db->where('id',$id);
                $this->db->update('banners');
            }  
        }   
          function save_images_to_article($id)
        {   
            
                for($i=1;$i<7;$i++){ 
                    if (is_uploaded_file($_FILES['im_'.$i]['tmp_name'])) {
                        $image[$i] = "f{$i}_".md5(time()."_image_{$i}").$_FILES['im_'.$i]['name']; 
                        move_uploaded_file( $_FILES["im_{$i}"]["tmp_name"], "i/febest/{$image[$i]}");
                    } 
                }   
                  for($i=1;$i<7;$i++){
                      if(isset($image[$i]))
                      if(is_file("i/febest/{$image[$i]}"))
                      {
                        $this->db->set('image_'.$i,$image[$i]);    
                      } else unset($image[$i]);
                  }   
            
                    if(sizeof($image)>0){
                     $this->db->where('id',$id); 
                     $this->db->update('items_id');
                    }
                   // echo $this->db->last_query();die;
                
        }
         function save_image_articles($id,$text)
        {   
                $this->db->set('articles',$text); 
                $this->db->where('id',$id);
                $this->db->update('items_id');
               // echo $this->db->last_query();
              
        } 
         function del_foto($id,$art)
        {   
                $this->db->set('image_'.$id,''); 
                $this->db->where('article',$art);
                $this->db->update('items_id');
               // echo $this->db->last_query();
              
        } 
 function rand_banner()
        {   
                if(!isset($_SESSION['rand_banners']))$_SESSION['rand_banners'] = array();
                $sel_image =false;
                $query= $this->db->query("select * from catalog_images");   
                $images=$query->result();
                if(!$images) return "/i/header_img.jpg";
                foreach($images as $im){
                    if(isset($_SESSION['rand_banners'][$im->id])) continue;
                    $_SESSION['rand_banners'][$im->id] =1;
                    $sel_image = $im; break;
                }
                if($sel_image) return "/i/banners/".$sel_image->image;
                    else {
                        $_SESSION['rand_banners'] = array();
                        $_SESSION['rand_banners'][$images[0]->id] =1;
                        return "/i/banners/".$images[0]->image;   
                    }
              
        } 
    
    }


    // 


?>
