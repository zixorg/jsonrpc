<?php

namespace Zixsihub\JsonRpc\Registry;

use ReflectionMethod;
use ReflectionParameter;
use Zixsihub\JsonRpc\Data\RequestData;
use Zixsihub\JsonRpc\Exception\JsonRpcException;

final class Registry implements RegistryInterface
{

	/** @var array */
	private $classMap = [];

	/** @var array */
	private $instancesMap = [];

	/** @var array */
	private $reflectionMap = [];
	
	/**
	 * @param array $instances
	 * @return RegistryInterface
	 */
	public function fill(array $instances): RegistryInterface
	{
		foreach ($instances as $name => $instance) {
			$this->validateInstance($name, $instance);
			
			$this->classMap[$name] = $instance;
			
			if (is_object($instance)) {
				$this->instancesMap[$name] = $instance;
			}
		}
		
		return $this;
	}
	
	/**
	 * @param RequestData $request
	 * @return mixed
	 */
	public function invoke(RequestData $request)
	{
		$instance = $this->getInstance($request->getMethodObjectName());
		$method = $this->getReflectionMethod($instance, $request);
		
		return  $method->invokeArgs($instance, $request->getParams());
	}
	
	/**
	 * @param string $namespace
	 * @return bool
	 */
	private function has(string $namespace): bool
	{
		return array_key_exists($namespace, $this->classMap);
	}

	/**
	 * @param string $namespace
	 * @return object
	 */
	private function getInstance(string $namespace): object
	{
		if (array_key_exists($namespace, $this->instancesMap)) {
			return $this->instancesMap[$namespace];
		}

		if (!$this->has($namespace)) {
			throw new JsonRpcException('Method not found', -32601);
		}
		
		$class = $this->classMap[$namespace];
		
		if (is_string($class) && class_exists($class)) {
			$this->instancesMap[$namespace] = new $class;
		} elseif (is_object($class)) {
			$this->instancesMap[$namespace] = $class;
		} else {
			throw new JsonRpcException('Method not found', -32601);
		}

		return $this->instancesMap[$namespace];
	}
	
	/**
	 * @param object $instance
	 * @param RequestData $data
	 * @return ReflectionMethod
	 * @throws JsonRpcException
	 */
	private function getReflectionMethod(object $instance, RequestData $data): ReflectionMethod
	{
		if (empty($data->getMethodActionName()) || !method_exists($instance, $data->getMethodActionName())) {
			throw new JsonRpcException('Method not found', -32601);
		}
		
		if (!array_key_exists($data->getMethodActionName(), $this->reflectionMap)) {
			$this->reflectionMap[$data->getMethod()] = new ReflectionMethod($instance, $data->getMethodActionName());
		}
		
		$reflectionMethod = $this->reflectionMap[$data->getMethod()];
		
		/** @var ReflectionParameter $param */
		foreach ($reflectionMethod->getParameters() as $param) {
			if (
				$param->isDefaultValueAvailable()
				|| array_key_exists($param->getName(), $data->getParams())
			) {
				continue;
			}

			throw new JsonRpcException('Invalid params', -32602,  $param->getName() . ' not found');
		}
		
		return $reflectionMethod;
	}
	
	/**
	 * @param string $name
	 * @param mixed $instance
	 * @return void
	 * @throws JsonRpcException
	 */
	private function validateInstance(string $name, $instance): void
	{
		if (array_key_exists($name, $this->classMap)) {
			throw new JsonRpcException(
				'Internal error', 
				-32603, 
				sprintf('Duplicate definition for name %s', $name)
			);
		}
		
		if (empty($instance) || (!is_string($instance) && !is_object($instance))) {
			throw new JsonRpcException(
				'Internal error', 
				-32603, 
				sprintf('Invalid instance definition for name %s', $name)
			);
		}
	}

}
