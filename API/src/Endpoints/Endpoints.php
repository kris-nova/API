<?php
namespace API\src\Endpoints;

use API\src\Endpoints\EndpointsInterface;
use API\src\Request\Request;

/**
 *
 *
 *
 * Sep 20, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Endpoints implements EndpointsInterface
{

    /**
     *
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function get()
    {
        //
    }

    public function post()
    {
        //
    }

    public function put()
    {
        //
    }

    public function delete()
    {
        //
    }
    
    /**
     * (non-PHPdoc)
     * @see \API\src\Endpoints\EndpointsInterface::run()
     */
    public function run(){
        //
    }

    /**
     * Not sure if this goes here yet
     * 
     */
    public function getResponse()
    {
        //
    }
}