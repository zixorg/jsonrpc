<?php

namespace Zixsihub\JsonRpc\Registry;

use Zixsihub\JsonRpc\Data\RequestData;

interface RegistryInterface
{

	/**
	 * @param array $instances
	 * @return RegistryInterface
	 */
	public function fill(array $instances): RegistryInterface;
	
	/**
	 * @param RequestData $request
	 * @return mixed
	 */
	public function invoke(RequestData $request);
		
}
