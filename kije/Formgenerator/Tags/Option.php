<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';

/**
 * Class Option
 * @package kije\Formgenerator\Tags
 */

/**
 * Class Option
 * @package kije\Formgenerator\Tags
 */
class Option extends HTMLTag
{
    protected $tagname = 'option';
    protected $selfclosing = false;
    protected $required_attributes = array();

    /**
     * @param $attrs
     * @param $text
     *
     * @internal param $value
     */
    public function __construct(array $attrs = array(), $text = '')
    {
        $this->setAttributes($attrs);
        $this->innerHTML = $text;
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
