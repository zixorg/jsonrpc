<?php

namespace Zixsihub\JsonRpc\Exception;

use Exception;
use Throwable;

class JsonRpcException extends Exception
{

	/** @var mixed|null */
	private $data;

	/**
	 * @param string $message
	 * @param int $code
	 * @param mixed|null $data
	 * @param Throwable|null $previous
	 */
	public function __construct(string $message = '', int $code = 0, $data = null, ?Throwable $previous = null)
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

}
