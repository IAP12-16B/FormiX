<?php


namespace kije\HTMLTags;


class Time extends InputField
{
    /**
     * @param string $name
     * @param bool   $required
     * @param string $value
     * @param array  $attributes
     */
    public function __construct(
        $name,
        $required = false,
        $value = '',
        array $attributes = array()
    ) {
        $attrs = array(
            'name'        => $name,
            'type'        => 'time',
            'value'       => $value
        );

        if ($required) {
            $attrs['required'] = 'required';
        }
        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
    }
}