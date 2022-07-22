<?php

namespace Tests;

use RuntimeException;

class OneClass
{
	
	
	public function methodOne($param2, $param3): string
	{
		return 'Method One';
	}
	
	/**
	 * @return string
	 */
	public function methodTwo(): string
	{
		return 'Method Two';
	}
	
	/**
	 * @return void
	 */
	public function methodThree(): void
	{
		throw new RuntimeException('403 Access Denied', 403);
	}
	
	/**
	 * @return void
	 */
	public function methodFour(): void
	{
		throw new RuntimeException('404 Not Found', 404);
	}
	
}
