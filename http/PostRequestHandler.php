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

require_once './http/PostRequests.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    /*
     * If the csrf config value is true
     * a csrf token needs to be provided
     *
     * If this is not the case return an error
     */
    if (Config::get("CSRF")) {
        if (!isset($_POST["csrf_token"])) {
            Debug::exitdump("Be sure to add a csrf token to your post!: <code>echo Csrf::csrf_token</code>",
                __LINE__, "http/PostRequestHandler");
        }
    }

    /*
     * @var Array
     */
    $url = Router::get_url();

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

    if (!empty($post_requests[$current_page])) {
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
}