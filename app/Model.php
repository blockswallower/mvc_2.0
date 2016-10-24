<?php

class Model {
    /**
     * This class will be a blueprint
     * for all other models
     */

    /**
     * @object Contains Database
     */
    protected $db;

    public function __construct() {
        /**
         * Sets up the database
         * for every other child model
         */
        $this->db = new Database();
    }
}