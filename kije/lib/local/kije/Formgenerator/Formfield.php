<?php


namespace kije\Formgenerator;

use kije\HTMLTags\Button;
use kije\HTMLTags\Fieldset;
use kije\HTMLTags\HTMLTag;
use kije\HTMLTags\InputField;
use kije\HTMLTags\Select;
use kije\HTMLTags\Textarea;

/**
 * Wrapper class for for
 * Class Formfield
 * @package kije\Formgenerator
 */
class Formfield
{
    /**
     * The input field
     * @inc InputField|Select|Textarea|Button|Fieldset $htmltag
     */
    protected $htmltag;
    /**
     * The caption for the form field
     * @inc string $caption
     */
    protected $caption;

    /**
     * @param InputField|Select|Textarea|Button|Fieldset|HTMLTag $htmltag
     * @param                                                    $caption
     */
    public function __construct(HTMLTag $htmltag = null, $caption = null)
    {
        $this->htmltag = $htmltag;
        $this->caption = $caption;
    }

    /**
     * @param Button|InputField|Select|Textarea|Fieldset $htmltag
     */
    public function setTag($htmltag)
    {
        $this->htmltag = $htmltag;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return InputField|Select|Textarea|Button|Fieldset
     */
    public function getTag()
    {
        return $this->htmltag;
    }
}
