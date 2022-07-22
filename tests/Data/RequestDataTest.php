<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Data\RequestData;

class RequestDataTest extends TestCase
{

	public function testDataRaw()
	{
		$dataRaw = '{"name": "value"}';
		$data = new RequestData($dataRaw);
		$this->assertEquals($dataRaw, $data->getDataRaw());
	}
	
	public function testNullData()
	{
		$data = new RequestData(null);
		$this->assertNull($data->getData());
	}
	
	public function testBadData()
	{
		$data = new RequestData('string');
		$this->assertNull($data->getData());
	}
	
	public function testArrayData()
	{
		$arrayData = [
			'id' => 1,
			'method' => 'object.action',
			'params' => ['param1' => 'value1', 'param2' => 'value2']
		];
		$data = new RequestData($arrayData);
		
		$this->assertEquals($arrayData, $data->getData());
		$this->assertEquals($arrayData['id'], $data->getId());
		$this->assertFalse($data->isNotification());
		$this->assertEquals($arrayData['method'], $data->getMethod());
		$this->assertEquals('object', $data->getMethodObjectName());
		$this->assertEquals('action', $data->getMethodActionName());
		$this->assertEquals($arrayData['params'], $data->getParams());
	}
	
	public function testObjectData()
	{
		$object = new stdClass();
		$object->id = 1;
		$object->method = 'object.action';
		$object->params = ['param1' => 'value1', 'param2' => 'value2'];
		
		$data = new RequestData($object);
		
		$this->assertEquals((array) $object, $data->getData());
		$this->assertEquals($object->id, $data->getId());
		$this->assertFalse($data->isNotification());
		$this->assertEquals($object->method, $data->getMethod());
		$this->assertEquals('object', $data->getMethodObjectName());
		$this->assertEquals('action', $data->getMethodActionName());
		$this->assertEquals($object->params, $data->getParams());
	}
	
}
