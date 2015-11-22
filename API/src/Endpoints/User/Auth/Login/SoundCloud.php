<?php
namespace API\src\Endpoints\User\Auth\Login;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Error;
use Njasm\Soundcloud\SoundcloudFacade;
use API\src\Config\Config;

/**
 * Used to Authenticate with SoundCloud
 *
 *
 * Oct 10, 2015
 * 
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class SoundCloud extends Endpoints
{

    public $request;

    /**
     * Send an empty request here
     *
     * The API will forward the request to the SoundCloud API, prompt the user to login
     * Return the token and login URL to the consumer for reference
     * We are now logged in with SoundCloud, and can start scraping user data
     */
    public function get()
    {
        $callback = 'https://' . Config::getConfig('Hostname') . '/User/Auth/Login/SoundCloud/index.php';
        $facade = new SoundcloudFacade(Config::getConfig('SoundCloudAppId'), Config::getConfig('SoundCloudSecret'), $callback);
        $url = $facade->getAuthUrl();
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $token = $facade->codeForToken($code);
            $rBody = $token->bodyArray();
            $accessToken = $rBody['access_token'];
            $me = $facade->get('/me')->request();
            $scBody = $me->bodyArray();
            $clientId = $scBody['id'];
            $body['soundcloudAccessToken_text'] = $accessToken;
            $body['soundcloudUserId_text'] = $clientId;
            $body['soundcloudName_text'] = $scBody['full_name'];
            $this->request->response->body = $body;
            $this->request->response->code = r_success;
            return $this->request;
        } else {
            header('Location: ' . $url);
        }
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