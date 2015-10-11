<?php
namespace API\src\Rest;

use API\src\Error\Error;
use API\src\Request\Request;

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

    static public function addBody(Request &$request)
    {
        $request->type = static::getType();
        switch ($request->type) {
            case t_json:
                $request->body = json_decode(static::getBody(), 1);
                break;
            case t_xml:
                Error::throwInternalException('XML is not yet supported - see future release');
                break;
        }
        if(isset($request->body['s_id'])){
            $request->id = $request->body['s_id'];
        }
    }

    /**
     * Will return the body of the request
     */
    static public function getBody()
    {
        switch (Verbs::getVerb()) {
            case v_get:
                if(empty($_GET)){
                    return '{}';
                }
                return json_encode($_GET);
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
//         if (Verbs::getVerb() == v_get) {
//             return - 1;
//         }
        $body = Body::getBody();
        $possibleJson = json_decode($body);
        if ($possibleJson) {
            return t_json;
        }
        Error::throwInternalException('The API does not support types other than JSON yet OR you have invalid JSON');
    }
}