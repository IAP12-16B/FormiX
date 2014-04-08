<?php

namespace kije\HTMLTags;


/**
 * Class Select
 * @package kije\HTMLTags
 */
class Select extends Formfield
{
    protected $tagname = 'select';
    protected $selfclosing = false;
    protected $requiredAttributes = array('name');

    /**
     * @var Option[]
     */
    private $options = array();

    /**
     * @param string $name
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
    {
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
     * @param Option[] $options
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
}
