<?php

use BoletoSinc\Request\RequestException;

class RequestExceptionTest extends \PHPUnit_Framework_TestCase
{
	public function testInstanceOk()
	{
		$exception = new RequestException();
		$this->assertInstanceOf('BoletoSinc\Request\RequestException', $exception);
	}
}