<?php



require "vendor/autoload.php";

$access_token = '1012626756:AAEfnux4jc_W_O8f0x87_L6ejWMMK9wvPhc';

$channelSecret = '6ff492dd1e967482a78926a0ec910eaf';

$pushID = 'U5ace03d6c9ff4a67a5006b48fc5e2491';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello world');
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







