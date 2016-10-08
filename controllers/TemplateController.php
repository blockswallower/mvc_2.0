<?php

class TemplateController extends Controller {
    public function __construct() {
        parent::__construct();

        /**
         * ========================================
         * If you would like to send variables
         * to the view, it should be done in this section
         *
         * If you try to accomplish this in a
         * lower section it won't function properly
         * ========================================
         */
        $this->config_globals_array();

        /**
         * Render the correct
         * content based on the
         * parameter
         */
        $te = new TemplateEngine($this->view->get_globals());

        $te->render_template("template", [
             "title" => "my new website",
             "page_content" => "testestest",
             "description" => "Hello my name is Dennis and i'm 18 years old!",
             "footer" => "created by Dennis Slimmers"
        ]);
    }
}