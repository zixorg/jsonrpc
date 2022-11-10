<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Data\ErrorData;

class ErrorDataTest extends TestCase
{

	public function testToArray()
	{
		$data = new ErrorData(1, 'message', null, 2);

		$this->assertIsArray($data->toArray());
	}
	
	public function testSetData()
	{
		$array = (new ErrorData(1, 'message', 'data', 2))->toArray();

		$this->assertArrayHasKey('data', $array['error']);
		$this->assertEquals('data', $array['error']['data']);
	}
	
	public function testStructure()
	{
		$code = 1;
		$message = 'message';
		$id = 2;
		$array = (new ErrorData($code, $message, null, $id))->toArray();
		
		$this->assertArrayHasKey('jsonrpc', $array);
		$this->assertEquals('2.0', $array['jsonrpc']);
		
		$this->assertArrayHasKey('id', $array);
		$this->assertEquals($id, $array['id']);
		
		$this->assertArrayHasKey('error', $array);
		$this->assertIsArray($array['error']);
		
		$this->assertArrayHasKey('code', $array['error']);
		$this->assertEquals($code, $array['error']['code']);
		
		$this->assertArrayHasKey('message', $array['error']);
		$this->assertEquals($message, $array['error']['message']);
	}
	
}
