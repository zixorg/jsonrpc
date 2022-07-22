<?php

use PHPUnit\Framework\TestCase;
use Zixsihub\JsonRpc\Message\Messages;

class MessagesTest extends TestCase
{

	/** @var Messages */
	private $messages;
	
	protected function setUp()
	{
		$this->messages = new Messages();
	}
	
	public function testMessageCode()
	{
		$this->assertEquals(Messages::PARSE_ERROR, -32700);
		$this->assertEquals(Messages::INVALID_REQUEST, -32600);
		$this->assertEquals(Messages::METHOD_NOT_FOUND, -32601);
		$this->assertEquals(Messages::INVALID_PARAMS, -32602);
		$this->assertEquals(Messages::INTERNAL_ERROR, -32603);
	}
	
	public function testMessageText()
	{
		$this->assertEquals(
			'Parse error',
			$this->messages->get(Messages::PARSE_ERROR)
		);
		
		$this->assertEquals(
			'Invalid Request',
			$this->messages->get(Messages::INVALID_REQUEST)
		);
		
		$this->assertEquals(
			'Method not found',
			$this->messages->get(Messages::METHOD_NOT_FOUND)
		);
		
		$this->assertEquals(
			'Invalid params',
			$this->messages->get(Messages::INVALID_PARAMS)
		);
		
		$this->assertEquals(
			'Internal error',
			$this->messages->get(Messages::INTERNAL_ERROR)
		);
		
		$this->assertEquals(
			$this->messages->get(Messages::INTERNAL_ERROR),
			$this->messages->get(0)
		);
	}
	
	public function testAdd()
	{
		$code = 1;
		$message = 'test message';
		$this->messages->add($code, $message);
		
		$this->assertEquals(
			$message,
			$this->messages->get($code)
		);
	}
	
}
