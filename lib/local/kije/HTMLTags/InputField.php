<?php

namespace kije\HTMLTags;


/**
 * Class InputField
 * @package kije\HTMLTags
 */
class InputField extends Formfield
{
    protected $tagname = 'input';
    protected $selfclosing = true;
    protected $requiredAttributes = array('name', 'type');

    /**
     * @return array
     */
    public function getAllowedAttributes()
    {
        return array_unique(
            array_merge(
                parent::getAllowedAttributes(),
                array(
                    'type',
                    'accept',
                    'autocomplete',
                    'autofocus',
                    'autosave',
                    'checked',
                    'disabled',
                    'form',
                    'formaction',
                    'formenctype',
                    'formmethod',
                    'formnovalidate',
                    'height',
                    'inputmode',
                    'list',
                    'max',
                    'maxlength',
                    'min',
                    'multiple',
                    'name',
                    'pattern',
                    'placeholder',
                    'readonly',
                    'required',
                    'selectionDirection',
                    'size',
                    'spellcheck',
                    'src',
                    'step',
                    'value',
                    'width'
                )
            )
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
        $res = parent::isValueValidForAttribute($key, $value);
        switch ($key) {
            case 'type':
                $res = $res && in_array($value, $this->getAllowedTypes());
                break;

            // TODO: implement other checks -> https://developer.mozilla.org/en-US/docs/Web/HTML/Element/Input
        }

        return $res;
    }

    /**
     * @return array
     */
    public function getAllowedTypes()
    {
        return array(
            'button',
            'checkbox',
            'color',
            'date',
            'datetime',
            'datetime-local',
            'email',
            'file',
            'hidden',
            'image',
            'month',
            'number',
            'password',
            'radio',
            'range',
            'reset',
            'search',
            'submit',
            'tel',
            'text',
            'time',
            'url',
            'week'
        );
    }
}
