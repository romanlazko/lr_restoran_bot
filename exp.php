<?php
    $inline_data = 'кнопка/стол/имя/айди/09876';
    $p = substr_count($inline_data,'/');

    for ($i = 1; $i <= $p; $i++) {
        $a = substr($inline_data, 0, strrpos($inline_data, '/');
        echo $a;
    }
//     $str = substr($inline_data, 0, strrpos($inline_data, '/'));
//     $str2 = substr($str, 0, strrpos($str, '/'));
//     $button = substr($str2, 0, strrpos($str2, '/'));
//     $table = substr($str2, strrpos($str2,"/")+1);    
//     $pos_name = substr($str, strrpos($str,"/")+1);
//     $str3 = substr($inline_data, strrpos($inline_data,"/")+1);
//     $pos_id = substr($str3, 0, strrpos($str3, '?'));
//     $order_id = substr($inline_data, strrpos($inline_data,"/")+1);

    //echo $button.' '.$table.' '.$pos_name.' '.$pos_id.' '.$order_id;
?>
