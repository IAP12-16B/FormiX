<?php


namespace kije\FormiX;


use kije\HTMLTags\Formfield;

/**
 * View for FormiX Formgenerator
 * @package kije\FormiX
 */
class View
{
    /**
     * @var Formfield[] $formfields Forfields
     */
    public $formfields;

    /**
     * @var String $template Path to template
     */
    protected $template;

    /**
     * @var bool $showForm If the form should be shown
     */
    protected $showForm = true;

    /**
     * @var String $formAction Value for the action-Attribute for the form-Tag
     */
    protected $formAction;

    /**
     * @var String $formMethod Value for the method-Attribute for the form-Tag
     */
    protected $formMethod;

    /**
     * @param String      $template
     * @param Formfield[] $formfields
     * @param string      $formAction
     * @param string      $formMethod
     */
    public function __construct($template, $formfields = array(), $formAction = '', $formMethod = 'post')
    {
        $this->template = $template;
        $this->formfields = $formfields;
        $this->formAction = $formAction;
        $this->formMethod = $formMethod;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Returns the rendered HTML of the Template
     * @return string HTML
     */
    public function render()
    {
        ob_start();
        include $this->template;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

} 