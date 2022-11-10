<?php

namespace Zixsihub\JsonRpc\Exception;

use Throwable;

interface RequestExceptionInterface extends Throwable
{
	/**
	 * @return mixed
	 */
	public function getData();
}
