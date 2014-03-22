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
class FormgeneratorException extends \Exception
{
}


class Formgenerator
{
	/**
	 * @var Formgenerator instance
	 */
	private static $_instance;
	protected $_form;
	private $_table;

	/**
	 * @var array options
	 */
	private $_options = array(
		'input_name_prefix' => 'form',
		'form_attrs'        => array(
			'action' => '',
			'method' => 'post'
		)
	);

	/**
	 * @param       $table
	 * @param array $options
	 */
	private function __construct($table, $options = array()) {
		$this->_table = $table;
		$this->_options = array_merge_recursive($this->_options, $options);


	}

	/**
	 * @return mixed
	 * @throws FormgeneratorException
	 */
	public static function getForm() {
		if (!empty(self::$_instance)) {
			self::$_instance->loadTable();

			return self::$_instance->_form;
		} else {
			throw new FormgeneratorException('Not initialized!');
		}
	}

	/**
	 *
	 */
	private function loadTable() {
		$stmt = DB::dbh()->prepare('SHOW COLUMNS FROM ' . $this->_table);
		$stmt->execute();

		$res = $stmt->fetchAll();

		if (!empty($res)) {
			$this->_form = new Form($this->_options['form_attrs']);

			foreach ($res as $column) {
				$type = $this->getType($column['Field'], $column['Type']);
				if ($type != NULL) {
					$formfield = NULL;
					switch ($type) {
						case 'textarea':
							$formfield = new Textarea();
							$formfield->setAttribute('name', $column['Field']);
							if ($column['Null'] == 'NO') {
								$formfield->setAttribute('required', 'required');
							}
							$this->_form->addElement($formfield);
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
								$this->_options['input_name_prefix'] . '[' . $column['Field'] . ']'
							);
							if ($column['Null'] == 'NO') {
								$formfield->setAttribute('required', 'required');
							}
							$this->_form->addElement($formfield);
							break;

						case 'floatnumber':
							$formfield = new InputField();
							$formfield->setAttribute('type', 'number');
							$formfield->setAttribute('step', 'any');
							$formfield->setAttribute(
								'name',
								$this->_options['input_name_prefix'] . '[' . $column['Field'] . ']'
							);
							if ($column['Null'] == 'NO') {
								$formfield->setAttribute('required', 'required');
							}
							$this->_form->addElement($formfield);
							break;


						case 'checkbox':
							$formfield = new InputField();
							$formfield->setAttribute('type', 'checkbox');
							$formfield->setAttribute(
								'name',
								$this->_options['input_name_prefix'] . '[' . $column['Field'] . ']'
							);
							$formfield->setAttribute('value', '1');
							if ($column['Null'] == 'NO') {
								$formfield->setAttribute('required', 'required');
							}
							$this->_form->addElement($formfield);
							break;

						case 'multicheckbox':
							$values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));

							foreach ($values as $value) {
								$formfield = new InputField();
								$formfield->setAttribute('type', 'checkbox');
								$formfield->setAttribute(
									'name',
									$this->_options['input_name_prefix'] .
									'[' .
									$column['Field'] .
									']'
								);
								$formfield->setAttribute('value', $value);
								$this->_form->addElement($formfield);
							}
							break;

						case 'radio':
							$values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));

							foreach ($values as $value) {
								$formfield = new InputField();
								$formfield->setAttribute('type', 'radio');
								$formfield->setAttribute(
									'name',
									$this->_options['input_name_prefix'] .
									'[' .
									$column['Field'] .
									']'
								);
								$formfield->setAttribute('value', $value);
								if ($column['Null'] == 'NO') {
									$formfield->setAttribute('required', 'required');
								}
								$this->_form->addElement($formfield);
							}
							break;

						case 'select':
							$values = array_filter(preg_split('/enum\(|\"|\'|[\s,]+|\)/i', $column['Type']));
							$formfield = new Select();
							$formfield->setAttribute(
								'name',
								$this->_options['input_name_prefix'] . '[' . $column['Field'] . ']'
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
							$this->_form->addElement($formfield);
							break;


						default:
							$formfield = new InputField();
							$formfield->setAttribute('type', 'text');
							$formfield->setAttribute(
								'name',
								$this->_options['input_name_prefix'] . '[' . $column['Field'] . ']'
							);
							if ($column['Null'] == 'NO') {
								$formfield->setAttribute('required', 'required');
							}
							$this->_form->addElement($formfield);
							break;
					}

				}
			}

			$formfield = new Button();
			$formfield->setAttribute('type', 'submit');
			$formfield->setText('Senden');
			$this->_form->addElement($formfield);
		}
	}

	/**
	 * @param $col_name
	 * @param $col_type
	 *
	 * @return string
	 */
	private function getType($col_name, $col_type) {
		$type = NULL;
		if (strpos($col_name, 'text_') === 0) {
			if (preg_match_all('/text/i', $col_type)) {
				$type = 'textarea';
			} else {
				if (strpos(strtolower($col_type), 'varchar') !== false) {
					$type = 'text';
				}
			}
		} elseif (strpos($col_name, 'checkbox_') === 0) {
			if (preg_match_all('/int/i', $col_type)) {
				$type = 'checkbox';
			} else if (strpos(strtolower($col_type), 'enum') !== false) {
				$type = 'multicheckbox';
			}

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
	public static function init($table, $options = array()) {
		if (empty(self::$_instance)) {
			self::$_instance = new Formgenerator($table, $options);
		} else {
			throw new FormgeneratorException('Already initialized!');
		}
	}
}