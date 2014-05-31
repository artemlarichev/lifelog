<?php

class Catalog extends Controller {

    var $conf = array();
    var $user_names = array();
    var $mp_status = array(0 => 'Новый',
        'InWork' => 'В работе',
        'NotAvailable' => 'Нет в наличии ',
        'Purchased' => 'Закуплено',
        'ReadyToSend' => 'Готово к отправке',
        'Send' => 'Отправлено поставщиком',
        'ReadyMy' => 'Готово к выдаче',
        'SendMy' => 'Выдано',
        'AGREE' => 'Превишение цены');

    function Catalog() {
        if (isset($_SESSION['user']['valuta'])) {
            $_SESSION['valuta'] = $_SESSION['user']['valuta'];
        };
        if (!isset($_SESSION['valuta'])) {
            $_SESSION['valuta'] = 'грн';
        };
        if (!isset($_SESSION['basket']) or !isset($_SESSION['basket_data'])) {
            $_SESSION['basket'] = array();
            $_SESSION['basket_data'] = array('count' => 0, 'sum' => '0', 'val' => $_SESSION['valuta']);
        };
        parent::Controller();
        $this->load->model('data_model', 'data');
        $this->load->model('article_model', 'article');
        $this->load->model('megaparts_model', 'megaparts');

        if (isset($_SESSION['user']['id'])) {
            $_SESSION['user'] = $this->data->get_row($_SESSION['user']['id'], 'users');
        }
        if (isset($_SESSION['manager'])) {
            $this->user_names = $this->data->get_user_names();
        }

        $SQL = 'SELECT * from  product where article<>"" ORDER BY RAND() limit 1';
        $query = $this->db->query($SQL);
        $res = $query->result_array();
        $this->conf['key'] = $res[0]['article'];

        $SQL = 'SELECT * from  suppliers where id="4" ';
        $query = $this->db->query($SQL);
        $res = $query->result_array();
        if (sizeof($res) > 0)
            $this->conf['emir_disc'] = $res[0]['discont'];
        else
            $this->conf['emir_disc'] = 20;



        $SQL = "SELECT * from site_config  ";
        $query = $this->db->query($SQL);
        $res = $query->result_array();
        foreach ($res as $val) {
            $this->conf[$val['name']] = $val['text'];
        }
        $this->conf['margins'] = unserialize($this->conf['margins']);
        $this->conf['nacenka'] = 1 + $this->conf['nacenka'] / 100;
        $this->conf['DostPtrice'] = 8;
        if (isset($_SESSION['user']))
            $this->conf['nacenka_emir'] = 1;
        if (isset($_SESSION['user']))
            if ($_SESSION['user']['DostPtrice'] > 0)
                $this->conf['DostPtrice'] = $_SESSION['user']['DostPtrice'];

        if (isset($_SESSION['user'])) {
            $this->conf['nacenka'] = 1 - (int) $_SESSION['user']['discont'] / 100;
        };


        if (isset($_SESSION['user']['disc_type_sup'])) {
            if (isset($this->conf['margins'][$_SESSION['user']['disc_type_sup']])) {
                $this->conf['discont'] = $this->conf['margins'][$_SESSION['user']['disc_type_sup']];
            }









































































            
                else$this->conf['discont'] = $this->conf['margins']['rozn'];
        }else
            $this->conf['discont'] = $this->conf['margins']['rozn'];

        if (isset($_SESSION['basket_data']['val'])) {
            if ($_SESSION['basket_data']['val'] != 'грн')
                $conf['kurs'] = 1;
        }
    }

    // поиск с каталога catalog.japan-auto.kiev.ua
    function catalog_search($code) {
        $res_id = $this->data->find_code_id(mysql_escape_string($code), 1);
        if ($res_id > 0)
            header("location:/search/result/$res_id");
        else
            $this->load->view('not_found_cod');
    }

    //главная страница сайта
    function index() {
        $data = array('conf' => $this->conf);
        $data['search_type'] = 'code';
        $data['top_image'] = 0;
        $data['keys'] = $this->article->get_keywords();
        $data['group'] = $this->data->get_groups();
        $data['articles'] = $this->article->last_articles(5);
        $data['cats'] = $this->article->get_cats();
        $data['index_page'] = $this->data->get_row('index', "pages", 'url');
        $data['sub_group'] = array();
        $data['news'] = $this->data->get_full_table('news', 'id desc');
        foreach ($data['group'] as $group) {
            $data['sub_group'][$group['group']] = $this->data->get_groups('1', $group['group']);
        }
        $data['group_1'] = array();
        $data['group_2'] = array();
        if (isset($_SESSION['manager'])) {
            $this->load->view('manager/index_page', $data);
            return false;
        }
        $this->load->view('index_page', $data);
    }

