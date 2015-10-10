<?php
namespace API\src\Endpoints\User\Auth\Login;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Error;
use Facebook\Facebook as Fb;
use API\src\Config\Config;
use API\src\Debug\Logger;
use API\src\Debug\LogException;
use API\src\Error\Exceptions\ApiException;

class Facebook extends Endpoints
{

    public $request;

    /**
     * Send an empty request here
     *
     * The API will forward the request to the Facebook graph API, prompt the user to login
     * Validate the access token
     * Create a long lived access token
     * Return the token and login URL to the consumer for reference
     * We are now logged in with facebook, and can start scraping user data
     */
    public function get()
    {
        Logger::info($this->request->body);
        $fb = new Fb([
            'app_id' => Config::getConfig('FacebookAppId'),
            'app_secret' => Config::getConfig('FacebookSecret'),
            'default_graph_version' => Config::getConfig('FacebookAPIVersion')
        ]);
        $helper = $fb->getRedirectLoginHelper();
        try {
            $accessToken = $helper->getAccessToken();
            // Prompt for creds
            if (empty($accessToken)) {
                $permissions = array(
                    'email'
                );
                $loginUrl = $helper->getLoginUrl('http://' . Config::getConfig('Hostname') . '/User/Auth/Login/Facebook/index.php', $permissions);
                header("Location: $loginUrl"); // Forward the request to facebook for login
            } else {
                // Valid access token!
                $oAuth2Client = $fb->getOAuth2Client();
                $tokenMetadata = $oAuth2Client->debugToken($accessToken);
                $tokenMetadata->validateAppId(Config::getConfig('FacebookAppId'));
                $tokenMetadata->validateExpiration();
                if (! $accessToken->isLongLived()) {
                    try {
                        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
                    } catch (Facebook\Exceptions\FacebookSDKException $e) {
                        LogException::e($e);
                        throw new ApiException($e->getMessage(), r_server);
                    }
                }
            }
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            LogException::e($e);
            throw new ApiException($e->getMessage(), r_server);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            LogException::e($e);
            throw new ApiException($e->getMessage(), r_server);
        }
        $body['loginUrl'] = $loginUrl;
        $body['facebookAccessToken'] = $accessToken->getValue();
        $this->request->response->body = $body;
        $this->request->response->code = r_success;
        return $this->request;
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