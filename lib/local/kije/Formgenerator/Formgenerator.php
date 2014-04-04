<?php
namespace kije\Formgenerator;

use kije\Formgenerator\inc\DB;
use kije\HTMLTags\Button;
use kije\HTMLTags\Checkbox;
use kije\HTMLTags\Fieldset;
use kije\HTMLTags\InputField;
use kije\HTMLTags\Option;
use kije\HTMLTags\Password;
use kije\HTMLTags\Radio;
use kije\HTMLTags\Select;
use kije\HTMLTags\Textarea;
use kije\HTMLTags\Textfield;


/**
 * Class FormgeneratorException
 * @package kije\Formgenerator
 */
class FormgeneratorException extends \Exception
{
}


/**
 * Class Formgenerator
 * @package kije\Formgenerator
 */
class Formgenerator
{
    private $table_name;
    private $options = array();

    /**
     * @inc Formfield[] $formfields
     */
    private $formfields;

    /**
     * @param $table_name
     * @param $options
     */
    public function __construct($table_name, array $options = array())
    {
        $this->setTableName($table_name);
        $this->setOptions($options);
    }

    /**
     * @param       $table_name
     * @param       $template string  Path to template
     * @param array $template_args
     * @param       $options  array   Options
     */
    public static function run($table_name, $template, array $template_args = array(), array $options = array())
    {
        $formgen = new self($table_name, $options);
        echo call_user_func_array(array($formgen, 'generate'), array($template, $template_args));
    }

