<?php

namespace Zixsihub\JsonRpc\Validator;

use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Exception\JsonRpcException;
use Zixsihub\JsonRpc\Validator\ValidatorInterface;

class Validator implements ValidatorInterface
{
	
	/**
	 * @param RequestInterface $request
	 * @return void
	 * @throws JsonRpcException
	 */
	public function validateRequest(RequestInterface $request): void
	{
		if ($request->getMethod() !== 'POST') {
			throw new JsonRpcException('Invalid Request', -32600);
		}
		
		if (empty($request->getBody())) {
			throw new JsonRpcException('Invalid Request', -32600);
		}

		if (!empty($request->getBody()) &&  empty($request->getParsedBody())) {
			throw new JsonRpcException('Parse error', -32700);
		}
	}
	
	/**
	 * @param mixed $data
	 * @return void
	 * @throws JsonRpcException
	 */
	public function validateRequestData($data): void
	{
		if ($data === null || $data === false) {
			throw new JsonRpcException('Parse error', -32700);
		}

		if (empty($data) || !is_array($data)) {
			throw new JsonRpcException('Invalid Request', -32600);
		}

		if (!array_key_exists('jsonrpc', $data) || $data['jsonrpc'] !== '2.0') {
			throw new JsonRpcException('Invalid Request', -32600);
		}

		if (!array_key_exists('method', $data) || empty($data['method']) ||  !is_string($data['method'])) {
			throw new JsonRpcException('Invalid Request', -32600);
		}

		if (!array_key_exists('params', $data) || !is_array($data['params'])) {
			throw new JsonRpcException('Invalid Request', -32600);
		}

		if (array_key_exists('id', $data) && $data['id'] !== null && !is_string($data['id']) && !is_numeric($data['id'])) {
			throw new JsonRpcException('Invalid Request', -32600);
		}
	}
	
}
