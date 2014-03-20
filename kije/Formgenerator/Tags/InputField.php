<?php
/**
 * Created by PhpStorm.
 * User: kije
 * Date: 3/19/14
 * Time: 8:03 PM
 */

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';


class InputField extends HTMLTag
{
	protected $_tagname = 'input';
	protected $_selfclosing = true;
	protected $_required_attributes = array('name', 'type');
	protected $_allowed_attributes = array(
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
	);

	protected $_allowed_types = array(
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


	/**
	 * @return array
	 */
	public function getAllowedTypes() {
		return $this->_allowed_types;
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
				$res = $res && in_array($value, $this->_allowed_types);
				break;

			// TODO: implement other checks -> https://developer.mozilla.org/en-US/docs/Web/HTML/Element/Input
		}

		return $res;
	}
} 