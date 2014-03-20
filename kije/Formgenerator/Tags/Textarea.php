<?php
/**
 * Created by PhpStorm.
 * User: kije
 * Date: 3/19/14
 * Time: 9:06 PM
 */

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';


class Textarea extends HTMLTag
{
	protected $_tagname = 'textarea';
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
		'cols',
		'disabled',
		'form',
		'maxlength',
		'name',
		'placeholder',
		'readonly',
		'required',
		'rows',
		'selectionDirection',
		'selectionEnd',
		'selectionStart',
		'spellcheck',
		'wrap'
	);

	/**
	 * @param $attrs
	 * @param $value
	 */
	public function __construct(array $attrs = array(), $value = '') {
		$this->setAttributes($attrs);
		$this->_innerHTML = $value;
	}

	/**
	 * @param $value
	 */
	public function setValue($value) {
		$this->setInnerHTML($value);
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->getInnerHTML();
	}
} 