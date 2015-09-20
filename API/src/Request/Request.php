<?php
namespace API\src\Request;

use API\src\Error\Exceptions\ApiException;
use API\src\Error\Error;

/**
 * All HTTP(s) requests should be transformed into this
 *
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Request
{
    
    public $id = null;
    
    public $protocol = null;

    public $type = null;

    public $headers = null;

    public $body = null;

    public $status = null;

    public $transaction = null;

    public $isAuthenticated = null;

    public $endPoint = null;

    public $verb = null;
    
    public function __construct(){
        $this->id = uniqid();
    }

    /**
     * Process the request
     */
    public function process()
    {
        Process::run($this);
    }

}