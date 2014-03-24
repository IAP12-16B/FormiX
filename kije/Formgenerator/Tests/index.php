<?php

require_once '../inc/globals.inc.php';
require_once FORMGEN_ROOT . '/Formgenerator.php';

echo '<pre>'.print_r($_POST, true).'</pre>';


\kije\Formgenerator\Formgenerator::init('test_form');
echo \kije\Formgenerator\Formgenerator::getForm()->toHTML();
