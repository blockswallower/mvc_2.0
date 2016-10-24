<?php

require 'DatabaseMigrator.php';

class Migrations extends DatabaseMigrator {
    /*
     * Call methods from the DatabaseMigrator class
     * to create databases, fields, tables etc
     */
    public function migrate() {
        $this->create_database("mysql", "localhost", "Snail", "root", "");
    }
}