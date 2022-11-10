<?php

namespace Zixsihub\JsonRpc\Http;

class Response implements ResponseInterface
{
	
	/** @var string|null */
	private $body;
	
	/** @var array */
	private $headers = [];
	
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
	}
	
	/**
	 * @return array
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	/**
	 * @return void
	 */
	public function send(): void
	{
		foreach ($this->headers as $name => $value) {
			header(sprintf('%s: %s', $name, $value));
		}
		
		echo (string) $this;
	}

	/**
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	public function withHeader(string $name, string $value): void
	{
		$this->headers[$name] = $value;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function withoutHeader(string $name): void
	{
		if (array_key_exists($name, $this->headers)) {
			unset($this->headers[$name]);
		}
	}
	
	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return (string) $this->body;
	}

}
