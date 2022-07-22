<?php

namespace Zixsihub\JsonRpc\Data;

class RequestData
{
	
	/** @var mixed */
	private $dataRaw;
	
	/** @var null|array */
	private $data;
	
	/** @var string|int|null */
	private $id;
	
	/** @var string|null */
	private $method;

	/** @var array */
	private $params = [];
	
	/** @var string|null */
	private $methodObjectName;

	/** @var string|null */
	private $methodActionName;
	
	/** @var bool */
	private $notification = true;

	/**
	 * @param mixed $data
	 */
	public function __construct($data = [])
	{
		$this->parse($data);
	}
	
	/**
	 * @param mixed $data
	 * @return void
	 */
	private function parse($data): void
	{
		$this->dataRaw = $data;
		
		if (!is_array($data) && !is_object($data)) {
			return;
		}
		
		if (is_object($data)) {
			$data = json_decode(json_encode($data), true);
		}
		
		$this->data = $data;
		
		if (array_key_exists('id', $data)) {
			$this->id = $data['id'];
			$this->notification = false;
		}
		
		if (array_key_exists('method', $data) && is_string($data['method'])) {
			$this->method = $data['method'];
			$this->parseMethod();
		}
		
		if (array_key_exists('params', $data) && is_array($data['params'])) {
			$this->params = $data['params'];
		}
	}
	
	/**
	 * @return mixed
	 */
	public function getDataRaw()
	{
		return $this->dataRaw;
	}

	/**
	 * @return null|array
	 */
	public function getData(): ?array
	{
		return $this->data;
	}
	
	/**
	 * @return string|null
	 */
	public function getMethod(): ?string
	{
		return $this->method;
	}

	/**
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * @return string|int|null
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return string|null
	 */
	public function getMethodObjectName(): ?string
	{
		return $this->methodObjectName;
	}

	/**
	 * @return string|null
	 */
	public function getMethodActionName(): ?string
	{
		return $this->methodActionName;
	}
	
	/**
	 * @return bool
	 */
	public function isNotification(): bool
	{
		return $this->notification;
	}

	/**
	 * @return void
	 */
	private function parseMethod(): void
	{
		if (empty($this->method)) {
			return;
		}
		
		$parts = explode('.', $this->method, 2);
		
		if (count($parts) < 2) {
			array_unshift($parts, null);
		} 
		
		$this->methodObjectName = $parts[0];
		$this->methodActionName = $parts[1];
	}
}
