<?php
namespace kije\Formgenerator\inc;

ini_set('display_errors', true);
error_reporting(E_ALL ^ E_DEPRECATED);

define('FORMGEN_INC_ROOT', __DIR__);
define('FORMGEN_ROOT', realpath(FORMGEN_INC_ROOT . '/..'));


require_once FORMGEN_INC_ROOT . '/db.config.php';
require_once FORMGEN_INC_ROOT . '/DB.php';
