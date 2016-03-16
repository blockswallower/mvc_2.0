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
    private $db_type = 'mysql';

    /**
     * @var String
     * Database host
     */
    private $db_host = 'localhost';

    /**
     * @var String
     * Database name
     */
    private $db_name = '';

    /**
     * @var String
     * Database username
     */
    private $db_username = 'root';

    /**
     * @var String
     * Database password
     */
    private $db_password = '';

    public function __construct() {
        /**
         * @var String
         * PDO Configurations
         */
        $dsn = "$this->db_type:dbname=$this->db_name;host=$this->db_host";

        parent::__construct($dsn, $this->db_username, $this->db_password);
    }
}