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
     * @param array $caption
     * @param null  $value
     * @param array $attributes
     */
    public function __construct($caption, $value = null, array $attributes = array())
    {
        $attrs = array();

        if ($value != null) {
            $attrs['value'] = $value;
        }

        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);
        $this->innerHTML = $caption;
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
                    'disabled',
                    'label',
                    'selected',
                    'value'
                )
            )
        );
    }

    /**
     * @param $text
     */
    public function setText($text)
    {
        $this->setInnerHTML(strip_tags($text));
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return strip_tags($this->getInnerHTML());
    }
}
