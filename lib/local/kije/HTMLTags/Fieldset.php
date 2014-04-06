<?php


namespace kije\HTMLTags;


class Fieldset extends Formfield implements Validateable
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
     * @param Formfield  $field
     * @param int|string $key
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
     * @param $key
     */
    public function removeField($key)
    {
        unset($this->fields[$key]);
    }

    /**
     *
     */
    protected function updateInnerHTML()
    {
        $this->innerHTML = '';

        foreach ($this->getFields() as $field) {
            $this->innerHTML .= sprintf('<label>%s %s</label>', $field->toHTML(), $field->getCaption());
        }
    }

    /**
     * @return Formfield[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param mixed $value
     *
     * @return bool|string
     */
    public function validateValue($value)
    {
        foreach ($this->getFields() as $field) {
            if ($field->get('value') == $value) {
                return true;
            }
        }

        return 'Invalid value!';
    }

    /**
     * @return string
     */
    public function getRegexPattern()
    {
        return '.*';
    }
}
