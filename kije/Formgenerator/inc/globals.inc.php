<?php
namespace kije\Formgenerator\inc;

ini_set('display_errors', true);
error_reporting(E_ALL ^ E_DEPRECATED);

require_once 'db.config.php';
require_once 'DB.php';

define('FORMGEN_INC_ROOT', __DIR__);
define('FORMGEN_ROOT', realpath(FORMGEN_INC_ROOT.'/..'));


