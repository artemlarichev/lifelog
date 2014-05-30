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
           <form action="" method="post">                             
          <div class="text_content">


                    <div class="static static_article">
                        <div class="edit_article_form_w">
                            <ul class="edit_article_form">

                                <li class="half">
                                    <dl>
                                        <dt>Название</dt>
                                        <dd><input type="text" name="title" id="title" value="<?=$cat['title']?>" onkeyup="Translit('title','url')"  ></dd>
                                    </dl>

                                </li>
                                <li class="half">
                                    <dl>
                                        <dt>Псевдоним</dt>
                                        <dd><input type="text" name="url" value="<?=$cat['url']?>"  id="url">
                                        <input type="hidden" name="id" value="<?=$cat['id']?>">
                                        </dd>
                                    </dl>
                                </li>

    <li class="full">
                                    <dl>
                                        <dt>Мета-заголовок</dt>
                                        <dd><input type="text" name="meta_title" value="<?=$cat['meta_title']?>"></dd>
                                    </dl>
                                </li>

                                <li class="full">
                                    <dl>
                                        <dt>Мета-ключевые слова</dt>
                                        <dd><input type="text" name="meta_keys" value="<?=$cat['meta_keys']?>"></dd>
                                    </dl>
                                </li>
                                <li class="full">
                                    <dl>
                                        <dt>Мета-описание</dt>
                                        <dd>
                                            <textarea name="meta_desc"><?=$cat['meta_desc']?></textarea>
                                        </dd>
                                    </dl>
                                </li>

                            </ul>
                            <div class="submit_wrap">
                                <input type="submit" value="Сохранить">
                            </div>
                        </div>


                    </div>

                </div>   
                </form>   
                    
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
   

                </div>
            </div>
 
 
 		</div>
        <script >
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
        </script>
	 <?php  $this->load->view('page_elements/footer');  ?>
	</div>
</div>
</body>
</html>