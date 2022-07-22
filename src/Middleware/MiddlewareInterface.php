<?php

namespace Zixsihub\JsonRpc\Middleware;

use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Http\ResponseInterface;

interface MiddlewareInterface
{
	public function handle(RequestInterface $request, callable $next): ResponseInterface;
}
