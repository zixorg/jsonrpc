<?php

namespace Zixsihub\JsonRpc\Http;

class Request implements RequestInterface
{

	/** @var string|null */
	private $body;

	/** @var string */
	private $method;
	
	/** @var bool */
	private $parsed = false;
	
	/** @var null|array|object */
	private $parsedBody;
	
	public function __construct()
	{
		$this->method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
		$this->body = file_get_contents('php://input') ?: null;
	}

	/**
	 * @return string|null
	 */
	public function getBody(): ?string
	{
		return $this->body;
	}
	
	/**
	 * @param string $body
	 * @return void
	 */
	public function withBody(string $body): void
	{
		$this->body = $body;
		$this->parsed = false;
	}

	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}
	
	/**
	 * @param string $method
	 * @return void
	 */
	public function withMethod(string $method): void
	{
		$this->method = $method;
	}

	/**
	 * @return null|array|object
	 */
	public function getParsedBody()
	{
		if ($this->parsed) {
			return $this->parsedBody;
		}
		
		if (empty($this->body)) {
			$this->parsed = true;
			return null;
		}
		
		$this->parsedBody = json_decode($this->body) ?: null;
		$this->parsed = true;
		
		return $this->parsedBody;
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return (string) $this->body;
	}

}
