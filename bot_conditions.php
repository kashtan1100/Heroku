<?php
function command($text,$telegram,$chat_id,$name,$first_name,$last_name,$menu)
{
    if ($text == "/start") {
        $reply = "Menu: ";
        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu,
            'resize_keyboard' => true, 'one_time_keyboard' => false]);
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply,
            'reply_markup' => $reply_markup]);

    } else if ($text == "Привет") {
        $reply = "Привет " . $first_name . " " . $last_name;
        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu,
            'resize_keyboard' => true, 'one_time_keyboard' => false]);
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply,
            'reply_markup' => $reply_markup]);
    } else if ($text == "42") {
        $img = 'https://project42.space/42.jpg';
        $reply = "Hello " . $first_name . " " . $last_name;
        $reply_markup = $telegram->replyKeyboardMarkup(['keyboard' => $menu, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
        $telegram->sendPhoto(['chat_id' => $chat_id, 'photo' => $img, 'caption' => $reply, 'parse_mode' => 'HTML']);
    } else if ($text == "Новости") {
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
    } else if (explode(' ', $text)[0] == "/tr") {
        yandex_translate();
    } else if ($text = "Inline") {
        $reply = "Inline keyboard";
        $inline[] = ['text' => 'Bot', 'url' => ''];
        $inline = array_chunk($inline, 2);
        $reply_markup = ['inline_keyboard' => $inline];
        $inline_keyboard = json_encode($reply_markup);
        $telegram->sendMessage(['chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $inline_keyboard]);
    }
}