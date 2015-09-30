<?php
namespace API\src\Data\Cassandra;

use \PDO as PDO;

class Connector {

    public function __construct($host = 'localhost'){
        $this->host = $host;
        $dsn = "cassandra:host=$host;port=9160";
        $db = new PDO($dsn);
        print_r($db);
        die;
    }
    
    
}
$connector = new Connector('10.1.1.45');

