<?php

    class Controller_Hello extends ControllerPageTemplate
    {
        public function Action_Index()
        {
            $this->header->seo_title = 'Index 1';
            $this->page->header = 'Test header';
            $this->page->add('content', View::f('menu'));
            $this->page->add('content', 'Index page');
        }

        public function Action_Index2()
        {
            echo View::f('index')->set(array(
                'seo_title' => 'Index 2',
                'content' => View::f('menu')
                             .View::f('block')->set(array('var'=>'Hello')),
            ));

            die(0);
        }

        public function Action_Test()
        {
            $this->header->seo_title = 'News';
            $this->page->header = 'Test news';
            $this->page->add('content', View::f('menu'));
            $this->page->add('content', 'Args <pre><code>'.print_r(func_get_args(), TRUE).'</code></pre>');
        }

        public function Action_404()
        {
            $this->header->seo_title = '404';
            $this->page->header = 'Error 404';
            $this->page->add('content', View::f('menu'));
            $this->page->add('content', 'Not found');
        }

        public function after()
        {
            $this->view->render();
            parent::after();
        }

    }