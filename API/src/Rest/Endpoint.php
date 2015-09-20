<?php
namespace API\src\Rest;

/**
 *
 * Commonly used endpoint logic
 *
 * Sep 20, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Endpoint
{

    /**
     * What is the endpoint for the request
     *
     * @return string
     */
    static public function getEndpoint()
    {
        $file = $_SERVER['SCRIPT_FILENAME'];
        $endpoint = str_replace('/index.php', '', $file);
        $epExp = explode('Endpoints/', $endpoint);
        return $epExp[1];
    }
}