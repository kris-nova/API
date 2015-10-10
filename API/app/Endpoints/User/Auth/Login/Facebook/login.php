<?php
use Facebook\Facebook;
use API\src\Config\Config;
use API\src\Server\Session;
require_once __DIR__ . '/../../../../../../Autoload.php';
$session = new Session();
$session->start();

$fb = new Facebook([
    'app_id' => Config::getConfig('FacebookAppId'),
    'app_secret' => Config::getConfig('FacebookSecret'),
    'default_graph_version' => Config::getConfig('FacebookAPIVersion')
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl('http://10.1.1.50/User/Auth/Login/Facebook/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';