<?php

namespace Zixsihub\JsonRpc\Validator;

use Zixsihub\JsonRpc\Http\RequestInterface;

interface ValidatorInterface
{
	
	/**
	 * @param RequestInterface $request
	 * @return void
	 */
	public function validateRequest(RequestInterface $request): void;
	
	/**
	 * @param mixed $data
	 * @return void
	 */
	public function validateRequestData($data): void;
	
}
