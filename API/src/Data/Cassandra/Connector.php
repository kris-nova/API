<?php
namespace API\src\Data\Cassandra;

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
     * @param bool $throw        
     * @throws ApiException
     */
    public function __construct($host = 'localhost', $port = 9042, $throw = true)
    {
        Logger::info('Connecting to Cassandra node ' . $host . ':' . $port);
        try {
            $this->cluster = Cassandra::cluster()->withContactPoints($host)
                ->withPort($port)
                ->build();
        } catch (\Cassandra\Exception\RuntimeException $e) {
            LogException::e($e);
            if ($throw) {
                throw new ApiException('Unable to build Cassandra node ' . $host, r_server);
            }
        }
    }

    /**
     * Connect!
     *
     * @param string $keyspace  
     * @param bool $throw          
     * @throws ApiException
     */
    public function connect($keyspace = null, $throw = true)
    {
        try {
            $this->session = $this->cluster->connect();
        } catch (\Cassandra\Exception\RuntimeException $e) {
            LogException::e($e);
            if ($throw) {
                throw new ApiException('Unable to connect to cassandra node ', r_server);
            }
        }
    }

    /**
     * Accepts a query string
     *
     * @param string $queryString            
     * @param bool $throw            
     * @throws ApiException
     * @return unknown
     */
    public function query($queryString, $throw = false)
    {
        if (empty($this->cluster) || empty($this->session)) {
            throw new ApiException('Query failure - missing connection stream');
        }
        $query = new Cassandra\SimpleStatement($queryString);
        try {
            $result = $this->session->execute($query);
            return $result;
        } catch (\Cassandra\Exception\RuntimeException $e) {
            LogException::e($e);
            if ($throw) {
                throw new ApiException('Query Failure', r_server);
            }
        }
    }

    /**
     * Will create a new kespace in the configured cluster
     *
     * @param string $keyspace            
     * @param string $class            
     * @param number $replicationFactor  
     * @param bool $throw         
     * @throws ApiException 
     */
    public function createKeyspace($keyspace, $class = 'SimpleStrategy', $replicationFactor = 1, $throw = false)
    {
        try {
            return $this->query("CREATE KEYSPACE $keyspace WITH REPLICATION = { 'class' : '$class', 'replication_factor' : $replicationFactor }; ");
        } catch (\Cassandra\Exception\RuntimeException $e) {
            LogException::e($e);
            if ($throw) {
                throw new ApiException('Create Keyspace Failure', r_server);
            }
        }
    }
}
