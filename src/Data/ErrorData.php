<?php

namespace Zixsihub\JsonRpc\Data;

class ErrorData implements ArrayableInterface
{
	/** @var string|int|null */
	private $id;
	
	/** @var int */
	private $code = 0;
	
	/** @var string */
	private $message = '';
	
	/** @var mixed */
	private $data = null;
	
	/**
	 * @param int $code
	 * @param string $message
	 * @param mixed $data
	 * @param string|int|null $id
	 */
	public function __construct(int $code, string $message, $data = null, $id = null)
	{
		$this->code = $code;
		$this->message = $message;
		$this->data = $data;
		$this->id = $id;
	}

	/**
	 * @return array
	 */
	public function toArray(): array
	{
		$result = [
			'jsonrpc' => '2.0',
			'error' => [
				'code' => $this->code,
				'message' => $this->message,
			],
			'id' => $this->id
		];
		
		if ($this->data !== null) {
			$result['error']['data'] = $this->data;
		}
		
		return $result;
	}

}
