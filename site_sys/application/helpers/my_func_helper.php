<?php
    define('USD','долл');
    header('Content-Type: text/html; charset=UTF-8');
    
    // Вывод даты текстом
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
    //отправка письма 
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

    // спрятать ариткул 
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


    function clear_code($code)
    {
        $code = str_replace(' ','',$code);
        $code = str_replace('-','',$code);
        $code = str_replace('/','',$code);
        $code = trim(str_replace('  ','',$code));
        return $code;    
    }


    function weight($m){ 
        return ($m/1000)." кг";  
    }   

?>