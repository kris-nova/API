<?php
namespace API\src\Endpoints\User\Auth;

use API\src\Endpoints\Endpoints;
use API\src\Request\Request;
use API\src\Error\Exceptions\ApiException;

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
        $this->request->body['password_text'] = md5($this->request->body['password_text']); //Encrypt the password
        $this->request->id = md5($this->request->body['email_text']); //What is our ID?
        if($this->cassandra->exists($this->request)){
            throw new ApiException('User exists', r_forbidden);
        }
        $result = $this->cassandra->insert($this->request);
        $this->request->response->body = 'User added';
        $this->request->response->code = r_success;
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