<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Exception\JsonRpcException;
use Zixsihub\JsonRpc\Http\Request;
use Zixsihub\JsonRpc\Validator\Validator;

class ValidatorTest extends TestCase
{

	/** @var Validator */
	private $validator;
	
	protected function setUp()
	{
		$this->validator = new Validator();
	}
	
	public function testBadMethod()
	{
		try {
			$request = new Request();
			$request->withMethod('GET');		
			$this->validator->validateRequest($request);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testInvalidRequest()
	{
		try {
			$request = new Request();
			$request->withMethod('POST');	
			$request->withBody('');
			$this->validator->validateRequest($request);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testParseError()
	{
		try {
			$request = new Request();
			$request->withMethod('POST');	
			$request->withBody('not json');
			$this->validator->validateRequest($request);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32700, $ex->getCode());
		}
	}
	
	public function testNullRequestData()
	{
		try {
			$this->validator->validateRequestData(null);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32700, $ex->getCode());
		}
	}
	
	public function testInvalidTypeRequestData()
	{
		try {
			$this->validator->validateRequestData(new stdClass());
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testMissVersion()
	{
		try {
			$this->validator->validateRequestData(['method' => 'object.action', 'params' => [], 'id' => 1]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testBadVersion()
	{
		try {
			$this->validator->validateRequestData(['jsonrpc' => '1.0', 'method' => 'object.action', 'params' => [], 'id' => 1]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testMissMethod()
	{
		try {
			$this->validator->validateRequestData(['jsonrpc' => '2.0', 'params' => [], 'id' => 1]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testEmptyMethod()
	{
		try {
			$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => '', 'params' => [], 'id' => 1]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testBadTypeMethod()
	{
		try {
			$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 123, 'params' => [], 'id' => 1]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testMissParams()
	{
		try {
			$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 'object.action', 'id' => 1]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testBadTypeParams()
	{
		try {
			$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 'object.action', 'params' => 'string', 'id' => 1]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
	public function testBadTypeId()
	{
		try {
			$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 'object.action', 'params' => [], 'id' => []]);
		} catch (JsonRpcException $ex) {
			$this->assertEquals(-32600, $ex->getCode());
		}
	}
	
}
