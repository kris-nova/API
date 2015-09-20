<?php
namespace API\src\Rest;

use API\src\Error\Error;

/**
 *
 * Body class
 *
 * This needs caching and major type handling
 *
 *
 * Sep 20, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Body
{

    /**
     * Will return the body of the request
     */
    static public function getBody()
    {
        switch (Verbs::getVerb()) {
            case v_get:
                return - 1;
            case v_post:
                return file_get_contents('php://input');
            case v_put:
                return file_get_contents('php://input');
            case v_delete:
                return file_get_contents('php://input');
        }
    }

    /**
     * Based on the body, will attempt to determine a type
     *
     * @return string
     */
    static public function getType()
    {
        if (Verbs::getVerb() == v_get) {
            return - 1;
        }
        $body = Body::getBody();
        $possibleJson = json_decode($body);
        if ($possibleJson) {
            return t_json;
        }
        Error::throwInternalException('The API does not support types other than JSON yet OR you have invalid JSON');
    }
}