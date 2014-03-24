<?php
namespace kije\Formgenerator;

require_once 'inc/globals.inc.php';
require_once FORMGEN_ROOT . '/Tags/Form.php';
require_once FORMGEN_ROOT . '/Tags/Textarea.php';
require_once FORMGEN_ROOT . '/Tags/InputField.php';
require_once FORMGEN_ROOT . '/Tags/Select.php';
require_once FORMGEN_ROOT . '/Tags/Option.php';
require_once FORMGEN_ROOT . '/Tags/Button.php';

use kije\Formgenerator\inc\DB;
use kije\Formgenerator\Tags\Button;
use kije\Formgenerator\Tags\Form;
use kije\Formgenerator\Tags\InputField;
use kije\Formgenerator\Tags\Option;
use kije\Formgenerator\Tags\Select;
use kije\Formgenerator\Tags\Textarea;

// TODO: Different exceptions
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
    /**
     * @var Formgenerator instance
     */
    private static $instance;
    protected $form;
    private $table;

    /**
     * @var array options
     */
    private $options = array(
        'input_name_prefix' => 'form',
        'form_attributes'   => array(
            'action' => '',
            'method' => 'post'
        )
    );

    /**
     * @param       $table
     * @param array $options
     */
    private function __construct($table, $options = array())
    {
        $this->table = $table;
        $this->options = array_merge_recursive($this->options, $options);


    }

    /**
     * @return mixed
     * @throws FormgeneratorException
     */
    public static function getForm()
    {
        if (!empty(self::$instance)) {
            self::$instance->loadTable();

            return self::$instance->form;
        } else {
            throw new FormgeneratorException('Not initialized!');
        }
    }

    /**
     *
     */
    private function loadTable()
    {
        $stmt = DB::dbh()->prepare('SHOW COLUMNS FROM ' . $this->table);
        $stmt->execute();

        $res = $stmt->fetchAll();

        if (!empty($res)) {
            $this->form = new Form($this->options['form_attributes']);

            foreach ($res as $column) {
                $type = $this->getType($column['Field'], $column['Type']);
                if ($type != null) {
                    $formfield = null;
                    switch ($type) {
                        case 'textarea':
                            $formfield = new Textarea();
                            $formfield->setAttribute(
                                'name',
                                $this->options['input_name_prefix'] . '[' . $column['Field'] . ']'
                            );
                            if ($column['Null'] == 'NO') {
                                $formfield->setAttribute('required', 'required');
                            }
                            $this->form->addElement($formfield);
                            break;

                        case 'password':
                        case 'text':
                        case 'date':
                        case 'time':
                        case 'datetime':
                        case 'number':
                            $formfield = new InputField();
                            $formfield->setAttribute('type', $type);
                            $formfield->setAttribute(
                                'name',
                                $this->options['input_name_prefix'] . '[' . $column['Field'] . ']'
                            );
                            if ($column['Null'] == 'NO') {
                                $formfield->setAttribute('required', 'required');
                            }
                            $this->form->addElement($formfield);
                            break;

                        case 'floatnumber':
                            $formfield = new InputField();
                            $formfield->setAttribute('type', 'number');
                            $formfield->setAttribute('step', 'any');
                            $formfield->setAttribute(
                                'name',
                                $this->options['input_name_prefix'] . '[' . $column['Field'] . ']'
                            );
                            if ($column['Null'] == 'NO') {
                                $formfield->setAttribute('required', 'required');
                            }
                            $this->form->addElement($formfield);
                            break;


                        case 'checkbox':
                            $formfield = new InputField();
                            $formfield->setAttribute('type', 'checkbox');
                            $formfield->setAttribute(
                                'name',
                                $this->options['input_name_prefix'] . '[' . $column['Field'] . ']'
                            );
                            $formfield->setAttribute('value', '1');
                            if ($column['Null'] == 'NO') {
                                $formfield->setAttribute('required', 'required');
                            }
                            $this->form->addElement($formfield);
                            break;

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


                        default:
                            $formfield = new InputField();
                            $formfield->setAttribute('type', 'text');
                            $formfield->setAttribute(
                                'name',
                                $this->options['input_name_prefix'] . '[' . $column['Field'] . ']'
                            );
                            if ($column['Null'] == 'NO') {
                                $formfield->setAttribute('required', 'required');
                            }
                            $this->form->addElement($formfield);
                            break;
                    }

                }
            }

            $formfield = new Button();
            $formfield->setAttribute('type', 'submit');
            $formfield->setText('Senden');
            $this->form->addElement($formfield);
        }
    }

    /**
     * @param $col_name
     * @param $col_type
     *
     * @return string
     */
    private function getType($col_name, $col_type)
    {
        $type = null;
        if (strpos($col_name, 'text_') === 0) {
            if (preg_match_all('/text/i', $col_type)) {
                $type = 'textarea';
            } else {
                if (strpos(strtolower($col_type), 'varchar') !== false) {
                    $type = 'text';
                }
            }
        } elseif (strpos($col_name, 'checkbox_') === 0) {
            $type = 'checkbox';
        } elseif (strpos($col_name, 'radio_') === 0 && strpos(strtolower($col_type), 'enum') !== false) {
            $type = 'radio';
        } elseif (strpos($col_name, 'select_') === 0 && strpos(strtolower($col_type), 'enum') !== false) {
            $type = 'select';
        } elseif (strpos($col_name, 'password_') === 0) {
            $type = 'password';
        } elseif (strpos($col_name, 'date_') === 0) {
            $type = 'date';
        } elseif (strpos($col_name, 'time_') === 0) {
            $type = 'time';
        } elseif (strpos($col_name, 'datetime_') === 0) {
            $type = 'datetime';
        } elseif (strpos($col_name, 'number_') === 0) {
            if (preg_match_all('/int/i', $col_type)) {
                $type = 'number';
            } elseif (preg_match_all('/double|float|real/i', $col_type)) {
                $type = 'floatnumber';
            }
        }

        return $type;
    }

    /**
     * @param       $table
     * @param array $options
     *
     * @throws FormgeneratorException
     */
    public static function init($table, $options = array())
    {
        if (empty(self::$instance)) {
            self::$instance = new Formgenerator($table, $options);
        } else {
            throw new FormgeneratorException('Already initialized!');
        }
    }
}
