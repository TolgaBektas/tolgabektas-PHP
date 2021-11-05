<?php
ini_set("display_errors", 1);

// curl başlatıldı
$ch = curl_init('http://tolgabektas.com/');

//curl ayarları
//curl_setopt($ch, CURLOPT_URL, 'https ://php.net');
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_REFERER => 'https://google.com',
    CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT']
]);
//curl isteği çalıştırıldı
$source = curl_exec($ch);

//curl sonlandırıldı
curl_close($ch);

echo $source;
print_r($source);
