<?php

class PostRequests {
    /*
     * @var Array
     */
    public $post_requests;

    public function __construct() {
        /*
         * This array contains all post requests
         *
         * for example: "index" => "IndexController.test",
         */
        $this->post_requests = [
            
        ];
    }

    /*
     * @return array
     */
    public function getPostRequests() {
        return $this->post_requests;
    }
}