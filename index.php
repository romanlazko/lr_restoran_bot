<?php

//   $servername="db4free.net: 3306";
//   $username="promocoder";
//   $password="zdraste1234";
//   $dbname="promocoder";
//   $dbconnect = new mysqli($servername, $username, $password, $dbname);

  define('EARTH_RADIUS', 6372795);

  $token = "780647425:AAH5bmyGITVXverN4VIns4Z4VlT03W-sGtM";
  $token2 = "633839981:AAHmf8yb2TJ9oEIL9ia2qYnrbbaWb6ULaBQ";
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
      $reply = "Привет ".$first_name.".\n".
          "Добро пожаловать в бота!
          \n*Список доступных команд:*
          \n/start\n/help";
      sendMessage($token,538296130,$reply);
  }



  function sendMessage($token,$chat_id,$reply){
      $parameters = [
          'chat_id' => $chat_id, 
          'text' => $reply, 
      ];
      file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
  }
//   function sendKeyboard($token,$chat_id,$buttons,$reply){
//       $keyboard =  json_encode($keyboard = ['keyboard' => $buttons, 
//                                             'resize_keyboard' => true, 
//                                             'one_time_keyboard' => false, 
//                                             'selective' => false]);  
//       $parameters = [
//           'chat_id' => $chat_id, 
//           'text' => $reply, 
//           'reply_markup' => $keyboard,
//       ];
//       file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
//   }
//   function inlineKeyboard($token,$chat_id,$reply,$buttons){
//       $inlineKeyboard = json_encode(array("inline_keyboard" => $buttons),true);
//       $parameters = [
//           'chat_id' => $chat_id, 
//           'text' => $reply, 
//           'reply_markup' => $inlineKeyboard,
//       ];
//       file_get_contents('https://api.telegram.org/bot' . $token . '/sendMessage?' . http_build_query($parameters).'&parse_mode=Markdown');
//   }
//   function editMassage($token,$chat_id,$message_id,$message,$buttons){
//       $inlineKeyboard = array("inline_keyboard" => $buttons);
//       $inlineKeyboard = json_encode($inlineKeyboard,true);        
//       $parameters = [
//           'chat_id' => $chat_id, 
//           'message_id' => $message_id, 
//           'text' => $message,
//           'reply_markup' => $inlineKeyboard,
//       ];
//       file_get_contents('https://api.telegram.org/bot' . $token . '/editMessageText?' . http_build_query($parameters).'&parse_mode=Markdown');
//   }
//   function deleteMessage($token,$chat_id,$message_id){     
//       $parameters = [
//           'chat_id' => $chat_id, 
//           'message_id' => $message_id, 
//       ];
//       file_get_contents('https://api.telegram.org/bot' . $token . '/deleteMessage?' . http_build_query($parameters));
//   }
//   $dbconnect->close();
?>
