<?php
use API\src\Config\Config;
use API\src\Request\Request;
require_once __DIR__ . '/../Autoload.php';

/*
 * Create new request
 */
$request = new Request();

/*
 * Build mock request
 */
$request->body = '{}';
$request->protocol = p_http;
$request->status = s_new;
$request->isAuthenticated = true;
$request->type = t_json;
$request->headers = array();
$request->endpoint = 'Auth/Login';
$request->verb = v_post;

/*
 * Send
 */
try {
    $request->process();
    //We get here, win request
    die('win');
} catch (Exception $e) {
    print_r($e->getMessage().PHP_EOL);
    die();
}
