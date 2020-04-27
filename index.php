<?php

/* токен бота, базовый URL для управления им и идентификатор чата бота с админом */
$bot_access_token = '1012626756:AAEfnux4jc_W_O8f0x87_L6ejWMMK9wvPhc';
$admin_chat_id = 'ADMINCHARID';
$bot_api = 'https://api.telegram.org/bot' . $bot_access_token;

// получаем то, что передано боту в POST-сообщении и
// распарсиваем в ассоциативный массив
$input_array = json_decode(file_get_contents('php:input'), true);

$chat_id = $input_array['message']['chat']['id'];  // выделяем идентификатор чата
$message = $input_array['message']['text'];        // выделяем сообщение

// начинаем распарсивать полученное сообщение
$command = '';      // команды нет
$user_chat_id = ''; // адресат не определён
$user_text = '';    // текст от юзера пустой
$admin_text = '';   // текст сообщения от админа тоже пустой

$message_length = strlen($message);           // определяем длину сообщения
if ($message_length != 0) {                   // если сообщение не нулевое
    $fs_pos = strpos($message, ' ');   // определяем позицию первого пробела
    if ($fs_pos === false) {                  // если пробелов нет,
        $command = $message;                  //  то это целиком команда, без текста
    } else {                                  // если пробелы есть,
        // выделяем команду и текст
        $command = substr($message, 0, $fs_pos);
        $user_text = substr($message, $fs_pos + 1, $message_length - $fs_pos - 1);

        $user_text_length = strlen($user_text); // определяем длину выделенного текста
        // если команда от админа и после неё есть текст - продолжаем парсить
        if (($chat_id == $admin_chat_id) && ($command === '/send') && ($user_text_length != 0)) {
            // определяем позицию второго пробела
            $ss_pos = strpos($user_text, ' ');   // если второго пробела нет
            if ($ss_pos === false) {                    // то это целиком id чата назначения,
                $user_chat_id = $user_text;             // а user_text - пустой
                $user_text = '';
            }
            else{                                     // если пробелы есть
                // выделяем id чата назначения и текст
                $user_chat_id = substr($user_text,0,$ss_pos);
                $admin_text = substr($user_text,$ss_pos+1,$user_text_length-$ss_pos-1);
            }
        }
    }
}

/* Функция отправки сообщения в чат с использованием метода sendMessage*/
function sendMessage($var_chat_id,$var_message){
    file_get_contents($GLOBALS['bot_api'].'/sendMessage?chat_id='.$var_chat_id.'&text='.urlencode($var_message));
}

// после того, как всё распарсили, - начинаем проверять и выполнять
switch ($command){
    case ('/start') :
    case ('/help') :
        sendMessage($chat_id,
            'Здравствуйте! Я робот, бла-бла-бла. Я знаю такие команды:
                        /help - вывести список поддерживаемых команд
                        /send <i>message</i> - послать <i>message</i> админу');
    // если это команда от админа, дописываем что можно только ему
    if ($chat_id == $admin_chat_id){
        // посылаем текст по назначению (в указанный user_chat)
        sendMessage($user_chat_id,$admin_text);
    }
    else{
        sendMessage($admin_chat_id,$chat_id. ': '.$user_text);
    }
    break;
    // команда /whoami добавлена чтобы админ мог узнать и записать
    // id своего чата с ботом, после этого её можно стереть
    case('/whoami'):
        sendMessage($chat_id,$chat_id);    // отсылаем юзеру id его чата с ботом
        break;
    default:
        sendMessage($chat_id,'неизвестная команда');
        break;
}