<?php
namespace API;

/**
 *
 * The main Autoloader that ties all the things together
 *
 * Sep 19, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Autoloader
{

    /**
     *
     * @var Instance
     */
    protected static $instance;

    /**
     * Static function to build the Autoloader
     * Static factory
     */
    static public function build($argv)
    {
        static::$instance = new self($argv);
    }

    /**
     * Build the class
     *
     * @param array $argv            
     */
    public function __construct($argv = array())
    {
        spl_autoload_register(array(
            $this,
            'autoload'
        ));
    }

    /**
     * The magic autoloading method
     *
     * @param string $class            
     */
    protected function autoload($class)
    {
        print_r($class);
        die();
    }
}

/**
 * Bootstrap
 */
Autoloader::build($argv); //Where all the things begin