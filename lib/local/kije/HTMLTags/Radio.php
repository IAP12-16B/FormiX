<?php


namespace kije\HTMLTags;


class Radio extends InputField
{

    /**
     * @param string $name
     * @param       $value
     * @param bool  $required
     * @param bool  $checked
     * @param array $attributes
     */
    public function __construct($name, $value, $required = false, $checked = false, $attributes = array())
    {
        $attrs = array(
            'name' => $name,
            'type'  => 'radio',
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