<?php

/**
 * =================================================================
 * @package Snail
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2017 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers/Snail
 * @license Open Source MIT license
 * =================================================================
 */

namespace Snail\App;

use Snail\App\Config\SNAIL;
use Snail\App\Utils\Debug;

class Database extends \PDO {
    /**
     * Database type
     */
    private $db_type;
    /**
     * Database host
     */
    private $db_host;
    /**
     * Database name
     */
    private $db_name;
    /**
     * Database username
     */
    private $db_username;
    /**
     * Database password
     */
    private $db_password;
    public function __construct() {
        $this->db_type = SNAIL::DB_TYPE;
        $this->db_host = SNAIL::DB_HOST;
        $this->db_name = SNAIL::DB_NAME;
        $this->db_username = SNAIL::DB_USERNAME;
        $this->db_password = SNAIL::DB_PASSWORD;

        if (!empty($this->db_name)) {
            if (!$this->database_exists()) {
                $data = "The database: '" . $this->db_name . "' does not exist!";
                Debug::fatal($data);
            }
        }

        $dsn = "$this->db_type:dbname=$this->db_name;host=$this->db_host";
        parent::__construct($dsn, $this->db_username, $this->db_password);
    }
    /*
     * Checks if database exists
     */
    private function database_exists() {
        $exists = true;

        /**
         * create a temporary PDO object to test
         * database connections
         */
        $PDO = new \PDO("$this->db_type:host=$this->db_host", $this->db_username, $this->db_password);
        $result = $PDO->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '"
            . $this->db_name ."'");
        $result->execute();

        /**
         * Returns an array if the given database exists
         * Data should look like this:
         *
         * Array ( [0] => Array ( [SCHEMA_NAME] => snail [0] => snail ) )
         */
        $found_database = $result->fetchAll();
        if (empty($found_database)) {
            $exists = false;
        }

        return $exists;
    }
}