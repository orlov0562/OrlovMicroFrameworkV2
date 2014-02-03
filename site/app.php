<?php

    class App
    {
        private static $instance = null;
        private $omf;
        private $cfg;

        private function __construct()
        {
            $this->init();
            $this->configure();
        }

        private function init()
        {
             $this->omf = new Omf();
        }

        private function configure()
        {
            $this->cfg = include(SITE_DIR.'configs/config.php');

            View::configure(array(
                'base_path' => SITE_DIR
                               .'views/'
                               .$this->cfg->template->name
                               .'/'
                ,
            ));

            pdo_sql::configure( include(SITE_DIR.'configs/db.php') );

            $this->omf->load_routes(include(SITE_DIR.'configs/routes.php'));

        }

        public static function instance()
        {
            if (is_null(self::$instance)) self::$instance = new App;
            return self::$instance;
        }

        public static function i() {
            return self::instance();
        }

        public function start()
        {
            $this->omf->execute();
        }
    }