<?php
namespace kije\Formgenerator\inc;

// Debug?
if (!defined('DEBUG')) {
    define('DEBUG', true);
}

// Define paths
define('FORMGEN_INC_ROOT', __DIR__);
define('FORMGEN_ROOT', realpath(FORMGEN_INC_ROOT . '/..'));

// Turn error reporting on/off
ini_set('display_errors', DEBUG);
error_reporting(E_ALL ^ E_DEPRECATED);

// set Error log
ini_set("log_errors", true);
ini_set("error_log", FORMGEN_ROOT . "/logs/php-error.log");

// includes
require_once FORMGEN_INC_ROOT . '/autoloader.php';
require_once FORMGEN_INC_ROOT . '/db.config.php';
require_once FORMGEN_INC_ROOT . '/DB.php';
