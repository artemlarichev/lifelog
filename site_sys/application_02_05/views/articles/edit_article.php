<!DOCTYPE HTML>
<html lang="ru-RU">
<?php
$count=1;
 $this->load->view('page_elements/head');  ?>
 <script type="text/javascript" >p_count='<?=$count?>';//'</script>
<body class="main_page">
<div class="wrapper">
	<div class="base" id="wrapper">
	<?php  $this->load->view('page_elements/header');  ?>

		<div class="main_row">
 <div class="content_row">
                   
                
                <div class="text_content">

                   <form action="" method="post">
                    <div class="static static_article">
                        <div class="edit_article_form_w">
                            <ul class="edit_article_form">
                                <li class="full">
                                    <dl>
                                        <dt>Название</dt>
                                        <dd><input type="text" name="title" id="title" value="<?=$article['title']?>" onkeyup="Translit('title','url')"   ></dd>
                                    </dl>
                                </li>
                                <li class="full">
                                    <dl>
                                        <dt>Псевдоним</dt>
                                        <dd><input type="text" name="url" value="<?=$article['url']?>" id="url" >
                                        <input type="hidden" name="id" value="<?=$article['id']?>">
                                        <input type="hidden" name="cat_id" value="<?=$article['cat_id']?>">
                                        
                                        </dd>
                                    </dl>
                                </li>
                                <li class="full mod_1">
                                    <dl>
                                        <dt>Анонс</dt>
                                        <dd>
                                            <div class="article_intro_block">
                                            <textarea id="article_intro_field" class="article_intro_field" name="anonce"><?=$article['anonce']?></textarea></div>
                                        </dd>
                                    </dl>
                                </li>
                                <li class="full">
                                    <dl>
                                        <dt>Текст статьи</dt>
                                        <dd class="article_text"><textarea id="tmce"  style="height: 600px;" class="article_text_field" name="text"><?=$article['text']?></textarea></dd>
                                    </dl>
                                </li>

                                <li class="half">
                                    <dl>
                                        <dt>Источник</dt>
                                        <dd><input type="text" name="link_title" value="<?=$article['link_title']?>"></dd>
                                    </dl>

                                </li>
                                <li class="half">
                                    <dl>
                                        <dt>Ссылка на источник</dt>
                                        <dd><input type="text" placeholder=" http://" name="link" value="<?=$article['link']?>" ></dd>
                                    </dl>
                                </li>

                                <li class="full">
                                    <dl>
                                        <dt>Ключевые слова</dt>
                                        <dd><input type="text" name="keys" value="<?=$article['keys']?>"></dd>
                                    </dl>
                                </li>
                                <li class="full">
                                    <dl>
                                        <dt>Мета-заголовок</dt>
                                        <dd><input type="text" name="meta_title" value="<?=$article['meta_title']?>"></dd>
                                    </dl>
                                </li>

                                <li class="full">
                                    <dl>
                                        <dt>Мета-ключевые слова</dt>
                                        <dd><input type="text" name="meta_keys" value="<?=$article['meta_keys']?>"></dd>
                                    </dl>
                                </li>
                                <li class="full">
                                    <dl>
                                        <dt>Мета-описание</dt>
                                        <dd>
                                            <textarea name="meta_desc"><?=$article['meta_desc']?></textarea>
                                        </dd>
                                    </dl>
                                </li>

                            </ul>
                            <div class="submit_wrap">
                                <input type="submit" value="Сохранить">
                            </div>
                        </div>


                    </div>
                   </form>
                </div>
                <div class="aside base_info">
                    <div class="base_i_breadcrumbs"><a title="База знаний" href="/articles">База знаний</a> /</div>
                    <h2 class="headline"><?=$cat['title']?>
                    <?if(isset($_SESSION['manager'])){?>
                        <a class="edit_ico" href="/articles/edit_cat/<?=$cat['id']?>" title=""></a>
                        <a class="del_ico" href="/articles/del/cat/<?=$cat['id']?>" title=""  onClick="return window.confirm('Удалить?')"></a>
                        <?}?> </h2> 
                    <ul class="brand_list">
                    <?foreach($cats as $item){
                       if($item['id']==$cat['id']) continue;     
                        ?>
                        <li><a title="<?=$item['title']?>" href="/articles/<?=$item['url']?>"><?=$item['title']?></a></li>
                        <?}?>
                               
                    </ul>
                     <?if(isset($_SESSION['manager'])){?>     
                    <div><a class="add" href="/articles/edit_cat/0" title="Добавить тему">Добавить тему</a></div>
                    <div><a class="add" href="/articles/edit_article/0/<?=$cat['id']?>" title="Добавить статью">Добавить статью</a></div>
                    <?}?>
                    <h2 class="tags_hline">Ключевые слова</h2>
                    <ul class="tags_list">
                    <?
                    $keys =explode(',',$article['keys']);
                    $cnt=sizeof($keys); 
                    if($cnt>0)   
                    $i=0;
                    foreach($keys as $key) {
                        $i++;
                    ?>
                        <li><a title="<?=$key?>" href="/articles/keywords/<?=trim($key)?>"><?=trim($key)?></a><?if($i<$cnt) echo","?> </li>
                    <?}?>    
                             
                    </ul>

                </div>
            </div>
 
    <script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>

        <script language="javascript" type="text/javascript">
    
           function Translit(from,to)
{
    /* Making transliteration! */
        
        new_el = document.getElementById(to);
        el = document.getElementById(from);
        A = new Array();
             A["Ё"]="yo";A["Й"]="i";A["Ц"]="ts";A["У"]="u";A["К"]="k";A["Е"]="e";A["Н"]="n";A["Г"]="g";A["Ш"]="sh";A["Щ"]="sch";A["З"]="z";A["Х"]="h";A["Ъ"]="";
        A["ё"]="yo";A["й"]="i";A["ц"]="ts";A["у"]="u";A["к"]="k";A["е"]="e";A["н"]="n";A["г"]="g";A["ш"]="sh";A["щ"]="sch";A["з"]="z";A["х"]="h";A["ъ"]="'";
        A["Ф"]="f";A["Ы"]="i";A["В"]="v";A["А"]="a";A["П"]="p";A["Р"]="r";A["О"]="o";A["Л"]="l";A["Д"]="d";A["Ж"]="zh";A["Э"]="e";
        A["ф"]="f";A["ы"]="i";A["в"]="v";A["а"]="a";A["п"]="p";A["р"]="r";A["о"]="o";A["л"]="l";A["д"]="d";A["ж"]="zh";A["э"]="e";
        A["Я"]="ya";A["Ч"]="ch";A["С"]="s";A["М"]="m";A["И"]="i";A["Т"]="t";A["Ь"]="";A["Б"]="b";A["Ю"]="yu";
        A["я"]="ya";A["ч"]="ch";A["с"]="s";A["м"]="m";A["и"]="i";A["т"]="t";A["ь"]="";A["б"]="b";A["ю"]="yu";A[" "]="-";
        new_el.value = el.value.replace(/([^\w])/g,
            function (str,p1,offset,s) {
                if ( typeof A[str] !== 'undefined'  ){return A[str];}else { return '';};
            }
        );
          
}
     

        tinyMCE.init({
            mode : "exact", elements : "tmce",
           
            theme : "advanced",
                language : "ru",
            plugins : "image,imagemanager,filemanager,advimage,advlink,contextmenu,paste,table",
            theme_advanced_buttons1_add_before : "newdocument,separator",
            theme_advanced_buttons1_add : " fontselect,fontsizeselect",
            theme_advanced_buttons2_add : "separator,forecolor,backcolor,liststyle",
            theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,",
            theme_advanced_buttons3_add_before : "tablecontrols",
            theme_advanced_buttons3_add : "media|,insertfile,insertimage",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            extended_valid_elements : "hr[class|width|size|noshade]",
             
            paste_use_dialog : false,
            theme_advanced_resizing : true,
            theme_advanced_resize_horizontal : true,
            apply_source_formatting : true,
            force_br_newlines : true,
            force_p_newlines : false,
            relative_urls : false,
            convert_urls : false,
            content_css : "/styles/min.css" 
             
        });
 
         </script>
 		</div>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>