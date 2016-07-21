<?php

use BoletoSinc\Service\RemessaPagamentoItauCnab240;

class RemessaPagamentoItauCnab240Test extends \PHPUnit_Framework_TestCase
{
	public function testInstanceOk()
	{
		$remessa = new RemessaPagamentoItauCnab240();
		$this->assertInstanceOf('BoletoSinc\Service\RemessaPagamentoItauCnab240', $remessa);
	}
}