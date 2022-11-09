<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Data\ResponseData;

class ResponseDataTest extends TestCase
{

	public function testToArray()
	{
		$data = new ResponseData(true, 1);

		$this->assertIsArray($data->toArray());
	}
	
	public function testStructure()
	{
		$result = true;
		$id = 2;
		$array = (new ResponseData($result, $id))->toArray();
		
		$this->assertArrayHasKey('jsonrpc', $array);
		$this->assertEquals('2.0', $array['jsonrpc']);
		
		$this->assertArrayHasKey('id', $array);
		$this->assertEquals($id, $array['id']);
	
		
		$this->assertArrayHasKey('result', $array);
		$this->assertEquals($result, $array['result']);
	}
	
}
