<?php

include ('vendor/autoload.php');
include ('menu.php');
include ('yandex.php');
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
else if ($text == "лунный пельмень") {
    $img = 'https://onwomen.ru/wp-content/uploads/2020/01/pelmeni-400x266.jpg';
    $reply = "Hello " . $first_name . " " . $last_name;
    $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
    $telegram->sendPhoto(['chat_id' => $chat_id, 'photo' => $img, 'caption' => $reply, 'parse_mode' => 'HTML']);
}

else if ($text == "Новости") {
    $xml = simplexml_load_file('https://news.google.com/rss/topics/CAAqKAgKIiJDQkFTRXdvSkwyMHZNR1ptZHpWbUVnSnlkUm9DVWxVb0FBUAE?hl=ru&gl=RU&ceid=RU%3Aru');
    $i = 0;
    $reply = "Наука и технологии: \n\n";
    foreach ($xml->channel->item as $item) {
        $i++;
        if ($i > 10) {
            break;
        }
        $reply .= "\xE2\x9E\xA1 " . $item->title . "\nДата: " .
            $item->pubDate . "(<a href='" . $item->link . "'>Читать полностью</a>)\n\n";
    }
    $telegram->sendMessage(['chat_id' => $chat_id, 'parse_mode' => 'HTML',
        'disable_web_page_preview' => true, 'text' => $reply]);
}

else if (explode(' ', $text)[0] == "/tr") {
    yandex_translate();
}