    //страница отдельной запчасти с наличия
    function parts($id, $del_foto = 0) {
        $data['part'] = $this->data->get_row((int) $id, 'product');
        if (isset($_SESSION['manager'])) {
            if ($this->input->post('im_id'))
                $this->data->save_image_articles($this->input->post('im_id'), $this->input->post('articles'));
            if ($del_foto > 0)
                $this->data->del_foto($del_foto, $data['part']['article']);
            if ($this->input->post('images_id'))
                $this->data->save_images_to_article($this->input->post('images_id'));
        }
        $data['group'] = $this->data->get_groups();
        $data['search_type'] = 'code';
        $data['group_1'] = array();
        $data['group_2'] = array();
        if ($data['part'] = $this->data->get_row((int) $id, 'product')) {
            $data['meta_title'] = "{$data['part']['article']} {$data['part']['manuf']} {$data['part']['group']} {$data['part']['group_1']} {$data['part']['group_2']}Запчасти На Японские Авто Джапан Авто";
            $data['meta_desc'] = "{$data['part']['article']} {$data['part']['manuf']} {$data['part']['group']} {$data['part']['group_1']} {$data['part']['group_2']}Запчасти На Японские Авто ";
            $data['meta_keys'] = "{$data['part']['article']}, {$data['part']['orig_nums']},{$data['part']['manuf']}, {$data['part']['group']}, {$data['part']['group_1']}, {$data['part']['group_2']}, Запчасти, Японские, Авто";

            $this->load->view('part', $data);
        } else {
            $this->load->view('not_found', $data);
        }
    }

    //текстовая страница
    function page($url) {
        $data['group'] = $this->data->get_groups();
        $data['search_type'] = 'code';
        $data['group_1'] = array();
        $data['group_2'] = array();
        $data['top_image'] = 2;
        if ($data['page'] = $this->data->get_row(mysql_escape_string($url), 'pages', 'url')) {
            $this->load->view('page', $data);
        } else {
            $this->load->view('not_found', $data);
        }
    }

    // поиск в форме на сайте по коду 
    function ajax_search($type) {
        if ($type == 'code') {
            echo $this->data->find_code_id($_POST['code']);
        } elseif ($type == 'group') {
            echo $this->data->find_group_id();
        } else {
            print(0);
        }
    }

    // поиск в форме на сайте по групам 
    function ajax_group($level = '1') {
        $this->db->query("SET NAMES `utf8`");
        $add = '';
        if (isset($_POST['find_id'])) {
            if ($search = $this->data->get_row((int) $_POST['find_id'], 'search_result')) {
                $add = ' and ' . $search['sql'];
                $_SESIION['find_id'] = $_POST['find_id'];
            }
        }
        if (isset($_POST['ses_group'])) {
            $_SESIION['ses_group'] = $_POST['ses_group'];
        };
        if (isset($_POST['ses_group_1'])) {
            $_SESIION['ses_group_1'] = $_POST['ses_group_1'];
        };
        if (isset($_POST['ses_group_2'])) {
            $_SESIION['ses_group_2'] = $_POST['ses_group_2'];
        };
        if ($level == '1') {
            $data = $this->data->get_groups((int) $level, mysql_escape_string($_POST['group']), '', $add);
        }
        if ($level == '2') {
            $data = $this->data->get_groups((int) $level, mysql_escape_string($_POST['group']), mysql_escape_string($_POST['group_1']), $add);
        }
        if (sizeof($data) > 0) {
            $result = array();
            foreach ($data as $val) {
                $result[] = $val['group'];
            }
            print(json_encode($result));
        } else {
            print(0);
        }
    }

