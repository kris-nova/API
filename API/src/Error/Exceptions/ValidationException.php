<?php
namespace API\src\Error\Exceptions;

use \Exception as Exception;

/**
 * This is what happens when a request fails validation
 * 
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class ValidationException extends Exception
{

    /**
     * What method failed validation
     *
     * @var string
     */
    public $failureMethod;

    /**
     * Build a new validation failure
     *
     * @param string $failureMethod            
     * @param string $message            
     */
    public function __construct($failureMethod = null, $message = null)
    {
        $this->message = $message;
        $this->failureMethod = $failureMethod;
        $this->code = r_missing;
        $this->previous = null;
    }
}