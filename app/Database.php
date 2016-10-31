<?php

class Database extends PDO {
    /**
     * This class will be used
     * for setting up and configuring
     * the database
     */

    /**
     * @var String
     * Database type
     */
    private $db_type;

    /**
     * @var String
     * Database host
     */
    private $db_host;

    /**
     * @var String
     * Database name
     */
    private $db_name;

    /**
     * @var String
     * Database username
     */
    private $db_username;

    /**
     * @var String
     * Database password
     */
    private $db_password;

    public function __construct() {
        $this->db_type = Config::get("DB_TYPE");
        $this->db_host = Config::get("DB_HOST");
        $this->db_name = Config::get("DB_NAME");
        $this->db_username = Config::get("DB_USERNAME");
        $this->db_password = Config::get("DB_PASSWORD");

        /**
         * @var String
         * PDO Configurations
         */

        if (!empty($this->db_name)) {
            /*
             * @var Object
             *
             * create a temporary PDO object to test
             * database connections
             */
            $PDO = new PDO("$this->db_type:host=$this->db_host", $this->db_username, $this->db_password);

            $result = $PDO->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '"
                                     . $this->db_name ."'");
            $result->execute();

            /*
             * @var Array
             *
             * Returns an array if the given database exists
             * Data should look like this:
             *
             * Array ( [0] => Array ( [SCHEMA_NAME] => snail [0] => snail ) )
             */
            $found_database = $result->fetchAll();

            if (empty($found_database)) {
                /*
                 * @var String
                 */
                $data = "The database: <i>'" . $this->db_name . "'</i> does not exist!";

                Debug::exitdump($data, __LINE__, "app/Database");
            }
        }

        $dsn = "$this->db_type:dbname=$this->db_name;host=$this->db_host";

        parent::__construct($dsn, $this->db_username, $this->db_password);
    }
}