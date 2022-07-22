<?php

namespace Zixsihub\JsonRpc\Data;

class ResponseData implements ArrayableInterface
{
	/** @var string|int|null */
	private $id;
	
	/** @var mixed */
	private $result = null;
	
	/**
	 * @param mixed $result
	 * @param string|int|null $id
	 */
	public function __construct($result, $id = null)
	{
		$this->result = $result;
		$this->id = $id;
	}
	
	/**
	 * @return array
	 */
	public function toArray(): array
	{
		return [
			'jsonrpc' => '2.0',
			'result' => $this->result,
			'id' => $this->id
		];
	}

}
