<?php

namespace Zixsihub\JsonRpc\Validator;

use Zixsihub\JsonRpc\Exception\RequestException;
use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Validator\ValidatorInterface;

final class Validator implements ValidatorInterface
{
	
	/**
	 * @param RequestInterface $request
	 * @return void
	 * @throws RequestException
	 */
	public function validateRequest(RequestInterface $request): void
	{
		if ($request->getMethod() !== 'POST') {
			throw RequestException::forInvalidRequest();
		}
		
		if (empty($request->getBody())) {
			throw RequestException::forInvalidRequest();
		}

		if (!empty($request->getBody()) &&  empty($request->getParsedBody())) {
			throw RequestException::forParseError();
		}
	}
	
	/**
	 * @param mixed $data
	 * @return void
	 * @throws RequestException
	 */
	public function validateRequestData($data): void
	{
		if ($data === null || $data === false) {
			throw RequestException::forParseError();
		}

		if (empty($data) || !is_array($data)) {
			throw RequestException::forInvalidRequest();
		}

		if (!array_key_exists('jsonrpc', $data) || $data['jsonrpc'] !== '2.0') {
			throw RequestException::forInvalidRequest();
		}

		if (!array_key_exists('method', $data) || empty($data['method']) ||  !is_string($data['method'])) {
			throw RequestException::forInvalidRequest();
		}

		if (!array_key_exists('params', $data) || !is_array($data['params'])) {
			throw RequestException::forInvalidRequest();
		}

		if (array_key_exists('id', $data) && $data['id'] !== null && !is_string($data['id']) && !is_numeric($data['id'])) {
			throw RequestException::forInvalidRequest();
		}
	}
	
}
