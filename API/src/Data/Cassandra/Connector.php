<?php
namespace API\src\Data\Cassandra;

require_once __DIR__ . '/../../../Autoload.php';
use \PDO as PDO;
use evseevnn\Cassandra\Database;

class Connector
{

    public function __construct($host = 'localhost')
    {
        $this->host = $host;
        $nodes = array($host);
        $database = new Database($nodes);
        print_r($database);
        die;
    }
}
$connector = new Connector('10.1.1.45');

