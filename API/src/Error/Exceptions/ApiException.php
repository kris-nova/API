<?php
namespace API\src\Error\Exceptions;

use \Exception as Exception;

/**
 *
 * If something goes wrong with a request
 *
 * This is the form it takes
 *
 * This is designed to be ready for a valid HTTP(s) response!
 * Code = Response Code
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class ApiException extends Exception
{
    // Here be dragons
}
