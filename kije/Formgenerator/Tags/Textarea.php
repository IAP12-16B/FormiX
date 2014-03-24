<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';


/**
 * Class Textarea
 * @package kije\Formgenerator\Tags
 */
class Textarea extends HTMLTag
{
    protected $tagname = 'textarea';
    protected $selfclosing = false;
    protected $required_attributes = array('name');

    /**
     * @param $attrs
     * @param $value
     */
    public function __construct(array $attrs = array(), $value = '')
    {
        $this->setAttributes($attrs);
        $this->innerHTML = $value;
    }

    /**
     * @return array
     */
    public function getAllowedAttributes()
    {
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
    public function setValue($value)
    {
        $this->setInnerHTML($value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->getInnerHTML();
    }
}
