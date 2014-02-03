<?php
    class Router
    {
        private $regexp;
        private $callback;
        private $name;

        public function __construct($regexp, $callback, $name='undefined')
        {
            $this->regexp = ($regexp instanceof RouterRegexp)
                          ? $regexp
                          : new RouterRegexp($regexp)
            ;

            $this->callback = ($callback instanceof RouterCallback)
                            ? $callback
                            : new RouterCallback($callback)
            ;

            $this->name = $name;
        }

        public function match($target)
        {
            return preg_match($this->regexp, $target);
        }

        public function callback($vars=array())
        {
            $this->callback->execute($vars);
        }

        public function callback_if_match($target)
        {
            $ret = FALSE;
            if (preg_match($this->regexp, $target, $regs))
            {
                array_shift($regs);
                $this->callback->execute($regs);
                $ret = TRUE;
            }
            return $ret;
        }


        public function get_name()
        {
            return $this->name;
        }

        public function __toString()
        {
            return $this->name;
        }

        public function name_match($regexp)
        {
            return preg_match($regexp, $this->name);
        }
    }