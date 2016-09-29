<?php

class QueryBuilder {
    /*
     * @var object
     * Database object
     */
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * @param $table_name
     * @return array
     *
     * Returns a SELECT * FROM statement
     */
    public function select_all($table_name) {
        $result = $this->db->prepare('SELECT * FROM '.$table_name);
        $result->execute();

        return $result->fetchAll();
    }

    /**
     * @param $table_name
     * @param $clause
     * @return array
     *
     * Returns SELECT * FROM ... WHERE statement
     */
    public function select_all_where($table_name, $clause) {
        $result = $this->db->prepare('SELECT * FROM '.$table_name.' WHERE '.$clause);
        $result->execute();

        return $result->fetchAll();
    }

    /**
     * @param $field
     * @param $table_name
     * @return array
     *
     * Returns a certain field/column
     */
    public function select_field($field, $table_name) {
        $result = $this->db->prepare('SELECT '.$field.' FROM '.$table_name);
        $result->execute();

        return $result->fetchAll();
    }

    /**
     * @param $table_name
     * @return array
     *
     * Returns a SELECT COUNT(*) statement
     */
    public function select_num($table_name) {
        $result = $this->db->prepare('SELECT COUNT(*) as count FROM '.$table_name);
        $result->execute();

        return $result->fetchAll();
    }

    /**
     * @param $string
     * @return string
     *
     * Properly qoutes a string for SQL Injection
     */
    public function escape($string) {
        return $this->db->quote($string);
    }

    /**
     * @param $table_name
     * @param $clause
     *
     * Executes a DELETE FROM ... WHERE statement
     */
    public function delete($table_name, $clause) {
        $result = $this->db->prepare('DELETE FROM '.$table_name.' WHERE '.$clause);
        $result->execute();
    }
}