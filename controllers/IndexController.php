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
        $this->load_model('index');

        /*
         * Sending variables to your view should be done
         * before rendering your view.
         *
         * for example: $this->set('index', 'test', 'testvalue');
         *
         * just add the globals array as second argument to the
         * show / show_hf method.
         *
         * for example: $this->view->show('index', $this->globals);
         *
         * Access in views: <?php echo $this->get('test'); ?>
         * 
         */
    }

    public function show() {
        /**
         * Render the correct
         * content based on the
         * parameter
         */
        $this->view->show("index");
    }
}