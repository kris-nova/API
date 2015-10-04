<?php
namespace API;

/**
 * PHP Settings
 */
date_default_timezone_set('GMT');

/**
 * Framework magic
 */
require_once __DIR__ . '/src/Framework/Functions.php';
require_once __DIR__ . '/src/Framework/Constants.php';

/**
 * Composer magic
 */
$composerAutoload = __DIR__.'/../vendor/autoload.php';
if(file_exists($composerAutoload)){
    require_once $composerAutoload;
}else{
    die('Please run composer to install dependencies!'.PHP_EOL);
}

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
     * The root directory
     *
     * @var string
     */
    public static $root;

    /**
     * What have we called the repo
     *
     * @var string
     */
    const REPOSITORY_NAME = 'API';

    /**
     * Static instance memory pointer
     *
     * @var Instance
     */
    protected static $instance = false;

    /**
     * Extensions to Autoload
     *
     * @var array
     */
    protected $extensions = array(
        '.php'
    );

    /**
     * Static function to build the Autoloader
     * Static factory
     */
    static public function build()
    {
        static::$root = __DIR__;
        if (! static::$instance) {
            static::$instance = new self();
        }
        return true;
    }

    /**
     * Build the class
     *
     * @param array $argv            
     */
    public function __construct()
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
        // echo $class.PHP_EOL;
        $root = Autoloader::$root;
        $len = strlen(Autoloader::REPOSITORY_NAME);
        $classPath = substr($class, $len);
        $included = false;
        foreach ($this->extensions as $key => $ext) {
            $fullClassPath = $root . str_replace('\\', '/', $classPath) . $ext;
            if (file_exists($fullClassPath)) {
                $included = true;
                require_once $fullClassPath;
            }
        }
        if ($included) {
            /* Silently win */
            return true;
        } else {
            /* We might want to make this better */
            die('Invalid filename ' . $class . '. Epic failure in Autoloader' . PHP_EOL);
            return false;
        }
    }
}

/**
 * Bootstrap
 */
Autoloader::build(); //Where all the things begin