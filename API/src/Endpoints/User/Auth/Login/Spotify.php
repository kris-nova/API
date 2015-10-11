<?php
namespace API\src\Endpoints\User\Auth\Login;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Error;
use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\Session;
use API\src\Config\Config;

class Spotify extends Endpoints
{

    public $request;

    public function get()
    {
        $session = new Session(Config::getConfig('SpotifyAppId'), Config::getConfig('SpotifySecret'));
        $callback = 'http://'.Config::getConfig('Hostname').'/User/Auth/Login/Spotify/index.php';
        $session->setRedirectUri($callback);
        $url = $session->getAuthorizeUrl();
//         header('Location: '.$url);
        print_r($url);
        die;
        
        
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