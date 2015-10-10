<?php
namespace API\src\Debug;

use API\src\Config\Config;

/**
 * Dat logger
 *
 *
 * Oct 3, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Logger
{

    public static $write = true;

    public static $output = false;

    public static $logLevel = - 1;

    const EMERGENCY = 1;

    const ALERT = 2;

    const CRITICAL = 4;

    const ERROR = 8;

    const WARNING = 16;

    const NOTICE = 32;

    const INFO = 64;

    const DEBUG = 128;

    /**
     * System is unusable.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function emergency($message)
    {
        static::log($message, static::EMERGENCY);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function alert($message)
    {
        static::log($message, static::ALERT);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function critical($message)
    {
        static::log($message, static::CRITICAL);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function error($message)
    {
        static::log($message, static::ERROR);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function warning($message)
    {
        static::log($message, static::WARNING);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function notice($message)
    {
        static::log($message, static::NOTICE);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function info($message)
    {
        static::log($message, static::INFO);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message            
     * @param array $context            
     * @return null
     */
    static public function debug($message)
    {
        static::log($message, static::DEBUG);
    }

    /**
     * All log calls come through here
     *
     * @param unknown $message            
     * @param string $level            
     */
    static protected function log($message, $level)
    {
        $line = static::getLine($message, $level);
        if (static::$write) {
            static::write($line, $level);
        }
        if (static::$output) {
            static::output($line);
        }
    }

    /**
     * Will send the line to stdout
     *
     * @param unknown $line            
     */
    static protected function output($line)
    {
        print_r($line);
    }

    /**
     * Will append the line to the configured logfile
     *
     * @param unknown $line            
     * @return number
     */
    static protected function write($line, $level)
    {
        if (static::$logLevel == - 1 || (static::$logLevel & $level)) {
            $date = date('Y-m-d');
            $logfile = Config::getConfig('LoggerDirectory') . '/' . Config::getConfig('LoggerFile') . $date;
            if (! file_exists(dirname($logfile))) {
                mkdir(dirname($logfile), '0775', true);
            }
            return file_put_contents($logfile, $line, FILE_APPEND);
        }
        return false;
    }

    /**
     * Will return the line we are logging
     *
     * @param unknown $message            
     * @param unknown $level            
     */
    static protected function getLine($message, $level)
    {
        switch ($level) {
            case static::EMERGENCY:
                $level = 'emergency';
                break;
            case static::ALERT:
                $level = 'alert';
                break;
            case static::CRITICAL:
                $level = 'critical';
                break;
            case static::ALERT:
                $level = 'alert';
                break;
            case static::CRITICAL:
                $level = 'critical';
                break;
            case static::ERROR:
                $level = 'error';
                break;
            case static::WARNING:
                $level = 'warning';
                break;
            case static::NOTICE:
                $level = 'notice';
                break;
            case static::INFO:
                $level = 'info';
                break;
            case static::DEBUG:
                $level = 'debug';
                break;
        }
        if (is_array($message) || is_object($message)) {
            $message = print_r($message, true);
        }
        $date = date('H:i:s');
        $line = $level . ' ' . $date . ' ' . $message . PHP_EOL;
        return $line;
    }
}