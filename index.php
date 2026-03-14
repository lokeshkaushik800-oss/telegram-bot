<?php

include "config.php";

$api = "https://api.telegram.org/bot$bot_token/";

$update = json_decode(file_get_contents("php://input"),true);

$message = $update["message"] ?? null;
$callback = $update["callback_query"] ?? null;

$chat_id = $message["chat"]["id"] ?? null;
$text = $message["text"] ?? "";

$data = $callback["data"] ?? null;
$cid = $callback["message"]["chat"]["id"] ?? null;

function sendMessage($chat,$msg,$keyboard=null){
global $api;

$params=[
"chat_id"=>$chat,
"text"=>$msg
];

if($keyboard){
$params["reply_markup"]=json_encode($keyboard);
}

file_get_contents($api."sendMessage?".http_build_query($params));

}

if($text=="/start"){

file_put_contents("users.txt",$chat_id."\n",FILE_APPEND);

$keyboard=[
"inline_keyboard"=>[
[
["text"=>"Buy Premium","callback_data"=>"premium"]
],
[
["text"=>"Premium Demo","url"=>$demo_channel]
],
[
["text"=>"How To Get Premium","url"=>$show_channel]
]
]
];

sendMessage($chat_id,"Price ₹99\nValidity Lifetime",$keyboard);

}

?>