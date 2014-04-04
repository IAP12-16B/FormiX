<?php

// Autoloader
spl_autoload_register(
    function ($classname) {
        /** @inc $classname String */
        $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
        if (file_exists((DOC_ROOT . '/lib/local/' . $classname . '.php'))) {
            include_once DOC_ROOT . '/lib/local/' . $classname . '.php';
        }
    }
);
