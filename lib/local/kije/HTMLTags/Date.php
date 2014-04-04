<?php


namespace kije\HTMLTags;


class Date extends InputField
{
    /**
     * @param string      $name
     * @param null|string $min
     * @param null|string $max
     * @param bool        $required
     * @param string      $placeholder
     * @param string      $value
     * @param array       $attributes
     *
     */
    public function __construct(
        $name,
        $min = null,
        $max = null,
        $required = false,
        $placeholder = '',
        $value = '',
        array $attributes = array()
    ) {
        $attrs = array(
            'name'        => $name,
            'type'        => 'date',
            'value'       => $value,
            'placeholder' => $placeholder
        );

        if ($min != null) {
            $attrs['min'] = $min;
        }

        if ($max != null) {
            $attrs['max'] = $max;
        }

        if ($required) {
            $attrs['required'] = 'required';
        }
        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
    }
} 