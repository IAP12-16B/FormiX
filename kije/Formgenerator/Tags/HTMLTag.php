<?php


/** Idea: create class Attribute, which is simply a class with a key and value, and it can validate itself  */

namespace kije\Formgenerator\Tags;

require_once '../inc/globals.inc.php';

class HTMLTagException extends \Exception
{
}

abstract class HTMLTag
{
	protected $_tagname;
	protected $_selfclosing;
	protected $_required_attributes = array();

	protected $_attrs = array();
	protected $_innerHTML = '';

	/**
	 * @param $attrs
	 *
	 * @internal param $text
	 * @internal param $value
	 */
	public function __construct(array $attrs = array()) {
		$this->setAttributes($attrs);
	}

	/**
	 * @param $attrs
	 */
	public function setAttributes(array $attrs) {
		foreach ($attrs as $key => $value) {
			$this->setAttribute($key, $value);
		}
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @throws HTMLTagException
	 */
	public function setAttribute($key, $value) {
		if ($this->isAttributeAllowed($key)) {
			if ($this->isValueValidForAttribute($key, $value)) {
				$this->_attrs[$key] = $value;
			} else {
				throw new HTMLTagException(
					'Value ' . $value . ' for attribute ' . $key . ' is not allowed in this tag.'
				);
			}
		} else {
			throw new HTMLTagException('Attribute ' . $key . ' not allowed in this tag.');
		}
	}

	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function isAttributeAllowed($key) {
		return in_array($key, $this->getAllowedAttributes());
	}

	public function getAllowedAttributes() {
		return array(
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
			'title'
		);
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return bool
	 */
	public function isValueValidForAttribute($key, $value) {
		// here useless, but child classes can implement their own validation
		return $this->isAttributeAllowed($key);
	}

	/**
	 * @return array
	 */
	public function getRequiredAttributes() {
		return $this->_required_attributes;
	}

	/**
	 * @return mixed
	 */
	public function getInnerHTML() {
		return $this->_innerHTML;
	}

	protected function setInnerHTML($html) {
		$this->_innerHTML = $html;
	}

	/**
	 * @return boolean
	 */
	public function isSelfclosing() {
		return $this->_selfclosing;
	}

	/**
	 * @return string
	 */
	public function getTagname() {
		return $this->_tagname;
	}

	/**
	 * @return array
	 */
	public function getAttributes() {
		return $this->_attrs;
	}

	public function setDataAttribute($key, $value) {
		if (strpos($key, 'data-') === 0) {
			$this->_attrs[$key] = $value;
		} else {
			throw new HTMLTagException('Data-Attribute (' . $key . ') must start with "data-".');
		}
	}

	/**
	 * @throws HTMLTagException
	 * @return string
	 */
	public function toHTML() {
		// check if all required attributes are set
		// FIXME: the following won't work.... it will also throw an error, when more attributes are set than the require ones
		if (count(($diffs = array_diff($this->_required_attributes, array_keys($this->_attrs)))) !== 0) {
			throw new HTMLTagException('Required attributes [' . implode(', ', $diffs) . '] not set!');
		}

		$html = '<' . $this->_tagname;

		foreach ($this->_attrs as $attr => $value) {
			$html .= sprintf(' %s="%s"', $attr, $value);
		}

		if ($this->_selfclosing) {
			$html .= '/>';
		} else {
			$html .= sprintf('>%s</%s>', $this->_innerHTML, $this->_tagname);
		}

		return $html;
	}


} 