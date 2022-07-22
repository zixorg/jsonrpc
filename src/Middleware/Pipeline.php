<?php

namespace Zixsihub\JsonRpc\Middleware;

use Zixsihub\JsonRpc\Handler\RequestHandler;
use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Http\ResponseInterface;

final class Pipeline
{
	/** @var RequestHandler */
	private $handler = [];
	
	/** @var MiddlewareInterface[] */
	private $middlewares = [];
	
	/**
	 * @param RequestHandler $handler
	 * @param MiddlewareInterface[] $middlewares
	 */
	public function __construct(RequestHandler $handler, array $middlewares)
	{
		$this->handler = $handler;
		$this->middlewares = $middlewares;
	}
	
	/**
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 */
	public function handle(RequestInterface $request): ResponseInterface
	{
		$middleware = array_shift($this->middlewares);
		
		if ($middleware !== null) {
			return $middleware->handle($request, [$this, 'handle']);
		}
		
		return $this->handler->handle($request);
	}
}