    //отображение результатов поиска запчастей 
    function search_result($id, $page = '') {

        error_reporting(E_ALL);
        $Data = trim(date("Y-m-d ", mktime(date('H'), date('i'), date('s'), date('m'), date('d') - 2, date('Y'))));

        $this->db->query("DELETE from search_result where `date`<'$Data'");



        $data = array('conf' => $this->conf);
        if ($search = $this->data->get_row((int) $id, 'search_result')) {
            $data['search'] = $search;
            if ($search['only'] > 0) {
                $data['only'] = 1;
            }
            if ($search['sklad'] == 0) {
                $data['s_sklad'] = 1;
            }
            if ($search['ukr'] == 0) {
                $data['s_ukr'] = 1;
            }
            if ($search['emir'] == 0) {
                $data['s_emir'] = 1;
            }
            if (isset($_POST['group'])) {
                $search['group'] = mysql_escape_string($_POST['group']);
                if ($_POST['group'] == '') {
                    $_POST['group_1'] = '';
                    $_POST['group_2'] == '';
                }
                if ($_POST['group_1'] == '') {
                    $_POST['group_2'] == '';
                }
            };
            if (isset($_POST['group_1'])) {
                $search['group_1'] = mysql_escape_string($_POST['group_1']);
            };
            if (isset($_POST['group_2'])) {
                $search['group_2'] = mysql_escape_string($_POST['group_2']);
            };
            $data['search_type'] = $search['type'];
            if ($search['type'] == 'group')
                $data['no_art'] = 1;

            if (!($search['group'] == '')) {
                $data['sel_group'] = mysql_escape_string($search['group']);
            }
            if (!($search['group_1'] == '')) {
                $data['sel_group_1'] = mysql_escape_string($search['group_1']);
            }
            if (!($search['group_2'] == '')) {
                $data['sel_group_2'] = mysql_escape_string($search['group_2']);
            }
            $data['group'] = $this->data->get_groups();
            // $data['group']=$this->data->get_groups();
            $data['group_1'] = array();
            $data['group_2'] = array();
            //    print_r($search);
            $data['res_group'] = $this->data->get_groups('', '', '', $search['key'], $search['only']);

            if ($search['group'] == '') {
                $data['res_group_1'] = array();
            } else {
                $data['res_group_1'] = $this->data->get_groups(1, $search['group'], '', $search['key'], $search['only']);
                $data['group_1'] = $this->data->get_groups(1, $search['group'], '', $search['key'], $search['only']);
            };

            if ($search['group_1'] == '') {
                $data['res_group_2'] = array();
            } else {
                $data['res_group_2'] = $this->data->get_groups(2, $search['group'], $search['group_1'], $search['key'], $search['only']);
                $data['group_2'] = $this->data->get_groups(2, $search['group'], $search['group_1'], $search['key'], $search['only']);
            };

            $data['f_id'] = $id;
            $data['result'] = $this->data->get_find_res($search);
            $data['result_add'] = array('sklad_analog' => array(), 'sup' => array(), 'sup_analog' => array(), 'emir' => array(), 'emir_analog' => array());
            if ($search['type'] == 'code') {
                $logo = $page;
                if ($logo != '') {
                    $logo = "AND makelogo ='{$logo}'";
                };
                // тут создаем таблицы для илюстрации поиска
                $SQL = "SELECT * from Substs where detailnum='" . $search['key'] . "'  $logo";

                $data['tab1'] = $query = $this->db->query($SQL)->result_array();
                //  print_r($data['tab1']);
                $analog = array("'start'");
                $makelogo = array("'start'");
                foreach ($data['tab1'] as $val) {
                    //if(strlen($val['detailnums'])<10) 
                    continue;
                    if (!in_array("'" . trim($val['detailnums']) . "'", $analog))
                        $analog[] = "'" . trim($val['detailnums']) . "'";
                    if (!in_array("'" . trim($val['makelogo'] . "'"), $makelogo))
                        $makelogo[] = "'" . $val['makelogo'] . "'";
                }
                // print_r($makelogo);
                $SQL = "SELECT * from emir_company where MakeLogo in(" . implode(',', $makelogo) . ")";
                //print($SQL);
                $data['makelogo'] = $query = $this->db->query($SQL)->result_array();

                $SQL = "SELECT * from Substs where detailnum in(" . implode(',', $analog) . ") $logo ";

                $data['tab2'] = $query = $this->db->query($SQL)->result_array();
                $analog2 = array();
                foreach ($data['tab2'] as $val) {
                    if (strlen($val['detailnums']) < 5)
                        continue;
                    if (!in_array("'" . trim($val['detailnums']) . "'", $analog2))
                        $analog2[] = "'" . trim($val['detailnums']) . "'";
                }
                $data['analog'] = $analog;
                $data['analog2'] = $analog2;


                $all_analog = array();

                foreach ($analog as $val) {
                    if (!in_array($val, $all_analog))
                        $all_analog[] = $val;
                }
                foreach ($analog2 as $val) {
                    if (!in_array($val, $all_analog))
                        $all_analog[] = $val;
                }

                if (sizeof($all_analog) < 15) {// ищем еще раз аноли по аналогах 
                    $SQL = "SELECT * from Substs where detailnum in(" . implode(',', $all_analog) . ") ";

                    $data['tab3'] = $query = $this->db->query($SQL)->result_array();
                    $analog3 = array();
                    foreach ($data['tab3'] as $val) {
                        if (!in_array("'" . trim($val['detailnums']) . "'", $all_analog))
                            $all_analog[] = "'" . trim($val['detailnums']) . "'";
                    }
                }



                $data['all_analog'] = $all_analog;

                //  $SQL="SELECT * from emir where DetailNum in(".implode(',',$all_analog).")"; 
                //$data['tab_emir']=   $query = $this->db->query($SQL)->result_array();
                // $data['result_sup'] = $this->data->get_find_res_sup($search,$data['result'],$all_analog);
                $data['result_add'] = $this->data->get_find_res_add($search, $all_analog);
            }
            if ((!($search['key'] == '')) and $search['type'] == 'group') {
                $data['group_key'] = $search['key'];
            }
            if ((!($search['key'] == '')) and $search['type'] == 'code') {
                $data['code_key'] = $search['key'];
            }
            $this->load->view('search_result', $data);
        } else {
            $this->load->view('not_found', $data);
        }
    }

