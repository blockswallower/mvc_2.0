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
                                 "minus", "times", "*", "end",
                                 "greater", "less", "print", "to"];

    /*
     * TemplateEngine Constructor
     *
     * @param $global_array
     */
    public function __construct($global_array = null) {
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
            /*
             * @var Array
             */
            $substring_exploded = explode(" ", $substring);

            /*
             * @var Array
             */
            $keywords = [];

            for ($ii = 0; $ii < Arr::size($substring_exploded); $ii++) {
                if ($substring_exploded[$ii] != "") {
                    $keywords[] = $substring_exploded[$ii];
                }
            }

            /*
             * @var String
             */
            $new_line .= "<?php ";

            if ($keywords[0] == "end") {
                $new_line = "<?php } ?>";
            } else if ($keywords[0] == "print") {
                $second_keyword = $keywords[1];

                if (Str::contains($second_keyword, "%")) {
                    $global = $this->get($this->decrypt_global_var_keyword($second_keyword));
                }

                $new_line .= 'echo "' . $global . '"; ?>';
            } else if ($keywords[0] == "@extend") {
                /*
                 * Extends given view
                 */
                $new_line .= '$this->view->extend("'. $keywords[1] .'"); ?>';
            } else {
                $new_line = $this->map_substring_keywords($new_line, $keywords);
            }
        } else {
            $keys = array_keys($values);
            $new_substring = str_replace($substring, $values[$keys[$value_index]], $substring);
            $new_line = str_replace($substring, $new_substring, $line);
        }

        return $new_line;
    }

    /**
     * @param $keywords
     * @param $new_line
     * @return mixed
     *
     * Step by step mapping of all keywords found
     */
    public function map_substring_keywords($new_line, $keywords) {
        /*
         * @var String
         */
        $first_keyword = $keywords[0];

        /*
         * @var String
         */
        $second_keyword = $keywords[1];

        /*
         * @var String
         */
        $third_keyword = $keywords[2];

        /*
         * @var String
         */
        $fourth_keyword = $keywords[3];

        /*
         * @var Boolean
         */
        $is_for_loop = false;

        if ($first_keyword == "for") {
            $is_for_loop = true;
        }

        /*
         * =====================================
         * Set first keyword
         */
        $new_line .= "" . $first_keyword . " (";

        /*
         * ======================================
         * Set second keyword
         */
        if (Str::contains($second_keyword, "%") && !$is_for_loop) {
            /*
             * @var String
             */
            $global = $this->get($this->decrypt_global_var_keyword($second_keyword));

            $new_line .= $global;
        } else {
            /*
             * Check if the tag contains for loop keywords
             */
            if ($is_for_loop) {
                /*
                 * Check if the for loop is numeric
                 */
                if ($third_keyword == "to") {
                    if (Str::contains($second_keyword, "%")) {
                        $second_keyword = $this->get($this->decrypt_global_var_keyword($second_keyword));
                    }

                    if (Str::contains($fourth_keyword, "%")) {
                        $fourth_keyword = $this->get($this->decrypt_global_var_keyword($fourth_keyword));
                    }

                    $new_line .= '$i = ' . $second_keyword . '; $i < ' . $fourth_keyword . ';' . '$i++) { ?>';
                }
            } else {
                $new_line .= "" . $second_keyword;
            }
        }

        /*
         * ========================================
         * Set third keyword
         */
        if (!$is_for_loop) {
            $new_line = $this->set_operator($third_keyword, $new_line);
        }

        /*
         * ========================================
         * Set fourth keyword
         */
        if (!$is_for_loop) {
            if (Str::contains($fourth_keyword, "%")) {
                /*
                 * @var String
                 */
                $global = $this->get($this->decrypt_global_var_keyword($fourth_keyword));

                $new_line .= $global. ") { ?>";
            } else {
                $new_line .= " " . $fourth_keyword. ") { ?>";
            }
        }

        return $new_line;
    }

    /**
     * @param $third_keyword
     * @param $new_line
     * @return string
     *
     * Adds a operator based on the third_keyword found
     */
    public function set_operator($third_keyword, $new_line) {
        switch ($third_keyword) {
            case "equals":
                $new_line .= " " . "==";
                break;
            case "!equals":
                $new_line .= " " . "!=";
                break;
            case "==":
                $new_line .= " " . "==";
                break;
            case "!=":
                $new_line .= " " . "!=";
                break;
            case "greater":
                $new_line .= " " . ">";
                break;
            case "less":
                $new_line .= " " . "<";
                break;
        }

        return $new_line;
    }

    /**
     * @param $keyword
     * @return string
     *
     * Decrypt global variable keyword
     */
    function decrypt_global_var_keyword($keyword) {
        /*
             * @var Array
             */
        $split = str_split($keyword);

        /*
         * @var Integer
         */
        $index = Arr::find_index($split, "%");

        unset($split[$index]);

        /*
         * @var String
         */
        $keyword = "";

        foreach ($split as $char) {
            $keyword .= $char;
        }

        return $keyword;
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

                if (isset($value)) {
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