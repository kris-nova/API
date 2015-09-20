<?php

namespace API\src\Rest;

class Endpoint {
    
    static public function getEndpoint(){
        $file = $_SERVER['SCRIPT_FILENAME'];
        $endpoint = str_replace('/index.php', '', $file);
        $epExp = explode('Endpoints/', $endpoint);
        print_r($epExp[1]);
        die;
    }
    
}