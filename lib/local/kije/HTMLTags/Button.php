<?php

namespace kije\HTMLTags;


/**
 * Class Button
 * @package kije\HTMLTags
 */
class Button extends Formfield
{
    protected $tagname = 'button';
    protected $selfclosing = false;
    protected $requiredAttributes = array();

    /**
     * @param null|string $name
     * @param string|null $value
     * @param string      $type
     * @param array       $attributes
     */
    public function __construct($text, $name = null, $value = null, $type = 'submit', array $attributes = array())
    {
        $attrs = array(
            'name'  => $name,
            'type'  => $type,
            'value' => $value,
        );

        $attrs = array_merge($attributes, $attrs);
        parent::__construct($attrs);

        $this->setText($text);
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
                    'formaction',
                    'formenctype',
                    'formmethod',
                    'formnovalidate',
                    'formtarget',
                    'name',
                    'type',
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
        $this->setInnerHTML($text);
    }
}
