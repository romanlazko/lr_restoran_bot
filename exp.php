<?php
//     $inline_data = 'кнопка/стол/имя/айди';
//     $str = substr($inline_data, 0, strrpos($inline_data, '/'));
//     $str2 = substr($str, 0, strrpos($str, '/'));
//     $str3 = substr($str2, 0, strrpos($str2, '/'));
//     $button = substr($str3, 0, strrpos($str3, '/'));
//     $table = substr($str3, strrpos($str3,"/")+1);    
//     $pos_name = substr($str2, strrpos($str2,"/")+1);
    
//     $pos_id = substr($str, strrpos($str,"/")+1);
//     $order_id = substr($inline_data, strrpos($inline_data,"/")+1);

//     echo $button.' '.$table.' '.$pos_name.' '.$pos_id.' '.$order_id.' ';
include __DIR__ ."/vendor/autoload.php";
$image = __DIR__ . "/qrcode.jpg";
$qrcode = new QrReader($image);
$text = $qrcode->text();
//echo $text;
?>
