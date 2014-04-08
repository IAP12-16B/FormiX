<?php


namespace kije\HTMLTags;

/**
 * Class Formfield
 * @package kije\HTMLTags
 */
class Formfield extends HTMLTag
{
    protected $caption;

    /**
     * @return String
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param String $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
        if ($this->isAttributeAllowed('title')) {
            $this->set('title', $this->caption);
        }
    }
}
