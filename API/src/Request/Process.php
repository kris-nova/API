<?php
namespace API\src\Request;

/**
 *
 * Class for the main logic to process a request
 *
 * Still bound by a class, but EXTREMELY procedural logic
 *
 * Still clever and uses logic to call methods according to convention
 *
 * 1. Validate
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Process
{

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
     * All validation for the request should live here
     */
    protected function runValidate()
    {
        Validate::run($this->request);
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
            if (strpos($methodName, 'run') === 0 && $methodName !== 'run') {
                $break = $instance->$methodName();
                if ($break) {
                    break;
                }
            }
        }
    }
}