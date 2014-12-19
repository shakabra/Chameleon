<?php
/** 
 * A Database object that reads from, writes to, and deletes
 * entries in a mysql database.
 *
 * This Database class requires that the hostname (DB_HOST), username
 * (BD_USER), password (DB_PASS), and database name (BD_NAME) be
 * defined constants.
 *
 *       NOTE:
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
     * @var object(mysqli) $connection "An object which represents the
     * connection to a MySQL Server."
     * -http://www.php.net/manual/en/mysqli.construct.php 
     */ 
    private $connection = null;

    /**
     * @var array $tables Stores the result set obtained from a
     * SHOW TABLES query against a database formatted into an array.
     */
    private $tables = null;


    /**
     * Constructor.
     */
    //public function __construct() {}


    /**
     * Used by this Database object to create a connection to a mysql
     * database. Sets the $connection property to a php mysqli object.
     *
     * @return void
     */
    private function connect()
    {
        $this->connection = new PDO(DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME,
            DB_USER, DB_PASS);
        if ($this->connection->connect_error) {
            $this->print_error('Database connection error, check defined db constants.');
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
    private function close()
    {
        $this->connection = null;
    }


    /**
     * Query the database, get the result, and return it.
     * If a query result has one row, an assocative array containing
     * the result will be returned, if the result has many rows, a
     * mulit-dimensional associative array will be returned.
     *
     * True if successfull; False if the query fails.
     *
     * @param string $query The query to send to the database.
     *
     * @return array|False Returns an array or multi-dimensional array
     * if successful and False if not.
     */
    public function query($sql, $fetch_mode=PDO::FETCH_ASSOC)
    {
        $this->connect();
        $result = $this->connection->query($sql, $fetch_mode);
        $this->close();
        return $result;
    }


    public function select($sql)
    {
        $result = array();
        $raw_result = $this->query($sql)->fetchAll();
        foreach ($raw_result as $row) {
            array_push($result, $row);
        }
        return $result;
    }


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
    private function set_tables()
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
                $this->print_error('Could not get tables.');
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


    /**
     * Add an authorized user to the 'users' table.
     * @todo make the args a container type and a variable so one can
     * vary the table to insert into.
     * 
     * @param type $username - username from the input form
     * @param type $salt - uniq string stored in database
     * @param type $hashed_salted_password - hashed password with salt added
     */
    public function add_authorized_user($username, $salt, $salted_password)
    {
        $query = 'INSERT INTO users (username, salt, salted_password) ' .
            "VALUES ('$username', '$salt', '$hashed_salted_password')";
        
        $insert_user_query = $this->query($query);
        
    }
}
