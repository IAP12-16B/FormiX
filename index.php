<?php
use kije\FormiX\FormiX;

require_once 'inc/globals.inc.php';


$formix = new FormiX('test_form');

$formfields = $formix->getFormfields();
?>
<pre><?php print_r($formfields); ?></pre>

<form method="post">
<?php
foreach($formfields as $field) {
    echo sprintf('<label>%s %s</label>', $field->toHTML(), $field->getCaption());
}
?>
</form>