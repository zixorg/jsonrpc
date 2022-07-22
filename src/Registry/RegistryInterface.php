<?php

namespace Zixsihub\JsonRpc\Registry;

use Zixsihub\JsonRpc\Data\RequestData;

interface RegistryInterface
{

	/**
	 * @param string $name
	 * @param string|object $instance
	 * @return RegistryInterface
	 */
	public function add(string $name, $instance): RegistryInterface;
	
	/**
	 * @param RequestData $request
	 * @return mixed
	 */
	public function invoke(RequestData $request);
		
}
