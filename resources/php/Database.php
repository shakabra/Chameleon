<?php
/** 
 * A Database object that reads from, writes to, and deletes
 * entries in a mysql database.
 *
 * This Database class requires that the hostname (DB_HOST), username
 * (BD_USER), password (DB_PASS), and database name (BD_NAME) be
 * defined constants. The Database object can be instanciated with or
 * without a [mysql database] table selected. If a table is passed as
 * an argument at time of instanciation, or later with the
 * set_selected_table() method, the Database object will use the
 * selected_table in subsequent Database method calls that have a
 * $table parameter.
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

class Database {

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
     * @var string $selected_table A mysql database table, used as a
     * default to all method calls that define a $table parameter.
     */
    private $selected_table = null;

    /**
     * @var array $table_attrib Stores table attributes obtained from a
     * DESCRIBE mysql query to a database.
     */
    private $table_attribs = null;

    /**
     * Constructor sets the value of tables property and optionally the
     * selected_table property.
     * 
     * If the constructor is given a valid $table argument at time of
     * instanciation the argument becomes the $selected_table, and will
     * be used by default in methods that define a $table paramater.
     * Else, the $selected_table property is unchanged (initially a
     * null value) and method calls with a $table parameter will
     * require a valid $table argument to be passed.
     *
     * @param string|null $table Set to null by default, optionally the
     * name of a database table to be used in subsequent calls to the
     * database.
     *
     * @return void
     */
    public function __construct($table=null) {
        $this->set_tables();
        if ($table) {
            $this->set_selected_table($table);
        }
    }

    /**
     * Used by this Database object to create a connection to a mysql
     * database. Sets the $connection property to a php mysqli object.
     *
     * @return void
     */
    private function connect() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->connection->connect_error) {
            throw new Exception(__METHOD__ . ', mysqli Connection Error.'.
                'Check defined DB_ constants.');
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
    private function close() {
        $this->connection->close();
        $this->connection = null;
    }

    /** 
     * Sets the value of the $tables property to an array containing the
     * tables in the configured mysql database.
     *
     * @return void
     */
    private function set_tables() {
        $this->connect();
        $result = $this->connection->query("SHOW TABLES");
        $this->close(); 
        $tables = [];

        if ($result) {
            while ($row = $result->fetch_array()) {
                $tables[] = $row[0];
            }
            $this->tables = $tables;
        }
        else {
            throw new Exception(__METHOD__.' (line '.__LINE__.') '.
                'mysqli query failed');
        }
    }

    /**
     * Get the value stored at $tables.
     *
     * @return array Containing the tables in the connected database.
     */
    public function get_tables() {
        return $this->tables;
    }

    /** 
     * Sets the value of the selected_table property.
     *
     * @param string $table The mysql database table that will be used
     * as the default argument for the $table parameter in methods
     * where it is defined.
     *
     * @return void
     */
    private function set_selected_table($table) {
        if (in_array($table, $this->tables)) {
            $this->selected_table = $table;
        }
        else {
            throw new Exception(__METHOD__ . ', $table argument ' .
                'not a valid database table.');
        } 
    }

    /** 
     * Get the stored value of the $selected_table property.
     *
     * If selected table has been set, returns the string stored as
     * $selected_table, else returns null.
     * @return string|null
     */
    public function get_selected_table() {
        return $this->selected_table?
            $this->selected_table : 'No table selected';
    }

    /** 
     * Gets the attributes of a either a given database table or the
     * stored $selected_table.
     *
     * @param string|null $table If $table argument is given, will get
     * attributes for the table supplied, else the attributes for the
     * table stored as the $selected_table property.
     *
     * @return array|null The attributes of either the $table supplied
     * as an argument or of the stored $selected_table.
     *
     * @todo: should I throw an exception if $table_attribs is falsey.
     */
    public function get_table_attribs($table=null) {
        if (!$table) {
            if ($this->selected_table) {
                $table = $this->selected_table;
            }
            else {
                throw new Exception(__METHOD__ .' No valid $table argument or'.
                    ' $selected_table propertey.');
            }
        }
        return $this->table_attribs;
    }

    /** 
     * Sets value of table_attribs property.
     *
     * When called queries the database for the attributes of the
     * $selected_table, or of the $table argument (if supplied).
     * The result is an associtive array that is stored in the
     * $table_attribs property.
     *
     * @todo Handle this exception
     * If $selected table is not set and $table is null, print a warning
     * and return.
     * @todo Should this privte function make the table param optional?
     *
     * @param string|null $table A mysql database table used whose
     * attributes will be used to set the $table_attribs property. Uses
     * the $selected_table property by default.
     *
     * @return void
     */
    private function set_table_attribs($table=null) {
        if (!$table) {
            if (!$this->selected_table) {
                return null;
            }
            $table = $this->selected_table;
        }

        $this->connect();
        $result = $this->connection->query("DESCRIBE $table");
        $this->close();

        $attribs = [];
        while ($rows = $result->fetch_assoc()) {
            $attribs[] = $rows['Field'];
        }
        $this->table_attribs = $attribs;
    }

    /**
     * Query the database, get the result, and return it.
     * If a query result has one row, an associtive array containing
     * the result will be returned, if the result has many rows, a
     * mulit-dimensional array associative will be returned.
     *
     * True if successfull; False if the query fails.
     *
     * @param string $query The query to send to the database.
     *
     * @return array|False Returns an array or multi-dimensional array
     * if successful and False if not.
     */
    public function query($query) {
        $this->connect();
        $result = $this->connection->query($query);
        $this->close();

        if ($result->num_rows > 1) {
            $all_entries = [];
            while ($row = $result->fetch_assoc()) {
                array_push($all_entries, $row);
            }
            $result = $all_entries;
        } elseif ($result->num_rows === 1) {
            $result = $result->fetch_assoc();
        }

        return $result;
    }

    /**
     * Add an authorized user to the 'users' table.
     * 
     * @param type $username - username from the input form
     * @param type $salt - uniq string stored in database
     * @param type $hashed_salted_password - hashed password with salt added
     */
    public function add_authorized_user($username, $salt, $salted_password){
        $query = 'INSERT INTO users (username, salt, salted_password) ' .
            "VALUES ('$username', '$salt', '$hashed_salted_password')";
        
        $insert_user_query = $this->query($query);
        
        return $insert_user_query;
    }
}
