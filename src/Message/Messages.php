<?php

namespace Zixsihub\JsonRpc\Message;

class Messages implements MessagesInterface
{

	public const PARSE_ERROR = -32700;
	public const INVALID_REQUEST = -32600;
	public const METHOD_NOT_FOUND = -32601;
	public const INVALID_PARAMS = -32602;
	public const INTERNAL_ERROR = -32603;

	/** @var array */
	private $messages = [
		self::PARSE_ERROR => 'Parse error',
		self::INVALID_REQUEST => 'Invalid Request',
		self::METHOD_NOT_FOUND => 'Method not found',
		self::INVALID_PARAMS => 'Invalid params',
		self::INTERNAL_ERROR => 'Internal error',
	];
	
	/**
	 * @param int $code
	 * @param string $message
	 * @return MessagesInterface
	 */
	public function add(int $code, string $message): MessagesInterface
	{
		$this->messages[$code] = $message;
		
		return $this;
	}

	/**
	 * @param int $code
	 * @return string
	 */
	public function get(int $code): string
	{
		if(!array_key_exists($code, $this->messages)) {
			$code = self::INTERNAL_ERROR;
		}
		
		return $this->messages[$code];
	}

}