    //страныцы с товарами с наличия по группам 
    function group($group = '', $group_1 = '', $group_2 = '') {
        $data = array('conf' => $this->conf);
        $data['result'] = $this->data->select_groups(mysql_escape_string($group), mysql_escape_string($group_1), mysql_escape_string($group_2));
        $data['search_type'] = 'group';
        $data['result_add']['sklad_analog'] = array();
        $data['no_art'] = 1;
        $data['group'] = $this->data->get_groups();
        $data['sel_group'] = str_replace('_', ' ', $group);
        $data['sel_group_1'] = str_replace('_', ' ', $group_1);
        $data['sel_group_2'] = str_replace('_', ' ', $group_2);
        $data['group_1'] = $this->data->get_groups(1, $data['sel_group']);
        $data['group_2'] = $this->data->get_groups(2, $data['sel_group'], $data['sel_group_1']);
        $data['top_image'] = 0;
        $data['meta_title'] = "{$group}, {$group_1} {$group_2}  Запчасти На Японские Авто Джапан Авто";
        $data['meta_desc'] = "{$group} {$group_1} {$group_2} Запчасти На Японские Авто ";
        $data['meta_keys'] = "{$group} {$group_1} {$group_2},  Запчасти, Японские, Авто";
        $this->load->view('group', $data);
    }

    //аякс функция добавления/изменения товаров в корзине
    function add_to_basket($add = 1) {

        error_reporting(0);
        //объявляем параметры
        $data_json = $this->input->post('data'); //массив заказа
        $f_n = $this->input->post('f_n');
        $currency = $_SESSION['valuta']; //валюта
        $discount = $this->conf['discont']; //скиндка
        $kurs = $this->conf['kurs'];
        $nacenka = $this->conf['nacenka'];

        if ($data_json == TRUE) {

            $data_arr = json_decode($data_json, true);

            //если есть массив
            if ($data_arr) {

                //перебираем то, что получили
                foreach ($data_arr as $val) {


                    //преобразование параметров
                    $id = $val['id'];
                    $id_type = $id . $val['type'];
                    $count = (int) $val['count'];
                    $type = $val['type'];
                    $hidden = $val['hidden'];
                    $price = $val['price'];

                    if (!isset($val['in_order'])) {
                        $in_order = 1;
                    }

                    //Если такой товар в корзине уже есть, изменяем количество
                    if (isset($_SESSION['basket'][$id_type])) {

                        if ($add > 0) {
                            $_SESSION['basket'][$id_type]['bascet_count'] = $_SESSION['basket'][$id_type]['bascet_count'] + $count;
                        } else {
                            $_SESSION['basket'][$id_type]['bascet_count'] = $count;
                        }
                    } else {

                        $_SESSION['basket'][$id_type]['start_count'] = $count;

                        //прописываем значения параметров
                        for ($i = 1; $i < 6; $i++) {
                            $_SESSION['basket'][$id_type]['add' . $i] = (int) $val['add' . $i];
                        }

                        //если товар есть на складе
                        if ($type == '0_sklad') {

                            //получаем данные по продукту
                            $product_info = $this->data->get_row($id, "product");
                            $_SESSION['basket'][$id_type] = $product_info;
                            if ($hidden != '0') {

                                $_SESSION['basket'][$id_type]['hidden'] = 1;
                                $produsers = explode(', ', strtolower('mazda, subaru, nissan, toyota, honda, mitsubishi, suzuki, daihatsu, hyhdai, kia, isuzu'));
                                if (in_array(strtolower($product_info['manuf']), $produsers)) {
                                    $product_info['manuf'] = "Оригинал";
                                } else {
                                    $product_info['manuf'] = "Лицензия";
                                }

                                $product_info['car_desc'] = '';
                                $product_info['hidden'] = '1';
                                $product_info['article'] = $hidden;


                                $_SESSION['basket'][$id_type]['price_end'] = $this->catalog_model->get_price($product_info, $currency, 'hidden');
                            } else {

                                $_SESSION['basket'][$id_type]['price_end'] = $this->catalog_model->get_price($product_info, $currency, $nacenka);
                            }

                            //если товар есть на складах в Украине
                        } elseif ($type == '1_ukr') {

                            $product_info = $this->data->get_row_ukr($id);
                            $_SESSION['basket'][$id_type] = $product_info;
                            if ($currency == 'USD') {
                                $_SESSION['basket'][$id_type]['price_end'] = $this->catalog_model->get_price_ukr($product_info, 1, $discount);
                            } else {
                                $_SESSION['basket'][$id_type]['price_end'] = $this->catalog_model->get_price_ukr($product_info, $kurs, $discount);
                            }

                            //если только на заказ
                        } elseif ($type == '2_mp') {
                            $product_info = $this->data->get_row_mp($id);
                            $_SESSION['basket'][$id_type] = $product_info;

                            if ($price > 0) {
                                $_SESSION['basket'][$id_type]['price_end'] = $price;
                            }
                        }

                        $_SESSION['basket'][$id_type]['type'] = $type;
                        $_SESSION['basket'][$id_type]['in_order'] = $in_order;
                        $_SESSION['basket'][$id_type]['bascet_count'] = $count;

                        for ($i = 1; $i < 6; $i++) {
                            $_SESSION['basket'][$id_type]['add' . $i] = (int) $val['add' . $i];
                        }
                    }

//                    } elseif ($type == '1_ukr') {
//                        $data['type'] = $type;
//                        $data = $this->data->get_row_ukr($id);
//                        $_SESSION['basket'][$id_type]['price_end'] = $this->catalog_model->get_price_ukr($data, $kurs, $discount);
//                    } 
                }

                $this->_refresh_basket();
            };
        }

        if ($f_n == TRUE) {
            error_reporting(E_ALL);
            //$this->_close_order();
            print('end');
        } else {
            $this->load->view('page_elements/basket_block');
        }
    }

