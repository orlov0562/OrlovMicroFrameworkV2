<?php

    spl_autoload_register(function ($class) {
        $class = str_replace('_', '/', $class);
        $class = strtolower($class);
        $class_filepath =  dirname(__FILE__).'/' . $class . '.php';
        if (is_readable($class_filepath))
        {
            include $class_filepath;
        }
    });