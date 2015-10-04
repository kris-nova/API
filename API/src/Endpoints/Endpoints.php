<?php
namespace API\src\Endpoints;

use API\src\Endpoints\EndpointsInterface;
use API\src\Request\Request;
use API\src\Error\Error;
use API\src\Config\Config;
use API\src\Data\Cassandra\Connector;
use API\src\Error\Exceptions\ApiException;
use API\src\Debug\Logger;
use API\src\Data\Schema;

/**
 * All API Endpoints *MUST* extend this
 *
 * Basically, if you plan on building an endpoint, it has to agree with this class
 *
 * Sep 20, 2015
 *
 * @author Kris Nova <kris@nivenly.com> github.com/kris-nova
 */
class Endpoints implements EndpointsInterface
{

    /**
     *
     * @var Request
     */
    public $request;

    /**
     *
     * @var Connector
     */
    public $cassandra;

    /**
     * We always need our request object
     *
     * @param Request $request            
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->cassandra = new Connector(Config::getConfig('CassandraNodeString'), (int) Config::getConfig('CassandraPort'));
        $this->cassandra->connect();
        if (Config::getConfig('AutoCreateTables')) {
            $this->createTable();
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\EndpointsInterface::get()
     */
    public function get()
    {
        Error::throwInternalException('`GET` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\EndpointsInterface::post()
     */
    public function post()
    {
        Error::throwInternalException('`POST` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\EndpointsInterface::put()
     */
    public function put()
    {
        Error::throwInternalException('`PUT` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\EndpointsInterface::delete()
     */
    public function delete()
    {
        Error::throwInternalException('`DELETE` is not defined for endpoint ' . $this->request->endpoint, i_emergency);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\EndpointsInterface::run()
     */
    public function run()
    {
        $verb = $this->request->verb;
        switch ($verb) {
            case v_get:
                $this->get();
                break;
            case v_post:
                $this->post();
                break;
            case v_put:
                $this->put();
                break;
            case v_delete:
                $this->delete();
                break;
        }
    }

    /**
     * (non-PHPdoc)
     *
     * @see \API\src\Endpoints\EndpointsInterface::getResponse()
     */
    public function getResponse()
    {
        // Here be dragons
    }

    /**
     */
    protected function createTable()
    {
        $endpoint = $this->request->endpoint;
        $keyspace = $this->request->keyspace;
        $this->cassandra->createKeyspace($keyspace);
        $createTableQuery = $this->getCreateTableQuery();
        $this->cassandra = new Connector(Config::getConfig('CassandraNodeString'), (int) Config::getConfig('CassandraPort'));
        $this->cassandra->connect($keyspace);
        Logger::debug('Create Table Query : ' . $createTableQuery);
        $this->cassandra->query($createTableQuery);
    }

    /**
     * Used to fetch the query on file to create the table
     *
     * @throws ApiException
     * @return string
     */
    protected function getCreateTableQuery()
    {
        $schema = $this->request->schema;
        $fields = '';
        $total = count($schema);
        $i = 0;
        foreach ($schema as $name => $options) {
            $i ++;
            $field = '';
            $field .= $name;
            $field .= ' ' . $options['type'];
            if ($options['primary']) {
                $field .= ' PRIMARY KEY';
            }
            if ($i !== $total) {
                $field .= ',';
            }
            $fields .= $field;
        }
        $query = 'create table ' . $this->request->table . '(' . $fields . ');';
        return $query;
    }
}

// CREATE TABLE tablename(
// column1 name datatype PRIMARYKEY,
// column2 name data type,
// column3 name data type,
// PRIMARY KEY (column1)
// )