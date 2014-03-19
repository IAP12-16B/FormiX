<?php
/**
 * Created by PhpStorm.
 * User: kije
 * Date: 3/19/14
 * Time: 9:28 PM
 */

namespace kije\Formgenerator\Tags;
require_once 'HTMLTag.php';

class Select extends HTMLTag {
    protected $_tagname = 'select';
    protected $_selfclosing = false;
    protected $_required_attributes = array('name');
    protected $_allowed_attributes = array(
        // global attributes
        'accesskey',
        'class',
        'contenteditable',
        'contextmenu',
        'dir',
        'draggable',
        'dropzone',
        'hidden',
        'id',
        'itemid',
        'itemprop',
        'itemref',
        'itemscope',
        'itemtype',
        'lang',
        'spellcheck',
        'style',
        'tabindex',
        'title',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'name',
        'required',
        'size'
    );

    private $_options = array();

    /**
     * @param array $attrs
     * @param array $options
     */
    public function __construct(array $attrs = array(), array $options = array()) {
        $this->setAttributes($attrs);
        $this->addOptions($options);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }


    /**
     * @param Option $option
     * @param int|string $key
     */
    public function addOption(Option $option, $key = null) {
        if ($key != null) {
            $this->_options[$key] = $option;
        } else {
            $this->_options[] = $option;
        }
    }

    /**
     * @param array $options
     */
    public function addOptions(array $options) {
        foreach($options as $option) {
            $this->addOption($option);
        }
    }

    /**
     * @param $key
     */
    public function removeOption($key) {
        unset($this->_options[$key]);
    }

    /**
     *
     */
    protected function updateInnerHTML() {
        $this->_innerHTML = '';

        foreach($this->getOptions() as $key => $option) {
            $this->_innerHTML .= $option->toHTML();
        }
    }

    /**
     * @return string
     */
    public function toHTML() {
        $this->updateInnerHTML();
        return parent::toHTML();
    }
} 