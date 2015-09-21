<?php
namespace API\src\Endpoints\Auth;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Error;
use API\src\Auth\Auth;

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

    /**
     *
     * @var Request
     */
    public $request;

    /**
     * Populate request
     *
     * @param Request $request            
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\Endpoints::get()
     */
    public function get()
    {
        Error::throwApiException('`GET` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    /**
     * Attempt to login with existing credentials
     *
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\Endpoints::post()
     */
    public function post()
    {
        //
    }

    /**
     * Attempt to create a new account
     *
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\Endpoints::put()
     */
    public function put()
    {
        Error::throwApiException('`GET` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    /**
     *
     * Attempt to delete an account
     *
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\Endpoints::delete()
     */
    public function delete()
    {
        Error::throwApiException('`DELETE` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    public function getResponse()
    {
        //
    }
}