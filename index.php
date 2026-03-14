<?php

include "config.php";

$update = json_decode(file_get_contents("php://input"), true);

if(isset($update["message"])){

$chat_id = $update["message"]["chat"]["id"];
$text = $update["message"]["text"];

}

function sendMessage($chat_id,$text,$keyboard=null){

global $bot_token;

$url = "https://api.telegram.org/bot$bot_token/sendMessage";

$data = [
"chat_id"=>$chat_id,
"text"=>$text,
"reply_markup"=>$keyboard
];

$options = [
"http"=>[
"header"=>"Content-Type: application/json",
"method"=>"POST",
"content"=>json_encode($data)
]
];

$context = stream_context_create($options);

file_get_contents($url,false,$context);

}

if($text=="/start"){

$keyboard = json_encode([
"inline_keyboard"=>[
[
["text"=>"Get Premium","callback_data"=>"premium"]
],
[
["text"=>"Premium Demo","url"=>$demo_channel]
],
[
["text"=>"How To Get Premium","url"=>$show_channel]
]
]
]);

sendMessage($chat_id,"Price ₹99\nValidity Lifetime",$keyboard);

}

?>
