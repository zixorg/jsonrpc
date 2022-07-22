<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Http\Response;

class ResponseTest extends TestCase
{

	/** @var Response */
	private $response;
	
	/** @var string */
	private $body = 'test body';
	
	protected function setUp()
	{
		$this->response = new Response();
	}
	
	public function testBody()
	{
		$this->response->withBody($this->body);
		$this->assertEquals($this->body, $this->response->getBody());
		
		$this->response->withBody('');
		$this->assertEquals('', $this->response->getBody());
	}
	
	public function testHeaders()
	{
		$this->assertInternalType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $this->response->getHeaders());
		$this->assertEquals([], $this->response->getHeaders());
		
		$this->response->withHeader('key', 'value');
		$this->assertTrue(array_key_exists('key', $this->response->getHeaders()));
		$this->assertTrue(in_array('value', $this->response->getHeaders()));
		
		$this->response->withoutHeader('key');
		$this->assertEquals([], $this->response->getHeaders());
	}
	
	public function testToString()
	{
		$this->response->withBody($this->body);
		$this->assertEquals($this->body, (string) $this->response);
	}
	
}
