<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;

abstract class RestActionAbstract
{
	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * @var Response
	 */
	protected $response;

	/**
	 * @param Request  $request
	 * @param Response $response
	 */
	public function __construct(Request $request, Response $response)
	{
		$this->request  = $request;
		$this->response = $response;
	}

	/**
	 * @param mixed $data
	 * @param int   $statusCode
	 */
	protected function setResponse($data, $statusCode = 200)
	{
		$this->response['Content-Type'] = 'application/json';
		$this->response->status($statusCode);
		$this->response->body(json_encode($data));
	}
}