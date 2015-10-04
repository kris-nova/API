<?php
/**
 * Simple cURL GET request
 * 
 */

/* Closing slashes are important here */
$url = 'http://localhost/User/Auth/Login/';

/* init */
$ch = curl_init();

$body = array(
    'user' => 'kris'
);

$fields = json_encode($body, JSON_PRETTY_PRINT);

/* POST options only! */
curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $fields
));

$resp = curl_exec($ch);

curl_close($ch);

print_r($resp);
die(1);