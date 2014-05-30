<?php
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

//        $min = $w_i;
//        if ($w_i > $h_i) $min = $h_i;
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
?>