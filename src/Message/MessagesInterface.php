<?php

namespace Zixsihub\JsonRpc\Message;

interface MessagesInterface
{
	
	/**
	 * @param int $code
	 * @param string $message
	 * @return MessagesInterface
	 */
	public function add(int $code, string $message): MessagesInterface;
	
	/**
	 * @param int $code
	 * @return string
	 */
	public function get(int $code): string;
	
}
