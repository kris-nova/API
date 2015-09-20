<?php
namespace API\src\Endpoints;

use API\src\Endpoints\EndpointsInterface;
use API\src\Request\Request;
use API\src\Error\Error;

/**
 * All API Endpoints *MUST* extend this
 *
 * Basically, if you plan on building an endpoint, it has to agree with this class
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

    /**
     * We always need our request object
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
     * @see \API\src\Endpoints\EndpointsInterface::get()
     */
    public function get()
    {
        Error::throwInternalException('`GET` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \API\src\Endpoints\EndpointsInterface::post()
     */
    public function post()
    {
        Error::throwInternalException('`POST` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \API\src\Endpoints\EndpointsInterface::put()
     */
    public function put()
    {
        Error::throwInternalException('`PUT` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \API\src\Endpoints\EndpointsInterface::delete()
     */
    public function delete()
    {
        Error::throwInternalException('`DELETE` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\EndpointsInterface::run()
     */
    public function run()
    {
        $verb = $this->request->verb;
        switch ($verb) {
            case v_get:
                $this->get();
                break;
            case v_post:
                $this->post();
                break;
            case v_put:
                $this->put();
                break;
            case v_delete:
                $this->delete();
                break;
        }
    }

    /**
     * (non-PHPdoc)
     * 
     * @see \API\src\Endpoints\EndpointsInterface::getResponse()
     */
    public function getResponse()
    {
        // Here be dragons
    }
}