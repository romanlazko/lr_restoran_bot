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
$latitude = $output['message']['location']['latitude'];
$longitude = $output['message']['location']['longitude'];
$first_name = $output['message']['from']['first_name'];

    include 'db.php';


if(isset($inline_data)){
    $chat_id = $output['callback_query']['message']['chat']['id'];
    $user_id = $output['callback_query']['from']['id'];

    $str = substr($inline_data, 0, strrpos($inline_data, '/'));
    $button = substr($str, 0, strrpos($str, '/'));
    $table = substr($str, strrpos($str,"/")+1);    
    $pos_id = substr($inline_data, strrpos($inline_data,"/")+1);
}else{
    $button = $output['message']['text'];
    $chat_id = $output['message']['chat']['id'];
    $user_id = $output['message']['from']['id'];
}

if($button =='/start'){        
    $reply_klient = "Привет ".$first_name.".\n".
        "Добро пожаловать в бота!\nЧто бы начать заказывать, отсканируй QR код на столе.";
    $button = [
      [array('text' => 'Сканировать QR код', 'url' => 'https://lrrestoranbot.herokuapp.com/qr.php?'.$chat_id)]
    ];
    inlineKeyboard($klient,$chat_id,$reply_klient,$button);
}
if($button =='continue'){
    $reply_klient = "Что бы вы хотели выбрать?";
    $menu = array('text' => 'Меню', 'callback_data' => 'menu/'.$table.'/'.$user_id);
    $button = [
         [$menu]
    ];
    inlineKeyboard($klient,$chat_id,$reply_klient,$button);
    //sendMessage($restoran,387145540,$reply_restoran);
}
if($button =='menu'){     
    $result = $dbconnect->query("SELECT bear FROM restoran");
    while($row = $result->fetch_assoc()){
        inlineKeyboard($klient,$chat_id,$row['bear'],order($table,$row['bear']));        
    }
}
if($button =='order'){
    $reply_klient = "Вы точно хотите заказать ".$pos_id." ?";
    $confirm = array('text' => "Подтвердить заказ", 'callback_data' => 'confirm/'.$table.'/'.$pos_id);
    $noconfirm = array('text' => "Отмена", 'callback_data' => 'noconfirm/'.$table.'/'.$pos_id);
    $button = [
         [$confirm],
         [$noconfirm]
    ]; 
    editMassage($klient,$chat_id,$message_id,$reply_klient,$button);
}
if($button =='noconfirm'){
    $reply_klient = $pos_id;
    editMassage($klient,$chat_id,$message_id,$reply_klient,order($table,$pos_id));
}
if($button =='confirm'){
    $reply_restoran = "Стол: ".$table."\nЗаказ: ".$pos_id;
    $button = [
         [array('text' => "Принять заказ", 'callback_data' => 'accept/'.$table.'/'.$pos_id)]
    ];  
    inlineKeyboard($restoran,$chat_id,$reply_restoran,$button);
}
if($button =='accept'){
    $reply_restoran = "Стол: ".$table."\nЗаказ: ".$pos_id;
    $button = [
         [array('text' => "Готово", 'callback_data' => 'done/'.$table.'/'.$pos_id)]
    ];
    editMassage($restoran,$chat_id,$message_id,$reply_restoran,$button);
}
function order($table,$bear){
    $order = array('text' => "Заказать", 'callback_data' => 'order/'.$table.'/'.$bear);
    $buttons = [
         [$order]
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

