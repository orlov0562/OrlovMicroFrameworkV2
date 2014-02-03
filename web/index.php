<?php
    define('ROOT_DIR', dirname(__FILE__).'/');
    define('SITE_DIR', dirname(dirname(__FILE__)).'/site/');
    define('VENDORS_DIR', dirname(dirname(__FILE__)).'/vendors/');

    require_once(SITE_DIR.'init.php');

    app::i()->start();