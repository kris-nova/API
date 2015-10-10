<?php
/**
 * Simple cURL POST request
 * 
 */

/* Closing slashes are important here */
$url = 'http://localhost/User/Auth/Login/Facebook/';

/* init */
$ch = curl_init();

$body = array(
);

$fields = json_encode($body, JSON_PRETTY_PRINT);

/* POST options only! */
curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
));

$resp = curl_exec($ch);

curl_close($ch);
$jsonresp = json_decode($resp);
if($jsonresp){
    print_r($jsonresp);
}else{
    print_r('Invalid JSON Response. Raw Output : '.PHP_EOL);
    print_r($resp);
    echo PHP_EOL;
}