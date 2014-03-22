<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';

class Select extends HTMLTag
{
	protected $_tagname = 'select';
	protected $_selfclosing = false;
	protected $_required_attributes = array('name');

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
	 * @param array $options
	 */
	public function addOptions(array $options) {
		foreach ($options as $option) {
			$this->addOption($option);
		}
	}

	/**
	 * @param Option     $option
	 * @param int|string $key
	 */
	public function addOption(Option $option, $key = NULL) {
		if ($key != NULL) {
			$this->_options[$key] = $option;
		} else {
			$this->_options[] = $option;
		}
	}

	public function getAllowedAttributes() {
		return array_unique(
			array_merge(
				parent::getAllowedAttributes(),
				array(
					'autofocus',
					'disabled',
					'form',
					'multiple',
					'name',
					'required',
					'size'
				)
			)
		);
	}

	/**
	 * @param $key
	 */
	public function removeOption($key) {
		unset($this->_options[$key]);
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

		foreach ($this->getOptions() as $key => $option) {
			$this->_innerHTML .= $option->toHTML();
		}
	}

	/**
	 * @return array
	 */
	public function getOptions() {
		return $this->_options;
	}
} 