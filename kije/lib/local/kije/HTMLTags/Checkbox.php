<?php


namespace kije\HTMLTags;


class Checkbox extends InputField
{

    /**
     * @param array $name
     * @param       $value
     * @param       $required
     * @param array $attributes
     */
    public function __construct($name, $value = '1', $required = false, $attributes = array())
    {
        $attrs = array(
            'name' => $name,
            'type'  => 'checkbox',
            'value' => $value
        );

        if ($required) {
            $attrs['required'] = 'required';
        }
        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
    }
}