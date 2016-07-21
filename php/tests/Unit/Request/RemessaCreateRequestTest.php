<?php

use BoletoSinc\Request\RemessaCreateRequest;

class RemessaCreateRequestTest extends \PHPUnit_Framework_TestCase
{
	public function testInstanceOk()
	{
		$request = new RemessaCreateRequest('TOKEN');
		$this->assertInstanceOf('BoletoSinc\Request\RemessaCreateRequest', $request);
	}
}