<?php

class DatabaseMigrator {
    /**
     * @param $db_type
     * @param $db_host
     * @param $db_name
     * @param $db_username
     * @param $db_password
     */
    public function create_database($db_type, $db_host, $db_name, $db_username, $db_password) {
        /*
         * @var Object
         * PDO Configuration
         */
        $PDO = new PDO("$db_type:host=$db_host", $db_username, $db_password);

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
}