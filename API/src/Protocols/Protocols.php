<?php
namespace API\src\Protocols;

/**
 * Protocols class
 *
 *
 * Sep 20, 2015
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Protocols
{

    /**
     * Logic for HTTP vs HTTPs
     */
    static public function getProtocol()
    {
        if(isset($_SERVER['HTTPS'])){
            return p_https;
        }
        return p_http;
    }
}