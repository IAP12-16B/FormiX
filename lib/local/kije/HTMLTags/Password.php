<?php
namespace kije\HTMLTags;


/**
 * Class Password
 * @package kije\HTMLTags
 */
class Password extends InputField
{
    /**
     * @var string $allowedCharacters a Regex-Pattern matching the allowed characters. Example: [a-Z0-9]
     */
    protected $allowedCharacters;

    /**
     * @var int $minlength the minimum length of the password
     */
    protected $minlength;

    /**
     * @var int $maxlength the maximum length of the password
     */
    protected $maxlength;

    /**
     * @param array  $name
     * @param bool   $required
     * @param string $placeholder
     * @param string $value
     * @param string $allowedCharacters
     * @param int    $minlength
     * @param int    $maxlength
     * @param array  $attributes
     */
    public function __construct(
        $name,
        $required = false,
        $placeholder = '',
        $value = '',
        $allowedCharacters = '.',
        $minlength = 0,
        $maxlength = null,
        array $attributes = array()
    ) {
        $attrs = array(
            'name'        => $name,
            'type'        => 'password',
            'value'       => $value,
            'placeholder' => $placeholder
        );

        if ($required) {
            $attrs['required'] = 'required';
        }

        $this->minlength = $minlength;
        $this->maxlength = $maxlength;
        $this->allowedCharacters = $allowedCharacters;

        $pattern = '('.$this->allowedCharacters.')';
        if ($this->minlength && $this->maxlength) {
            $pattern .= '{'.$this->minlength.','.$this->maxlength.'}';
        } elseif ($this->maxlength) {
            $pattern .= '{,'.$this->maxlength.'}';
        } elseif ($this->minlength) {
            $pattern .= '{'.$this->minlength.',}';
        } else {
            $pattern = '*';
        }

        $attrs['pattern'] = $pattern;

        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
    }
}
