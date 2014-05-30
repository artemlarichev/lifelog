<?php
class User extends Controller {
    
    function User(){
        session_start();
        parent::Controller();
        
        $this->load->model('data_model', 'data');
        $this->load->helper('my_func', 'cookie');
                
        header('Content-Type: text/html; charset=UTF-8');
    }
    
    function enter() {
        $this->load->view('user/enter');
    }
    
    function register() {
        
        if($_COOKIE['reg_ok_cookie'] == 1) {
            $this->load->view('user/register_ok');
        } else {
            $this->load->view('user/register');
        }
    }
    
    // email checking... ^^
    function is_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    function ajax_register() {
        $email = $_POST['reg_email'];
        $pass = $_POST['reg_pass'];
        $pass2 = $_POST['reg_pass2'];
        $count = (int)$_POST['reg_count'];
        $user_type = 'user'; // тип пользователя
        //$card = rand(20000,70000);
                        
        if(!empty($email)) {
            $sql = "SELECT * FROM `users` WHERE `email` = '" . $email . "'";
            $query = $this->db->query($sql);
            $result = $query->result_array();
            
            if($result[0]['email'] === $email) {
                print("email_exists"); 
                exit();
            }
            
            if(!$this->is_email($email)) {
                print("wrong_format");
                exit();
            }
        } else {
            print('empty_email');
            exit();
        }
        
        if(!empty($pass)) {
            if(strlen($pass) < 5 || strlen($pass) > 25) {
                print('pass_length');
                exit();
            }
        } else {
            print('empty_pass');
            exit();
        }
        
        if(!empty($pass2)) {
            if($pass2 !== $pass) {
                print('dont_match');
                exit();
            }
        } else {
            print('empty_pass2');
            exit();
        }
        
        if(!empty($count)) {
            if(!is_numeric($count)) {
                print('not_int');
                exit();
            }
        } else {
            print('empty_count');
            exit();
        }
        
        $password = md5(md5($pass));
        $check_card = "SELECT * FROM `users` WHERE `card` = '" . $card . "'";
        $check = $this->db->query($check_card);
        if($check) {
            unset($card);
            $card = rand(20000,70000);
        }
        
        $last_card = "SELECT * FROM `users` ORDER BY `id` DESC LIMIT 1";
        //$get = $this->db->query($last_card);
        $get = mysql_query($last_card);
        $a = mysql_fetch_array($get);
        $nc = $a['card'] + 1;
        
        $ins = "INSERT INTO `users`(card,email,pass,credit,user_type,discont)
                    VALUES('$nc', '$email', '$password', '$count', '$user_type', 5)";
        $q = $this->db->query($ins);
        if($q) {
            $last_id = $this->db->insert_id();
            $u = "SELECT `card`,`email` FROM `users` WHERE `id` = '" . $last_id . "'";
            $c = $this->db->query($u);
            $r = $c->result_array();
            
            $card_number = $r[0]['card'];
            $email_address = $r[0]['email'];
            
            setcookie('reg_ok_cookie', 1, time() + 60);  // for 1 min
            
            // отправляем письмецо
            $subj = "Регистрация на сайте japan-auto.kiev.ua";
            $msg = "
                <html>
                    <head><title>Успешная регистрация</title></head>
                    <body>
                        Вы зарегистрировались на сайте new.japan-auto.kiev.ua. <br/>
                        Номер карточки: <b>".$card_number."</b> <br/>
                        Пароль: используйе пароль, введенный при регистрации.<br/>
                    </body>
                </html>
            ";
            $headers = "Content-type: text/html; charset=utf-8 \r\n";
            $headers .= "From: Support <support@japan-auto.kiev.ua>\r\n";
            
            mail($email_address, $subj, $msg, $headers);
        }
    }
    
    function recover() {
        if($_COOKIE['recover_ok_cookie'] == 1) {
            $this->load->view('user/recover_ok');
        } else {
            $this->load->view('user/recover');
        }
    }
    
    function ajax_recover() {
        $email = $_POST['recover_email'];
        
        if(empty($email)) {
            print('empty_recover_email');
            exit();
        } else {
            if(!$this->is_email($email)) {
                print('wrong_email_format');
                exit();
            }
            
            $q = "SELECT * FROM `users` WHERE `email` = '" . $email . "'";
            $query = $this->db->query($q);
            $result = $query->result_array();
            if($result) {
                $new = $this->passGen(10);
                $up = "UPDATE `users` SET `pass` = '" . md5(md5($new)) . "' WHERE `id` = '" . $result[0]['id'] . "'";
                $update = $this->db->query($up);
                if($update) {
                    $subj = "Восстановление пароля";
                    $msg = "
                        <html>
                            <head><title>Восстановление пароля</title></head>
                            <body>
                                Восстановление пароля!
                                Ваш номер карточки: <b>" . $result[0]['card'] . "</b><br/>
                                Ваш новый пароль: <b>" . $new . "</b>
                            </body>
                        </html>
                    ";
                    $headers = "Content-type: text/html; charset=utf-8 \r\n";
                    $headers .= "From: Support <support@japan-auto.kiev.ua>\r\n";
                    
                    mail($email, $subj, $msg, $headers);
                    setcookie('recover_ok_cookie', 1, time() + 60);
                }
            } else {
                print('not_found');
                exit();
            }
        }
        
    }
    
    function passGen($number) {
        $arr = array('a','b','c','d','e','f',  
                 'g','h','i','j','k','l',  
                 'm','n','o','p','r','s',  
                 't','u','v','x','y','z',  
                 'A','B','C','D','E','F',  
                 'G','H','I','J','K','L',  
                 'M','N','O','P','R','S',  
                 'T','U','V','X','Y','Z',  
                 '1','2','3','4','5','6',  
                 '7','8','9','0','.',',',  
                 '(',')','[',']','!','?',  
                 '&','^','%','@','*','$',  
                 '<','>','/','|','+','-',  
                 '{','}','`','~');
        
        $pass = "";
        for($i = 0; $i < $number; $i++) {
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        
        return $pass;
    }
}