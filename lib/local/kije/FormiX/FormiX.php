<?php

namespace kije\FormiX;

use DB;
use kije\HTMLTags\Button;
use kije\HTMLTags\Checkbox;
use kije\HTMLTags\Date;
use kije\HTMLTags\Datetime;
use kije\HTMLTags\Fieldset;
use kije\HTMLTags\Formfield;
use kije\HTMLTags\Number;
use kije\HTMLTags\Option;
use kije\HTMLTags\Password;
use kije\HTMLTags\Radio;
use kije\HTMLTags\Select;
use kije\HTMLTags\Textarea;
use kije\HTMLTags\Textfield;
use kije\HTMLTags\Time;
use kije\HTMLTags\Validateable;

/**
 * Class FormiX
 * @package kije\FormiX
 */
class FormiX
{
    protected $tableName;
    protected $formfields;
    private $structure;

    /**
     * @param string $table
     */
    public function __construct($table)
    {
        $this->tableName = $table;
    }

    /**
     * @return Formfield[]
     */
    public function getFormfields()
    {
        if (empty($this->formfields)) {
            $this->buildForm();
        }

        return $this->formfields;
    }

    public function buildForm()
    {
        if (empty($this->structure)) {
            $this->updateStructure();
        }

        $this->formfields = array();
        foreach ($this->structure as $column) {
            if ($field = $this->column2formfield($column)) {
                $this->formfields[$column['Field']] = $field;
            }
        }

        $this->formfields['submit'] = new Button('Submit');
    }

    /**
     *
     */
    private function updateStructure()
    {
        $stmt = DB::dbh()->prepare('SHOW FULL COLUMNS FROM ' . $this->tableName);
        $stmt->execute();

        $this->structure = array();

        foreach ($stmt->fetchAll() as $row) {
            // filter auto_incremented values (may also be a security improvement)
            if (strpos(strtolower($row['Extra']), 'auto_increment') === false) {
                $this->structure[$row['Field']] = $row;
            }
        }


    }

    /**
     * @param $column
     *
     * @return Formfield|null
     */
    protected function column2formfield($column)
    {
        // TODO: Rewrite this methode
        $type = $column['Type'];
        $name = $column['Field'];
        $required = ($column['Null'] == 'YES');
        $value = $column['Default'];
        $caption = $column['Comment'];

        $formfield = null;

        if (strpos($name, 'text_') === 0) {

            if (preg_match_all('/text/i', $type)) {
                $formfield = new Textarea($name, $required, $caption, $value);
            } elseif (preg_match_all('/char/i', $type)) {
                $maxlength = array_filter(preg_split('/(var)?char\(|\)/i', $type));
                $formfield = new Textfield($name, $required, $caption, $value, intval($maxlength[1]));
            }
        } elseif (strpos($name, 'checkbox_') === 0) {
            $formfield = new Checkbox($name, '1', $required);
        } elseif (strpos($name, 'password_') === 0) {
            $formfield = new Password($name, $required, $caption, $value);
        } elseif (strpos($name, 'date_') === 0) {
            $formfield = new Date($name, date('c'), null, $required, $caption, $value);
        } elseif (strpos($name, 'time_') === 0) {
            $formfield = new Time($name, null, null, $required, $caption, $value);
        } elseif (strpos($name, 'datetime_') === 0) {
            $formfield = new Datetime($name, date('c'), null, $required, $caption, $value);
        } elseif (strpos($name, 'number_') === 0) {
            if (preg_match_all('/int/i', $type)) { // Todo: Types?
                $formfield = new Number($name, 1, $required, $caption, $value);
            } elseif (preg_match_all('/double|float|real/i', $type)) {
                $formfield = new Number($name, 'any', $required, $caption, $value);
            }
        } elseif (preg_match_all('/enum/i', $type)) {
            $values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));
            if (strpos($name, 'radio_') === 0 && strpos(strtolower($type), 'enum') !== false) {
                $formfield = new Fieldset();
                foreach ($values as $val) {
                    $radio = new Radio($name, $val, $required, $val == $value);
                    $radio->setCaption($val);
                    $formfield->addField($radio);
                }
            } elseif (strpos($name, 'select_') === 0 && strpos(strtolower($type), 'enum') !== false) {
                $formfield = new Select($name, $required);
                foreach ($values as $val) {
                    $formfield->addOption(
                        new Option($val, $value)
                    );
                }
            }
        }

        if ($formfield != null) {
            $formfield->setCaption($caption);
            $formfield->set('id', $name);
        }

        return $formfield;
    }

    /**
     * @param array $form_request Array with the values of the submitted form
     *
     * @return array
     */
    public function validate($form_request)
    {
        $messages = array();
        $errors = array();

        $this->buildForm();

        foreach ($form_request as $key => $value) {
            if (array_key_exists($key, $this->structure)) {
                $formfield = $this->column2formfield($this->structure[$key]);
                if ($formfield instanceof Validateable) {
                    $formfield->validateValue($value);
                }
            }
        }

        return array('messages' => $messages, 'errors' => $errors);
    }
}
