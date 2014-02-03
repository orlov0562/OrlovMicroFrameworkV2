<?php

    foreach(glob(dirname(__FILE__).'/*') as $dir)
    {
        if (is_readable($dir.'/autoloader.php'))
        {
            require_once($dir.'/autoloader.php');
        }
    }

    require_once('orlov/pdo_sql.class.php');