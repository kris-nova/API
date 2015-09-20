<?php
namespace API\src\Auth;

use API\src\Request\Request;

/**
 * Future Auth class
 *
 *
 * Sep 20, 2015
 * 
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Auth
{

    /**
     * Logic for authenticating API requests
     *
     * This is the method that prevents people from hacking us
     *
     * @param Request $request            
     * @return boolean
     */
    static public function isAuthenticated()
    {
        return true; /* This needs a meeting with the gang */
    }
}