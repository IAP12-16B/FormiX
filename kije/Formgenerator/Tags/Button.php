<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';

class Button extends HTMLTag
{

	protected $_tagname = 'button';
	protected $_selfclosing = false;
	protected $_required_attributes = array();


	public function __construct() {

	}

	public function getAllowedAttributes() {
		return array_unique(
			array_merge(
				parent::getAllowedAttributes(),
				array(
					'autofocus',
					'disabled',
					'form',
					'formaction',
					'formenctype',
					'formmethod',
					'formnovalidate',
					'formtarget',
					'name',
					'type',
					'value'
				)
			)
		);
	}

	/**
	 * @param $text
	 */
	public function setText($text) {
		$this->setInnerHTML($text);
	}

} 