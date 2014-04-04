<?php
namespace kije\HTMLTags;

/**
 * Class Textfield
 * @package kije\HTMLTags
 */
class Textfield extends InputField
{
    /**
     * @param array  $name
     * @param        $required
     * @param string $placeholder
     * @param string $value
     * @param        $maxlength
     * @param array  $attributes
     */
    public function __construct(
        $name,
        $required,
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
}
