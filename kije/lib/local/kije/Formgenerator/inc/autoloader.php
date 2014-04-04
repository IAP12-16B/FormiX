<?php

// Autoloader
spl_autoload_register(
    function ($classname) {
        /** @inc $classname String */
        $classname = str_replace('\\', DIRECTORY_SEPARATOR, $classname);
        if (file_exists(realpath(FORMGEN_ROOT . '/../../') . '/' . $classname . '.php')) {

            require_once realpath(FORMGEN_ROOT . '/../../') . '/' . $classname . '.php';
        }
    }
);
