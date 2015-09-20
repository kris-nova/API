<?php
namespace API\src\Rest;

use API\src\Error\Error;

/**
 * Used for REST header information
 *
 * Sep 20, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Header
{

    /**
     * What do those headers look like?
     */
    static public function getHeaderArray()
    {
        return getallheaders();
    }
}