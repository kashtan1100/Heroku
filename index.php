<?php

include ('vendor/autoload.php');
include ('menu.php');
include ('settings.php');
include ('bot_lib.php');
include ('yandex_translate.php');
include ('bot_conditions.php');
use Telegram\Bot\Api;

$telegram = new Api($api);
$api = ('1012626756:AAEfnux4jc_W_O8f0x87_L6ejWMMK9wvPhc');
$result = $telegram->getWebhookUpdates();

$text = $result["message"]["text"];                 //Текст сообщения
$chat_id = $result["message"]["chat"]["id"];        //Уникальный идентификатор пользователя
$name = $result["message"]["from"]["username"];     //Юзернейм пользователя
$first_name = $result["message"]["from"]["first_name"];
$last_name = $result["message"]["from"]["last_name"];
$get_user = get_user($connect,$chat_id);
$old_id = $get_user['chat_id'];
$username = $first_name .  ' ' . $last_name;


command($text,$telegram,$chat_id,$name,$first_name,$last_name,$menu);
add_user($connect, $username,$chat_id,$name,$old_id);
textlog($connect, $chat_id, $text);
