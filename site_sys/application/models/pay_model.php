<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    // работа с балансом и платежами

    class Pay_model extends Model
    { 
        function Pay_model()
        {
            parent::Model(); 
        }

        //добавление платежа по заказу и смена баланса
        function add_pay_order($order_id)
        {
            $this->db->where('id',$order_id); 
            $query = $this -> db -> get ( 'orders' );
            $order =  $query -> row();  
            if(!$order) return false; //получаем заказ

            $this->db->where('order_id',$order_id); 
            $this->db->where('type','out'); 
            $query = $this -> db -> get ( 'pay_in_out' );
            $pay =  $query -> row();          
            if($pay) return false; // заказ уже есть в таблице платежей

            $this->db->where('id',$order->user);  
            $query = $this -> db -> get ( 'users' );
            $user =  $query -> row();          
            if(!$user) return false; // получаем пользователя

            $balance = $user->balans-$order->summ;
            // ставим данные платежа  suma     balans     text
            $this->db->set('suma',($order->summ));
            $this->db->set('balans',$balance);
            $this->db->set('order_id',$order->id);
            $this->db->set('user',$_SESSION['user']['id']);
            $this->db->set('data',Date('Y-m-d'));
            $this->db->set('type','out');
            $this->db->set('text','&mdash;');
            $this -> db -> insert ( 'pay_in_out' );
            // меняем данные баланса пользователя    balans
            $this->refresh_user_balance($user->id); 

            return true;

        }  
        
        // добавление платежа вручную 
        function add_pay($data)
        {
            //проверка на повтор
            $this->db->where($data);
            $query = $this->db->get('pay_in_out');
            $find = $query -> row();  
            if(!$find){
                $this->db->set($data); 
                $this -> db -> insert ( 'pay_in_out' );
                // меняем данные баланса пользователя    balans
                $this->refresh_user_balance($data['user']);
            }
        }      

        // редактирование платежа
        function edit_pay($data,$id)
        {
            $this->db->where('id',$id); 
            $query = $this -> db -> get ( 'pay_in_out' );
            $pay =  $query -> row();          
            if(!$pay) return false; // получаем платеж

            if($pay->order_id>0){// изменить суму и в заказе если платеж по заказу
                $this->db->set('summ',$data['suma']); 
                $this -> db -> where ( 'id',$pay->order_id );
                $this -> db -> update ( 'orders' );
            }
            $rizn = ($data['suma']-$pay->suma);
            if($pay->type=='in')$data['balans'] = number_format(($pay->balans+$rizn),2,'.','');    
            else $data['balans'] = number_format(($pay->balans-$rizn),2,'.','');    
            $this->db->set($data); 
            $this -> db -> where ( 'id',$id );
            $this -> db -> update ( 'pay_in_out' );
            // меняем данные баланса пользователя    balans
            $this->refresh_user_balance($pay->user);
        }      
        
        //изменение суммы в таблице платежей и балансе при изменении суммы заказа
        function change_pay_summ_by_order($order_id)
        {
            $this->db->where('id',$order_id); 
            $query = $this -> db -> get ( 'orders' );
            $order =  $query -> row();  
            if(!$order) return false; //получаем заказ

            $this->db->where('order_id',$order_id); 
            $this->db->where('type','out'); 
            $query = $this -> db -> get ( 'pay_in_out' );
            $pay =  $query -> row();          
            if(!$pay) return false; // получаем платеж

            $this->db->where('id',$order->user);  
            $query = $this -> db -> get ( 'users' );
            $user =  $query -> row();          
            if(!$user) return false; // получаем пользователя

            if( number_format(($order->summ),2,'.','')== number_format(($pay->suma),2,'.','')) return true; // если сумма не менялась ничего не делаем
            $rizn = ($pay->suma-$order->summ); //получаем изменение

            // меняем данные платежа  suma     balans     text
            $this->db->set('suma',($pay->suma-$rizn));
            $this->db->set('balans',($pay->balans+$rizn));
            $this->db->set('text',$pay->text." изм.({$rizn}) ".Date('d.m.Y'));
            $this->db->where('id',$pay->id);  
            $this -> db -> update ( 'pay_in_out' );
            // меняем данные баланса пользователя    balans
            $this->refresh_user_balance($user->id);

            return true;

        }

        //пересчет баланса пользователя
        function refresh_user_balance($user_id)
        {
            $query = $this->db->query("SELECT sum( suma )  as suma
                FROM `pay_in_out` 
                WHERE user ={$user_id}
                AND TYPE = 'out'");
            $out =  $query -> row();    

            $query = $this->db->query("SELECT sum( suma ) as suma
                FROM `pay_in_out` 
                WHERE user ={$user_id}
                AND TYPE = 'in'");
            $in =  $query -> row();     
            $summ = number_format(($in->suma-$out->suma),2,'.','');    
            $this->db->query("UPDATE `users`  
                set balans   ='{$summ}'
                WHERE id = '{$user_id}'");

        }
        
        function get_my_pays()
        {
            $SQL='SELECT *  FROM pay_in_out where user="'.(int)$_SESSION['user']['id'].'" order by data desc,id desc';
            $query = $this->db->query($SQL);
            return $query->result_array(); 
        }

        function del_pay($id)
        { 
            $query = $this->db->query("SELECT * from pay_in_out where id=$id");
            $pay =  $query -> row();  
            if(!$pay) return false;  
            $this->db->query("DELETE from pay_in_out where id=$id");
            $this->refresh_user_balance($pay->user);
        }


    }
?>