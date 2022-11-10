<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Exception\RequestException;
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
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$request = new Request();
		$request->withMethod('GET');		
		$this->validator->validateRequest($request);
	}
	
	public function testInvalidRequest()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$request = new Request();
		$request->withMethod('POST');	
		$request->withBody('');
		$this->validator->validateRequest($request);
	}
	
	public function testParseError()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::PARSE_ERROR);
		
		$request = new Request();
		$request->withMethod('POST');	
		$request->withBody('not json');
		$this->validator->validateRequest($request);
	}
	
	public function testNullRequestData()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::PARSE_ERROR);
		
		$this->validator->validateRequestData(null);
	}
	
	public function testInvalidTypeRequestData()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(new stdClass());
	}
	
	public function testMissVersion()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['method' => 'object.action', 'params' => [], 'id' => 1]);
	}
	
	public function testBadVersion()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['jsonrpc' => '1.0', 'method' => 'object.action', 'params' => [], 'id' => 1]);
	}
	
	public function testMissMethod()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['jsonrpc' => '2.0', 'params' => [], 'id' => 1]);
	}
	
	public function testEmptyMethod()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => '', 'params' => [], 'id' => 1]);
	}
	
	public function testBadTypeMethod()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 123, 'params' => [], 'id' => 1]);
	}
	
	public function testMissParams()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 'object.action', 'id' => 1]);
	}
	
	public function testBadTypeParams()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 'object.action', 'params' => 'string', 'id' => 1]);
	}
	
	public function testBadTypeId()
	{
		$this->expectException(RequestException::class);
		$this->expectExceptionCode(RequestException::INVALID_REQUEST);
		
		$this->validator->validateRequestData(['jsonrpc' => '2.0', 'method' => 'object.action', 'params' => [], 'id' => []]);
	}
	
}
