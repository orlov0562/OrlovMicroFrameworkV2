<?php
    class RouterRegexp
    {
        private $regexp;

        public function __construct($regexp, $isPattern=FALSE, $validators=array(), $template='~^{@regexp}$~i')
        {
            if ($isPattern)
            {
                $regexp = $this->convert_from_pattern($regexp, $validators, $template);
            }

            $this->regexp = $regexp;
        }

        public function get()
        {
            return $this->regexp;
        }

        public function __toString()
        {
            return $this->regexp;
        }

        public function convert_from_pattern($route, array $validators=array(), $template='~^{@regexp}$~')
        {

            $route_regexp = str_replace(array('[',']'), array('(?:',')?'), $route);

            if ($validators)
            {
                krsort($validators);
                foreach ($validators as $var=>$regexp)
                {
                    $route_regexp = str_replace('@'.$var, '('.$regexp.')', $route_regexp);
                }
            }

            $this->check_regexp_for_vars($route_regexp);

            $route_regexp = str_replace('{@regexp}', $route_regexp, $template);

            return $route_regexp;
        }

        private function check_regexp_for_vars($route_regexp) // проверяет остались ли в регулярке переменные валидатора
        {
            if (strpos($route_regexp,'@')) {
                $vars = array();
                if (preg_match_all('~@([a-z0-9]*)~i',$route_regexp, $regs))
                {
                    for ($i=0; $i<count($regs[0]); $i++)
                    {
                        $vars[]='@'.(empty($regs[1][$i])?'{'.$i.'}':$regs[1][$i]);
                    }
                }
                throw new Exception('Not found validators for vars: '.implode(', ',$vars).' in route: '. $route_regexp);
            }
        }
    }