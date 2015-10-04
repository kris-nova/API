<?php
namespace API\src\Endpoints\User\Auth;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;

class Login extends Endpoints
{

    public $request;

    public function get()
    {
        Error::throwApiException('`GET` operations are not currently supported for the endpoint ' . $this->request->endpoint, r_missing);
    }

    /**
     * Will attempt to create a new user in our system
     */
    public function post()
    {
        $this->cassandra->upsert($this->request);
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