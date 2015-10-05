<?php
namespace API\src\Request;

use API\src\Error\Error;
use API\src\Data\Schema;

/**
 * Request validation
 *
 * This will be a rule based procedural class
 *
 * The class parses validation from the top down
 * The class will look for methods that follow the convention:
 * validateMethod()
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Validate
{

    /**
     * Will check the request object for null class properties
     */
    public function validateNotNullProperties()
    {
        foreach (get_object_vars($this->request) as $key => $value) {
            if (($value)) {
                $this->fail('Missing value for `' . $key . '` in request');
            }
        }
    }

    /**
     * Will validate the request body against the defined schema
     */
    public function validateRequestSchema()
    {
        $body = $this->request->body;
        foreach ($this->request->schema as $name => $options) {
            // We only care properties where required = 1
            if ($options['required'] == 1) {
                $found = false;
                foreach ($body as $key => $value) {
                    if ($name == $key) {
                        $found = true;
                        break;
                    }
                }
                if (! $found) {
                    $this->fail('Missing required property ' . $name . ' [' . $options['type'] . ']');
                }
            }
        }
    }

    /**
     *
     * @var Request;
     */
    protected $request = null;

    /**
     *
     * @param Request $request            
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Validation failure
     *
     * @param string $message            
     */
    protected function fail($message = null)
    {
        $backtrace = debug_backtrace();
        $failingMethod = $backtrace[1]['function'];
        Error::throwValidationException($failingMethod, $message);
    }

    /**
     * The static method to handle :
     * - Dependency injection
     * - Instance factory
     * - Applied procedural function handling
     *
     * @param Request $request            
     */
    static public function run(Request $request)
    {
        $instance = new self($request);
        $reflection = new \ReflectionClass($instance);
        $methodsObjs = $reflection->getMethods();
        foreach ($methodsObjs as $methodsObj) {
            $methodName = $methodsObj->name;
            if (strpos($methodName, 'validate') === 0) {
                $break = $instance->$methodName();
                if ($break) {
                    break;
                }
            }
        }
    }
}