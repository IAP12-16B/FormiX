<?php


namespace kije\HTMLTags;


use kije\Formgenerator\Formfield;

class Fieldset extends HTMLTag
{
    protected $tagname = 'fieldset';
    protected $selfclosing = false;
    protected $requiredAttributes = array();

    /**
     * @inc Formfield[] $fields
     */
    protected $fields = array();


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
                    'form',
                    'name'
                )
            )
        );
    }

    /**
     * @param \kije\Formgenerator\Formfield $field
     * @param int|string                    $key
     *
     */
    public function addField(Formfield $field, $key = null)
    {
        if ($key != null) {
            $this->fields[$key] = $field;
        } else {
            $this->fields[] = $field;
        }
    }

    /**
     * @return string
     */
    public function toHTML()
    {
        $this->updateInnerHTML(); // TODO: put this in HTMLTag so you dont have to include this in every child class

        return parent::toHTML();
    }

    /**
     *
     */
    protected function updateInnerHTML()
    {
        $this->innerHTML = '';

        foreach ($this->getFields() as $field) {
            $this->innerHTML .= sprintf('<label>%s %s</label>', $field->getTag()->toHTML(), $field->getCaption());
        }
    }

    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $key
     */
    public function removeOption($key)
    {
        unset($this->fields[$key]);
    }
}
