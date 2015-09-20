<?php
namespace API\src\Error\Exceptions;

use \Exception as Exception;

/**
 * If this is thrown, then you broke something in the framework
 * 
 * Basically, this is used for internal errors only
 * 
 * If the public see's this, we have a major security vulnerability
 *
 * Sep 19, 2015
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class InternalException extends Exception
{
    //
}