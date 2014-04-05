<?php


namespace kije\HTMLTags;


interface Validateable
{
    /**
     * @param mixed $value
     *
     * @return bool|string
     */
    public function validateValue($value);

    /**
     * @return string
     */
    public function getRegexPattern();
}