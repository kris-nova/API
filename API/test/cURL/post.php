<?php
/**
 * Simple cURL GET request
 * 
 */

/* Closing slashes are important here */
$url = 'http://localhost/Auth/Login/';

/* init */
$ch = curl_init();

$fields = "{}";

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
die();