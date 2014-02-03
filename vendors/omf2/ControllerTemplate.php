<?php

    abstract class ControllerTemplate extends Controller
    {
        protected $view;
        protected $header;
        protected $body;
        protected $footer;


        public function before(){

            $base_view_dir = dirname(__FILE__).'/views/base/';

            $this->view = View::f('index', $base_view_dir);

            $this->header = View::f('header', $base_view_dir);
            $this->body = View::f('body', $base_view_dir);
            $this->footer = View::f('footer', $base_view_dir);

            $this->view->bind('header', $this->header);
            $this->view->bind('body', $this->body);
            $this->view->bind('footer', $this->footer);

        }
    }