<?php
    $str = substr($inline_data, 0, strrpos($inline_data, '/'));
    $button = substr($str, 0, strrpos($str, '/'));
    $table = substr($str, strrpos($str,"/")+1);    
    $pos_name = substr($inline_data, strrpos($inline_data,"/")+1);
    $pos_id = 
    echo $str.' '.$button.' '.$table.' '.$pos_name.' ';
