<?php
/**
 * Created by PhpStorm.
 * User: kije
 * Date: 3/19/14
 * Time: 9:45 PM
 */

namespace kije\Formulargenerator\Tags;
require_once 'HTMLTag.php';

class Form extends HTMLTag {
    protected $_tagname = 'form';
    protected $_selfclosing = false;
    protected $_required_attributes = array();
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
        'accept',
        'accept-charset',
        'action',
        'autocomplete',
        'enctype',
        'method',
        'name',
        'novalidate',
        'target'
    );

    private $_elements = array();

    /**
     * @param $attrs
     * @param array $elements
     */
    public function __construct(array $attrs = array(), array $elements = array()) {
        $this->setAttributes($attrs);
        $this->addElements($elements);
    }

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * @param \kije\Formulargenerator\Tags\HTMLTag $element
     * @param int|string $key
     */
    public function addElement(HTMLTag $element, $key = null) {
        if ($key != null) {
            $this->_elements[$key] = $element;
        } else {
            $this->_elements[] = $element;
        }
    }

    /**
     * @param array $elements
     */
    public function addElements(array $elements) {
        foreach($elements as $element) {
            $this->addElement($element);
        }
    }

    /**
     * @param $key
     */
    public function removeOption($key) {
        unset($this->_elements[$key]);
    }

    /**
     *
     */
    protected function updateInnerHTML() {
        $this->_innerHTML = '';

        foreach($this->getElements() as $key => $element) {
            $this->_innerHTML .= $element->toHTML();
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