<?php

/**
 * Really simple class for building new files
 * 
 * Because I am lazy and stuff
 * 
 * Really, I think the code here speaks to that
 * 
 * Sep 20, 2015
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class CreateNewEndPoint
{

    public function __construct($argv)
    {
        if (! isset($argv[1])) {
            die('Please pass the full endpoint path you wish to create [EX: Auth/Login] ' . PHP_EOL);
        }
        $endpoint = str_replace('/', '\\', $argv[1]);
        $exp = explode('\\', $endpoint);
        $depth = count($exp);
        $class = array_pop($exp);
        
        /* Write app endpoint */
        echo 'Writing app endpoint..' . PHP_EOL;
        $appFileToWrite = __DIR__ . '/../API/app/Endpoints/' . str_replace('\\', '/', $endpoint) . '/index.php';
        @mkdir(dirname($appFileToWrite), '0644', 1);
        $appContent = file_get_contents(__DIR__ . '/DefaultContent/AppEndpoint');
        $depth = '/../..';
        foreach ($exp as $d) {
            $depth .= '/..';
        }
        $appContents = str_replace('<<DEPTH>>', $depth, $appContent);
        file_put_contents($appFileToWrite, $appContents);
        
        /* Write src endpoint */
        echo 'Writing src endpoint..' . PHP_EOL;
        $srcContent = file_get_contents(__DIR__ . '/DefaultContent/SrcEndpoint');
        $inc = array_pop($exp);
        $srcContent = str_replace('<<INC>>', $inc, $srcContent);
        $srcContent = str_replace('<<CLASS>>', $class, $srcContent);
        $srcFileToWrite = __DIR__ . '/../API/src/Endpoints/' . str_replace('\\', '/', $endpoint) . '.php';
        @mkdir(dirname($srcFileToWrite), '0644', 1);
        file_put_contents($srcFileToWrite, $srcContent);
        
        /* All done! */
        echo 'Done..' . PHP_EOL;
    }
}
$create = new CreateNewEndPoint($argv);