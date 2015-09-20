<?php
namespace API;

require_once __DIR__ . '/src/Framework/Functions.php';

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
     * @var string
     */
    public static $root;

    /**
     *
     * @var string
     */
    const REPOSITORY_NAME = 'API';

    /**
     *
     * @var Instance
     */
    protected static $instance;

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
    static public function build($argv)
    {
        static::$root = __DIR__;
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
            // Silently win
            return true;
        } else {
            die('Invalid filename ' . $class . '. Epic failure in Autoloader');
            return false;
        }
    }
}

/**
 * Bootstrap
 */
Autoloader::build($argv); //Where all the things begin
