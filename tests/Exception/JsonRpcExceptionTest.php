<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Data\ErrorData;

class JsonRpcExceptionTest extends TestCase
{

	public function testCreate()
	{
		$message = 'message';
		$code = 123;
		$data = ['param1', 'param2'];
		$exception = new \Zixsihub\JsonRpc\Exception\JsonRpcException($message, $code, $data);
		
		$this->assertEquals($message, $exception->getMessage());
		$this->assertEquals($code, $exception->getCode());
		$this->assertEquals($data, $exception->getData());
	}
	
}
