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

    /*
     * @var Array
     *
     * All keywords that resemble a "Template Keyword"
     */
    public $template_keywords = ["for", "while", "if", "if not",
                                 "do", "equals", "not equals", ">",
                                 "<", "==", "!=", "-", "+", "plus",
                                 "minus", "times", "*"];

    /*
     * TemplateEngine Constructor
     */
    public function __construct() {
        $this->set_base_view_path("./views/");
    }

    public function decrypt_template($view, $values) {
        /*
         * @var File
         * used for reading line by line
         */
        $file = file($this->get_base_view_path() . $view . ".php");

        /*
         * @var String
         * Used for compairing and
         * rendering.
         */
        $template = file_get_contents($this->get_base_view_path() . $view . ".php");

        /*
         * @var Array
         */
        $templateTagsFound = [];

        /*
         * @var Integer
         */
        $value_index = 0;
        
        foreach ($file as $line) {
            if (Str::contains($line, $this->template_tags, true)) {
                $this->decrypt_template_tag($line, $values, $value_index);

                $templateTagsFound[] = $line;
                $value_index ++;
            }
        }
    }

    public function render_template($view, $values = null) {
        $this->decrypt_template($view, $values);
    }

    public function decrypt_template_tag($line, $values, $value_index) {
        $substring = Str::substring($line, "{", "}") . "}";
        $new_line = "";

        if (Str::contains($substring, $this->template_keywords)) {
            Debug::pagedump("A template keyword was found!", __LINE__, __CLASS__);
        } else {
            $keys = array_keys($values);
            $new_substring = str_replace($substring, $keys[$value_index], $values[$keys[$value_index]]);

//            Debug::dump("New line replace");
//            Debug::dump($line);
//            Debug::dump($substring);
//            Debug::dump($new_substring);

            $new_line = str_replace($line, $substring, $new_substring);

            Debug::exitdump($new_line);
            exit;
        }
    }

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