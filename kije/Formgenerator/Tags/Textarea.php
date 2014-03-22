<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';


class Textarea extends HTMLTag
{
	protected $_tagname = 'textarea';
	protected $_selfclosing = false;
	protected $_required_attributes = array('name');

	/**
	 * @param $attrs
	 * @param $value
	 */
	public function __construct(array $attrs = array(), $value = '') {
		$this->setAttributes($attrs);
		$this->_innerHTML = $value;
	}

	public function getAllowedAttributes() {
		return array_unique(
			array_merge(
				parent::getAllowedAttributes(),
				array(
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
				)
			)
		);
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