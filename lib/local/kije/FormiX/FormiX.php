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

/**
 * Class FormiX
 * @package kije\FormiX
 */
class FormiX
{
    protected $tableName;
    /**
     * @var Formfield[]
     */
    protected $formfields;

    /**
     * @var array $structure The Database Structure
     */
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

    /**
     * Updates the Form
     */
    protected function buildForm()
    {
        if (empty($this->structure)) {
            $this->updateStructure();
        }

        $this->formfields = array();
        foreach ($this->structure as $column) {
            if ($field = $this->getFormfieldFromColumn($column)) {
                $this->formfields[$column['Field']] = $field;
            }
        }

        $this->formfields['submit'] = new Button('Submit');
    }

    /**
     *  Updates the structure from DB
     */
    private function updateStructure()
    {
        $stmt = DB::dbh()->prepare('SHOW FULL COLUMNS FROM `' . $this->tableName . '`');
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
     * Builds the Formfield object from a DB column (retrieved by SHOW FULL COLUMNS FROM ...)
     *
     * @param array       $column
     * @param null|string $value
     *
*@return Formfield|null
     */
    protected function getFormfieldFromColumn($column, $value = null)
    {
        // TODO: Rewrite this methode, it's ugly
        $type = $column['Type'];
        $name = $column['Field'];
        $fieldname = sprintf('%s[%s]', $this->tableName, $name);
        $required = ($column['Null'] != 'YES');
        $value = ($value ? $value : $column['Default']);
        $caption = $column['Comment'];

        $formfield = null;

        if (strpos($name, 'text_') === 0) {
            if (preg_match_all('/text/i', $type)) {
                $formfield = new Textarea($fieldname, $required, $caption, $value);
            } elseif (preg_match_all('/char/i', $type)) {
                $maxlength = array_filter(preg_split('/(var)?char\(|\)/i', $type));
                $formfield = new Textfield($fieldname, $required, $caption, $value, intval($maxlength[1]));
            }
        } elseif (strpos($name, 'checkbox_') === 0) {
            $formfield = new Checkbox($fieldname, '1', $required, !empty($value));
        } elseif (strpos($name, 'password_') === 0) {
            $formfield = new Password($fieldname, $required, $caption, $value);
        } elseif (strpos($name, 'date_') === 0) {
            $formfield = new Date($fieldname, null, null, $required, $value);
        } elseif (strpos($name, 'time_') === 0) {
            $formfield = new Time($fieldname, $required, $value);
        } elseif (strpos($name, 'datetime_') === 0) {
            $formfield = new Datetime($fieldname, date('c'), null, $required, $value);
        } elseif (strpos($name, 'number_') === 0) {
            if (preg_match_all('/int/i', $type)) { // Todo: Types?
                $formfield = new Number($fieldname, 1, $required, $caption, $value);
            } elseif (preg_match_all('/double|float|real|numeric/i', $type)) {
                $formfield = new Number($fieldname, 'any', $required, $caption, $value);
            }
        } elseif (preg_match_all('/enum|set/i', $type)) {
            $values = $this->getEnumValues($column['Type']);
            if (strpos($name, 'radio_') === 0) {
                $formfield = new Fieldset();
                foreach ($values as $val) {
                    $radio = new Radio($fieldname, $val, $required, $val == $value);
                    $radio->setCaption($val);
                    $formfield->addField($radio);
                }
            } elseif (strpos($name, 'select_') === 0) {
                $formfield = new Select($fieldname, $required);

                // First Option is empty
                $formfield->addOption(new Option(' ', ''));

                foreach ($values as $val) {
                    $formfield->addOption(
                        new Option($val, $value, $value == $val)
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
     * Extracts the values from an enum/set
     *
     * @param $sqlEnum
     *
     * @return array
     */
    protected function getEnumValues($sqlEnum)
    {
        return array_filter(preg_split('/(enum|set)\(|\"|\'|(\s?,\s?)+|\)/i', $sqlEnum));
    }
}
