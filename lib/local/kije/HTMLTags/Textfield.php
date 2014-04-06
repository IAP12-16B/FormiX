<?php
namespace kije\HTMLTags;

/**
 * Class Textfield
 * @package kije\HTMLTags
 */
class Textfield extends InputField implements Validateable
{
    /**
     * @param array    $name
     * @param boolean  $required
     * @param string   $placeholder
     * @param string   $value
     * @param int|null $maxlength
     * @param array    $attributes
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
            'type'        => 'text',
            'value'       => $value,
            'placeholder' => $placeholder,
            'maxlength'   => $maxlength
        );

        if ($required) {
            $attrs['required'] = 'required';
        }
        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
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
