<?php

namespace Zixsihub\JsonRpc;

use Zixsihub\JsonRpc\Handler\HandlerInterface;
use Zixsihub\JsonRpc\Handler\RequestHandler;
use Zixsihub\JsonRpc\Http\Request;
use Zixsihub\JsonRpc\Middleware\MiddlewareInterface;
use Zixsihub\JsonRpc\Middleware\Pipeline;
use Zixsihub\JsonRpc\Registry\Registry;
use Zixsihub\JsonRpc\Registry\RegistryInterface;
use Zixsihub\JsonRpc\Validator\Validator;

final class Server
{
	
	/** @var array */
	private $instances;
	
	/** @var HandlerInterface */
	private $handler;
	
	/** @var RegistryInterface */
	private $registry;
	
	/** @var MiddlewareInterface[] */
	private $middlewares = [];
	
	/**
	 * @param array $instances
	 * @param MiddlewareInterface[] $middlewares
	 */
	public function __construct(array $instances, array $middlewares = [])
	{
		$this->instances = $instances;
		$this->middlewares = $middlewares;
	}
	
	/**
	 * @param HandlerInterface $handler
	 * @return self
	 */
	public function setHandler(HandlerInterface $handler): self
	{
		$this->handler = $handler;
		
		return $this;
	}
	
	/**
	 * @param RegistryInterface $registry
	 * @return self
	 */
	public function setRegistry(RegistryInterface $registry): self
	{
		$this->registry = $registry;
		
		return $this;
	}	
	
	/**
	 * @return void
	 */
	public function run(): void
	{
		$this->registry = $this->registry ?? new Registry();
		$this->registry->fill($this->instances);
		
		$this->handler = $this->handler ?? new RequestHandler(new Validator());
		$this->handler->setRegistry($this->registry);
		
		$response = (new Pipeline($this->handler, $this->middlewares))->handle(new Request());
		$response->withHeader('Content-Type', 'application/json');
		$response->send();
	}
	
}
