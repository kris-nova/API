<?php
namespace API\src\Request;

use API\src\Config\Config;
use API\Autoloader;

/**
 * 
 *
 *
 * Sep 20, 2015
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Logic
{
    /**
     * Logic for autoloading classes by the naming convention in Endpoints
     */
    public function runClassByRequest(){
        $fullClassPath = 'API/src/Endpoints/'.$this->request->endpoint;
        $fullClassName = str_replace('/', '\\', $fullClassPath);
        $class = new $fullClassName($this->request);
        $class->run();
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