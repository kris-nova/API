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
            /* Invalid Usague */
            echo 'Usage: php CreateNewEndPoint <endpoint> <comment = null>'.PHP_EOL;
            echo 'Ex   : php CreateNewEndPoint Auth/Login "Used to authenticate login requests"'.PHP_EOL;
            die(1);
        }
        /* Add comment to file */
        $comment = '';
        if(isset($argv[2])){
            $comment = $argv[2];
        }
        
        $endpoint = str_replace('/', '\\', $argv[1]);
        $exp = explode('\\', $endpoint);
        $depth = count($exp);
        $class = array_pop($exp);
        
        /* Write app endpoint */
        echo 'Writing app endpoint..' . PHP_EOL;
        $appFileToWrite = __DIR__ . '/../API/app/Endpoints/' . str_replace('\\', '/', $endpoint) . '/index.php';
        @mkdir(dirname($appFileToWrite), '0644', 1);
        $appContents = file_get_contents(__DIR__ . '/DefaultContent/AppEndpoint');
        $depth = '/../..';
        foreach ($exp as $d) {
            $depth .= '/..';
        }
        $appContents = str_replace('<<DEPTH>>', $depth, $appContents);
        $appContents = str_replace('<<COMMENT>>', $comment, $appContents);
        file_put_contents($appFileToWrite, $appContents);
        
        /* Write src endpoint */
        echo 'Writing src endpoint..' . PHP_EOL;
        $srcContent = file_get_contents(__DIR__ . '/DefaultContent/SrcEndpoint');
        $inc = '';
        foreach($exp as $e){
            $inc .= $e.'\\';
        }
        $inc = substr($inc, 0, -1);
        $srcContent = str_replace('<<INC>>', $inc, $srcContent);
        $srcContent = str_replace('<<CLASS>>', $class, $srcContent);
        $srcFileToWrite = __DIR__ . '/../API/src/Endpoints/' . str_replace('\\', '/', $endpoint) . '.php';
        @mkdir(dirname($srcFileToWrite), '0644', 1);
        file_put_contents($srcFileToWrite, $srcContent);
        
        /* Write default .json */
        echo 'Writing default endpoint json..' . PHP_EOL;
        $table = strtolower($endpoint);
        $table = str_replace('\\', '_', $table);
        $table = strtolower($exp[0]).'.'.$table;
        $tableContents = file_get_contents(__DIR__. '/DefaultContent/endpoint.json');
        $tableFileToWrite = dirname($srcFileToWrite).'/'.$class.'.json';
        file_put_contents($tableFileToWrite, $tableContents);
        
        /* All done! */
        echo 'Done..' . PHP_EOL;
    }
}
$create = new CreateNewEndPoint($argv);