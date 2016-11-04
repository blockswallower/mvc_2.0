<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 */

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
     * Database name
     */
    private $db_name;

    /**
     * @var String
     * Database password
     */
    private $db_password;

    /**
     * @var Object
     * PDO Configuration
     */
    private $PDO;

    /**
     * @param $db_name
     *
     * Creates a database using PDO
     */
    public function create_database($db_name) {
        /**
         * Set PDO error mode to exception
         */
        $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $db_name = "`".str_replace("`", "``", $db_name) . "`";

        /**
         * Create the database!
         */
        if ($this->PDO->query("CREATE DATABASE IF NOT EXISTS $db_name")) {
            echo "Database: '$db_name' has been successfully created! \n";
        }

        $this->db_name = $db_name;

        /**
         * Optional:
         */
        $this->PDO->exec("USE $db_name");
    }

    /**
     * @param $table_name
     * @param $columns
     * @param $database
     *
     * Creates table and inserts given columns using PDO
     */
    public function create_table($table_name, $columns, $database = null) {
        if (is_array($columns)) {
            /**
             * Set PDO error mode to exception
             */
            $this->PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /**
             * @var String
             */
            $table_columns = "";

            for ($ii = 0; $ii < count($columns); $ii++) {
                $comma = count($columns) - 1 == $ii ? "" : ", ";

                /**
                 * Don't add a comma if the current column
                 * in the loop is the last given column
                 */
                $table_columns .= $columns[$ii] . $comma;
            }

            /**
             * @var String
             *
             * Set the database to the given database if not null
             */
            $database = $database === null ? "" : $database . ".";

            if ($this->PDO->query("CREATE TABLE IF NOT EXISTS $database$table_name ($table_columns)")) {
                echo "Table : '$table_name' has been successfully created \n";
            }
        } else {
            echo "Please enter an array as second argument";
        }
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

        /**
         * @var Object
         * PDO Configuration
         */
        $this->PDO = new PDO("$this->db_type:host=$this->db_host", $this->db_username, $this->db_password);
    }
}