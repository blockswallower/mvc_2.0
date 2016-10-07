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
     * @var Mixed array
     */
    public $globals;

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
    public function __construct($global_array) {
        $this->set_base_view_path("./views/");
        $this->view = new View();

        /*
         * set global variables
         */
        $this->globals = $global_array;
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
                $new_line = $this->map_substring_keywords($substring_exploded, $new_line,
                                                          $first_keyword, Arr::size($substring_exploded));
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
    public function map_substring_keywords($substring_exploded , $new_line, $first_keyword, $array_size) {
        /*
         * @var Array
         */
        $valid_arrays_sizes = [
            "4", "5", "6", "7", "8"
        ];

        if (!in_array($array_size, $valid_arrays_sizes)) {
            Debug::pagedump("Wrong syntax, keep the amount of spaces under 3", __LINE__, __CLASS__);
            exit;
        }

        /*
         * @var String
         */
        $second_keyword = $substring_exploded[$array_size >= 5 ? 2: 1];

        /*
         * @var String
         */
        $third_keyword = $substring_exploded[$array_size >= 5 ? 3: 2];

        /*
         * @var String
         */
        $fourth_keyword = $substring_exploded[$array_size >= 5 ? 4: 3];

        $new_line .= "" . $first_keyword . " (";

        if (Str::contains($second_keyword, "$")) {
            Debug::pagedump($second_keyword . " is a specific variable", __LINE__, __CLASS__);
            exit;
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
            case "==":
                $new_line .= " " . "==";
                break;
            case "!=":
                $new_line .= " ". "!=";
                break;
        }

        if (Str::contains($fourth_keyword, "$")) {
            Debug::pagedump($second_keyword . " is a specific variable", __LINE__, __CLASS__);
            exit;
        } else {
            $new_line .= " " . $fourth_keyword. ") { ?>";
        }

        return $new_line;
    }

    /**
     * @param null $key
     * @return mixed
     *
     * returns a value from the "globals" variable
     * can be used in templates like this:
     *
     * $this->get([KEY]);
     */
    public function get($key = null) {
        /*
         * @var String
         */
        $cur_controller = Controller::return_current_controller();

        if (!empty($this->globals[$cur_controller])) {
            if (!empty($key)) {
                $value = $this->globals[$cur_controller][$key];

                if (!empty($value)) {
                    return $value;
                } else {
                    Debug::pagedump('The value you are trying to access is empty or NULL', __LINE__, __CLASS__);
                }
            } else {
                Debug::pagedump('Please enter an array key as an argument: $this->get([KEY])', __LINE__, __CLASS__);
            }
        } else {
            Debug::pagedump("No variables has been send from this controller yet: " . ucfirst($cur_controller) . "Controller",
                __LINE__, __CLASS__);
        }

        return $key;
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