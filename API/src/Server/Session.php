<?php
namespace API\src\Server;

use API\src\Error\Exceptions\ApiException;
use API\src\Config\Config;
/**
 * Session object
 *
 *
 * Oct 10, 2015
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Session
{

    /**
     * Defines the session write path
     *
     * @param string $writePath            
     */
    public function __construct($writePath = null)
    {
        if (empty($writePath)) {
            $writePath = Config::getConfig('SessionSavePath');
        }
        if (! file_exists(dirname($writePath))) {
            mkdir(dirname($writePath), null, true);
        }
        session_save_path($writePath);
    }

    /**
     * Will start a session
     * 
     * @return boolean
     */
    public function start()
    {
        if(session_start()){
            return true;
        }
        throw new ApiException('Unable to start session', r_server);
    }
}