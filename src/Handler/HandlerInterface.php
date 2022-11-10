<?php

namespace Zixsihub\JsonRpc\Handler;

use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Http\ResponseInterface;
use Zixsihub\JsonRpc\Registry\RegistryInterface;

interface HandlerInterface
{

	/**
	 * @param RegistryInterface $registry
	 * @return self
	 */
	public function setRegistry(RegistryInterface $registry): self;
	
	/**
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 */
	public function handle(RequestInterface $request): ResponseInterface;
}
