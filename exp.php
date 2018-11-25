<?php
//     $inline_data = 'кнопка/стол/имя/айди/09876';
//     $p = substr_count($inline_data,'/');
//     echo $p;
//     for($i = 1; $i <= $p; $i++) {
//         $a = substr($inline_data, 0, strrpos($inline_data, '/');
//         echo $a;
//     };
    $str = substr($inline_data, 0, strrpos($inline_data, '/'));
    $str2 = substr($str, 0, strrpos($str, '/'));
    $str3 = substr($str2, 0, strrpos($str2, '/'));
    $button = substr($str2, 0, strrpos($str2, '/'));
    $table = substr($str2, strrpos($str2,"/")+1);    
    $pos_name = substr($str, strrpos($str,"/")+1);
    
    $pos_id = substr($str3, 0, strrpos($str3, '?'));
    $order_id = substr($inline_data, strrpos($inline_data,"/")+1);

    echo $str.' '.$str2.' '.$str3.' ';
?>
