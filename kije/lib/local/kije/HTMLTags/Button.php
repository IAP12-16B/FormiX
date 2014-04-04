<?php

namespace kije\HTMLTags;


/**
 * Class Button
 * @package kije\HTMLTags
 */
class Button extends HTMLTag
{

    protected $tagname = 'button';
    protected $selfclosing = false;
    protected $requiredAttributes = array();


    /**
     *
     *
     * public function __construct()
     * {
     * parent::__contruct();
     * }*/

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
