<?php

class TemplateEngine {
    /*
     * @var String
     */
    public $base_view_path;

    /*
     * @var String
     */
    public $temp_view = "TempView.php";

    /*
     * @var Array
     *
     * All tags that resemble a "Template tag"
     */
    public $template_tags = ["{{", "}}"];

    public function __construct() {
        $this->set_base_view_path("./views/");
    }

    public function decrypt_template($view) {
        $file = file($this->get_base_view_path() . $view . ".php");
        $template = [];
        $templateTagsFound = [];
        
        foreach ($file as $line) {
            if (Str::contains($line, $this->template_tags, true)) {
                $templateTagsFound[] = $line;
            }

            $template[] = $line;
        }

        Debug::dump($template);
        Debug::exitdump($templateTagsFound);
    }

    public function render_template($view) {
        $this->decrypt_template($view);
    }

    public function contains_template_tags() {}

    /**
     * @return string
     */
    public function get_base_view_path() {
        return $this->base_view_path;
    }

    /**
     * @param $view_path
     */
    public function set_base_view_path($view_path) {
        $this->base_view_path = $view_path;
    }
}