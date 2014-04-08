<?php
use kije\FormiX\FormiX;

require_once 'inc/globals.inc.php';
?>
<!doctype html>
<html lang="de">
    <head>
        <meta charset="UTF-8" />
        <title>Test-Form</title>

        <style>
            :invalid {
                background-color: orange;
                border: 1px solid beige;
                box-shadow: 0 0 5px red;
                color: #000;
            }

            :not(button):valid {
                background-color: greenyellow;
                box-shadow: 0 0 5px greenyellow;
                border: 1px solid green;
                color: #000;
            }

            ::-webkit-input-placeholder {
                color: #333;
            }

            fieldset {
                border: none;
                box-shadow: 0 0 4px rgba(0,0,0,0.3);
                border-radius: 20px;
            }

            .test_form {
                width: 40%;
                min-width: 300px;
                float: left;
                border-right: 1px dotted black;
                padding: 4%;
            }

            .test_form:last-child {
                border: none;
            }

            .test_form dl dt {
                clear: left;
                float: left;
                min-width: 26%;
                padding-right: 2%;
                box-sizing: border-box;
            }

            .test_form dl dd {
                float: left;
            }

            .test_form dl dt,
            .test_form dl dd {
                padding-bottom: 5px;
            }
        </style>
    </head>
    <body>
        <section class="test_form">
            <h1>Test</h1>
            <?php

            // initialize Formgenerator
            $form1 = new FormiX('test_form2');

            // initialize View
            $formView1 = new kije\FormiX\View(DOC_ROOT.'/TestFormView.phtml',$form1->getFormfields(),'', 'post');
            echo $formView1->render();
            ?>
        </section>
        <section class="test_form">
            <h1>Echtes Formular</h1>
            <?php

            // initialize Formgenerator
            $form2 = new FormiX('real_form');

            // initialize View
            $formView2 = new kije\FormiX\View(DOC_ROOT.'/TestFormView.phtml',$form2->getFormfields(),'', 'post');
            echo $formView2->render();
            ?>
        </section>

    </body>
</html>