    /**
     * @param       $template string      Path to template
     * @param array $args
     *
     * @return string
     */
    public function generate($template, array $args = array())
    {
        foreach ($args as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include $template;
        $content = ob_get_contents();
        ob_end_clean();

        foreach ($args as $key => $value) {
            $$key = $value;
        }

        return $content;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    protected function setOptions($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @return mixed
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * @param mixed $table_name
     */
    protected function setTableName($table_name)
    {
        $this->table_name = $table_name;
    }

    private function loadTable()
    {
        $res = $this->getScheme();

        if (!empty($res)) {
            $this->formfields = array_map(array($this, 'getFormfieldFromColumn'), $res);
        }

        $submit_button = new Button();
        $submit_button->setAttribute('type', 'submit');
        $submit_button->setText('Senden');
        $this->formfields[] = new Formfield($submit_button);
    }

    /**
     * @return array
     */
    private function getScheme()
    {
        $stmt = DB::dbh()->prepare('SHOW FULL COLUMNS FROM ' . $this->table_name);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @param $column
     */
    protected function getFormfieldFromColumn($column)
    {
        $type = $column['Type'];
        $name = $column['Field'];
        $required = ($column['Null'] == 'YES');
        $value = $column['Default'];
        $caption = $column['Comment'];


        if (strpos($name, 'text_') === 0) {

            if (preg_match_all('/text/i', $type)) {
                $formfield = new Formfield(
                    new Textarea($name, $required, $caption, $value),
                    $caption
                );
            } elseif (preg_match_all('/char/i', $type)) {
                $maxlength = array_filter(preg_split('/(inc)?char\(|\)/i', $type));
                $formfield = new Formfield(
                    new Textfield($name, $required, $caption, $value, intval($maxlength[1])),
                    $caption
                );
            }
        } elseif (strpos($name, 'checkbox_') === 0) {
            $formfield = new Formfield(new Checkbox($name, '1', $required), $caption);
        } elseif (strpos($name, 'password_') === 0) {
            $formfield = new Formfield(
                new Password($name, $required, $caption, $value),
                $caption
            );
        } elseif (strpos($name, 'date_') === 0) {
        } elseif (strpos($name, 'time_') === 0) {
        } elseif (strpos($name, 'datetime_') === 0) {
        } elseif (strpos($name, 'number_') === 0) {
            if (preg_match_all('/int/i', $type)) { // Todo: Types?
            } elseif (preg_match_all('/double|float|real/i', $type)) {
            }
        } else {
            $values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));
            if (strpos($name, 'radio_') === 0 && strpos(strtolower($type), 'enum') !== false) {
                $fieldset = new Fieldset();
                foreach ($values as $val) {
                    $fieldset->addField(
                        new Formfield(new Radio($name, $val, $required, $val == $value), $val)
                    );
                }
                $formfield = new Formfield($fieldset, $caption);
            } elseif (strpos($name, 'select_') === 0 && strpos(strtolower($type), 'enum') !== false) {
                $select = new Select($name, $required);
                foreach ($values as $val) {
                    $select->addOption(
                        new Option($val, $value)
                    );
                }

                $formfield = new Formfield($select, $caption);
            }
        }
    }

    /**
     * Converts a column (from SHOW [Full] COLLUMS FROM ...) to a formfield/array of formfields
     *
     * @param $column array
     *
     * @return Formfield|Formfield[]
     */
    protected function column2formfield(array $column)
    {
        $type = $this->getType($column['Field'], $column['Type']);
        if ($type != null) {
            $formfield = null;
            if ($type == 'radio') {
                $formfield = new Formfield();
                $tag = null;

                if ($type == 'textarea') {
                    $tag = new Textarea();
                } elseif (
                    $type == 'password' ||
                    $type == 'text' ||
                    $type == 'date' ||
                    $type == 'time' ||
                    $type == 'datetime' ||
                    $type == 'number' ||
                    $type == 'floatnumber'
                ) {
                    $tag = new InputField();
                } elseif ($type == 'select') {
                    $tag = new Select();
                }

                if ($type == 'password') {

                } elseif ($type == 'text') {

                } elseif ($type == 'date') {

                } elseif ($type == 'time') {

                } elseif ($type == 'datetime') {

                } elseif ($type == 'number') {
                    $tag->setAttribute('type', 'number');
                } elseif ($type == 'floatnumber') {
                    $tag->setAttribute('type', 'number');
                    $tag->setAttribute('step', 'any');
                } elseif ($type == 'checkbox') {
                    $tag->setAttribute('type', 'checkbox');
                    $tag->setAttribute('value', '1');
                } elseif ($type == 'radio') {

                } elseif ($type == 'select') {

                }

                $tag->setAttribute(
                    'name',
                    $this->table_name . '[' . $column['Field'] . ']'
                );

                if ($column['Null'] == 'NO') {
                    $tag->setAttribute('required', 'required');
                }

                $formfield->setTag($tag);
            } else {
                $formfield = array();
                $tag = new InputField();

                $values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));

                foreach ($values as $value) {
                    $tag = new InputField();
                    $tag->setAttribute('type', 'radio');
                    $tag->setAttribute(
                        'name',
                        $this->options['input_name_prefix'] .
                        '[' .
                        $column['Field'] .
                        ']'
                    );
                    $tag->setAttribute('value', $value);
                    if ($column['Null'] == 'NO') {
                        $formfield->setAttribute('required', 'required');
                    }
                    $this->form->addElement($formfield);
                }
            }

            return $formfield;


            switch ($type) {

                case 'radio':
                    $values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));

                    foreach ($values as $value) {
                        $formfield = new InputField();
                        $formfield->setAttribute('type', 'radio');
                        $formfield->setAttribute(
                            'name',
                            $this->options['input_name_prefix'] .
                            '[' .
                            $column['Field'] .
                            ']'
                        );
                        $formfield->setAttribute('value', $value);
                        if ($column['Null'] == 'NO') {
                            $formfield->setAttribute('required', 'required');
                        }
                        $this->form->addElement($formfield);
                    }
                    break;

                case 'select':
                    $values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));
                    $formfield = new Select();
                    $formfield->setAttribute(
                        'name',
                        $this->options['input_name_prefix'] . '[' . $column['Field'] . ']'
                    );

                    if ($column['Null'] == 'NO') {
                        $formfield->setAttribute('required', 'required');
                    }

                    foreach ($values as $value) {
                        $option = new Option();
                        $option->setAttribute('value', $value);
                        $option->setText($value);
                        $formfield->addOption($option);
                    }
                    $this->form->addElement($formfield);
                    break;


            }

        }
    }
}
