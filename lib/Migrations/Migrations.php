<?php

require 'DatabaseMigrator.php';

class Migrations extends DatabaseMigrator {
    /**
     * Call methods from the DatabaseMigrator class
     * to create databases, fields, tables etc
     */
    public function migrate() {
        $this->set_database_requirements("mysql", "localhost", "root", "");

        $this->create_database("Snail");

        $this->create_table("users", [
           "id INT(11) AUTO_INCREMENT PRIMARY KEY",
           "username VARCHAR(55) NOT NULL",
           "password VARCHAR(150) NOT NULL"
        ]);
    }
}