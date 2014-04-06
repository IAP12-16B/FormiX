<?php


namespace kije\HTMLTags;


class Time extends InputField implements Validateable
{
    /**
     * @param string $name
     * @param bool   $required
     * @param string $placeholder
     * @param string $value
     * @param array  $attributes
     */
    public function __construct(
        $name,
        $required = false,
        $placeholder = '',
        $value = '',
        array $attributes = array()
    ) {
        $attrs = array(
            'name'        => $name,
            'type'        => 'time',
            'value'       => $value,
            'placeholder' => $placeholder
        );

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
        if (!preg_match_all($this->getRegexPattern(), $value)) {
            return 'Wrong format!';
        }

        return true;
    }

    /**
     * @return string
     */
    public function getRegexPattern()
    {
        return '/(0?[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}/';
    }
}