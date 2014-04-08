<?php

namespace kije\HTMLTags;



/**
 * Class Option
 * @package kije\HTMLTags
 */
class Option extends Formfield
{
    protected $tagname = 'option';
    protected $selfclosing = false;
    protected $requiredAttributes = array();

    /**
     * @param string $caption
     * @param null  $value
     * @param bool   $selected
     * @param array $attributes
     */
    public function __construct($caption, $value = null, $selected = false, array $attributes = array())
    {
        $attrs = array();

        if ($value !== null) {
            $attrs['value'] = $value;
        }

        if ($selected) {
            $attrs['selected'] = 'selected';
        }

        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
        $this->innerHTML = $caption;
    }


    public function getAllowedAttributes()
    {
        return array_unique(
            array_merge(
                parent::getAllowedAttributes(),
                array(
                    'disabled',
                    'label',
                    'selected',
                    'value'
                )
            )
        );
    }

    /**
     * Sets the Text of the option
     * @param string $text
     */
    public function setText($text)
    {
        $this->setInnerHTML(strip_tags($text));
    }

    /**
     * @return string
     */
    public function getText()
    {
        return strip_tags($this->getInnerHTML());
    }
}
