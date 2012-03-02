<?php

/**
 * @group Controller
 */

class CoreTest extends CIUnit_TestCase
{
	public function setUp()
	{
		// Set the tested controller
		$this->CI = set_controller('core');
	}
	
	public function testPing()
	{
		// Call the controllers method
		$this->CI->ping();
	}
}
