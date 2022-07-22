<?php

namespace Zixsihub\JsonRpc\Handler;

use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Http\ResponseInterface;

interface HandlerInterface
{

	/**
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 */
	public function handle(RequestInterface $request): ResponseInterface;
}
