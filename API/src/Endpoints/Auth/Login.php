<?php
namespace API\src\Endpoints\Auth;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Error;

/**
 * The primary class for handling all HTTP requests for login
 *
 * After the user has been authenticated and a valid HTTP request has been sent
 *
 * The API will return more information on how to proceed with authenticated
 * HTTPs requests
 *
 * The idea here is that we will have a generic login request format, that can
 * be authenticated with us, google, facebook, etc, etc..
 * 
 * But all API sessions will start here :)
 *
 * Sep 20, 2015
 * 
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Login extends Endpoints
{

    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get()
    {
        Error::throwApiException('`GET` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
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