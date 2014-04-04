<?php

namespace kije\HTMLTags;

require_once 'HTMLTag.php';

/**
 * Class Form
 * @package kije\Tags
 */

/**
 * Class Form
 * @package kije\HTMLTags
 */
class Form extends HTMLTag
{
    protected $tagname = 'form';
    protected $selfclosing = false;
    protected $requiredAttributes = array();

    private $elements = array();

    /**
     * @param           $attrs
     * @param HTMLTag[] $elements
     */
    public function __construct(array $attrs = array(), array $elements = array())
    {
        $this->setAttributes($attrs);
        $this->addElements($elements);
    }

    /**
     * @param array $elements
     */
    public function addElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
    }

    /**
     * @param \kije\HTMLTags\HTMLTag $element
     * @param int|string                       $key
     */
    public function addElement(HTMLTag $element, $key = null)
    {
        if ($key != null) {
            $this->elements[$key] = $element;
        } else {
            $this->elements[] = $element;
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
                    'accept',
                    'accept-charset',
                    'action',
                    'autocomplete',
                    'enctype',
                    'method',
                    'name',
                    'novalidate',
                    'target'
                )
            )
        );
    }

    /**
     * @param $key
     */
    public function removeOption($key)
    {
        unset($this->elements[$key]);
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

        foreach ($this->getElements() as $element) {
            $this->innerHTML .= $element->toHTML();
        }
    }

    /**
     * @return HTMLTag[]
     */
    public function getElements()
    {
        return $this->elements;
    }
}
