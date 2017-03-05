<?php

/**
 * @package Snail_MVC
 * @author Dennis Slimmers, Bas van der Ploeg
 * @copyright Copyright (c) 2016 Dennis Slimmers, Bas van der Ploeg
 * @link https://github.com/dennisslimmers01/Snail-MVC
 * @license Open Source MIT license
 *
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
    /**
     * If the csrf config value is true
     * a csrf token needs to be provided
     *
     * If this is not the case return an error
     */

    /*
     * TODO: This needs to be debugged big time
     */

//    if (Config::get("CSRF")) {
//        if (!isset($_POST["csrf_token"])) {
//            Debug::exitdump("Be sure to add a csrf token to your post!: <code>echo Csrf::csrf_token</code>",
//                __LINE__, "http/PostRequestHandler");
//        }
//    }

    /**
     * @var array
     */
    $url = Router::get_url();

    if (Arr::size($url) > 2) {
        $current_page = '';

        for ($ii  = 2; $ii < Arr::size($url); $ii++) {
            $slash =  Arr::last($url) == $url[$ii] ? "" : "/";
            $current_page .= $url[$ii] . $slash;
        }
    } else {
        $current_page = $url[2];
    }

    $PostRequests = new PostRequests();

    $post_requests = $PostRequests->getPostRequests();

    /*
     * This check is needed if the developer wants
     * to use multiple forms in one view.
     *
     * To use multiple forms add a hidden input field with
     * the name "multforms" to each form in your view:
     *
     * for example: <input type="hidden" name="multforms" value="loginform">
     *
     * the value you give this hidden field is going to be the unique id
     * of this form.
     *
     * To execute a method on this specific form id,
     * add this to the PostRequest class:
     *
     * for example: "test/loginform" => "TestController.test",
     */
    if (isset($_POST["multforms"])) {
        if (!empty($_POST["multforms"])) {
            $current_page .= "/" . $_POST["multforms"];

            if (!empty($post_requests[$current_page])) {
                if (strstr($post_requests[$current_page], ".")) {
                    $split = explode(".", $post_requests[$current_page]);
                    $controller = $split[0];

                    require_once 'controllers/' . $controller . '.php';

                    $controller = new $split[0];
                    $controller->$split[1]();
                }
            }
        }
    } else {
        if (!empty($post_requests[$current_page])) {
            if (strstr($post_requests[$current_page], ".")) {
                $split = explode(".", $post_requests[$current_page]);
                $controller = $split[0];

                require_once 'controllers/' . $controller . '.php';

                $controller = new $split[0];
                $controller->$split[1]();
            }
        }
    }
}