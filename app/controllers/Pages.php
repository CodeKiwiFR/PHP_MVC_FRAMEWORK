<?php
    class Pages extends Controller {
        private $postModel;

        public function __construct() {
            // Load models here
        }

        public function index() {
            // Loading the view
            $data = [
                "title" => "WELCOME!"
            ];
            $this->loadView("pages/index", $data);
        }

        public function about() {
            // Loading the view
            $data = [
                "title" => "About us"
            ];
            $this->loadView("pages/about", $data);
        }
    }