<?php

class TemplateEngine {
    /*
     * @var String
     */
    public $base_view_path;

   /*
    * @var Object
    *
    * TODO: fix that templates can't access global view variables
    */
    public $view;

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
    public $template_keywords = ["for", "while", "if", "ifnot",
                                 "do", "equals", "!equals", "==",
                                 "!=", "-", "+", "plus", "else",
                                 "minus", "times", "*", "end"];

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
     *
     * Decrypts the whole template and checks
     * if there are any lines with template tags
     * or template keywords
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

                if (!Str::contains($line, $this->template_keywords)) {
                    $value_index ++;
                }
            }
        }
    }

    /**
     * @param $view
     * @param null $values
     *
     * Renders template and changes content back to template form
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
     *
     * Decrypts a given line with template tags ('{{', '}}')
     * en checks for template keywords
     */
    public function decrypt_template_tag($line, $values, $value_index) {
        /*
         * @var String
         */
        $substring = Str::substring($line, "{", "}") . "}";

        /*
         * @var String
         */
        $new_line = "";

        if (Str::contains($substring, $this->template_keywords)) {
            $substring = Str::substringint($substring, 2, strlen($substring) - 3);
            $substring_exploded = explode(" ", $substring);

            /*
             * @var String
             */
            $first_keyword = "";

            /*
             * @var String
             */
            $new_line .= "<?php ";

            foreach ($substring_exploded as $str) {
                if ($str != "") {
                    $first_keyword = $str;
                    break;
                }
            }

            if ($first_keyword == "end") {
                $new_line = "<?php } ?>";
            } else {
                $new_line = $this->map_substring_keywords($substring_exploded, $new_line, $first_keyword);
            }
        } else {
            $keys = array_keys($values);
            $new_substring = str_replace($substring, $values[$keys[$value_index]], $substring);
            $new_line = str_replace($substring, $new_substring, $line);
        }

        return $new_line;
    }

    /**
     * @param $substring_exploded
     * @param $new_line
     * @param $first_keyword
     * @return mixed
     */
    public function map_substring_keywords($substring_exploded , $new_line, $first_keyword) {
        /*
         * @var String
         */
        $second_keyword = $substring_exploded[2];

        /*
         * @var String
         */
        $third_keyword = $substring_exploded[3];

        /*
         * @var String
         */
        $fourth_keyword = $substring_exploded[4];

        $new_line .= "" . $first_keyword . " (";

        if (Str::contains($second_keyword, "$")) {
            Debug::pagedump($second_keyword . " is a specific variable", __LINE__, __CLASS__);
        } else {
            $new_line .= "" . $second_keyword;
        }

        switch ($third_keyword) {
            case "equals":
                $new_line .= " " . "==";
                break;
            case "!equals":
                $new_line .= " ". "!=";
                break;
        }

        if (Str::contains($fourth_keyword, "$")) {
            Debug::pagedump($second_keyword . " is a specific variable", __LINE__, __CLASS__);
        } else {
            $new_line .= " " . $fourth_keyword. ") { ?>";
        }

        return $new_line;
    }

    /**
     * @param $template
     *
     * requires the decrypted template
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