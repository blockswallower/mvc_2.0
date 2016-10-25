<?php

require 'DatabaseMigrator.php';

class Migrations extends DatabaseMigrator {
    /*
     * Call methods from the DatabaseMigrator class
     * to create databases, fields, tables etc
     */
    public function migrate() {
        $this->set_database_requirements("mysql", "localhost", "root", "");

        $this->create_database("Snail");
    }
}