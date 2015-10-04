<?php
namespace API\src\Data;

use API\src\Error\Exceptions\ApiException;
class Schema
{
    
    static public $schema = null;

    static public function getSchemaArray($request)
    {
        if(static::$schema){
            return static::$schema;
        }
        $json = __DIR__ . '/../Endpoints/'.$request->endpoint.'.json';
        if(file_exists($json)){
            $content = file_get_contents($json);
            $array = json_decode($content, true);
            if(empty($array)){
                throw new ApiException('Invalid json schema file', r_server);
            }
            return static::$schema = $array;
        }else{
            throw new ApiException('Missing json schema file', r_server);
        }
    }
}