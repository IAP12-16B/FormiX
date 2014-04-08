<?php

namespace kije\HTMLTags;


/**
 * Class Textarea
 * @package kije\HTMLTags
 */
class Textarea extends Formfield
{
    protected $tagname = 'textarea';
    protected $selfclosing = false;
    protected $requiredAttributes = array('name');

    /**
     * @param array  $name
     * @param bool   $required
     * @param string $placeholder
     * @param string $value
     * @param int $maxlength
     * @param array  $attributes
     */
    public function __construct(
        $name,
        $required = false,
        $placeholder = '',
        $value = '',
        $maxlength = null,
        array $attributes = array()
    ) {
        $attrs = array(
            'name'        => $name,
            'placeholder' => $placeholder
        );

        if ($required) {
            $attrs['required'] = 'required';
        }

        if ($maxlength) {
            $attrs['maxlength'] = $maxlength;
        }

        $attrs = array_merge($attributes, $attrs);
        $this->setAttributes($attrs);
        $this->innerHTML = $value;
    }

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
     * @param string $value
     */
    public function setValue($value)
    {
        $this->setInnerHTML($value);
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->getInnerHTML();
    }
}
