<?php

class TemplateEngine {
    /*
     * @var String
     */
    public $base_view_path;

   /*
    * @var Object
    */
    public $view;

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
        $this->view = new View();
    }

    /**
     * @param $view
     * @param $values
     */
    public function decrypt_template($view, $values) {
        /*
         * @var File
         * used for reading line by line
         */
        $file = file($this->get_base_view_path() . $view . ".php");

        /*
         * @var Array
         */
        $templateTagsFound = [];

        /*
         * @var Integer
         */
        $value_index = 0;

        foreach ($file as $line) {
            /*
             * @var String
             * Used for compairing and
             * rendering.
             */
            $template = file_get_contents($this->get_base_view_path() . $view . ".php");

            if (Str::contains($line, $this->template_tags, true)) {
                $new_line = $this->decrypt_template_tag($line, $values, $value_index);
                $new_template_content =  str_replace($line, $new_line, $template);

                file_put_contents($this->get_base_view_path() . $view . ".php", $new_template_content);

                $templateTagsFound[] = $line;
                $value_index ++;
            }
        }
    }

    /**
     * @param $view
     * @param null $values
     */
    public function render_template($view, $values = null) {
        $old_content = file_get_contents($this->get_base_view_path() . $view . ".php");
        $this->decrypt_template($view, $values);

        require $this->get_base_view_path() . $view . ".php";

        /*
         * Sets view content back to template form
         */
        file_put_contents($this->get_base_view_path() . $view . ".php", $old_content);
    }

    /**
     * @param $line
     * @param $values
     * @param $value_index
     * @return mixed|string
     */
    public function decrypt_template_tag($line, $values, $value_index) {
        $substring = Str::substring($line, "{", "}") . "}";
        $new_line = "";

        if (Str::contains($substring, $this->template_keywords)) {
            Debug::pagedump("A template keyword was found!", __LINE__, __CLASS__);
        } else {
            $keys = array_keys($values);
            $new_substring = str_replace($substring, $values[$keys[$value_index]], $substring);
            $new_line = str_replace($substring, $new_substring, $line);
        }

        return $new_line;
    }

    /**
     * @param $template
     */
    public function show($template) {
        require $template;
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