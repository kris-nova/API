<?php
namespace API\src\Config;

use API\Autoloader;

/**
 * Will parse all INI files in /cfg
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Config
{

    /**
     * Flag for build
     *
     * @var bool
     */
    protected static $isInit = false;

    /**
     * Config hash (if we have any)
     *
     * @var array
     */
    protected static $config = array();

    /**
     * Will build the config class if needed
     *
     * @return boolean
     */
    static public function init()
    {
        if (! static::$isInit) {
            $ini = static::getIniString();
            static::$config = parse_ini_string($ini);
        }
        return static::$isInit = true;
    }

    /**
     * Attempts to get a config key
     *
     * Will take alphabetical precedence on duplicate config keys
     * Whichever defines the key last alphabetically will be stored in memory
     *
     * @param string $key            
     * @param string $return            
     * @return string
     */
    static public function getConfig($key, $return = null)
    {
        static::init();
        if (isset(static::$config[$key])) {
            return static::$config[$key];
        }
        return $return;
    }

    /**
     * Will return the string of all ini files in /cfg
     *
     * @return string
     */
    static protected function getIniString()
    {
        $string = null;
        $files = scandir(Autoloader::$root . '/cfg');
        foreach ($files as $file) {
            if (strpos($file, 'ini') !== false) {
                $workingPath = Autoloader::$root . '/cfg/' . $file;
                $string .= file_get_contents($workingPath) . PHP_EOL;
            }
        }
        return $string;
    }
}

