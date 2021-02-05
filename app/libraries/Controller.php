<?php
    /*
     * Base Controller
     * This loads the models and views
     */
    class Controller {
        // Load Model
        public function loadModel($model) {
            // Require model file
            require_once "./../app/models/" . $model . ".php";

            // Instantiate model
            return new $model();
        }

        // Load view
        public function loadView($view, $data = []) {
            // Require view file
            if (file_exists("./../app/views/" . $view . ".php")) {
                require_once "./../app/views/" . $view . ".php";
            } else {
                // If the view does not exist
                die("View does not exist!");
            }
        }
    }