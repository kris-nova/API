<?php
namespace API\src\Endpoints\User\Auth\Login;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Error;
use API\src\Config\Config;

/**
 * Used to Authenticate with Google
 *
 *
 * Oct 10, 2015
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Google extends Endpoints
{

    public $request;

    public function get()
    {
        $callback = 'http://api.soundeavor.com/User/Auth/Login/Google/';
        $config = new \Google_Config();
        $config->setApplicationName('Soundeavor');
        $config->setClientId(Config::getConfig('GoogleClientId'));
        $config->setClientSecret(Config::getConfig('GoogleClientSecret'));
        $config->setRedirectUri($callback);
        $client = new \Google_Client($config);
        $client->addScope('https://www.googleapis.com/auth/urlshortener');
        
        $service = new \Google_Service_Urlshortener($client);
        
        if (isset($_GET['code'])) {
            die('hrmm?');
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }else{
            $url = $client->createAuthUrl();
            header('Location: ' . $url);
        }
        
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
        } else {
            $authUrl = $client->createAuthUrl();
        }
        
        if ($client->getAccessToken()) {
            $url = new Google_Service_Urlshortener_Url();
            $url->longUrl = $_GET['url'];
            $short = $service->url->insert($url);
            $_SESSION['access_token'] = $client->getAccessToken();
            print_r($_SESSION);
            die;
        }
        
//         if (isset($_GET['code'])) {
//             //We are in a callback
//             $client->authenticate($_GET['code']);
//             $accessToken = $client->getAccessToken();
//             print_r($accessToken);
//             die;
//         }else{

//         }

        die('WE GOT HERE');
        
        
        
        
    }

    public function post()
    {
        Error::throwApiException('`POST` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    public function put()
    {
        Error::throwApiException('`GET` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    public function delete()
    {
        Error::throwApiException('`DELETE` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    public function getResponse()
    {
        //
    }
}