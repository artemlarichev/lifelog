<?php
 
define('USD','долл');
/**
 * @version 0.1
 * @author recens
 * @license GPL
 * @copyright Гельтищева Нина (http://recens.ru)
 */

/**
* Масштабирование изображения
*
* Функция работает с PNG, GIF и JPEG изображениями.
* Масштабирование возможно как с указаниями одной стороны, так и двух, в процентах или пикселях.
*
* @param string Расположение исходного файла
* @param string Расположение конечного файла
* @param integer Ширина конечного файла
* @param integer Высота конечного файла
* @param bool Размеры даны в пискелях или в процентах
* @return bool
*/
function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }
	if ($percent) {
		$w_o *= $w_i / 100;
		$h_o *= $h_i / 100;
	}
	if (!$h_o) $h_o = $w_o/($w_i/$h_i);
	if (!$w_o) $w_o = $h_o/($h_i/$w_i);
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}

/**
* Обрезка изображения
*
* Функция работает с PNG, GIF и JPEG изображениями.
* Обрезка идёт как с указанием абсоютной длины, так и относительной (отрицательной).
*
* @param string Расположение исходного файла
* @param string Расположение конечного файла
* @param array Координаты обрезки
* @param bool Размеры даны в пискелях или в процентах
* @return bool
*/
function crop($file_input, $file_output, $crop = 'square',$percent = false) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }
	if ($crop == 'square') {

	  if ($w_i > $h_i)
	   {
		$x_o = ($w_i - $h_i) / 2;
		$min = $h_i;
		} else
		{
			$y_o = ($h_i - $w_i) / 2;
			$min = $w_i;
		}

//		$min = $w_i;
//		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}



/**
* Масштабирование изображения
*
* Функция работает с PNG, GIF и JPEG изображениями.
* Масштабирование возможно как с указаниями одной стороны, так и двух, в процентах или пикселях.
*
* @param string Расположение исходного файла
* @param string Расположение конечного файла
* @param integer Ширина конечного файла
* @param integer Высота конечного файла
* @param bool Размеры даны в пискелях или в процентах
* @return bool */

function resize_file($file_input, $file_output, $w_o) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		//echo 'Невозможно получить длину и ширину изображения';
		return;
        }
        $types = array('','gif','jpeg','png','jpg');
        $ext = $types[$type];
        if ($ext) {
    	        $func = 'imagecreatefrom'.$ext;
    	        $img = $func($file_input);
        } else {
    	      //  echo 'Некорректный формат файла';
		return;
        }

    if($w_i<$h_i)
     {
         if($h_i<$w_o) {return;};
		 $h_o = $w_o;
		 $w_o = $h_o/($h_i/$w_i);
     }
     else
     {
         if($w_i<$w_o) {return;};
		 $w_o = $w_o;
		 $h_o = $w_o/($w_i/$h_i);
     }
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2 or $type == 4) {
		return imagejpeg($img_o,$file_output,90);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}


function resize_file_x($file_input, $file_output, $w_o) {
	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		//echo 'Невозможно получить длину и ширину изображения';
		return;
        }
        $types = array('','gif','jpeg','png','jpg');
        $ext = $types[$type];
        if ($ext) {
    	        $func = 'imagecreatefrom'.$ext;
    	        $img = $func($file_input);
        } else {
    	      //  echo 'Некорректный формат файла';
		return;
        }


         if($w_i<$w_o) {return;};
		 $w_o = $w_o;
		 $h_o = $w_o/($w_i/$h_i);

	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2 or $type == 4) {
		return imagejpeg($img_o,$file_output,90);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}


