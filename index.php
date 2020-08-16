<?php

include ('vendor/autoload.php');
include ('menu.php');
include ('settings.php');
include ('bot_lib.php');
include ('yandex_translate.php');
use Telegram\Bot\Api;

$telegram = new Api($api);
$result = $telegram->getWebhookUpdates();

$text = $result["message"]["text"];                 //Текст сообщения
$chat_id = $result["message"]["chat"]["id"];        //Уникальный идентификатор пользователя
$name = $result["message"]["from"]["username"];     //Юзернейм пользователя
$first_name = $result["message"]["from"]["first_name"];
$last_name = $result["message"]["from"]["last_name"];
$get_user = get_user($connect,$chat_id);
$old_id = $get_user['chat_id'];
$username = $first_name .  ' ' . $last_name;

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
else if ($text == "42"){
    $img = 'https://project42.space/42.jpg';
    $reply = "Hello " . $first_name . " " . $last_name;
    $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
    $telegram->sendPhoto(['chat_id' => $chat_id, 'photo' => $img, 'caption' => $reply, 'parse_mode' => 'HTML']);
}
else if($text == "Новости"){
    $xml = simplexml_load_file('https://news.google.com/rss/topics/CAAqKAgKIiJDQkFTRXdvSkwyMHZNR1ptZHpWbUVnSnlkUm9DVWxVb0FBUAE?hl=ru&gl=RU&ceid=RU%3Aru');
    $i = 0;
    $reply = "Наука и технологии: \n\n";
    foreach ($xml->channel->item as $item){
        $i++;
        if($i>10){
            break;
        }
        $reply .= "\xE2\x9E\xA1 ".$item->title."\nДата: ".
            $item->pubDate."(<a href='".$item->link."'>Читать полностью</a>)\n\n";
    }
    $telegram->sendMessage(['chat_id' => $chat_id, 'parse_mode' => 'HTML',
        'disable_web_page_preview' => true, 'text' => $reply]);
}

else if(explode(' ', $text)[0] == "/переводчик"){
    yandex_translate();
}

add_user($connect, $username,$chat_id,$name,$old_id);
textlog($connect, $chat_id, $text);
