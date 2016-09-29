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
         * Sets up the db object
         * for the other models
         */
        $this->db = new Database();
    }
}