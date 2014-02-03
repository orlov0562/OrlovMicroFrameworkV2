<?php

    abstract class ControllerPageTemplate extends ControllerTemplate
    {
        protected $page;

        public function before(){
            parent::before();
            $base_view_dir = dirname(__FILE__).'/views/base/';

            $this->page = View::f('page', $base_view_dir);
            $this->body->bind('body', $this->page);
        }
    }