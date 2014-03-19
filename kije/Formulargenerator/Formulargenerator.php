<?php
namespace kije\Formulargenerator;
use kije\Formulargenerator\inc\DB;
use kije\Formulargenerator\Tags\Form;

require_once 'inc/globals.inc.php';
require_once 'Tags/Form.php';

class FormulargeneratorException extends \Exception {}


class Formulargenerator {
    private $_table;
    protected $_form;

    private $_options = array(
        'form_attrs' => array(
            'action' => '',
            'method' => 'post'
        )
    );

    /**
     * @var Formulargenerator instance
     */
    private static $_instance;

    /**
     * @param $table
     * @param array $options
     */
    private function __construct($table, $options = array()) {
        $this->_table = $table;
        $this->_options = array_merge_recursive($this->_options, $options);

        $this->_form = new Form($this->_options['form_attrs']);

        $this->loadTable();
    }

    /**
     * @param $table
     * @param array $options
     * @throws FormulargeneratorException
     */
    public static function init($table, $options = array()) {
        if (empty(self::$_instance)) {
            self::$_instance = new Formulargenerator($table, $options);
        } else {
            throw new FormulargeneratorException('Already initialized!');
        }
    }

    /**
     *
     */
    private function loadTable() {
        $stmt = DB::dbh()->prepare('SHOW COLUMNS FROM '.$this->_table);
        $stmt->execute();

        $res = $stmt->fetchAll();

        if (!empty($res)) {
            $this->_fields = array();

            foreach($res as $column) {
                $type = $this->getType($column['Field'], $column['Type']);
                if ($type != null) {
                }
            }
        }
    }

    /**
     * @param $col_name
     * @param $col_type
     * @return string
     */
    private function getType($col_name, $col_type) {
        $type = null;
        if (strpos($col_name , 'text_') === 0) {
            if (preg_match_all('/text/i', $col_type)) {
                $type = 'textarea';
            } else if (strpos(strtolower($col_type), 'varchar') !== false) {
                $type = 'text';
            }
        } else if (strpos($col_name , 'checkbox_') === 0) {
            if (preg_match_all('/int/i', $col_type)) {
                $type = 'checkbox';
            } else if (strpos(strtolower($col_type), 'enum') !== false) {
                $type = 'multicheckbox';
            }

        }
        return $type;
    }
}