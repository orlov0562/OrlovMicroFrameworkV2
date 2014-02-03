<?php

    require_once(VENDORS_DIR.'loader.php');
    require_once(SITE_DIR.'autoloader.php');

    set_exception_handler(function($e){
        die($e->getMessage().'<hr>'.'<pre>'.$e->getTraceAsString().'</pre>');
    });

    require_once(SITE_DIR.'app.php');

    header('Content-Type: text/html; charset=utf-8');