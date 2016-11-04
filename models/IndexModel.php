<?php

class IndexModel extends Model {
    public function __construct() {
        parent::__construct();

        /**
         * @var Object
         *
         * QueryBuilder Object
         */
        $qb = new QueryBuilder();
    }
}