// Уменшение и обрекса изображения до квадрата $ww х $ww
//
function th_file($file_input, $file_output, $ww=129,$crop = 'square',$percent = false)
 {

	list($w_i, $h_i, $type) = getimagesize($file_input);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png','jpg');
    if($type=='jpg') {$type='jpeg';};
    $ext = $types[$type];
    if ($ext) {

    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }
	if ($crop == 'square') {
		if ($w_i > $h_i) {
			$x_o = ($w_i - $h_i) / 2;
			$min = $h_i;
		} else {
			$y_o = ($h_i - $w_i) / 2;
			$min = $w_i;
		}
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;
		if ($percent) {
			$w_o *= $w_i / 100;
			$h_o *= $h_i / 100;
			$x_o *= $w_i / 100;
			$y_o *= $h_i / 100;
		}
    	if ($w_o < 0) $w_o += $w_i;
	    $w_o -= $x_o;
	   	if ($h_o < 0) $h_o += $h_i;
		$h_o -= $y_o;
	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2 or $type == 4) {
	 	$img_o2 = imagecreatetruecolor($ww, $ww);
		imagecopyresampled($img_o2, $img_o, 0, 0, 0, 0, $ww, $ww, $min, $min);
		return imagejpeg($img_o2,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}

function resize_image($file, $file_end, $size=800)
 {
	list($w_i, $h_i, $type) = getimagesize($file);
	if (!$w_i || !$h_i) {
		echo 'Невозможно получить длину и ширину изображения';
		return;
    }
    $types = array('','gif','jpeg','png','jpg');
    if($type=='jpg') {$type='jpeg';};
    $ext = $types[$type];
    if ($ext) {

    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file);
    } else {
    	echo 'Некорректный формат файла';
		return;
    }

    $koef =  $size/$w_i ;
     if($w_i<=$size) {$koef=1;};
    $w_o =ceil($w_i*$koef);
    $h_o =ceil($h_i*$koef);
    $img_o = imagecreatetruecolor($w_o, $h_o);
	imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
	if ($type == 2 or $type == 4) {
		return imagejpeg($img_o,$file_end,80);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_end);
	}
}


function   russian_date($date)
	{
	$m='';
	$date=explode("-", $date);
	if(sizeof($date)>2)
	{
		switch ((int)$date[1]){
		case 1: $m='января'; break;
		case 2: $m='февраля'; break;
		case 3: $m='марта'; break;
		case 4: $m='апреля'; break;
		case 5: $m='мая'; break;
		case 6: $m='июня'; break;
		case 7: $m='июля'; break;
		case 8: $m='августа'; break;
		case 9: $m='сентября'; break;
		case 10: $m='октября'; break;
		case 11: $m='ноября'; break;
		case 12: $m='декабря'; break;
		}
		return (int)$date[2].'&nbsp;'.$m.'&nbsp;'.$date[0];
	}  else {return $date;};
  }


function anons_link($title,$url)
{
 	if((strpos(" ".$title,'[')>0) and (strpos(" ".$title,']')>0))  {
						 	 return (str_replace('[',"<a  href='$url'>",str_replace(']','</a>',$title)) );
						 	 }else
						 	 { return "<a  href='$url'>".$title."</a>";};


	//return "<a href='$url' title='$title'>$title </a>";
}
function cat_link($title,$url,$css='')
{
	return "<a href='$url' $css  title='$title'>$title </a>";
}

  function full_del_dir($directory)
  {
  $dir = opendir($directory);
  while(($file = readdir($dir)))
  {
    if ( is_file ($directory."/".$file))
    {
      unlink ($directory."/".$file);
    }
    else if ( is_dir ($directory."/".$file) &&
             ($file != ".") && ($file != ".."))
    {
      full_del_dir ($directory."/".$file);
    }
  }
  closedir ($dir);
  rmdir ($directory);

  }

  function date_dif($date1,$date2)
  {

		$arr1 = explode('-', $date1);
		$arr2 = explode('-', $date2);
		$time1 = mktime(0,0,0,$arr1[1],$arr1[2],$arr1[0]);
		$time2 = mktime(0,0,0,$arr2[1],$arr2[2],$arr2[0]);
		$dif = ($time2 - $time1) / 86400;
		return $dif;
}


function array_key_multi_sort($arr, $l , $f='strnatcasecmp')
{
    usort($arr, create_function('$a, $b', "return $f(\$a['$l'], \$b['$l']);"));
    return($arr);
}
/*
		$aaa[1]['id'] = "1";
		$aaa[1]['page'] = "тест";
		$aaa[1]['year'] = "1998";

		$aaa[2]['id'] = "2";
		$aaa[2]['page'] = "тест2";
		$aaa[2]['year'] = "1997";

		$aaa[3]['id'] = "3";
		$aaa[3]['page'] = "тест3";
		$aaa[3]['year'] = "1999";

		$sort = array_key_multi_sort($aaa, 'year');
		print_r($sort);

function cmp($a, $b)
 {
 $return = strcmp($a[1], $b[1]);
 if ($return == 0){
 if ($a[0] == $b[0]) {
 return 0;
 }
 return ($a[0] > $b[0]) ? -1 : 1;
 } else {
 return $return;
 }

 }
 uasort($newarray, "cmp");
 echo "<pre>";
 print_r($newarray);
 echo "</pre>";

*/
function make_keys($text)
{
	$text= str_replace("\r",' ',$text);
	$text= str_replace("\n",' ',$text);
	 	$array = explode(' ',strip_tags($text));
	$i=0;
	$str='';
	foreach($array as $val)
	{
		if(strlen($val)>8) {$str=$str.','.$val;$i++;}  else {continue;};
//		if(mb_strlen($val,'utf8')>4) {$str=$str.','.$val;$i++;}  else {continue;};
		if($i>5) {break;}
	}
	$str[0]=' ';

	return trim($str.',');
}

