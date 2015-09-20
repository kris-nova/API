<?php
namespace API\src\Error\Exceptions;

use \Exception as Exception;

class ApiException extends Exception
{

    public function __construct($message, $code, $previous)
    {
        //
    }
}