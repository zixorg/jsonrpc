<?php

namespace Zixsihub\JsonRpc\Handler;

use Exception;
use Zixsihub\JsonRpc\Data\ArrayableInterface;
use Zixsihub\JsonRpc\Data\ErrorData;
use Zixsihub\JsonRpc\Data\RequestData;
use Zixsihub\JsonRpc\Data\ResponseData;
use Zixsihub\JsonRpc\Exception\JsonRpcException;
use Zixsihub\JsonRpc\Http\RequestInterface;
use Zixsihub\JsonRpc\Http\Response;
use Zixsihub\JsonRpc\Http\ResponseInterface;
use Zixsihub\JsonRpc\Registry\RegistryInterface;
use Zixsihub\JsonRpc\Validator\ValidatorInterface;

class RequestHandler implements HandlerInterface
{

	/** @var RegistryInterface */
	private $registry;

	/** @var ValidatorInterface */
	private $validator;

	/** @var bool */
	private $batch = false;

	/** @var ArrayableInterface[] */
	private $result = [];

	/**
	 * @param ValidatorInterface $validator
	 */
	public function __construct(ValidatorInterface $validator)
	{
		$this->validator = $validator;
	}
	
	/**
	 * @param RegistryInterface $registry
	 * @return HandlerInterface
	 */
	public function setRegistry(RegistryInterface $registry): HandlerInterface
	{
		$this->registry = $registry;
		
		return $this;
	}

	/**
	 * @param RequestInterface $request
	 * @return ResponseInterface
	 */
	public function handle(RequestInterface $request): ResponseInterface
	{
		try {
			$this->validator->validateRequest($request);

			foreach ($this->makeDataPool($request) as $data) {
				$this->call($data);
			}
		} catch (Exception $ex) {
			$this->batch = false;
			$this->result[] = $this->makeErrorData($ex);
		}

		return $this->makeResponse();
	}

	/**
	 * @param RequestData $data
	 * @return void
	 */
	private function call(RequestData $data): void
	{
		try {
			$this->validator->validateRequestData($data->getData());
			$result = $this->registry->invoke($data);

			if (!$data->isNotification()) {
				$this->result[] = new ResponseData($result, $data->getId());
			}
		} catch (Exception $ex) {
			if ($data->isNotification() && !in_array($ex->getCode(), [-32700, -32600, -32601])) {
				return;
			} 
			
			$this->result[] = $this->makeErrorData($ex, $data->getId());
		}
	}

	/**
	 * @param RequestInterface $request
	 * @return RequestData[]
	 */
	private function makeDataPool(RequestInterface $request): array
	{
		$this->batch = is_array($request->getParsedBody());
		$body = $request->getParsedBody();

		if (!is_array($body)) {
			return [new RequestData($body)];
		}

		$pool = [];

		foreach ($body as $data) {
			$pool[] = new RequestData($data);
		}

		return $pool;
	}
	
	/**
	 * @return ResponseInterface
	 */
	private function makeResponse(): ResponseInterface
	{
		$response = new Response();
		
		if (empty($this->result)) {
			return $response;
		}
		
		if ($this->batch) {
			$result = array_map(
				function (ArrayableInterface $row) {
					return $row->toArray();

				}, 
				$this->result
			);
		} else {
			$result = current($this->result)->toArray();
		}

		$response->withBody(json_encode($result, JSON_UNESCAPED_UNICODE));
		
		return $response;
	}
	
	/**
	 * @param Exception $ex
	 * @param string|int|null $id
	 * @return ErrorData
	 */
	private function makeErrorData(Exception $ex, $id = null): ErrorData
	{
		$data = null;
		
		if ($ex instanceof JsonRpcException) {
			$data = $ex->getData();
		}
		
		return new ErrorData((int) $ex->getCode(), $ex->getMessage(), $data, $id);
	}

}
