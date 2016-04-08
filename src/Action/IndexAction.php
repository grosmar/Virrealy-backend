<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\TestRepository;

class IndexAction extends RestActionAbstract
{
	/**
	 * @var TestRepository
	 */
	private $repository;

	/**
	 * @param Request        $request
	 * @param Response       $response
	 * @param TestRepository $repository
	 */
	public function __construct(
		Request $request,
		Response $response,
		TestRepository $repository
	) {
		parent::__construct($request, $response);

		$this->repository = $repository;
	}

	public function __invoke()
	{
		$this->setResponse($this->repository->getAllUser());
	}
}