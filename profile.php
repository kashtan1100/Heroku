<?php


$access_token = '1012626756:AAEfnux4jc_W_O8f0x87_L6ejWMMK9wvPhc';

$userId = 'U5ace03d6c9ff4a67a5006b48fc5e2491';

$url = 'https://api.line.me/v2/bot/profile/'.$userId;

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;

