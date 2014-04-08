<?php

namespace kije\HTMLTags;

use kije\HTMLTags\Exceptions\HTMLTagException;

/**
 * Abstract HTMLTag Class. Base Class for every Html tag
 * @package kije\Tags
 */
abstract class HTMLTag
{
    /**
     * @var string $tagname The Tag's name
     */
    protected $tagname;

    /**
     * @var bool $selfclosing If the tag is selfclosing (eg. <input ... />)
     */
    protected $selfclosing;

    /**
     * @var array $requiredAttributes Attributes, which must be set, before Tag can be rendered to HTML
     */
    protected $requiredAttributes = array();

    /**
     * @var array   Attributes of the Tag
     */
    protected $attrs = array();

    /**
     * @var string  The innerHTML of the Tag. Only used when $selfclosing is set to false
     */
    protected $innerHTML = '';

    /**
     * @param $attrs
     */
    public function __construct(array $attrs = array())
    {
        $this->setAttributes($attrs);
    }

    /**
     * Set multiple attributes
     * @see setAttribute
     *
     * @param array $attrs Array of attributes
     */
    public function setAttributes(array $attrs)
    {
        foreach ($attrs as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * Set an attribute
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @throws HTMLTagException
     */
    public function setAttribute($attribute, $value)
    {
        if ($this->isAttributeAllowed($attribute)) {
            if ($this->isValueValidForAttribute($attribute, $value)) {
                $this->attrs[$attribute] = $value;
            } else {
                throw new HTMLTagException(
                    'Value ' . $value . ' for attribute ' . $attribute . ' is not allowed in this tag.'
                );
            }
        } else {
            throw new HTMLTagException('Attribute ' . $attribute . ' not allowed in this tag.');
        }
    }

    /**
     * Checks whether a attribute is allowed on this Tag
     *
     * @param string $attribute
     *
     * @return bool
     */
    public function isAttributeAllowed($attribute)
    {
        return in_array($attribute, $this->getAllowedAttributes());
    }

    /**
     * Returns an array of allowed attributes on this Tag
     * @return array
     */
    public function getAllowedAttributes()
    {
        return array(
            // global attributes
            'accesskey',
            'class',
            'contenteditable',
            'contextmenu',
            'dir',
            'draggable',
            'dropzone',
            'hidden',
            'id',
            'itemid',
            'itemprop',
            'itemref',
            'itemscope',
            'itemtype',
            'lang',
            'spellcheck',
            'style',
            'tabindex',
            'title'
        );
    }

    /**
     * Value check for attributes
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function isValueValidForAttribute($attribute, $value)
    {
        // here useless, but child classes can implement their own validation
        return $this->isAttributeAllowed($attribute);
    }

    /**
     * Get attribute
     *
     * @param string $attr
     *
     * @return mixed
     */
    public function get($attr)
    {
        $val = null;
        if (array_key_exists($attr, $this->attrs)) {
            $val = $this->attrs[$attr];
        }
        return $val;
    }

    /**
     * Shorthand for setAttribute
     *
     * @param $attribute
     * @param $value
     */
    public function set($attribute, $value)
    {
        $this->setAttribute($attribute, $value);
    }

    /**
     * Get all required attributes for this Tag
     * @return array
     */
    public function getRequiredAttributes()
    {
        return $this->requiredAttributes;
    }

    /**
     * @return boolean
     */
    public function isSelfclosing()
    {
        return $this->selfclosing;
    }

    /**
     * @return string
     */
    public function getTagname()
    {
        return $this->tagname;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attrs;
    }

    /**
     * Methode to add a data-Attribute to the Tag, because setting them via setAttribute will throw an exception
     *
     * @param string $key The name (data- will automatically prepended)
     * @param mixed  $value
     *
     */
    public function setDataAttribute($key, $value)
    {
        $this->attrs['data-' . $key] = $value;
    }

    /**
     * Gets the rendered HTML of the Tag
     * @throws HTMLTagException
     * @return string
     */
    public function toHTML()
    {
        // check if all required attributes are set
        if (count(($diffs = array_diff($this->requiredAttributes, array_keys($this->attrs)))) !== 0) {
            throw new HTMLTagException('Required attributes [' . implode(', ', $diffs) . '] not set!');
        }

        // opening Tag
        $html = '<' . $this->tagname;

        // add all set attributes
        foreach ($this->attrs as $attr => $value) {
            if (!empty($value)) {
                $html .= sprintf(' %s="%s"', $attr, $value);
            }
        }

        // close tag
        if ($this->selfclosing) {
            $html .= '/>';
        } else {
            $html .= sprintf('>%s</%s>', $this->getInnerHTML(), $this->tagname);
        }

        return $html;
    }

    /**
     * Gets the innerHTML of the Tag
     * @return string
     */
    public function getInnerHTML()
    {
        // Update innerHTML first
        $this->updateInnerHTML();
        return $this->innerHTML;
    }

    /**
     * Sets the innerHTML
     *
     * @param $html
     */
    protected function setInnerHTML($html)
    {
        $this->innerHTML = $html;
    }

    protected function updateInnerHTML()
    {
    }
}
