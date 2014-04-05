<?php


namespace kije\HTMLTags;


class Datetime extends InputField implements Validateable
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
            'type'        => 'datetime',
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

    /**
     * @param mixed $value
     *
     * @return bool|string
     */
    public function validateValue($value)
    {
        // TODO: Implement validateValue() method.
    }

    /**
     * @return string
     */
    public function getRegexPattern()
    {
        return '/([0-2][0-9]{3})\-([0-1][0-9])\-([0-3][0-9])T([0-5][0-9])\:([0-5][0-9])\:([0-5][0-9])(Z|([\-\+]([0-1][0-9])\:00))/';
    }
}
