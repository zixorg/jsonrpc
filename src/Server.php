<?php

namespace Zixsihub\JsonRpc;

use Zixsihub\JsonRpc\Handler\HandlerInterface;
use Zixsihub\JsonRpc\Handler\RequestHandler;
use Zixsihub\JsonRpc\Http\Request;
use Zixsihub\JsonRpc\Message\Messages;
use Zixsihub\JsonRpc\Message\MessagesInterface;
use Zixsihub\JsonRpc\Middleware\MiddlewareInterface;
use Zixsihub\JsonRpc\Middleware\Pipeline;
use Zixsihub\JsonRpc\Registry\Registry;
use Zixsihub\JsonRpc\Registry\RegistryInterface;
use Zixsihub\JsonRpc\Validator\Validator;

class Server
{
	
	/** @var HandlerInterface */
	private $handler;
	
	/** Registry\RegistryInterface */
	private $registry;
	
	/** @var MessagesInterface */
	private $messages;
	
	/** @var MiddlewareInterface */
	private $middlewares = [];
	
	/**
	 * @param HandlerInterface $handler
	 * @param RegistryInterface $registry
	 * @param MessagesInterface $messages
	 */
	public function __construct(HandlerInterface $handler = null, RegistryInterface $registry = null, MessagesInterface $messages = null)
	{
		$this->registry = $registry ?? new Registry();
		$this->messages = $messages ?? new Messages();
		$this->handler = $handler ?? $this->initializeHandler();
	}
	
	/**
	 * @param string $name
	 * @param string|object $instance
	 * @return self
	 */
	public function registerInstance(string $name, $instance): self
	{
		$this->registry->add($name, $instance);
		
		return $this;
	}
	
	/**
	 * @param array<string, mixed> $map
	 * @return self
	 */
	public function registerInstances(array $map): self
	{
		foreach ($map as $name => $instance) {
			$this->registry->add($name, $instance);
		}
		
		return $this;
	}
	
	/**
	 * @param array<int, string> $map
	 * @return self
	 */
	public function registerMessages(array $map): self
	{
		foreach ($map as $code => $message) {
			$this->messages->add((int) $code, (string) $message);
		}
		
		return $this;
	}
	
	/**
	 * @param MiddlewareInterface[] $middlewares
	 * @return self
	 */
	public function registerMiddlewares(array $middlewares): self
	{
		$this->middlewares = $middlewares;
		
		return $this;
	}
	
	/**
	 * @return void
	 */
	public function run(): void
	{
		$request = new Request();
		$response = (new Pipeline($this->handler, $this->middlewares))->handle($request);
		
		$response->withHeader('Content-Type', 'application/json');
		$response->send();
	}
	
	/**
	 * @return HandlerInterface
	 */
	private function initializeHandler(): HandlerInterface
	{
		return 
			new RequestHandler(
				$this->registry,
				new Validator(),
				$this->messages
			);
	}
	
}
