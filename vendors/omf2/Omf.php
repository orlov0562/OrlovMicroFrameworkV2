<?php
    class OMF
    {

        private $routes = array();
        private $current_route = null;
        private $request;


        public function __construct()
        {
            $this->request = $this->get_request();
        }

        public function add_route(Router $route)
        {
            $this->routes[] = $route;
        }

        public function load_routes(array $routes)
        {
            $this->routes = $routes;
        }

        public function execute()
        {
            foreach($this->routes as $route)
            {
                if ($route->callback_if_match($this->request))
                {
                    $current_route = $route;
                    break;
                }
            }
        }

        public function get_current_route()
        {
            return $this->current_route;
        }

        public function get_request()
        {
            $ret = (php_sapi_name() != 'cli')
                 ? $this->get_web_request_uri()
                 : $this->get_cli_request_uri();
            return $ret;
        }

        private function get_web_request_uri()
        {
            $ret = isset($_SERVER['REQUEST_URI'])
                 ? $_SERVER['REQUEST_URI']
                 : '/';

            if ($pos_get = strpos($ret, '?')) $ret = substr($ret, 0, $pos_get);

            return $ret;
        }

        private function get_cli_request_uri()
        {
            $ret = isset($argv[1]) ? $argv[1] : '/';
            return $ret;
        }
    }