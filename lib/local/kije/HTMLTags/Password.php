<?php
namespace kije\HTMLTags;


/**
 * Class Password
 * @package kije\HTMLTags
 */
class Password extends InputField implements Validateable
{
    protected $allowedCharacters;
    protected $minlength;
    protected $maxlength;

    /**
     * @param array  $name
     * @param bool   $required
     * @param string $placeholder
     * @param string $value
     * @param string $allowedCharacters
     * @param int    $minlength
     * @param null   $maxlength
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
            'placeholder' => $placeholder,

        );

        if ($required) {
            $attrs['required'] = 'required';
        }

        $this->maxlength = $maxlength;
        $this->minlength = $maxlength;
        $this->allowedCharacters = $allowedCharacters;

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
            if (strlen($value) < $this->minlength) {
                return 'Too short! Requires min. '.$this->minlength.' characters!';
            } elseif (strlen($value) > $this->maxlength) {
                return 'Too long! May only contain up to '.$this->maxlength.' characters!';
            } else {
                return 'Format does not match!';
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function getRegexPattern()
    {
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

        return $pattern;
    }
}
