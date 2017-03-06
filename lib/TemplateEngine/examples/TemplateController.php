<?php

class TemplateController extends Controller {
    public function __construct() {
        parent::__construct();

        $this->load_library("TemplateEngine");

        /**
         * Sending variables to your template should
         * be done before the config_template_globals
         * method call
         */
        $this->set("template", "number", 0);
        $this->set("template", "number2", 10);

        /**
         * This method allows templates
         * to access global variables
         */
        $this->config_template_globals();
    }

    public function show() {
        /**
         * Render a template / view using
         * the TemplateEngine
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