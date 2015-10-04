<?php
namespace API\src\Data\Cassandra;

use API\src\Debug\Logger;
use \Cassandra as Cassandra;
use \Cassandra\SimpleStatement;
use API\src\Debug\LogException;
use API\src\Error\Exceptions\ApiException;
use API\src\Request\Request;

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

    /**
     *
     * @var \Cassandra\Cluster
     */
    protected $cluster = null;

    /**
     *
     * @var Cassandra\Session
     */
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
     * @return Cassandra\Rows
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
     * Will create a new keyspace in the configured cluster
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

    /**
     * Will upsert a record in the database with an accurate updated / created timestamp
     *
     * @param Request $request            
     * @return Cassandra\Rows
     */
    public function upsert(Request $request)
    {
        $body = $request->body;
        $values = '';
        $columns = '';
        if (! isset($body['s_id'])) {
            // New request
            $body['create_time'] = $request->startTime;
            $body['s_id'] = $request->id;
        }
        $body['update_time'] = $request->startTime;
        foreach ($body as $column => $value) {
            //
            $columns .= $column . ', ';
            $values .= "'" . $value . "', ";
        }
        $columns = substr($columns, 0, - 2);
        $values = substr($values, 0, - 2);
        $query = "INSERT INTO $request->keyspace.$request->table ($columns) VALUES ($values) IF NOT EXISTS;";
        Logger::info('Upsert Query : ' . $query);
        $results = $this->query($query);
        return $results;
    }

    /**
     * Will insert a record in the database with an accurate updated / created timestamp
     *
     * @param Request $request            
     * @return Cassandra\Rows
     */
    public function insert(Request $request)
    {
        $body = $request->body;
        $values = '';
        $columns = '';
        if (! isset($body['s_id'])) {
            // New request
            $body['create_time'] = $request->startTime;
            $body['s_id'] = $request->id;
        }
        $body['update_time'] = $request->startTime;
        foreach ($body as $column => $value) {
            //
            $columns .= $column . ', ';
            $values .= "'" . $value . "', ";
        }
        $columns = substr($columns, 0, - 2);
        $values = substr($values, 0, - 2);
        $query = "INSERT INTO $request->keyspace.$request->table ($columns) VALUES ($values);";
        Logger::info('Insert Query : ' . $query);
        $results = $this->query($query);
        return $results;
    }

    /**
     *
     * @param Request $request            
     * @return Cassandra\Rows
     */
    public function get(Request $request)
    {
        $query = "SELECT * FROM $request->keyspace.$request->table WHERE s_id = '$request->id';";
        $results = $this->query($query);
        return $results;
    }

    /**
     * Will let us know if the record allready exists or not
     *
     * @param Request $request            
     * @return bool
     */
    public function exists(Request $request)
    {
        $query = "SELECT s_id FROM $request->keyspace.$request->table WHERE s_id = '$request->id';";
        $results = $this->query($query);
        return $results->count();
    }
}
