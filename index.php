<?php

$servername="db4free.net: 3306";
$username="romanlazko";
$password="zdraste123";
$dbname="promocoder1";
$dbconnect = new mysqli($servername, $username, $password, $dbname);
// define('EARTH_RADIUS', 6372795);

$restoran = "780647425:AAH5bmyGITVXverN4VIns4Z4VlT03W-sGtM";
$klient = "738988528:AAH9NXpv9RdgUiUKLE5hYB8nheHSLWW4aOI";
$output = json_decode(file_get_contents('php://input'),true);
$inline_data = $output['callback_query']['data'];
$message_id = $output['callback_query']['message']['message_id'];
$first_name = $output['message']['from']['first_name'];
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


if(isset($inline_data)){
    $chat_id = $output['callback_query']['message']['chat']['id'];
    $user_id = $output['callback_query']['from']['id'];

    $str = substr($inline_data, 0, strrpos($inline_data, '/'));
    $str2 = substr($str, 0, strrpos($str, '/'));
    $button = substr($str2, 0, strrpos($str2, '/'));
    $table = substr($str2, strrpos($str2,"/")+1);    
    $pos_name = substr($str, strrpos($str,"/")+1);
    $pos_id = substr($inline_data, strrpos($inline_data,"/")+1);
}else{
    $button = $output['message']['text'];
    $chat_id = $output['message']['chat']['id'];
    $user_id = $output['message']['from']['id'];
}

if($button =='/start'){        
    $reply_klient = "Привет ".$first_name.".\n".
        "Добро пожаловать в бота!\nЧто бы начать заказывать, отсканируй QR код на столе.";
    $buttons = [
      [array('text' => 'Сканировать QR код', 'url' => 'https://lrrestoranbot.herokuapp.com/qr.php?'.$chat_id)]
    ];
    inlineKeyboard($klient,$chat_id,$reply_klient,$buttons);
}
if($button =='continue'){
    $reply_klient = "Что бы вы хотели выбрать?";
    inlineKeyboard($klient,$chat_id,$reply_klient,menu($table,$pos_name,$pos_id));
}
if($button =='menu'){     
    showPos($klient,$chat_id,$dbconnect,$table);
}
if($button =='plus'){
    $pos_name=$pos_name+1;
    if($pos_name < 5)editMassage($klient,$chat_id,$message_id,posData($pos_id,$dbconnect)['pos_name'],order($table,$pos_name,$pos_id));
}
if($button =='minus'){
    $pos_name=$pos_name-1;
    if($pos_name > 0)editMassage($klient,$chat_id,$message_id,posData($pos_id,$dbconnect)['pos_name'],order($table,$pos_name,$pos_id));
}
if($button =='order'){
    $reply_klient = "Ваш заказ:\n".posData($pos_id,$dbconnect)['pos_name']."\n
    Количество: " .$pos_name."\n
    Подтвердить заказ?";
    $buttons = [
         [array('text' => "Подтвердить заказ", 'callback_data' => 'confirm/'.$table.'/'.$pos_name.'/'.$pos_id)],
         [array('text' => "Отмена", 'callback_data' => 'noconfirm/'.$table.'/'.$pos_name.'/'.$pos_id)]
    ]; 
    editMassage($klient,$chat_id,$message_id,$reply_klient,$buttons);
}
if($button =='noconfirm'){
    $reply_klient = posData($pos_id,$dbconnect)['pos_name'];
    editMassage($klient,$chat_id,$message_id,$reply_klient,order($table,1,$pos_id));
}
if($button =='confirm'){
    $reply_restoran = "Стол: ".$table."\nЗаказ: ".$pos_id; 
    //inlineKeyboard($restoran,$chat_id,$reply_restoran,buttons("Принять заказ",'accept',$table,));
}
if($button =='accept'){
    $reply_restoran = "Стол: ".$table."\nЗаказ: ".$pos_id;
    $buttons = [
         [array('text' => "Готово", 'callback_data' => 'done/'.$table.'/'.$pos_id)]
    ];
    editMassage($restoran,$chat_id,$message_id,$reply_restoran,$buttons);
}
function menu($table,$pos_name,$pos_id){
    $buttons = [
         [array('text' => "Меню", 'callback_data' => 'menu/'.$table.'/'.$pos_name.'/'.$pos_id)]
    ];  
    return $buttons;
}
function order($table,$pos_num,$pos_id){
    $buttons = [
         [array('text' => 'Заказать', 'callback_data' => 'order/'.$table.'/'.$pos_num.'/'.$pos_id)],
         [array('text' => '-', 'callback_data' => 'minus/'.$table.'/'.$pos_num.'/'.$pos_id),
          array('text' => $pos_num, 'callback_data' => 'minus/'.$table.'/'.$pos_num.'/'.$pos_id),
          array('text' => '+', 'callback_data' => 'plus/'.$table.'/'.$pos_num.'/'.$pos_id)]
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
//     $buttons = [["Позвать официанта"],["Позвать кальянщика"],["Меню"]];
//     sendKeyboard($klient,$chat_id,$buttons,$reply_klient);
//     inlineKeyboard($klient,$chat_id,'Выберете номер своего стола',tables($user_id));
//     $reply_restoran = "Подключение к Боту\n
//     *Имя:*".$first_name;
//     sendMessage($restoran,387145540,$reply_restoran);
?>

