<?php
namespace API\src\Request;

use API\src\Error\Exceptions\ValidationException;
use API\src\Response\Response;

/**
 *
 * Class for the main logic to process a request
 *
 * Still bound by a class, but EXTREMELY procedural logic
 *
 * Still clever and uses logic to call methods according to convention
 *
 * 1. Write Transaction
 * 2. Validate
 * 3. Logic
 * 4. Destroy Transaction
 *
 *
 * Sep 19, 2015
 *
 * @author Kris Childress <kris@nivenly.com> github.com/kris-nova
 */
class Process
{

    /**
     * Yes.
     * I am writing transactions we can rebuild from..
     * Seriously.
     *
     * There might be a bug here, because there will be a gap between the request being accepted, and getting here
     *
     * A pretty large gap too
     * So there will still be room for failure
     * But still, run transactions first
     *
     * Also, there is recursive object pointers here..
     */
    protected function runTransactionBuild()
    {
        $this->request->transaction = new Transaction($this->request); /* Write the transaction record to disk */
    }

    /**
     * All validation for the request should live here
     *
     * @throws ValidationException
     */
    protected function runValidate()
    {
        Validate::run($this->request);
    }

    /**
     * Okay, we have a valid and transactional request
     * I think it is safe to finally do something with it
     */
    protected function runLogic()
    {
        Logic::run($this->request); /* The logic to attempt to parse the request */
    }

    /**
     * Okay once we get here it is safe to destroy the transaction record for this request
     */
    protected function runTransactionDestroy()
    {
        $this->request->transaction->destroy(); /* Unlink the transaction file */
        unset($this->request->transaction); /* Destroy the pointer in memory */
    }

    /**
     * This request
     *
     * @var Request;
     */
    protected $request = null;

    /**
     * Populate class with the request pointer
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
