<?php
namespace API\src\Data\Cassandra;

require_once __DIR__ . '/../../../Autoload.php';
use \PDO as PDO;
use evseevnn\Cassandra\Database;

class Connector
{

    public function __construct($host = 'localhost', $port = '9201')
    {
        $this->host = $host;
        $this->port = $port;
        $nodes = array($host.':'.$port);
        $database = new Database($nodes, 'ks');
        $results = $database->connect();
        print_r($database);
        print_r($results);
        die;
    }
}
$connector = new Connector('10.1.1.45');

