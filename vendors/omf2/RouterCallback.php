<?php
    class RouterCallback
    {
        private $controller;
        private $action;

        public function __construct($callback='Index::Index')
        {
            list($controller, $action) = array_pad(explode('::',$callback), 2, 'Index');
            $this->controller = 'Controller_'.$this->prepare_name($controller);
            $this->action = 'Action_'.$this->prepare_name($action);
            $this->vars = $vars;
        }

        public function execute($vars = array())
        {
            if (class_exists($this->controller, TRUE))
            {
                $obj = new $this->controller;
                $this->call_class_method($obj, 'before');
                $this->call_class_method($obj, $this->action, $vars, TRUE);
                $this->call_class_method($obj, 'after');
            }
            else
            {
                throw new Exception('Class '.$this->controller.' not found');
            }
        }

        private function prepare_name($name)
        {
            $name = strtolower(trim($name));
            $name = preg_replace_callback('/\b\p{Ll}/', function($match){
                return mb_strtoupper($match[0]);
            }, $name);
            return $name;
        }

        private function call_class_method($obj, $method, $vars=array(), $required_method=FALSE)
        {
            if (method_exists($obj, $method))
            {
                if (is_callable(array($obj, $method)))
                {
                    call_user_func_array(array($obj, $method), $vars);
                }
                else
                {
                    throw new Exception('Method '.get_class($obj).'::'.$method.' not callable');
                }
            }
            elseif($required_method)
            {
                throw new Exception('Method '.get_class($obj).'::'.$method.' not found');
            }
        }
    }