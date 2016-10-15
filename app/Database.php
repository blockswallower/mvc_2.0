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
        $dsn = "$this->db_type:dbname=$this->db_name;host=$this->db_host";

        parent::__construct($dsn, $this->db_username, $this->db_password);
    }
}