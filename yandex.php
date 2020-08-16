<?php

function yandex_translate()
{
    $token = "1012626756:AAEfnux4jc_W_O8f0x87_L6ejWMMK9wvPhc";
// key yandex translate
    $key = '';
    $file = file_get_contents('php://input');
    $json = json_decode($file, true);
    $chat_id = $json['message']['chat']['id'];
//
    $message = $json['message']['text'];
//
    $message = urlencode($message);
//
    $detect = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/detect?key=$key&text=$message");
//
    $detect = json_decode($detect, true);
    $detect = $detect['lang'];

    $yandex = file_get_contents("https://translate.yandex.net/api/v1.5/tr.json/translate?key=$key&lang=$detect-en&text=$message");

    $yandex = json_decode($yandex, true);
    $answer = '';
    foreach ($yandex['text'] as $value) {
        $answer .= ' ' . $value;
    }


    $output = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$answer");
    return $output;
}

