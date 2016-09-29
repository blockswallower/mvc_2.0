<?php

class Urls {
    /*
     * @var Array
     * Contains all routing permissions
     * So if "index" is in the array,
     * the user is allowed to browse to the
     * index page.
     */
    public $urls;

    public function __construct() {
        $this->urls = [
            "index",
            "debug"
        ];
    }
}