    // ajax функция обновления данных в корзине для дальних заказов
    function update_basket() {
        if (isset($_POST['data'])) {
            $data_json = $_POST['data'];
            if ($data_arr = json_decode($data_json, true)) {
                foreach ($data_arr as $val) {
                    $s_index = (int) $val['id'] . $val['type'];
                    /* if($val['type']=='2_mp')
                      {
                      $data = $this->data->get_row_mp($val['id'] );
                      if(isset($val['price'])>0)
                      {
                      $_SESSION['basket'][$s_index]['price_end']=  $val['price'];
                      }
                      }
                      $data['type'] = $val['type'];
                     */
                    //$_SESSION['basket'][$s_index]['in_order']= $val['in_order'];
                    $_SESSION['basket'][$s_index]['add2'] = $val['add2'];
                    $_SESSION['basket'][$s_index]['add4'] = $val['add4'];
                    $_SESSION['basket'][$s_index]['add5'] = $val['add5'];
                    $_SESSION['basket'][$s_index]['bascet_count'] = $val['count'];
                }
                $this->_refresh_basket();
            }
        }
        $this->load->view('page_elements/basket_block');
    }

    // ajax функция получения данных из сессии    
    function get_session_data() {
        $s_idx = $this->input->post('s_idx');
        echo json_encode($_SESSION['basket'][$s_idx]);
    }

    //отображение  корзины
    function basket() {        //print_r($_SESSION['basket']); die;
        $data = array('conf' => $this->conf);
        $data['search_type'] = 'code';
        $data['group'] = $this->data->get_groups();
        $data['top_image'] = 0;
        $data['group_1'] = array();
        $data['group_2'] = array();
        $data['result'] = $_SESSION['basket'];
        if (sizeof($_SESSION['basket']) < 1)
            return header('location:/');
        $this->load->view('basket', $data);
    }

    // сумма корзины
    function basket_sum() {
        print($_SESSION['basket_data']['sum']);
    }

    //удаление из корзины
    function del($id = '') {
        if (isset($_SESSION['basket'][$id])) {
            unset($_SESSION['basket'][$id]);
        };
        $this->_refresh_basket();
        header('location:/basket');
    }

