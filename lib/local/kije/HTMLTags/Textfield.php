<?php
namespace kije\HTMLTags;

/**
 * Class Textfield
 * @package kije\HTMLTags
 */
class Textfield extends InputField
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
}
