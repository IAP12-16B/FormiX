<?php

namespace kije\Formgenerator\Tags;

require_once 'HTMLTag.php';

/**
 * Class Button
 * @package kije\Formgenerator\Tags
 */

/**
 * Class Button
 * @package kije\Formgenerator\Tags
 */
class Button extends HTMLTag
{

    protected $tagname = 'button';
    protected $selfclosing = false;
    protected $required_attributes = array();


    /**
     *
     */
    public function __construct()
    {

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
