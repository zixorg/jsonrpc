<?php

namespace Zixsihub\JsonRpc\Http;

interface ResponseInterface
{
	
	/**
	 * @return null|string
	 */
	public function getBody(): ?string;
	
	
	/**
	 * @param string $body
	 */
	public function withBody(string $body): void;
	
	/**
	 * @return array
	 */
	public function getHeaders(): array;
	
	/**
	 * @param string $name
	 * @param string $value
	 */
	public function withHeader(string $name, string $value): void;
	
	/**
	 * @param string $name
	 * @return void
	 */
	public function withoutHeader(string $name): void;
	
	/**
	 * @return void
	 */
	public function send(): void;
	
	/**
	 * @return string
	 */
	public function  __toString(): string;
	
}
