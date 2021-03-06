<?php

// Debug?
if (!defined('DEBUG')) {
    define('DEBUG', true);
}

// Define absolute Paths (these are relative to this document)
define('INC_ROOT', __DIR__);
define('DOC_ROOT', realpath(INC_ROOT . '/..'));

// Turn error reporting on/off
ini_set('display_errors', DEBUG);
error_reporting(E_ALL ^ E_DEPRECATED);

// set Error log
ini_set("log_errors", true);
ini_set("error_log", DOC_ROOT . "/var/log/php-error.log");

// includes
require_once DOC_ROOT . '/inc/autoloader.php';
require_once DOC_ROOT . '/inc/db.config.php';
require_once DOC_ROOT . '/inc/DB.php';
