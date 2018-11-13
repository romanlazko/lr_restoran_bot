<?php
function userfunc($token,$chat_id,$user_id,$dbconnect){
    $new_user = true;
    $result = $dbconnect->query("SELECT user_id FROM users");
    while($row = $result->fetch_assoc()){
        
        if($row['user_id']==$user_id){
            $new_user = false;
            break;
        }
    }   
    if($new_user === false){
        sendMessage($token,$chat_id,'ТЫ СТАРЫЙ ПОЛЬЗОВАТЕЛЬ');
    }
    else{
        $createUser = "INSERT INTO users(user_id,userLat,userLong,position,posName,pos_id) VALUES('$user_id','0','0','0','a','0')";            
        if($dbconnect->query($createUser) === TRUE){
            sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
        }
    }
   
};
function updateLocation($token,$chat_id,$dbconnect,$user_id,$latitude,$longitude){
    $putLocation = "UPDATE `users` SET `userLat` = '$latitude', `userLong` = '$longitude' WHERE `user_id` = '$user_id'";
    if($dbconnect->query($putLocation) === TRUE){
        if(distance('48.4420860','35.0160808',$latitude,$longitude) < 20000){
            $reply = 'Ваш город Днепр';        
        }
        else {
            $reply = 'Ваш город в Пизде мира';
        }
        $buttons = [["Настройки"],["Категории"]];
        sendKeyboard($token,$chat_id,$buttons,$reply);
    }
}
function showPos($position,$token,$dbconnect,$chat_id,$category){
    $result = $dbconnect->query("SELECT posName, pos_id FROM $category WHERE position = '$position'");
    while($row = $result->fetch_assoc()){
        inlineKeyboard($token,$chat_id,$row['posName'],More($row['pos_id'],$category));        
    }   
}
function posData($pos_id,$dbconnect,$from){
    
    $result = $dbconnect->query("SELECT more,posName FROM $from WHERE pos_id = '$pos_id'");
    while($row = $result->fetch_assoc()){        
        return $row;
    }   
}
// function promocodeInsert($token,$chat_id,$dbconnect,$pos_id,$user_id,$promocode){
//     $promocodeInsert = "INSERT INTO promocodes(pos_id,user_id,promocode) VALUES('$pos_id','$user_id','$promocode')";            
//     if($dbconnect->query($promocodeInsert) === TRUE){
//         sendMessage($token,$chat_id,'Промо-код записан'); 
//     }
// }
function promocodeExam($dbconnect,$pos_id,$user_id){
    include 'promocode.php';
    $promocode = promocode();
    $result = $dbconnect->query("SELECT promocode
                                 FROM promocodes 
                                 WHERE pos_id = '$pos_id' AND user_id = '$user_id'");
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()){        
            return $row['promocode'];
        } 
    }
    else {
        $promocodeInsert = $dbconnect->query("INSERT INTO promocodes(pos_id,user_id,promocode) 
                                              VALUES('$pos_id','$user_id','$promocode')");
        return $promocode;
    }   
}
// function create($token,$chat_id,$dbconnect){
//     $login = "promocodes";
//     $ucertable = "CREATE TABLE $login (
//                     pos_id INT(30) NOT NULL,
//                     user_id INT(30) NOT NULL,
//                     promocode INT(30) NOT NULL)";
//     if($dbconnect->query($ucertable) === TRUE){
//         sendMessage($token,$chat_id,'Создана таблица');
//     }      
// //     $login = "MisterCat";
// //     $createUser = "INSERT INTO EatAndDrinks(posName,posLat, posLong, posShow) VALUES('$login','48.4643541','35.0468668','notShow')";
// //             if($dbconnect->query($createUser) === TRUE){
// //                 sendMessage($token,$chat_id,'Добавлено'); 
// //             }
//  };
?>
