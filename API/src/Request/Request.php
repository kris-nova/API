<?php
namespace API\src\Request;

use API\src\Error\Exceptions\ApiException;
use API\src\Error\Error;
use API\src\Protocols\Protocols;
use API\src\Rest\Verbs;
use API\src\Rest\Body;
use API\src\Rest\Header;
use API\src\Auth\Auth;
use API\src\Rest\Endpoint;

/**
 * All HTTP(s) requests should be transformed into this
 *
 * This should build itself on instantiation
 *
 * Validation will handle any errors
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Request
{

    public $id = null;

    public $protocol = null;

    public $verb = null;

    public $body = null;

    public $type = null;

    public $headers = null;

    public $status = null;

    public $transaction = null;

    public $isAuthenticated = null;

    public $endpoint = null;

    /**
     */
    public function __construct()
    {
        $this->id = uniqid(); /* Lets give this request a unique ID */
        $this->protocol = Protocols::getProtocol(); /* HTTP(s) */
        $this->verb = Verbs::getVerb(); /* How are we sending this request? */
        $this->body = Body::getBody(); /* If the request has a body, we better get it */
        $this->type = Body::getType(); /* I wonder what type of body this is */
        $this->headers = Header::getHeaderArray(); /* Get the headers, if we have them */
        $this->status = s_new; /* New request */
        /*transaction is handled in Process::run(); */
        $this->isAuthenticated = Auth::isAuthenticated();
        $this->endpoint = Endpoint::getEndpoint();
    }

    /**
     * Process the request
     */
    public function process()
    {
        Process::run($this);
    }
}