function captcha()
	{
	$width = 100;              //Ширина изображения
	$height = 40;              //Высота изображения
	$font_size = 11;           //Размер шрифта
	$let_amount = 5;           //Количество символов, которые нужно набрать
	$fon_let_amount = 30;      //Количество символов на фоне
	$font = "js/cour.ttf";  //Путь к шрифту

	//набор символов
	$letters =array("0","1","2","3","4","5","6","7","8","9");
	//цвета
	$colors =array("90","110","130","150","170","190","210");

	$src = imagecreatetruecolor($width,$height);   //создаем зображение
	$fon = imagecolorallocate($src,255,255,255);   //создаем фон
	imagefill($src,0,0,$fon);                      //заливаем изображение фоном

	for($i=0;$i <$fon_let_amount;$i++)         //добавляем на фон буковки
	{
	//случайный цвет
	$color = imagecolorallocatealpha($src,rand(0,255),rand(0,255),rand(0,255),100);
	//случайный символ
	$letter =$letters[rand(0,sizeof($letters)-1)];
	//случайный размер

	$size = rand($font_size-2,$font_size+2);
	imagettftext($src,$size,rand(0,45),
	rand($width*0.1,$width-$width*0.1),
	rand($height*0.2,$height),$color,$font,$letter);
	}

	for($i=0;$i <$let_amount;$i++)     //то же самое для основных букв
	{
	$color = imagecolorallocatealpha($src,$colors[rand(0,sizeof($colors)-1)],
	$colors[rand(0,sizeof($colors)-1)],
	$colors[rand(0,sizeof($colors)-1)],rand(20,40));
	$letter =$letters[rand(0,sizeof($letters)-1)];
	$size = rand($font_size*2-2,$font_size*2+2);
	$x = ($i+1)*$font_size + rand(1,5);     //даем каждому символу случайное смещение
	$y = (($height*2)/3) + rand(0,5);
	$cod[] =$letter;                       //запоминаем код
	imagettftext($src,$size,rand(0,15),$x,$y,$color,$font,$letter);
	}

	$cod = implode("",$cod);                   //переводим код в строку


	 $_SESSION['kaptcha']=$cod;

	 header ("Content-type: image/gif");        //выводим готовую картинку
	imagegif($src);
	exit();
}

  function format_size($file) {
  	if(file_exists($file))
  	{$size=filesize($file);
      $sizes = array("b", " Kb", " Mb", " Gb", " Tb", " PB", " EB", " ZB", " YB");
      if ($size == 0) { return('n/a'); } else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
     }
     else
     {
     	return "(n/a)";
     }
}

function make_full_url($cat_1,$cat_2,$cat_3,$cat_4)
{
   $url='';
	if(!($cat_1=='')) {$url.='/'.$cat_1;};
	if(!($cat_2=='')) {$url.='/'.$cat_2;};
	if(!($cat_3=='')) {$url.='/'.$cat_3;};
	if(!($cat_4=='')) {$url.='/'.$cat_4;};
	return $url;
}
function  short_text($text)
{
	if(!($text==''))
	{
		if(strpos('.',$text)>2)
		{
			$text=substr($text,0,strpos('.',$text));
		}
	}
	return $text;
}


function send_mail_msg($title,$msg,$mail,$from='noreply@japan-auto.kiev.ua')
{
	   	$subject = $title;

		$message = "
		<html>
		    <head>
		        <title>$title</title>
		    </head>
			    <body>
              	<p>$msg </p>
		    </body>
		</html>";

		$headers  = "Content-type: text/html; charset=utf-8 \r\n";
		if(!($from=='')){$headers .= "From: $from \r\n";}

		mail($mail, $subject, $message, $headers);

}
function hide_value($text,$no_art=0)
{
    return $text;
    if($no_art>0)
    {
   		$len=strlen($text);
		if($len<3){$text='**';}else {$text=substr($text,0,1)."***".substr($text,$len-1,1);};
		return $text;
	 };
	 if(isset($_SESSION['user']))
	 {
	  if($_SESSION['user']['full_art']>0)
	  {
	 		return $text;
	  }
	 }

		$len=strlen($text);
		if($len<3){$text='**';}else {$text=substr($text,0,1)."***".substr($text,$len-1,1);};
	 return $text;

}

