<?php
/**
 * Created by PhpStorm.
 * User: kije
 * Date: 3/19/14
 * Time: 9:19 PM
 */

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';

class Option extends HTMLTag
{
	protected $_tagname = 'option';
	protected $_selfclosing = false;
	protected $_required_attributes = array();

	/**
	 * @param $attrs
	 * @param $text
	 *
	 * @internal param $value
	 */
	public function __construct(array $attrs = array(), $text = '') {
		$this->setAttributes($attrs);
		$this->_innerHTML = $text;
	}

	public function getAllowedAttributes() {
		return array_unique(
			array_merge(
				parent::getAllowedAttributes(),
				array(
					'disabled',
					'label',
					'selected',
					'value'
				)
			)
		);
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