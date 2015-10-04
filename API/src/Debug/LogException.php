<?php
namespace API\src\Debug;

use API\src\Debug\Logger;

/**
 * Used to log an exception class
 *
 *
 * Oct 3, 2015
 * 
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class LogException
{

    /**
     * Will log an exception
     *
     * @param Exception $e            
     */
    static public function e($e)
    {
        $message = $e->getMessage();
        $code = $e->getCode();
        $file = $e->getFile();
        Logger::error('Exception ' . $code . ' ' . $message . ' ' . $file);
    }
}