<?php

/*
 * This script will handel every post request in the
 * http/PostRequest.php class
 *
 * In this class you will find the post_requests array.
 * In this array you can manage which method Snail will call
 * on a certain post request.
 *
 * For example:
 *
 * If you submit a form on the index page
 * and you want to call the test() method located
 * in your IndexController, add this in the post_requests array:
 *
 * "index" => "IndexController.test"
 */

require_once 'PostRequests.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /*
     * @var Array
     */
    $url = get_url();

    /*
     * @var String
     */
    $current_page = $url[2];

    /*
     * @var Object
     */
    $PostRequests = new PostRequests();

    /*
     * @var Array
     */
    $post_requests = $PostRequests->getPostRequests();

    if (strstr($post_requests[$current_page], ".")) {
        /*
         * @var Array
         */
        $split = explode(".", $post_requests[$current_page]);

        /*
         * @var String
         */
        $controller = $split[0];

        require_once 'controllers/' . $controller . '.php';

        /*
         * @var Object
         */
        $controller = new $split[0];

        /*
         * Runs method given in post_requests
         */
        $controller->$split[1]();
    }
}

/**
 * @return array
 */
function get_url() {
    /*
     * @var Array
     */
    $split = explode("/", $_SERVER['REQUEST_URI']);

    if (!empty($split[2])) {
        if (Str::contains($split[2], ["?", "="], true)) {
            /*
             * @var Array
             */
            $strsplit = str_split($split[2]);

            /*
             * @var Integer
             */
            $question_mark_index = Arr::find_index($strsplit, "?");

            /*
             * @var String
             */
            $cut_string = Str::substringint($split[2], 0, $question_mark_index - 1);

            $split[2] = $cut_string;
        }
    }

    return $split;
}