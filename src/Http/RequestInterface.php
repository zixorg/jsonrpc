<?php

namespace Zixsihub\JsonRpc\Http;

interface RequestInterface
{
	
	/**
	 * @return string
	 */
	public function getMethod(): string;
	
	/**
	 * @param string $method
	 * @return void
	 */
	public function withMethod(string $method): void;
	
	/**
	 * @return null|string
	 */
	public function getBody(): ?string;
	
	/**
	 * @param string $body
	 * @return void
	 */
	public function withBody(string $body): void;
	
	/**
	 * @return null|array|object
	 */
	public function getParsedBody();
	
	/**
	 * @return string
	 */
	public function  __toString(): string;
	
}
