<?php

namespace kije\HTMLTags;


/**
 * Class Select
 * @package kije\HTMLTags
 */
class Select extends Formfield implements Validateable
{
    protected $tagname = 'select';
    protected $selfclosing = false;
    protected $requiredAttributes = array('name');

    private $options = array();

    /**
     * @param array    $name
     * @param bool     $required
     * @param Option[] $options
     * @param array    $attributes
     *
     */
    public function __construct(
        $name,
        $required = false,
        array $options = array(),
        array $attributes = array()
    )
    {// TODO: selected
        $attrs = array(
            'name' => $name,
        );

        if ($required) {
            $attrs['required'] = 'required';
        }

        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
        $this->addOptions($options);
    }

    /**
     * @param array $options
     */
    public function addOptions(array $options)
    {
        foreach ($options as $option) {
            $this->addOption($option);
        }
    }

    /**
     * @param Option     $option
     * @param int|string $key
     */
    public function addOption(Option $option, $key = null)
    {
        if ($key != null) {
            $this->options[$key] = $option;
        } else {
            $this->options[] = $option;
        }
    }

    /**
     * @return array
     */
    public function getAllowedAttributes()
    {
        return array_unique(
            array_merge(
                parent::getAllowedAttributes(),
                array(
                    'autofocus',
                    'disabled',
                    'form',
                    'multiple',
                    'name',
                    'required',
                    'size'
                )
            )
        );
    }

    /**
     * @param $key
     */
    public function removeOption($key)
    {
        unset($this->options[$key]);
    }

    /**
     *
     */
    protected function updateInnerHTML()
    {
        $this->innerHTML = '';

        foreach ($this->getOptions() as $option) {
            $this->innerHTML .= $option->toHTML();
        }
    }

    /**
     * @return Option[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $value
     *
     * @return bool|string
     */
    public function validateValue($value)
    {
        foreach ($this->getOptions() as $option) {
            if ($option->get('value') == $value) {
                return true;
            }
        }

        return 'Invalid value!';
    }

    /**
     * @return string
     */
    public function getRegexPattern()
    {
        return '.*';
    }
}
