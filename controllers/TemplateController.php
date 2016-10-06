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

        $this->set("template", "test", "testvalue");

        $this->config_view_array();

        /**
         * Render the correct
         * content based on the
         * parameter
         */
        $te = new TemplateEngine();
        $te->render_template("template", [
             "title" => "my new website",
             "page_content" => "testestest",
             "description" => "Hello my name is Dennis and i'm 18 years old!"
        ]);
    }
}