    //оформление корзины в заказ
    function _close_order() {
        $tmp_basket = array();
        $valuta = $_SESSION['basket_data']['val'];
        if (isset($_SESSION['basket'])) {
            if (isset($_SESSION['user'])) {
                $data['name'] = $_SESSION['user']['name'];
                $data['fullname'] = $_SESSION['user']['fullname'];
                $data['user'] = $_SESSION['user']['id'];
                $data['card'] = $_SESSION['user']['card'];
                $data['tel'] = $_SESSION['user']['tel'];
                $data['email'] = $_SESSION['user']['email'];
            } else {
                $data['name'] = $this->input->post('f_n');
                $data['user'] = 0;
                $data['card'] = 0;
                $data['tel'] = $this->input->post('tel');
                $data['email'] = $this->input->post('email');
            }
            $data['status'] = 0;
            $data['count'] = $_SESSION['basket_data']['count'];
            $data['summ'] = $_SESSION['basket_data']['sum'];
            $data['valuta'] = $_SESSION['basket_data']['val'];
            $data['comment'] = $this->input->post('comment');
            $data['data'] = Date('Y-m-d');
            $data['time'] = Date('H:i:s');

            $from_mail = 'japan-auto@japan-auto.kiev.ua';
            $mail = 'japan-auto_bumer@ukr.net';
            //$this->order_model->send_order_mail($mail, $data, $from_mail, $this->conf['nacenka']);
            $id = 0;
            if (isset($_SESSION['user'])) {
                $mp_data = array();
                $order_details = array();
                foreach ($_SESSION['basket'] as $key => $val) {
                    if ($val['in_order'] < 1) {
                        $tmp_basket[$key] = $val;
                        continue;
                    }
                    $data_detail = array();
                    $data_detail['prod_id'] = $val['id'];
                    $data_detail['type'] = $val['type'];
                    $data_detail['count'] = $val['bascet_count'];
                    $data_detail['start_count'] = $val['bascet_count'];
                    $data_detail['start_price'] = $val['price_end'];
                    if ($val['type'] == '0_sklad') {
                        if (isset($val['hidden'])) {
                            $data_detail['hidden'] = 1;
                            $nac = 'hidden';
                        } else
                            $nac = $this->conf['nacenka'];

                        $data_detail['article'] = $val['article'];
                        $data_detail['manuf'] = $val['manuf'];
                        $data_detail['note'] = $val['note'];
                        $data_detail['car_desc'] = $val['car_desc'];
                        $data_detail['price'] = $this->catalog_model->get_price($val, $data['valuta'], $nac);
                    }elseif ($val['type'] == '1_ukr') {
                        $data_detail['article'] = $val['product'];
                        $data_detail['manuf'] = $val['producer'];
                        $data_detail['note'] = $val['desc'];
                        $data_detail['car_desc'] = $val['desc'];
                        $data_detail['supplier'] = $val['supplier'];
                        if ($data['valuta'] != USD) {
                            $data_detail['price'] = $this->catalog_model->get_price_ukr($val, $this->conf['kurs'], $this->conf['discont']);
                        } else {
                            $data_detail['price'] = $this->catalog_model->get_price_ukr($val, 1, $this->conf['discont']);
                        }
                    } elseif ($val['type'] == '2_mp') {
                        if ((int) $val['id'] > 0)
                            $id = $val['id']; else
                            $id = $val['prod_id'];
                        $mp_data[$val['id']] = $val;
                        $data_detail['article'] = $val['DetailNum'];
                        $data_detail['manuf'] = $val['MakeName'];
                        $data_detail['mp_start_cnt'] = $val['bascet_count'];
                        $data_detail['note'] = $val['PriceLogo'] . " " . $val['PartNameRus'];
                        $data_detail['car_desc'] = $val['PriceLogo'] . " " . $val['PartNameRus'];
                        $data_detail['price'] = number_format($val['price_end'], 2, '.', '');
                        $data_detail['start_price'] = number_format($val['price_end'], 2, '.', '');
                        $data_detail['start_count'] = $val['bascet_count'];
                        $mp_data[$id]['order_detail'] = $data_detail;
                    }
                    if (!$data_detail['start_count'])
                        $data_detail['start_count'] = $val['bascet_count'];
                    if (!$data_detail['start_price'])
                        $data_detail['start_price'] = $data_detail['price'];

                    $order_details[] = $data_detail;
                }
                $this->order_model->basket_to_order($data, $order_details, $mp_data);
                // $this->order_model->send_order_mail($_SESSION['user']['email'], $data, $from_mail);
                $_SESSION['user'] = $this->data->get_row($_SESSION['user']['id'], 'users');
            }

            if (isset($_SESSION['user']))
                $user_id = $_SESSION['user']['id']; else
                $user_id = 0;
            unset($_SESSION['basket']);
            unset($_SESSION['basket_data']);
            if (isset($_SESSION['user'])) {
                $SQL = "update users set basket=''  where id='" . (int) $_SESSION['user']['id'] . "'";
                $query = $this->db->query($SQL);
            }
            if ($tmp_basket) {// добавляем тимчасову корзину
                $_SESSION['basket'] = $tmp_basket;
                $_SESSION['basket_data']['val'] = $valuta;
                $this->_refresh_basket();
            }
        }
    }

