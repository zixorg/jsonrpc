<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Http\Request;

class RequestTest extends TestCase
{

	/** @var Request */
	private $request;
	
	/** @var string */
	private $body = '{"param1": "value1", "param2": "value2"}';
	
	protected function setUp()
	{
		$this->request = new Request();
	}
	
	public function testBody()
	{
		$this->request->withBody($this->body);
		$this->assertEquals($this->body, $this->request->getBody());
		
		$this->request->withBody('');
		$this->assertEquals('', $this->request->getBody());
	}
	
	public function testMethod()
	{
		$this->request->withMethod('POST');
		$this->assertEquals('POST', $this->request->getMethod());
		
		$this->request->withMethod('GET');
		$this->assertEquals('GET', $this->request->getMethod());
	}
	
	public function testToString()
	{
		$this->request->withBody($this->body);
		$this->assertEquals($this->body, (string) $this->request);
	}
	
	public function testParsedBody()
	{
		$this->request->withBody('');
		$this->assertNull($this->request->getParsedBody());
		
		$this->request->withBody('not json');
		$this->assertNull($this->request->getParsedBody());
		
		$this->request->withBody($this->body);
		$this->assertObjectHasAttribute('param1', $this->request->getParsedBody());
		
		$this->request->withBody('[1, 2]');
		$this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->request->getParsedBody());
	}
}
