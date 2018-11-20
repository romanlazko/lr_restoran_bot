<?php
// function userfunc($token,$chat_id,$user_id,$dbconnect){
//     $new_user = true;
//     $result = $dbconnect->query("SELECT user_id FROM users");
//     while($row = $result->fetch_assoc()){
        
//         if($row['user_id']==$user_id){
//             $new_user = false;
//             break;
//         }
//     }   
//     if($new_user === false){
//         sendMessage($token,$chat_id,'ТЫ СТАРЫЙ ПОЛЬЗОВАТЕЛЬ');
//     }
//     else{
//         $createUser = "INSERT INTO users(user_id,userLat,userLong,position,posName,pos_id) VALUES('$user_id','0','0','0','a','0')";            
//         if($dbconnect->query($createUser) === TRUE){
//             sendMessage($token,$chat_id,'ТЫ НОВЫЙ ПОЛЬЗОВАТЕЛЬ'); 
//         }
//     }
   
// };
function showPos($klient,$chat_id,$dbconnect,$table){
    $result = $dbconnect->query("SELECT pos_name,pos_id FROM restoran");
    while($row = $result->fetch_assoc()){
        inlineKeyboard($klient,$chat_id,$row['pos_name'],order($table,1,$row['pos_id']));        
    }     
}
function posData($pos_id,$dbconnect){
    
    $result = $dbconnect->query("SELECT pos_name FROM restoran WHERE pos_id = '$pos_id'");
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
