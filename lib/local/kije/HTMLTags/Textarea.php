<?php

namespace kije\HTMLTags;


/**
 * Class Textarea
 * @package kije\HTMLTags
 */
class Textarea extends Formfield implements Validateable
{
    protected $tagname = 'textarea';
    protected $selfclosing = false;
    protected $requiredAttributes = array('name');

    /**
     * @param array  $name
     * @param        $required
     * @param string $placeholder
     * @param string $value
     * @param null   $maxlength
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
            'placeholder' => $placeholder,
            'maxlength'   => $maxlength
        );

        if ($required) {
            $attrs['required'] = 'required';
        }
        $attrs = array_merge($attributes, $attrs);
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

    /**
     * @param mixed $value
     *
     * @return bool|string
     */
    public function validateValue($value)
    {
        if (!preg_match_all($this->getRegexPattern(), $value)) {
            return sprintf('Text too long (may only be up to %d characters)!', $this->get('maxlength'));
        }

        return true;
    }

    /**
     * @return string
     */
    public function getRegexPattern()
    {
        $pattern = '/.';
        if ($this->get('maxlength')) {
            $pattern .= '{,'.$this->get('maxlength').'}';
        } else {
            $pattern .= '*';
        }

        $pattern .= '/';

        return $pattern;
    }
}