function send_order_mail($email,$data,$from_mail,$nacenka=1)
{
	$text="
					<div class='big_table_wrap'>
						<table  border='1'>
							<thead>
								<tr>
									<th class='marking'>
										 Артикул
									</th>
									<th class='maker'> Производитель </th>
									<th class='important'> Примечание </th>
									<th class='price'> ".$_SESSION['basket_data']['val']." </th>
									<th class='col'> шт. </th>
									<th class='sum'> Сумма </th>

								</tr>
							</thead>

	<tbody>";

	$count=0;
	$group='';
    
	foreach($_SESSION['basket'] as $val){
        if($val['in_order']<1) continue;
		$count++;
        if($val['type']=='0_sklad'){
		            $cu_group=$val['group'];
		            if(!($val['group_1']=='')) {$cu_group.=' >> '.$val['group_1'];}
		            if(!($val['group_2']=='')) {$cu_group.=' >> '.$val['group_2'];}
		            if(!($group==$cu_group))
		            {
			                    $group=$cu_group;
	                    $text.="<tr>
			                    <td class='table_hline_row' colspan='9'>
				                    <b>".$group."</b>
			                    </td>
		                    </tr>";
                      }
                                          $text.="<tr>
			                <td>
				                 ".$val['article']."</a>
			                </td>
		 	                <td>".$val['manuf']."</td>
		 	                <td>".$val['car_desc']."</td>
		 	                <td class='numeric'>";
                            $text.=round($val['price_end']); 

		 	                $text.="</td>

			                 <td class='f_buy'>".$val['bascet_count']."</td>
			                 <td class='numeric'> ";
			                   $text.=$val['bascet_count']*round($val['price_end']);

			                 $text.=" </td>

		                </tr>";
             }elseif($val['type']=='1_ukr'){
                 $text.="<tr>
                                <td class='table_hline_row' colspan='9'>
                                    <b>Под заказ</b>
                                </td>
                            </tr>";
                     
                                          $text.="<tr>
                            <td>
                                 ".$val['product']."</a>
                            </td>
                             <td>".$val['producer']."</td> 
                             <td> </td>
                             <td class='numeric'> 
                            ".$val['price_end']."
                             </td>

                             <td class='f_buy'>".$val['bascet_count']."</td>
                             <td class='numeric'> ";
                               $text.=$val['bascet_count']*$val['price_end'];

                             $text.=" </td>

                        </tr>";
                 
             }   elseif($val['type']=='2_mp'){
                 $text.="<tr>
                                <td class='table_hline_row' colspan='9'>
                                    <b>дальний заказ</b>
                                </td>
                            </tr>";
                     
                                          $text.="<tr>
                            <td>
                                 ".$val['DetailNum']."</a>
                            </td>
                             <td>".$val['MakeName']."</td> 
                             <td>Поставщик ".$val['PriceLogo']."</td>
                             <td class='numeric'> 
                            ".$val['price_end']."
                             </td>

                             <td class='f_buy'>".$val['bascet_count']."</td>
                             <td class='numeric'> ";
                               $text.=$val['bascet_count']*$val['price_end'];

                             $text.=" </td>

                        </tr>";
                 
             }    
                  
                
		 $text.="<tr   <td colspan='9' class='table_check_row'>
			 ";

					if($val['add1']>0) {$text.="Только этот артикул   "; }
					if($val['add2']>0) {$text.="Только этот производитель   "; }
					if($val['add3']>0) {$text.="Только это количество  ";   }
					if($val['add4']>0) {$text.="Возможно повышение стоимости  ";}
					if($val['add5']>0) {$text.=" Могу ждать месяц  ";}


			$text.="</td>";
			}

	$text.="</tbody>
    </table>";




					$text.="<div class='basket_info'>
							<dl class='basket_user_form'>
								<dt><label for='f_n'>Имя и фамилия:</label></dt>
								<dd>".$data['name']."</dd>
								<dt><label for='tel' >Телефон:</label></dt>
								<dd>".$data['tel']."</dd>
								<dt><label for='mail'>Почта:</label></dt>
								<dd>".$data['email']."</dd>
								<dt><label for='comments'>Комментарии и уточнения:</label></dt>
								<dd class='texta_wrap'>".$data['comment']."</dd>

							</dl>
							<div class='basket_total'>
								<div class='total'>
									Итого к оплате: <span id='suma2'>".$_SESSION['basket_data']['sum']."</span>
									".$_SESSION['basket_data']['val']."

								</div>

							</div>
						</div>
					</div>




	";
    //  print($text);exit();
    $title='Новий заказ на сайте Джапан АВТО';
	if(!isset($_SESSION['user'])) { $title.=' (незарегистрированный пользователь)';}
	send_mail_msg($title,$text,$email);
    return $text;
}

