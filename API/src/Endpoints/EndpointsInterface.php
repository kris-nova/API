<?php
namespace API\src\Endpoints;

use API\src\Request\Request;

/**
 * All endpoints will follow this convention
 *
 * If you are adding logic to the API it better damn well implement this interface
 *
 *
 * Sep 20, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
interface EndpointsInterface
{

    /**
     * Dependency Injection
     * Basically we will always need the request
     *
     * @param Request $request            
     */
    public function __construct(Request $request);

    /**
     * get (Read)
     *
     * Used to parse get requests
     */
    public function get();

    /**
     * post (Create)
     *
     * Used to parse post requests
     */
    public function post();

    /**
     * put (Update)
     *
     * Used to parse put requests
     */
    public function put();

    /**
     * delete (Delete)
     *
     * Used to parse delete requests
     */
    public function delete();

    /**
     * Well return a response object for this endpoint
     */
    public function getResponse();

    /**
     * This is the main method of how we enter all endpoint classes
     */
    public function run();
}