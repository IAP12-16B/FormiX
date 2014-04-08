<?php


namespace kije\HTMLTags;

/**
 * Class Checkbox
 * @package kije\HTMLTags
 */
class Checkbox extends InputField
{

    /**
     * @param string $name
     * @param string $value
     * @param bool   $required
     * @param bool   $checked
     * @param array  $attributes
     */
    public function __construct($name, $value = '1', $required = false, $checked = false, $attributes = array())
    {
        $attrs = array(
            'name'  => $name,
            'type'  => 'checkbox',
            'value' => $value
        );

        if ($required) {
            $attrs['required'] = 'required';
        }

        if ($checked) {
            $attrs['checked'] = 'checked';
        }

        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
    }
}
