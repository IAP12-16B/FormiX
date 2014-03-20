<?php
/**
 * Created by PhpStorm.
 * User: kije
 * Date: 3/20/14
 * Time: 9:27 PM
 */

namespace kije\Formgenerator\Tests;

require_once '../Tags/HTMLTag.php';

use kije\Formgenerator\Tags\HTMLTag;
use PHPUnit_Framework_TestCase;

class TestTag extends HTMLTag
{
}

class HTMLTagTest extends PHPUnit_Framework_TestCase
{
	private $_instance;

	public function setUp() {
		$this->_instance = new TestTag();
	}

	public function testGetRequiredAttributes() {
		$this->fail('Not yet implemented');
	}
}
 