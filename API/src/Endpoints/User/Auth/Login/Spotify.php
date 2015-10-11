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

    /**
     * (non-PHPdoc)
     * @see \API\src\Endpoints\Endpoints::get()
     */
    public function get()
    {
        $session = new Session(Config::getConfig('SpotifyAppId'), Config::getConfig('SpotifySecret'));
        $callback = 'http://api.soundeavor.com/User/Auth/Login/Spotify/index.php';
        $session->setRedirectUri($callback);
        $url = $session->getAuthorizeUrl();
        if (!isset($_GET['code'])) {
            header('Location: ' . $url);
        }
        $code = $_GET['code'];
        $api = new SpotifyWebAPI();
        $session->requestToken($code);
        $api->setAccessToken($session->getAccessToken());
        $me = $api->me();
        $body['spotifyName_text'] = $me->display_name;
        $body['spotifyAccessToken_text'] = $session->getAccessToken();
        $body['spotifyUserId_text'] = $me->id;
        $this->request->response->body = $body;
        $this->request->response->code = r_success;
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