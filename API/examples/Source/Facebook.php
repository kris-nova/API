<?php

/*
 * Get access token from http://10.1.1.50/User/Auth/Login/Facebook
 */

/* Closing slashes are important here */
$url = 'http://10.1.1.50/User/Source/Facebook/index.php';
$accessToken = 'CAAKDrhdZAZA60BAPZAeBfZCBbdYOk6E0c1j5YZCk0rlOIW735DH3jrl1D16ZAZBEhuqxnUDqsbTlRdsZBrpLKtzPv13MSckKoHQ6SbZBZBKfMUUzHLL3lAwebITVd6XBgL4I00kWb2CeRREtb9j6LOYmFwllM7ZAuj1LdpEXjiz4FJbKtW3KEYMEzxmVVhkeWcl0SGyeOSLWQzjBwZDZD';
$userId = '178822619122617';

$url .= '?facebookAccessToken_text=' . $accessToken . '&facebookUserId_text=' . $userId.'&facebookFields_text=id,name,gender,bio,birthday,age_range,devices';
// $url = urlencode($url);

/* GET options only! */
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $url
));
$resp = curl_exec($ch);
curl_close($ch);

/* Check for valid response */
$jsonresp = json_decode($resp);
if (empty($jsonresp)) {
    echo 'Invalid JSON response from API. Raw Data : ' . PHP_EOL;
    print_r($resp);
    die();
}

print_r($jsonresp);
die();