function send_manager_help_mail()
{
 



                    $text.="<div class='basket_info'>
                            <dl class='basket_user_form'>
                                <dt><label for='f_n'>ФИО:</label></dt>
                                <dd>".$_POST['full_name']."</dd>
                                <dt><label for='tel' >Телефон:</label></dt>
                                <dd>".$_POST['phone_num']."</dd>
                                <dt><label for='mail'>Почта:</label></dt>
                                <dd>".$_POST['email']."</dd>
                                
                                <dt><label for='mail'>Марка:</label></dt>
                                <dd>".$_POST['sel_brand']."</dd>
                                <dt><label for='mail'>Модель и модификация:</label></dt>
                                <dd>".$_POST['car_model']."</dd>
                                <dt><label for='mail'>Год:</label></dt>
                                <dd>".$_POST['sel_year']."</dd>
                                <dt><label for='mail'>Тип кузова:</label></dt>
                                <dd>".$_POST['type_carcass']."</dd>
                                <dt><label for='mail'>Топливо:</label></dt>
                                <dd>".$_POST['sel_type_fuel']."</dd>
                                <dt><label for='mail'>Объем:</label></dt>
                                <dd>".$_POST['volume_motor']."</dd>
                                <dt><label for='mail'>Коробка передач:</label></dt>
                                <dd>".$_POST['sel_transmission']."</dd>
                                <dt><label for='mail'>Номер кузова:</label></dt>
                                <dd>".$_POST['num_carcass']."</dd>
                                <dt><label for='mail'>VIN-код:</label></dt>
                                <dd>".$_POST['vin_code']."</dd>
                                
                                     <dt><label for='mail'>Текст запроса:</label></dt>
                                <dd>".$_POST['text']."</dd>
                                
                                

                            </dl>
                            
                            </div>
                        </div>
                    </div>




    ";
     // print($text);exit();
    $title='Запрос менеджеру на сайте Джапан АВТО';
                                                                   
    send_mail_msg($title,$text,'japan-auto_bumer@ukr.net');
    send_mail_msg($title,$text,'slider@ukr.net');
   // return $text;
}

function convert_date($data,$to=1)
{
    $arr=explode('.',$data);
   if($to>1)
   {
       $arr=explode('.',$data);
        return $arr['2'].'-'.$arr['1'].'-'.$arr['0'];
   }
   else
   {
         $arr=explode('-',$data);
           return $arr['2'].'.'.$arr['1'].'.'.$arr['0'];
   }
}
function get_price_emir ($val,$kurs, $discont,$emir_disc)
{ 
    
 $price=str_replace(",",'',$val['DetailPrice'])*$kurs*(100+$discont+$emir_disc)/100; 
 return (int)$price;
    
}  
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

function clear_code($code)
{
    $code = str_replace(' ','',$code);
    $code = str_replace('-','',$code);
    $code = str_replace('/','',$code);
    $code = trim(str_replace('  ','',$code));
 return $code;    
}


function endin($point)
{
   
    $point=(string)(int)$point;
    $char =substr($point,strlen($point)-1,1);
    if(strlen($point)>1){
       $char_d =substr((string)$point,strlen($point)-2,2);
    
        if (in_array($char_d,array("11","12","13","14"))) return 'товаров';
        
    }
    
    switch ($char) {
        case '1':
            return 'товар'; 
            break;
        case '2':
        case '3':
        case '4':
            return 'товара'; 
            break;
        default:
            return 'товаров'; 
            break;
        }
      
}

function weight($m){
  //  if($m>500 and $m< 500000){
        return ($m/1000)." кг"; 
  //  }elseif($m<500){
  //      return ($m)." г"; 
 //   }else{
  //      return ($m/1000000)." т"; 
 //   }
}

?>