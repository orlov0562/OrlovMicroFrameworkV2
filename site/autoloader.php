<?php
    spl_autoload_register(function ($class) {
        $class = str_replace('_', '/', $class);
        $class = strtolower($class);
        $class = preg_replace('~^(controller|model|view)/~','$1s/',$class);
        $class_filepath =  SITE_DIR. $class . '.php';
        if (is_readable($class_filepath))
        {
            include $class_filepath;
        }
    });