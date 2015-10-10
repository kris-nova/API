<?php
use Facebook\Facebook;
use API\src\Config\Config;
use API\src\Server\Session;
require_once __DIR__ . '/../Autoload.php';


$fb = new Facebook([
    'app_id' => Config::getConfig('FacebookAppId'),
    'app_secret' => Config::getConfig('FacebookSecret'),
    'default_graph_version' => Config::getConfig('FacebookAPIVersion')
]);

$app = $fb->getApp();

$accessToken = $app->getAccessToken();
$accessTokenValue = $accessToken->getValue();

$oauth2 = $fb->getOAuth2Client();
$tokenMeta = $oauth2->debugToken($accessToken);
$tokenMeta->validateAppId(Config::getConfig('FacebookAppId'));
$tokenMeta->validateExpiration();


