<?php

class DatabaseMigrator {
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
     * Database username
     */
    private $db_username;

    /**
     * @var String
     * Database password
     */
    private $db_password;

    /**
     * @param $db_name
     *
     * Creates a database using PDO
     */
    public function create_database($db_name) {
        /*
         * @var Object
         * PDO Configuration
         */
        $PDO = new PDO("$this->db_type:host=$this->db_host", $this->db_username, $this->db_password);

        /*
         * Set PDO error mode to exception
         */
        $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $db_name = "`".str_replace("`", "``", $db_name) . "`";

        /*
         * Create the database!
         */
        if ($PDO->query("CREATE DATABASE IF NOT EXISTS $db_name")) {
            echo "Database: '$db_name' has been successfully created! \n";
        }

        $PDO->query("use $db_name");
    }

    /**
     * @param $db_type
     * @param $db_host
     * @param $db_username
     * @param $db_password
     *
     * Sets all the Database requirements
     */
    public function set_database_requirements($db_type, $db_host, $db_username, $db_password) {
        $this->db_type = $db_type;
        $this->db_host = $db_host;
        $this->db_username = $db_username;
        $this->db_password = $db_password;
    }
}