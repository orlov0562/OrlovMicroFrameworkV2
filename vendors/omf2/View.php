<?php
    class View
    {
        private $vars = array();
        private static $base_path='';
        private $view_filepath;

        public static function configure(array $config)
        {
            self::$base_path = $config['base_path'];
        }

        public static function f($view, $base_path='')
        {
            return new View($view, $base_path);
        }

        public function __set($var, $val)
        {
            $this->set($var, $val);
        }

        public function __get($var)
        {
            return isset($this->vars[$var]) ? $this->vars[$var] : null;
        }


        public function __construct($view, $base_path='')
        {
            if (!$base_path AND self::$base_path) $base_path = self::$base_path;

            $view_filepath = $base_path
                             .strtolower(trim($view))
                             .'.php';
            if (!is_readable($view_filepath))
            {
                throw new Exception('View '.$view.' not found');
            }

            $this->view_filepath = $view_filepath;
        }

        public function set($vars, $val=null)
        {
            if (!is_array($vars)) $vars = array($vars=>$val);

            foreach ($vars as $var=>$val)
            {
                $this->vars[$var] = $val;
            }

            return $this;
        }

        public function bind($vars, &$val=null)
        {
            if (!is_array($vars)) $vars = array($vars=>&$val);

            foreach ($vars as $var=>&$val)
            {
                $this->vars[$var] = &$val;
            }
            return $this;
        }

        public function add($vars, $val=null)
        {
            if (!is_array($vars)) $vars = array($vars=>$val);

            foreach ($vars as $var=>$val)
            {
                if (!isset($this->vars[$var])) $this->vars[$var] = '';
                $this->vars[$var] .= $val;
            }

            return $this;
        }

        public function render($return=FALSE)
        {
            $old_err_reporting_level = error_reporting();
            error_reporting($old_err_reporting_level & ~E_NOTICE);
            ob_start();
            extract($this->vars);
            include $this->view_filepath;
            $ret = ob_get_clean();
            error_reporting($old_err_reporting_level);
            if (!$return) echo $ret; else return $ret;
        }

        public function __toString()
        {
            return $this->render(TRUE);
        }
    }