<?php
/**
 * Created by PhpStorm.
 * User: kije
 * Date: 3/19/14
 * Time: 9:19 PM
 */

namespace kije\Formulargenerator\Tags;
require_once 'HTMLTag.php';

class Option extends HTMLTag {
    protected $_tagname = 'option';
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
        'disabled',
        'label',
        'selected',
        'value'
    );

    /**
     * @param $attrs
     * @param $text
     * @internal param $value
     */
    public function __construct(array $attrs = array(), $text = '') {
        $this->setAttributes($attrs);
        $this->_innerHTML = $text;
    }

    /**
     * @param $text
     */
    public function setText($text) {
        $this->setInnerHTML(strip_tags($text));
    }

    /**
     * @return mixed
     */
    public function getText() {
        return strip_tags($this->getInnerHTML());
    }
} 