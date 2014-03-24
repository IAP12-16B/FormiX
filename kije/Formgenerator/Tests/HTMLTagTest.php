<?php
namespace kije\Formgenerator\Tests;

require_once realpath(__DIR__.'/../Tags/HTMLTag.php');

use kije\Formgenerator\Tags\HTMLTag;
use PHPUnit_Framework_TestCase;

/**
 * Class TestTag
 * @package kije\Formgenerator\Tests
 */
class TestTag extends HTMLTag
{
}

/**
 * Class HTMLTagTest
 * @package kije\Formgenerator\Tests
 */
class HTMLTagTest extends PHPUnit_Framework_TestCase
{
    private $instance;

    public function setUp()
    {
        $this->instance = new TestTag();
    }

    public function testGetRequiredAttributes()
    {
        $this->fail('Not yet implemented');
    }
}
