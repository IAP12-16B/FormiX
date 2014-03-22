<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';

class Form extends HTMLTag
{
	protected $_tagname = 'form';
	protected $_selfclosing = false;
	protected $_required_attributes = array();

	private $_elements = array();

	/**
	 * @param       $attrs
	 * @param array $elements
	 */
	public function __construct(array $attrs = array(), array $elements = array()) {
		$this->setAttributes($attrs);
		$this->addElements($elements);
	}

	/**
	 * @param array $elements
	 */
	public function addElements(array $elements) {
		foreach ($elements as $element) {
			$this->addElement($element);
		}
	}

	/**
	 * @param \kije\Formgenerator\Tags\HTMLTag $element
	 * @param int|string                       $key
	 */
	public function addElement(HTMLTag $element, $key = NULL) {
		if ($key != NULL) {
			$this->_elements[$key] = $element;
		} else {
			$this->_elements[] = $element;
		}
	}

	public function getAllowedAttributes() {
		return array_unique(
			array_merge(
				parent::getAllowedAttributes(),
				array(
					'accept',
					'accept-charset',
					'action',
					'autocomplete',
					'enctype',
					'method',
					'name',
					'novalidate',
					'target'
				)
			)
		);
	}

	/**
	 * @param $key
	 */
	public function removeOption($key) {
		unset($this->_elements[$key]);
	}

	/**
	 * @return string
	 */
	public function toHTML() {
		$this->updateInnerHTML();

		return parent::toHTML();
	}

	/**
	 *
	 */
	protected function updateInnerHTML() {
		$this->_innerHTML = '';

		foreach ($this->getElements() as $key => $element) {
			/** @noinspection PhpUndefinedMethodInspection */
			$this->_innerHTML .= $element->toHTML();
		}
	}

	/**
	 * @return array
	 */
	public function getElements() {
		return $this->_elements;
	}


} 