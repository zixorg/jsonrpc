<?php

namespace Zixsihub\JsonRpc\Exception;

use Exception;
use Throwable;

class RequestException extends Exception  implements RequestExceptionInterface
{

	public const PARSE_ERROR = -32700;
	public const INVALID_REQUEST = -32600;
	public const METHOD_NOT_FOUND = -32601;
	public const INVALID_PARAMS = -32602;
	public const INTERNAL_ERROR = -32603;
	
	/** @var mixed */
	private $data;
	
	/**
	 * @param string $message
	 * @param int $code
	 * @param mixed $data
	 * @param Throwable|null $previous
	 */
	public function __construct(string $message = "", int $code = 0, $data = null, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
		
		$this->data = $data;
	}
	
	/**
	 * @return mixed
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param mixed $data
	 * @return self
	 */
	public static function forParseError($data = null): self
	{
		return new self('Parse error', self::PARSE_ERROR);
	}

	/**
	 * @param mixed $data
	 * @return self
	 */
	public static function forInvalidRequest($data = null): self
	{
		return new self('Invalid request', self::INVALID_REQUEST);
	}
	
	/**
	 * @param mixed $data
	 * @return self
	 */
	public static function forMethodNotFound($data = null): self
	{
		return new self('Method not found', self::METHOD_NOT_FOUND);
	}
	
	/**
	 * @param mixed $data
	 * @return self
	 */
	public static function forInvalidParams($data = null): self
	{
		return new self('Invalid params', self::INVALID_PARAMS, $data);
	}
	
	/**
	 * @param mixed $data
	 * @return self
	 */
	public static function forInternalError($data = null): self
	{
		return new self('Internal error', self::INTERNAL_ERROR, $data);
	}
}
