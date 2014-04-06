<?php
use kije\FormiX\FormiX;

require_once 'inc/globals.inc.php';
?>
<!doctype html>
<html lang="de">
    <head>
        <meta charset="UTF-8" />
        <title>Test-Form</title>
    </head>
    <body>
        <pre><?php print_r($_REQUEST); ?></pre>
        <?php

        $formix = new FormiX('test_form');
        $show_form = true;

        $errors = array();
        $messages = array();

        if (array_key_exists('test_form', $_POST)) {
            $res = $formix->validate($_POST['test_form']);
            print_r($res );
            $messages = $res['messages'];
            $errors = $res['errors'];
            var_dump($messages );
            var_dump($errors);
            $show_form = !empty($errors);
        }
        ?>
        <p class="errors"><?php echo implode('<br>', $errors); ?></p>

        <p class="messages"><?php echo implode('<br>', $messages); ?></p>
        <?php
        if ($show_form):
            $formfields = $formix->getFormfields();
            ?>
            <form method="post">
                <dl>
                    <?php
                    foreach ($formfields as $field) {
                        echo sprintf(
                            '<dt><label for="%s">%s:</label></dt>' . PHP_EOL . '<dd>%s</dd>' . PHP_EOL,
                            $field->get('id'),
                            $field->getCaption(),
                            $field->toHTML()
                        );
                    }
                    ?>
                </dl>
            </form>
        <?php endif; ?>
    </body>
</html>
