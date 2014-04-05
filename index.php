<?php
use kije\FormiX\FormiX;

require_once 'inc/globals.inc.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Test-Form</title>
    </head>
    <body>
        <?php
        $formix = new FormiX('test_form');

        if (array_key_exists('test_form', $_POST)) {
            list($errors, $messages) = $formix->validate($_POST['test_form']);
        } else {
        $formfields = $formix->getFormfields();
        ?>
            <form method="post">
                <dl>
                    <?php
                    foreach ($formfields as $field) {
                        echo sprintf(
                            '<dt><label for="%s">%s:</label></dt>'.PHP_EOL.'<dd>%s</dd>'.PHP_EOL,
                            $field->get('id'),
                            $field->getCaption(),
                            $field->toHTML()
                        );
                    }
                    ?>
                </dl>
            </form>
        <?php } ?>
    </body>
</html>
