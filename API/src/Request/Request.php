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
use API\src\Data\Schema;
use API\src\Response\Response;

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

    /**
     * Unique (time based) ID for the request
     *
     * @var string
     */
    public $id = null;

    /**
     * The start timestamp for this request
     *
     * @var string
     */
    public $startTime = null;

    /**
     * Enum for which protocol the request came in on
     *
     * @var int
     */
    public $protocol = null;

    /**
     * Enum for the request verb (GET, POST, PUT, DELETE, etc..)
     *
     * @var int
     */
    public $verb = null;

    /**
     * The body of the request (if applicable)
     * Otherwise will set to -1
     *
     * @var unknown
     */
    public $body = null;

    /**
     * Enum for the request type (JSON, XML, etc..)
     *
     * @var int
     */
    public $type = null;

    /**
     * Array of `key => value` header pairs
     *
     * @var array
     */
    public $headers = null;

    /**
     * Enum for the request status in memory
     *
     * @var int
     */
    public $status = null;

    /**
     * The recursive transaction object
     *
     * @var Transaction
     */
    public $transaction = null;

    /**
     * Flag to let us know if the request has been authenticated
     *
     * @var bool
     */
    public $isAuthenticated = null;

    /**
     * Common name for the endpoint the request came in on
     *
     * @var string
     */
    public $endpoint = null;

    /**
     * The keyspace for this endpoint
     *
     * @var string
     */
    public $keyspace = null;

    /**
     * The table for this request
     *
     * @var string
     */
    public $table = null;

    /**
     * Schema for the request
     *
     * @var array
     */
    public $schema = null;
    
    /**
     * The response object
     * 
     * @var Response
     */
    public $response = null;

    /**
     * This will build the request
     *
     * Basically we need to scrape very particular data out of PHP and the binaries existing memory load
     * This will form the data into what we consider "The Request"
     *
     * This is subject to change BUT,
     * The paradigm of always being able to automagically build "The Request" from memory will stay
     * "The Request" should magically appear from thin air here
     */
    public function __construct()
    {
        $this->startTime = new \Cassandra\Timestamp();
        $this->protocol = Protocols::getProtocol(); /* HTTP(s) */
        $this->verb = Verbs::getVerb(); /* How are we sending this request? */
        Body::addBody($this); /* First adaption - will add the body type and content to the object */
        /* If an ID is set, use it for the request, otherwise generate a new one */
        if (isset($this->body['s_id'])) {
            $this->id = $this->body['s_id'];
        } else {
            $this->id = uniqid();
        }
        $this->headers = Header::getHeaderArray(); /* Get the headers, if we have them */
        $this->status = s_new; /* New request */
        // /* Transactions are handled in Process */
        $this->isAuthenticated = Auth::isAuthenticated(); /* Lets us know if we are authenticated */
        $this->endpoint = Endpoint::getEndpoint(); /* Endpoint for the request */
        $exp = explode('/', $this->endpoint);
        $this->keyspace = strtolower($exp[0]); /* Cassandra keyspace for this request */
        $this->table = strtolower(str_replace('/', '_', $this->endpoint)); /* Table from endpoint */
        $this->schema = Schema::getSchemaArray($this); /* Schema map */
        $this->response = new Response();
    }

    /**
     * Process the request
     */
    public function process()
    {
        Process::run($this);
    }

    /**
     *
     * @param string $key            
     * @param string $required            
     * @param string $default            
     * @throws ApiException
     * @return unknown
     */
    public function get($key, $required = true, $default = null)
    {
        if (isset($this->body[$key])) {
            return $this->body[$key];
        }
        if ($required) {
            throw new ApiException('Missing request key `' . $key . '`', r_invalid);
        }
        return $default;
    }
}
