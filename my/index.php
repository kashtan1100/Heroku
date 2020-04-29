<?php

include ('vendor/autoload.php');
include ('menu.php');
use Telegram\Bot\Api;

$telegram = new Api('1012626756:AAEfnux4jc_W_O8f0x87_L6ejWMMK9wvPhc');
$result = $telegram->getWebhookUpdates();

$text = $result["message"]["text"];
$chat_id = $result["message"]["chat"]["id"];
$name = $result["message"]["from"]["username"];
$first_name = $result["message"]["from"]["first_name"];
$last_name = $result["message"]["from"]["last_name"];

if($text == "/start"){
    $reply = "Menu: ";
    $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu,
        'resize_keyboard' => true, 'one_time_keyboard' => false]);
    $telegram->sendMessage(['chat_id' => $chat_id , 'text' => $reply,
        'reply_markup' => $reply_markup]);

}
else if ($text == "Привет"){
    $reply = "Привет " . $first_name . " " . $last_name;
    $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu,
        'resize_keyboard' => true, 'one_time_keyboard' => false]);
    $telegram->sendMessage(['chat_id' => $chat_id , 'text' => $reply,
        'reply_markup' => $reply_markup]);
}
else if ($text == "Кнопка 2"){
    $reply = "Привет " . $first_name . " " . $last_name . " это кнопка 2";
    $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu,
        'resize_keyboard' => true, 'one_time_keyboard' => false]);
    $telegram->sendMessage(['chat_id' => $chat_id , 'text' => $reply,
        'reply_markup' => $reply_markup]);
}