<?php
/** Idea: create class Attribute, which is simply a class with a key and value, and it can validate itself  */

namespace kije\Formgenerator\Tags;

require_once '../inc/globals.inc.php';

/**
 * Class HTMLTagException
 * @package kije\Formgenerator\Tags
 */
class HTMLTagException extends \Exception
{
}

/**
 * Class HTMLTag
 * @package kije\Formgenerator\Tags
 */
abstract class HTMLTag
{
    protected $tagname;
    protected $selfclosing;
    protected $required_attributes = array();

    protected $attrs = array();
    protected $innerHTML = '';

    /**
     * @param $attrs
     *
     * @internal param $text
     * @internal param $value
     */
    public function __construct(array $attrs = array())
    {
        $this->setAttributes($attrs);
    }

    /**
     * @param $attrs
     */
    public function setAttributes(array $attrs)
    {
        foreach ($attrs as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * @param $key
     * @param $value
     *
     * @throws HTMLTagException
     */
    public function setAttribute($key, $value)
    {
        if ($this->isAttributeAllowed($key)) {
            if ($this->isValueValidForAttribute($key, $value)) {
                $this->attrs[$key] = $value;
            } else {
                throw new HTMLTagException(
                    'Value ' . $value . ' for attribute ' . $key . ' is not allowed in this tag.'
                );
            }
        } else {
            throw new HTMLTagException('Attribute ' . $key . ' not allowed in this tag.');
        }
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function isAttributeAllowed($key)
    {
        return in_array($key, $this->getAllowedAttributes());
    }

    /**
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
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function isValueValidForAttribute($key, $value)
    {
        // here useless, but child classes can implement their own validation
        return $this->isAttributeAllowed($key);
    }

    /**
     * @return array
     */
    public function getRequiredAttributes()
    {
        return $this->required_attributes;
    }

    /**
     * @return mixed
     */
    public function getInnerHTML()
    {
        return $this->innerHTML;
    }

    /**
     * @param $html
     */
    protected function setInnerHTML($html)
    {
        $this->innerHTML = $html;
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
     * @param $key
     * @param $value
     *
     * @throws HTMLTagException
     */
    public function setDataAttribute($key, $value)
    {
        if (strpos($key, 'data-') === 0) {
            $this->attrs[$key] = $value;
        } else {
            throw new HTMLTagException('Data-Attribute (' . $key . ') must start with "data-".');
        }
    }

    /**
     * @throws HTMLTagException
     * @return string
     */
    public function toHTML()
    {
        // check if all required attributes are set
        if (count(($diffs = array_diff($this->required_attributes, array_keys($this->attrs)))) !== 0) {
            throw new HTMLTagException('Required attributes [' . implode(', ', $diffs) . '] not set!');
        }

        $html = '<' . $this->tagname;

        foreach ($this->attrs as $attr => $value) {
            $html .= sprintf(' %s="%s"', $attr, $value);
        }

        if ($this->selfclosing) {
            $html .= '/>';
        } else {
            $html .= sprintf('>%s</%s>', $this->innerHTML, $this->tagname);
        }

        return $html;
    }
}
