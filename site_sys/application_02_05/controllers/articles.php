<?php
class Articles extends Controller {

   var  $conf=array('client'=>'1');  
    var  $user_names=array(); var  $group=array();
 	function Articles()
	{
        
 


	    session_start();
	 	parent::Controller();
         $this->load->model('data_model','data');
         $this->load->model('article_model','article');
		$this->load->helper('my_func');
		header('Content-Type: text/html; charset=UTF-8');
		 		 
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
    function index() {
        $data['level']=0;
        $data['last_articles']=$this->article->last_articles(20);
	    $data['cats'] = $this->article->get_cats();
        $data['keys'] = $this->article->get_keywords();
         if(isset($data['cats'][0])){
             $data['articles'] =$this->article->get_articles_by_cat($data['cats'][0]['id']);
             $data['cat'] =$this->article->get_cat($data['cats'][0]['id']);
         } 
          else $data['articles']=NULL;
         if(isset($data['articles'][0])) $data['article'] = $data['articles'][0];
                else $data['article']=NULL;
                                           
          $this->load->view('articles/index',$data);
	}

    function show_article($url,$add_url='') {

           $data['cat'] =$this->article->get_cat_url($url);   
           $data['articles'] =$this->article->get_articles_by_cat($data['cat']['id']);   
           $data['keys'] = $this->article->get_keywords(array('cat_id'=>$data['cat']['id']));
           $data['cats'] = $this->article->get_cats(); 
           $data['level']=0;
        if($add_url==''){// показываем раздел
            $data['level']=1;
            if(isset($data['articles'][0])) $data['article'] = $data['articles'][0];
                else $data['article']=NULL; 
                $data['meta_title']=   $data['cat']['meta_title'];
                $data['meta_desc']=   $data['cat']['meta_desc'];
                $data['meta_keys']=   $data['cat']['meta_keys'];
                $this->load->view('articles/cat',$data);
        }else {// показываем статью                                                           
            $data['level']=2;
            $data['article'] = $this->article->get_article_url($add_url);
                $data['meta_title']=   $data['article']['meta_title'];
                $data['meta_desc']=   $data['article']['meta_desc'];
                $data['meta_keys']=   $data['article']['meta_keys'];

         $this->load->view('articles/article',$data);     
        }
   
         
         
    } 

    function edit_article($id=0,$cat_id=0) {
        $data['level']=2;
            if(!isset($_SESSION['manager']))  header("location:/articles");     
          if($this->input->post('title')){
               
            $this->article->save_article(array("title"=>$this->input->post('title'),
                                         "cat_id"=>$this->input->post('cat_id'),
                                         "id"=>$this->input->post('id'),
                                         "url"=>$this->input->post('url'),
                                         "anonce"=>$this->input->post('anonce'),
                                         "text"=>$this->input->post('text'),
                                         "keys"=>$this->input->post('keys'),
                                         "link"=>$this->input->post('link'),
                                         "link_title"=>$this->input->post('link_title'),
                                         "meta_title"=>$this->input->post('meta_title'),
                                         "meta_desc"=>$this->input->post('meta_desc'),
                                         "meta_keys"=>$this->input->post('meta_keys')                
                                            ));  

           $cats_url =$this->article->get_cats_url();                                                
            header("location:/articles/{$cats_url[$this->input->post('cat_id')]}/{$this->input->post('url')}");   
            return;                                           
          }            
          $data['article'] =$this->article->get_article($id);   
          if($cat_id<1)$cat_id =  $data['article']['cat_id'];
          
          $data['cats'] = $this->article->get_cats();
          $data['cat'] =$this->article->get_cat($cat_id);                                                  
         
          if(!$data['article']) $data['article'] =array('title'=>'','id'=>'0','url'=>'','cat_id'=>$cat_id,'anonce'=>'','text'=>'','keys'=>'','link_title'=>'','link'=>'','meta_title'=>'','meta_keys'=>'','meta_desc'=>'');
          if($cat_id==0) $data['cat'] = $this->article->get_cat($data['article']['cat_id']);                                                  
          $this->load->view('articles/edit_article',$data);
    } 

    function edit_cat($id=0) {
           $data['level']=1;
          if(!isset($_SESSION['manager']))  header("location:/articles");     
                  if($this->input->post('title')){
            $id = $this->article->save_cat(array("title"=>$this->input->post('title'),        
                                         "id"=>$this->input->post('id'),
                                         "url"=>$this->input->post('url'),              
                                         "meta_desc"=>$this->input->post('meta_desc'),
                                         "meta_title"=>$this->input->post('meta_title'),
                                         "meta_keys"=>$this->input->post('meta_keys')                
                                            )); 
                                            
              header("location:/articles/{$this->input->post('url')}");                                              
          }                                             
          $data['cats'] = $this->article->get_cats(); 
          $data['cat'] =$this->article->get_cat($id);  
            if(!$data['cat']) $data['cat'] =array('title'=>'','id'=>'0','url'=>'','meta_title'=>'','meta_keys'=>'','meta_desc'=>'');
          $this->load->view('articles/edit_cat',$data);
    } 
    
    function del($type,$id) { 
        if(!isset($_SESSION['manager']))  header("location:/articles");             
        if($type=='article')  $this->article->del_article($id); 
        elseif($type=='cat')  $this->article->del_cat($id); 
        header("location:/articles");
    } 

    function keywords($key) {    
    $data['level']=2;                       
        $key = str_replace('_',' ',$key);
         $data['cats'] = $this->article->get_cats(); 
         $data['articles'] =$this->article->get_articles_by_keywords($key);
         $key_str = '';
         foreach($data['articles'] as $item){
                   if($item['keys']!='')$key_str .= ",".$item['keys'];
         } 
         $keys=explode(',',$key_str);
         $keys =  array_unique($keys);
         foreach($keys as $k=>$val) if(trim($val)=='') {unset($keys[$k]);}
         
         $data['keyword'] =$key; 
         $data['keys'] =$keys; 
         
         $data['cats_url'] =$this->article->get_cats_url();              
         $this->load->view('articles/keywords',$data);  
    } 
  
 }

?>