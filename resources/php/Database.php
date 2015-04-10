<?php
/** 
 * A Database object that reads from, writes to, and deletes
 * entries in a mysql database.
 *
 * This Database class requires that the hostname (DB_HOST), username
 * (BD_USER), password (DB_PASS), and database name (BD_NAME) be
 * defined constants.
 *
 *       Database column headers referred to as attributes
 *       Database row entries referred to as values
 *       e.g.:
 *       -------------------
 *       | attrib | attrib |
 *       +--------+--------+
 *       | value  | value  |
 *       -------------------
 */
require_once 'Chameleon.php';


class Database extends Chameleon
{
    /**
     * An array the contains the Database object's configuration.
     */
    protected $config = [];

    /**
     * @var object(mysqli) $connection "An object which represents the
     * connection to a MySQL Server."
     * -http://www.php.net/manual/en/mysqli.construct.php 
     */ 
    protected $connection = null;

    /**
     * @var array $tables Stores the result set obtained from a
     * SHOW TABLES query against a database formatted into an array.
     */
    protected $tables = null;


    /**
     * Constructor.
     *
     * Validates the given configuration array, and if valid sets
     * the config property.
     */

    public function __construct($config)
    {
        if ($this->check_config($config)) {
            $this->config = $config;
        }
        else {
            $this->printError('Invalid Database Configuration');
        }
    }


    /**
     * Checks the given configuration array for necessary values and
     * return true if config is valid and false otherwise.
     *
     * @return bool True if no errors, fasle otherwise.
     */

    protected function check_config($config)
    {
        $err = [];
        $config_keys =
            ['db_driver', 'db_host', 'db_name', 'db_user', 'db_pass'];

        foreach ($config_keys as $key)
        {
            if (!array_key_exists($key, $config)) {
                $this->printError("Config $key missing");
            }
        }

        return empty($err);
    }


    /**
     * Used by this Database object to create a connection to a mysql
     * database. Sets the $connection property to a php mysqli object.
     *
     * @return void
     */

    protected function connect()
    {
        try {
            $this->connection = new PDO(
                $this->config['db_driver'].':host='.$this->config['db_host'].
                ';dbname='.$this->config['db_name'],
                $this->config['db_user'],
                $this->config['db_pass']
            );
        }
        catch (PDOException $pdo_e) {
            error_log($pdo_e->getMessage());
            $this->printError('Connection error '.$pdo_e->getMessage());
        }
    }


    /**
     * Used by the Database object to close a connection to a mysql
     * database. Closes the $connection property and sets it to null.
     *
     * @todo: test that the connection property is a mysqli object with
     * a connection before attempting to close it.
     *
     * @return void
     */

    protected function close()
    {
        $this->connection = null;
    }


    /**
     * Query the database with $sql, get the result, and return it.
     * Prints a warning if result is invalid.
     *
     * @param string $sql The query to send to the database.
     * @param int $fetch_mode The way you want the query returned.
     * The default is PDO::FETCH_ASSOC (See PDO Constants).
     *
     * @return array|False Returns an array or multi-dimensional array
     * if successful and False if not.
     */

    public function query($sql, $fetch_mode=PDO::FETCH_ASSOC)
    {
        $this->connect();
        $result = $this->connection->query($sql, $fetch_mode);
        
        if (! $result instanceof PDOStatement) {
            $result = False;
            $this->printWarning("Query did not return PDOStatement");
        }

        $this->close();
        return $result;
    }


    /**
     * Perform a given sql SELECT query on a PDO/Database.
     *
     * @param String $sql The given SELECT query.
     *
     * @return Array|False Array containing the result if SELECT query
     * succeeded, False otherwise.
     */

    public function select($sql)
    {
        $result = array();
        $raw_result = $this->query($sql);

        if ($raw_result) {
            foreach ($raw_result->fetchAll() as $row) {
                array_push($result, $row);
            }
        }
        else {
            $result = False;
        }

        return $result;
    }


    /**
     * Perform a given sql INSERT statement on a PDO/Database.
     *
     * @param String $sql The given INSERT statement.
     *
     * @return int Integer representing the number of rows resulting
     * from the attempted INSERT query.
     */

    public function insert($sql)
    {
        $result = 0;
        $this->connect();
        if ($r = $this->connection->query($sql)) {
            $result = $r->rowCount();
        }
        return $result;
        $this->close();
    }


    /** 
     * Sets the value of the $tables property to an array containing the
     * tables in the configured mysql database.
     *
     * @return void
     */

    protected function set_tables()
    {
        $raw_query = $this->select('SHOW TABLES');
        $result = array();
        foreach ($raw_query as $row) {
            foreach ($row as $table) {
                array_push($result, $table);
            }
        } 
        $this->tables = $result;
    }

    /**
     * Provides a way to reflect upon which Database the PHP object is
     * actually using.
     *
     * @return String The name of the Database (db_name in the config
     * array).
     */

    public function get_name()
    {
        return $this->config['db_name'];
    }


    /**
     * Get the value stored at $tables.
     *
     * @return array Containing the tables in the connected database.
     */

    public function get_tables()
    {
        if (!$this->tables) {
            try {
                $this->set_tables();
            }
            catch(Exception $e) {
                error_log(__METHOD__.' '.$e->getMessage().' '.$e->getCode());
                $this->printError('Could not get tables.');
            }
        }
        return $this->tables;
    }


    /** 
     * Gets the attributes of a either a given database table.
     *
     * @param string $table The database table whose attribute will be returned.
     *
     * @return array|null The attributes of the $table supplied
     */

    public function get_table_attribs($table)
    {
        $raw_result = $this->select("DESCRIBE $table");
        $result = array();
        foreach ($raw_result as $row) {
            array_push($result, $row['Field']);
        }
        return $result;
    }
}
