<?php

include "config.php";

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(isset($update["message"])){

$chat_id = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];

}

function sendMessage($chat_id,$message,$keyboard=null){

global $bot_token;

$url = "https://api.telegram.org/bot".$bot_token."/sendMessage";

$post = [
"chat_id"=>$chat_id,
"text"=>$message,
"parse_mode"=>"HTML"
];

if($keyboard){
$post["reply_markup"] = $keyboard;
}

$ch = curl_init($url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
curl_exec($ch);
curl_close($ch);

}

if(isset($text) && $text == "/start"){

$keyboard = json_encode([
"inline_keyboard"=>[
[
["text"=>"💎 Get Premium","callback_data"=>"premium"]
],
[
["text"=>"🎬 Premium Demo","url"=>$demo_channel]
],
[
["text"=>"📖 How To Get Premium","url"=>$show_channel]
]
]
]);

sendMessage($chat_id,"💰 Price ₹99\n⏳ Validity Lifetime",$keyboard);

}

?>
