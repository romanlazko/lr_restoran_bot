<?php

$servername="db4free.net: 3306";
$username="restoran";
$password="zdraste1234";
$dbname="restoran_klient";
$dbconnect = new mysqli($servername, $username, $password, $dbname);

define('EARTH_RADIUS', 6372795);

$restoran = "780647425:AAH5bmyGITVXverN4VIns4Z4VlT03W-sGtM";
$klient = "738988528:AAH9NXpv9RdgUiUKLE5hYB8nheHSLWW4aOI";
$output = json_decode(file_get_contents('php://input'),true);
$inline_data = $output['callback_query']['data'];
$message_id = $output['callback_query']['message']['message_id'];
$latitude = $output['message']['location']['latitude'];
$longitude = $output['message']['location']['longitude'];
$first_name = $output['message']['from']['first_name'];

//   include 'BD.php';

if(isset($inline_data)){
    $chat_id = $output['callback_query']['message']['chat']['id'];
    $user_id = $output['callback_query']['from']['id'];

    $str = substr($inline_data, 0, strrpos($inline_data, '/'));
    $category = substr($str, strrpos($str,"/")+1);
    $button = substr($str, 0, strrpos($str, '/'));
    $pos_id = substr($inline_data, strrpos($inline_data,"/")+1);

}else{
    $button = $output['message']['text'];
    $chat_id = $output['message']['chat']['id'];
    $user_id = $output['message']['from']['id'];
}

if($button =='/start'){        
    $reply_klient = "Привет ".$first_name.".\n".
        "Добро пожаловать в бота!
        \n*Список доступных команд:*
        \n/start\n/help";
    
    $buttons = [["Позвать официанта"],["Позвать кальянщика"]];
    sendKeyboard($klient,$chat_id,$buttons,$reply_klient);
    inlineKeyboard($klient,$chat_id,'Выберете номер своего стола',tables($user_id));
}

// if($button =='/start'){        
//     $reply_klient = "Привет ".$first_name.".\n".
//         "Добро пожаловать в бота!
//         \n*Список доступных команд:*
//         \n/start\n/help
//         \nНапишите номер своего стола";
//     $reply_restoran = "Подключение к Боту\n
//     *Имя:*".$first_name.
//       "Стол";
//     $buttons = [["Позвать официанта"],["Позвать кальянщика"]];
//     sendKeyboard($klient,$chat_id,$buttons,$reply_klient);
//     sendMessage($restoran,538296130,$reply_restoran);
// }
if($button =='Позвать официанта'){        
    $reply_klient = "Привет ".$first_name.".\n".
        "Добро пожаловать в бота!
        \n*Список доступных команд:*
        \n/start\n/help";
    $reply_restoran = "Подключение к Боту\n
    *Имя:*".$first_name;
    $buttons = [["Позвать официанта"],["Позвать кальянщика"]];
    sendKeyboard($klient,$chat_id,$buttons,$reply_klient);
    sendMessage($restoran,$chat_id,$reply_restoran);
}


function tables($user_id){
    $table1 = array('text' => 'table1', 'callback_data' => 'table1/'.$user_id.'1');
    $table2 = array('text' => 'table2', 'callback_data' => 'table2/'.$user_id.'1');
    $table3 = array('text' => 'table3', 'callback_data' => 'table3/'.$user_id.'1');
    $table4 = array('text' => 'table4', 'callback_data' => 'table4/'.$user_id.'1');
    $table5 = array('text' => 'table5', 'callback_data' => 'table5/'.$user_id.'1');
    $table6 = array('text' => 'table6', 'callback_data' => 'table6/'.$user_id.'1');
    $table7 = array('text' => 'table7', 'callback_data' => 'table7/'.$user_id.'1');
    $table8 = array('text' => 'table8', 'callback_data' => 'table8/'.$user_id.'1');
    $buttons = [
      [$table1,$table2],
      [$table3,$table4],
      [$table5,$table6],
      [$table7,$table8]
    ];
    return $buttons;
}
function sendMessage($token,$chat_id,$reply){
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
}
function sendKeyboard($token,$chat_id,$buttons,$reply){
    $keyboard =  json_encode($keyboard = ['keyboard' => $buttons, 
                                          'resize_keyboard' => true, 
                                          'one_time_keyboard' => false, 
                                          'selective' => false]);  
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
        'reply_markup' => $keyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
}
function inlineKeyboard($token,$chat_id,$reply,$buttons){
    $inlineKeyboard = json_encode(array("inline_keyboard" => $buttons),true);
    $parameters = [
        'chat_id' => $chat_id, 
        'text' => $reply, 
        'reply_markup' => $inlineKeyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
}
function editMassage($token,$chat_id,$message_id,$message,$buttons){
    $inlineKeyboard = array("inline_keyboard" => $buttons);
    $inlineKeyboard = json_encode($inlineKeyboard,true);        
    $parameters = [
        'chat_id' => $chat_id, 
        'message_id' => $message_id, 
        'text' => $message,
        'reply_markup' => $inlineKeyboard,
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/editMessageText?' . http_build_query($parameters).'&parse_mode=Markdown');
}
function deleteMessage($token,$chat_id,$message_id){     
    $parameters = [
        'chat_id' => $chat_id, 
        'message_id' => $message_id, 
    ];
    file_get_contents('https://api.telegram.org/bot' . $token . '/deleteMessage?' . http_build_query($parameters));
}
$dbconnect->close();
?>
