<?php

class IndexController extends Controller {
    public function __construct() {
        parent::__construct();
        /**
         * Loads the correct model
         * based on the parameter
         *
         * access with: $this->[LOADMODEL_PARAMETER]->[FUNCTION_CALL]
         */
        $this->loadmodel('index');

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
        $this->view->show('index');
    }
}