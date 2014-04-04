<?php

namespace kije\FormiX;


/**
 * Class FormiX
 * @package kije\FormiX
 */
class FormiX
{
    protected $tableName;
    private $structure;


    public function __construct($table)
    {
        $this->tableName = $table;
    }

    public function getFormfields()
    {

    }

    protected function column2formfield($column)
    {

    }

    private function updateStructure()
    {

    }
}
