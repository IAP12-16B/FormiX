<?php


namespace kije\HTMLTags;


class Number extends InputField
{
    /**
     * @param string     $name
     * @param int|string $step
     * @param bool       $required
     * @param string     $placeholder
     * @param string     $value
     * @param null|int   $min
     * @param null|int   $max
     * @param array      $attributes
     */
    public function __construct(
        $name,
        $step = 1,
        $required = false,
        $placeholder = '',
        $value = '',
        $min = null,
        $max = null,
        array $attributes = array()
    ) {
        $attrs = array(
            'name'        => $name,
            'type'        => 'number',
            'value'       => $value,
            'placeholder' => $placeholder,
            'step'        => $step
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
