<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';


/**
 * Class Select
 * @package kije\Formgenerator\Tags
 */
class Select extends HTMLTag
{
    protected $tagname = 'select';
    protected $selfclosing = false;
    protected $required_attributes = array('name');

    private $_options = array();

    /**
     * @param array $attrs
     * @param array $options
     */
    public function __construct(array $attrs = array(), array $options = array())
    {
        $this->setAttributes($attrs);
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
            $this->_options[$key] = $option;
        } else {
            $this->_options[] = $option;
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
        unset($this->_options[$key]);
    }

    /**
     * @return string
     */
    public function toHTML()
    {
        $this->updateInnerHTML();

        return parent::toHTML();
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
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }
}
