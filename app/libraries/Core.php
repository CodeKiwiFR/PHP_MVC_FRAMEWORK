<?php
    /*
     * App core class
     * Creates URL and loads core controller
     * URL FORMAT: /controller/method/param1/param2/...
     */
    class Core {
        // Our properties have default values that we set here
        protected $currentController = "Pages";
        protected $currentMethod = "index";
        protected $params = [];

        public function __construct() {
            $url = $this->getUrl();

            // Trying to reach the controller corresponding to $url first index
            if (isset($url[0])) {
                if (file_exists("./../app/controllers/" . ucwords($url[0]) . ".php")) {
                    // If exists, then we set it as controller
                    $this->currentController = ucwords($url[0]);
                }
                // Unset $url at index 0
                unset($url[0]);
            }

            // Require the controller
            require_once "./../app/controllers/" . $this->currentController . ".php";

            // Instantiate controller class
            $this->currentController = new $this->currentController;

            // Check for second part of URL (method to use from our controller)
            if (isset($url[1])) {
                if (method_exists($this->currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                }
                unset($url[1]);
            }

            // Get parameters, the last part of the url (unsetting controller and method args enables to keep only params inside of our $url array)
            $this->params = $url ? array_values($url) : [];

            // Call a callback with array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl() {
            // Getting the url from $_GET, cleaning it and exploding it into an array
            if (isset($_GET["url"])) {
                $url = rtrim($_GET["url"], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }