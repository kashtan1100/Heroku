<?php

include ('vendor/autoload.php');
use Telegram\Bot\Api;

$telegram = new Api('1012626756:AAEfnux4jc_W_O8f0x87_L6ejWMMK9wvPhc');
$result = $telegram->getWebhookUpdates();

$text = $result['message']['text'];
$chat_id = $result['message']['chat']['id'];
$name = $result['message']['from']['username'];
$first_name = $result['message']['from']['first_name'];
$last_name = $result['message']['from']['last_name'];

if($text == "/start"){
    $reply = 'Hello World' . $first_name . ' ' . $last_name;
    $telegram->sendMessage(['chat_id' => $chat_id , 'text => $reply']);

}