<?php
namespace kije\HTMLTags;


/**
 * Class Password
 * @package kije\HTMLTags
 */
class Password extends InputField
{
    /**
     * @param array  $name
     * @param        $required
     * @param string $placeholder
     * @param string $value
     * @param        $attributes
     */
    public function __construct($name, $required, $placeholder = '', $value = '', array $attributes = array())
    {
        $attrs = array(
            'name'        => $name,
            'type'        => 'password',
            'value'       => $value,
            'placeholder' => $placeholder,

        );

        if ($required) {
            $attrs['required'] = 'required';
        }
        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
    }
}
