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
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Google extends Endpoints
{

    public $request;

    public function get()
    {
        $callback = 'http://api.soundeavor.com/User/Auth/Login/Google/index.php';
        $config = new \Google_Config();
        $config->setApplicationName('Soundeavor');
        $config->setClientId(Config::getConfig('GoogleClientId'));
        $config->setClientSecret(Config::getConfig('GoogleClientSecret'));
        $config->setRedirectUri($callback);
        $client = new \Google_Client($config);
        
        /*
         * Add scopes (permissions) for the client https://developers.google.com/oauthplayground/
         */
        $client->addScope('https://www.googleapis.com/auth/plus.me');
        if (! isset($_GET['code'])) {
            $loginUrl = $client->createAuthUrl();
            header('Location: ' . $loginUrl);
        }
        $code = $_GET['code'];
        $client->authenticate($code);
        $accessToken = $client->getAccessToken();
        $accessToken = $accessToken['access_token'];
        $service = new \Google_Service_Plus($client);
        $scopes = $service->availableScopes;
        print_r($scopes);
        die();
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