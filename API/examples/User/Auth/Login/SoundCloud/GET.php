<?php
use API\src\Config\Config;
use Httpful\Request;
require_once __DIR__ . '/../../../../../Autoload.php';


/******************************************************************************
 * User/Auth/Login/SoundCloud
 * 
 * Used to authenticate a user via SoundCloud
 * 
 * GET() Example
 * 
 *****************************************************************************/



/******************************************************************************
 * Define URI parameters
 *****************************************************************************/
$protocol = 'http://';
$hostname = Config::getConfig('Hostname');
$endpoint = '/User/Auth/Login/SoundCloud/';


/******************************************************************************
 * Define body ARRAY() and build parameters
*****************************************************************************/
$body[''] = '';
$body[''] = '';


$paramString = '?';
foreach($body as $key => $value){
    if(empty($key) || empty($value)){
        continue;
    }
    $paramString .= $key.'='.$value.'&';
}
$paramString = substr($paramString, 0, -1);


/******************************************************************************
 * Build URI
 *****************************************************************************/
$uri = $protocol.$hostname.$endpoint.$paramString;


/******************************************************************************
 * Send the request
 *****************************************************************************/
$response = Request::get($uri)->send();
$body = $response->body;

/******************************************************************************
 * Output our response
 * Failure on  : Empty response, Invalid JSON (raw dump)
 * Success on : Valid JSON
 *****************************************************************************/
if(empty($body)){
    echo '**FAILURE**'.PHP_EOL;
    echo 'Empty response'.PHP_EOL;
    die(1);
}
$json = json_decode($body, true);
if(empty($json)){
    echo '**FAILURE**'.PHP_EOL;
    echo 'Invalid JSON response. Raw Output : '.PHP_EOL;
    print_r($body);
    die(1);
}
echo '**Success!**'.PHP_EOL;
print_r($json);
die(0);
