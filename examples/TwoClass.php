<?php

namespace Tests;

use RuntimeException;

class TwoClass
{
	
	/**
	 * @return void
	 */
	public function methodOne(): void
	{
		
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
