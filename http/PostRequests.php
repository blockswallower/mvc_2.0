<?php

class PostRequests {
    public $post_requests;

    public function __construct() {
        /**
         * This array contains all post requests
         *
         * for example: "index" => "IndexController.test",
         *
         * For multiple form usage:
         *
         * "index/indexForm" => "IndexController.test"
         */
        $this->post_requests = [

        ];
    }

    /**
     * @return array
     */
    public function getPostRequests() {
        return $this->post_requests;
    }
}