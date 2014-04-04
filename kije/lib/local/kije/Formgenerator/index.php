<?php

use kije\Formgenerator\Formgenerator;

require_once 'inc/globals.inc.php';
require_once FORMGEN_ROOT . '/Formgenerator.php';


Formgenerator::run(
    'test_form',
    FORMGEN_ROOT . '/TestFormTemplate.phtml',
    array('show_form' => true, 'method' => 'post', 'action' => '')
);
