<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';


class InputField extends HTMLTag
{
	protected $_tagname = 'input';
	protected $_selfclosing = true;
	protected $_required_attributes = array('name', 'type');


	public function getAllowedAttributes() {
		return array_unique(
			array_merge(
				parent::getAllowedAttributes(),
				array(
					'type',
					'accept',
					'autocomplete',
					'autofocus',
					'autosave',
					'checked',
					'disabled',
					'form',
					'formaction',
					'formenctype',
					'formmethod',
					'formnovalidate',
					'height',
					'inputmode',
					'list',
					'max',
					'maxlength',
					'min',
					'multiple',
					'name',
					'pattern',
					'placeholder',
					'readonly',
					'required',
					'selectionDirection',
					'size',
					'spellcheck',
					'src',
					'step',
					'value',
					'width'
				)
			)
		);
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return bool
	 */
	public function isValueValidForAttribute($key, $value) {
		$res = parent::isValueValidForAttribute($key, $value);
		switch ($key) {
			case 'type':
				$res = $res && in_array($value, $this->getAllowedTypes());
				break;

			// TODO: implement other checks -> https://developer.mozilla.org/en-US/docs/Web/HTML/Element/Input
		}

		return $res;
	}

	public function getAllowedTypes() {
		return array(
			'button',
			'checkbox',
			'color',
			'date',
			'datetime',
			'datetime-local',
			'email',
			'file',
			'hidden',
			'image',
			'month',
			'number',
			'password',
			'radio',
			'range',
			'reset',
			'search',
			'submit',
			'tel',
			'text',
			'time',
			'url',
			'week'
		);
	}
} 