<?php
namespace API\src\Rest;

use API\src\Error\Error;

/**
 * Used to get the verb for the request
 *
 *
 * Sep 20, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Verbs
{

    /**
     * Will return the constant for whatever verb the request is using
     * The logic is return on success, without checking for a race condition
     */
    static public function getVerb()
    {
        // Check $_SERVER
        if (! isset($_SERVER['REQUEST_METHOD'])) {
            Error::throwInternalException('Invalid runtime environment. No request type defined.');
        }
            /* GET */
        if (static::isGet()) {
            return v_get;
            /* POST */
        } elseif (static::isPost()) {
            return v_post;
            /* PUT */
        } elseif (static::isPut()) {
            return v_put;
            /* DELETE */
        } elseif (static::isDelete()) {
            return v_delete;
            /* UNKNOWN */
        } else {
            Error::throwInternalException('Unable to determine verb', i_emergency);
        }
    }

    /**
     * Will determine if this is a GET request or not
     *
     * @return boolean
     */
    static private function isGet()
    {
        $verb = $_SERVER['REQUEST_METHOD'];
        if ($verb == 'GET') {
            return true;
        }
        return FALSE;
    }

    /**
     * Will determine if this is a POST request or not
     *
     * @return boolean
     */
    static private function isPost()
    {
        $verb = $_SERVER['REQUEST_METHOD'];
        if ($verb == 'POST') {
            return true;
        }
        return FALSE;
    }

    /**
     * Will determine if this is a PUT request or not
     *
     * @return boolean
     */
    static private function isPut()
    {
        $verb = $_SERVER['REQUEST_METHOD'];
        if ($verb == 'PUT') {
            return true;
        }
        return FALSE;
    }

    /**
     * Will determine if this is a DELETE request or not
     *
     * @return boolean
     */
    static private function isDelete()
    {
        $verb = $_SERVER['REQUEST_METHOD'];
        if ($verb == 'DELETE') {
            return true;
        }
        return FALSE;
    }
}