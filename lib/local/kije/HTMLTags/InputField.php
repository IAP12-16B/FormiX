<?php

namespace kije\HTMLTags;


/**
 * Base class for all <input ... /> Tags
 * @package kije\HTMLTags
 */
class InputField extends Formfield
{
    protected $tagname = 'input';
    protected $selfclosing = true;
    protected $requiredAttributes = array('name', 'type');

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

    public function isValueValidForAttribute($attribute, $value)
    {
        $res = parent::isValueValidForAttribute($attribute, $value);
        switch ($attribute) {
            case 'type':
                $res = $res && in_array($value, $this->getAllowedTypes());
                break;
        }

        return $res;
    }

    /**
     * Get all allowed types
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
