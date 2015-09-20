<?php

/**
 * Debug Die
 * 
 * Great function to debug and die anything in PHP
 * 
 */
function dd()
{
    $args = func_get_args();
    foreach($args as $key => $arg){
        print_r($arg);
        if(!is_array($arg) || !is_object($arg)){
            print_r(PHP_EOL);
        }
    }
    die(1);
}