    //прайс в цсв для пользователей
    function price() {
        if (!isset($_SESSION['user'])) {
            header('location:/');
            return;
        };
        if (isset($_SESSION['manager_id'])) {
            $tmp = $_SESSION['user'];

            $SQL = 'SELECT *  FROM users where id="' . $_SESSION['manager_id'] . '" ';
            $query = $this->db->query($SQL);
            $res = $query->result_array();
            $_SESSION['user'] = $res[0];
            $_SESSION['user']['price'] = 1;
        }
        if ($_SESSION['user']['price'] < 1) {
            header('location:/');
            return;
        };
        if ($_SESSION['user']['valuta'] == 'грн') {
            $field = 'price_uah';
        } else {
            $field = 'price_usd';
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-disposition: attachment; filename=parts.csv');
        $fields = $this->db->list_fields('product');
        $this->db->query('SET NAMES cp1251');
        $csv = 'article; manuf;  ' . $field . "; cross";
        $res_t = mysql_query("select * from product") or die("Ошибка 70");
        while ($val = mysql_fetch_array($res_t)) {
            $csv.=";
";
            $csv.=trim($val['article']) . ";" . trim($val['manuf']) . ";" . $this->catalog_model->get_price($val, $_SESSION['user']['valuta'], $this->conf['nacenka']) . ";" . trim($val['cross']) . ";";
        }
        echo $csv;
        if (isset($_SESSION['manager_id'])) {
            $_SESSION['user'] = $tmp;
        }
    }

    //поиск по мегапартсу запчатсей по коду (используется на странице результатов поиска)
    function ajax_find_mp() {
        $DetailNum = $this->input->post('DetailNum');
        $data['result'] = $this->megaparts->ajax_find($DetailNum);
        $data['code_key'] = $DetailNum;
        if ($data['result'] == 'error') {
            echo "<h2>У вас нет доступа к ээтому разделу!</h2>";
            return;
        }
        if ($data['result'] == 'empty') {
            echo " ";
            return;
        }
        $this->load->view('mp_find', $data);
    }

    //запрос менеджеру 
    function ajax_manager_help() {
        $this->order_model->send_manager_help_mail();
    }

    //страницы с запчастями поставщиков для индексации поисковиками 
    function suppliers($mark = 'all', $page = 1) {
        $data['result'] = $this->catalog_model->suppliers($mark, $page);
        $data['mark'] = $mark;
        if ($mark != 'all') {
            $data['meta_title'] = "Запчасти {$mark}";
            $data['meta_desc'] = "Запчасти {$mark}";
            $data['meta_keys'] = "Запчасти {$mark}";
            $data['page_cnt'] = $this->catalog_model->suppliers_page_cnt($mark);
            $data['cur_page'] = $page;
            foreach ($data['result'] as $val) {
                $data['meta_keys'] .= "," . $val['product'];
            }
        }

        $this->load->view('suppliers', $data);
    }

    //страница запчасти из поставщиков (для индексации поисковиками )
    function spart($id) {
        $data['group'] = $this->data->get_groups();
        $data['search_type'] = 'code';
        $data['group_1'] = array();
        $data['group_2'] = array();
        $data['part'] = $this->data->get_row((int) $id, 'suppliers_products');
        $data['meta_title'] = $data['part']['product'] . " " . $data['part']['producer'] . "   " . $data['part']['desc'];
        $data['meta_desc'] = $data['part']['product'] . " " . $data['part']['producer'] . "   " . $data['part']['desc'];
        $data['meta_keys'] = $data['part']['product'] . ", " . $data['part']['producer'] . ",  " . $data['part']['desc'];
        $this->load->view('spart', $data);
    }

    //страницы с запчастями поставщиков для индексации поисковиками 
    function emir_suppliers($mark = 'all', $page = 1) {
        $data['result'] = $this->catalog_model->emir_suppliers($mark, $page);
        $data['mark'] = $mark;

        if ($mark != 'all') {
            $mark = $this->catalog_model->MakeLogoName($mark);
            $data['meta_title'] = "Запчасти {$mark}";
            $data['meta_desc'] = "Запчасти {$mark}";
            $data['meta_keys'] = "Запчасти {$mark}";
            foreach ($data['result'] as $val) {
                $data['meta_keys'] .= "," . $val['DetailNum'];
            }
            $data['page_cnt'] = $this->catalog_model->emir_suppliers_page_cnt($data['mark']);
            $data['cur_page'] = $page;
        }
        $this->load->view('emir_suppliers', $data);
    }

    //страница запчасти из емиратов (для индексации поисковиками )
    function mpart($id) {

        $data['group'] = $this->data->get_groups();
        $data['search_type'] = 'code';
        $data['group_1'] = array();
        $data['group_2'] = array();
        $data['part'] = $this->data->get_row((int) $id, 'emir');
        //      MakeLogo     DetailNum     DetailPrice     DetailName
        $data['meta_title'] = $this->catalog_model->MakeLogoName($data['part']['MakeLogo']) . " " . $data['part']['DetailNum'] . " " . $data['part']['DetailName'];
        $data['meta_desc'] = $this->catalog_model->MakeLogoName($data['part']['MakeLogo']) . " " . $data['part']['DetailNum'] . " " . $data['part']['DetailName'];
        $data['meta_keys'] = $this->catalog_model->MakeLogoName($data['part']['MakeLogo']) . ", " . $data['part']['DetailNum'] . ", " . $data['part']['DetailName'];
        $this->load->view('mpart', $data);
    }

    // пересчет корзины
    function _refresh_basket() {
        $count = 0;
        $sum = 0;
        foreach ($_SESSION['basket'] as $value) {
            if (!isset($value['in_order']))
                $value['in_order'] = 1;
            $count = $count + $value['bascet_count'];
            if ($value['type'] == '0_sklad') {
                if (isset($value['hidden']))
                    $nac = 'hidden'; else
                    $nac = $this->conf['nacenka'];
                if ($_SESSION['basket_data']['val'] == 'грн') {
                    $sum = $sum + $value['price_end'] * $value['bascet_count'] * $value['in_order'];
                } else {
                    $sum = $sum + $value['price_end'] * $value['bascet_count'] * $value['in_order'];
                }
            } elseif ($value['type'] == '1_ukr') {
                if ($_SESSION['basket_data']['val'] == 'грн') {
                    $sum = $sum + $this->catalog_model->get_price_ukr($value, $this->conf['kurs'], $this->conf['discont']) * $value['bascet_count'] * $value['in_order'];
                } else {
                    $sum = $sum + $this->catalog_model->get_price_ukr($value, 1, $this->conf['discont']) * $value['bascet_count'] * $value['in_order'];
                }
            } elseif ($value['type'] == '2_mp') {
                $sum = $sum + number_format($value['price_end'] * $value['bascet_count'] * $value['in_order'], 2, '.', '');
            }
        }
        $_SESSION['basket_data']['count'] = $count;
        $_SESSION['basket_data']['sum'] = $sum;
        if (isset($_SESSION['user'])) {
            $basket_save['basket_data'] = $_SESSION['basket_data'];
            $basket_save['basket'] = $_SESSION['basket'];
            $basket_str = str_replace("'", "\'", serialize($basket_save));
            $SQL = "update users set basket='$basket_str'  where id='" . (int) $_SESSION['user']['id'] . "'";
            $query = $this->db->query($SQL);
        }
    }

    // вход на сайт из формы авторизации
    function ajax_login() {
        $card = (int) $_POST['card'];
        $SQL = 'SELECT *  FROM users where card="' . $card . '" ';
        $query = $this->db->query($SQL);
        error_reporting(0);
        if ($res = $query->result_array()) {
            if ($res[0]['pass'] == md5(md5($_POST['pass']))) {
                $_SESSION['user'] = $res[0];
                unset($_SESSION['basket']);
                unset($_SESSION['valuta']);
                unset($_SESSION['basket_data']);

                if (!($res[0]['basket'] == '')) {
                    $basket_save = unserialize($res[0]['basket']);
                    if (is_array($basket_save)) {
                        if (isset($basket_save['basket'])) {
                            $_SESSION['basket'] = $basket_save['basket'];
                        };
                        if (isset($basket_save['basket_data'])) {
                            $_SESSION['basket_data'] = $basket_save['basket_data'];
                        };
                    }
                }
                if ($res[0]['valuta'] == USD) {
                    $_SESSION['valuta'] = USD;
                } else {
                    $_SESSION['valuta'] = 'грн';
                }

                if ($_SESSION['user']['user_type'] == 'manager') {
                    $_SESSION['manager'] = $_SESSION['user']['fields'];
                    $_SESSION['user']['price'] = 1;
                    $_SESSION['manager_id'] = $_SESSION['user']['id'];
                    print(1);
                } else {
                    $this->load->view('page_elements/login_box');
                };
            } else {
                print('0');
            };
        } else {
            print('0');
        }
    }

    //вывод формы авторизации
    function login_box() {
        $this->load->view('page_elements/login_box', array('ajax' => 1));
    }

    //КРОН  загрузка прайса с автопартс
    function cron_ap() {
        $this->load->model('avtoparts_model', 'avtoparts');
        $this->avtoparts->load_price();
    }

    //КРОН  отправка заказов укр поставщикам
    function cron_ukr_supliers() {
        $this->order_model->cron_ukr_supliers();
    }

}

?>
