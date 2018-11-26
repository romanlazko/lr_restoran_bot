<?php
function showPos($klient,$chat_id,$table){
    $servername="db4free.net: 3306";
    $username="romanlazko";
    $password="zdraste123";
    $dbname="promocoder1";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);
    $result = $dbconnect->query("SELECT pos_name,pos_id FROM restoran");
    while($row = $result->fetch_assoc()){
        inlineKeyboard($klient,$chat_id,$row['pos_name'],order($table,1,$row['pos_id']));        
    }    
    $dbconnect->close();
}
function posData($pos_id){
    $servername="db4free.net: 3306";
    $username="romanlazko";
    $password="zdraste123";    
    $dbname="promocoder1";
    $dbconnect = new mysqli($servername, $username, $password, $dbname);    
    $result = $dbconnect->query("SELECT pos_name FROM restoran WHERE pos_id = '$pos_id'");
    while($row = $result->fetch_assoc()){        
        return $row;
    }   
    $dbconnect->close();
}
function orderfunc($klient,$restoran,$chat_id,$pos_id,$user_id,$order_time,$id,$table,$pos_name,$dbconnect){    
    $result = $dbconnect->query("SELECT id FROM order_id");    
    while($row = $result->fetch_assoc()){        
        if($row['id']==$id){
            $new_id = false;
            break;
        }
    }   
    if($new_id !== false){
        $orderInsert = "INSERT INTO order_id(user_id,id,order_text,order_time) VALUES('$user_id','$id','$pos_id','$order_time')";            
        if($dbconnect->query($orderInsert) === TRUE){
            $reply_restoran = "Стол: ".$table."\nЗаказ: ".$pos_id."\nКоличество: ".$pos_name; 
            inlineKeyboard($restoran,$chat_id,$reply_restoran,confirm($table,$pos_name,$pos_id));
        } 
    }
    else{
        answerCallbackQuery($klient, $output['callback_query']['id'], "Ваш заказ уже подтвержден, ожидайте!", true);
    }
}
?>
