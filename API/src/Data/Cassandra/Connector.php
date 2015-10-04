<?php
namespace API\src\Data\Cassandra;

require_once __DIR__ . '/../../../Autoload.php';
use \PDO as PDO;
use evseevnn\Cassandra\Database;
use API\src\Debug\Logger;
use \Cassandra as Cassandra;
use \Cassandra\SimpleStatement;
use API\src\Debug\LogException;
use API\src\Error\Exceptions\ApiException;

/**
 * Connector class for connection to a cassandra node
 *
 *
 * Oct 3, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Connector
{

    protected $host;

    protected $port;

    protected $cluster = null;

    protected $session = null;

    /**
     * Where and what port
     *
     * @param string $host            
     * @param number $port            
     * @throws ApiException
     */
    public function __construct($host = 'localhost', $port = 9042)
    {
        Logger::info('Connecting to Cassandra node ' . $host . ':' . $port);
        try {
            $this->cluster = Cassandra::cluster()->withContactPoints($host)
                ->withPort($port)
                ->build();
        } catch (\Cassandra\Exception\RuntimeException $e) {
            LogException::e($e);
            throw new ApiException('Unable to connect to Cassandra node ' . $host, 1);
        }
    }

    /**
     * Connect!
     *
     * @param string $keyspace
     * @throws ApiException
     */
    public function connect($keyspace = null)
    {
        try {
            $this->session = $this->cluster->connect();
        } catch (\Cassandra\Exception\RuntimeException $e) {
            LogException::e($e);
        }
    }

    /**
     * Accepts a query string and will query accordingly
     *
     * @param unknown $queryString            
     */
    public function query($queryString)
    {
        if (empty($this->cluster) || empty($this->session)) {
            throw new ApiException('Query failure - missing connection stream');
        }
        $query = new Cassandra\SimpleStatement($queryString);
        $result = $this->session->execute($query);
        return $result;
    }
}
