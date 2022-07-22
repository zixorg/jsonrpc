<?php

namespace Zixsihub\JsonRpc\Middleware;

use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Http\ResponseInterface;
use Zixsihub\JsonRpc\Middleware\MiddlewareInterface;

class PrettyMiddleware implements MiddlewareInterface
{
	
	/**
	 * @param RequestInterface $request
	 * @param callable $next
	 * @return ResponseInterface
	 */
	public function handle(RequestInterface $request, callable $next): ResponseInterface
	{
		/** @var ResponseInterface $response*/
		$response = $next($request);
		
		if (empty($response->getBody()) || filter_input(INPUT_GET, 'pretty') === null) {
			return $response;
		}
		
		$json = json_encode(
			json_decode($response->getBody()),
			JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
		);
		
		$response->withBody($json);
		
		return $response;
	}

}
