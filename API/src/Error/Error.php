<?php
namespace API\src\Error;

use API\src\Error\Exceptions\ApiException;
use API\src\Error\Exceptions\InternalException;
use API\src\Error\Exceptions\ValidationException;

/**
 * Main Error handling class
 *
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Error
{

    /**
     * Will throw an API Exception
     *
     * @param string $mesage            
     * @param string $code            
     * @param string $previous            
     * @throws ApiException
     */
    static public function throwApiException($message = null, $code = null, $previous = null)
    {
        throw new ApiException($message, $code, $previous);
    }

    /**
     * Will throw an Internal Exception
     *
     * @param string $mesage            
     * @param string $code            
     * @param string $previous            
     * @throws InternalException
     */
    static public function throwInternalException($message = null, $code = null, $previous = null)
    {
        throw new InternalException($message, $code, $previous);
    }
    
    /**
     * Will throw a Validation Exception
     * 
     * @param string $failingMethod
     * @param string $message
     */
    static public function throwValidationException($failingMethod, $message = null)
    {
        throw new ValidationException($failingMethod, $message);
    }
}