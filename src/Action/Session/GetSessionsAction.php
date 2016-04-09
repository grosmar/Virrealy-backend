<?php

namespace Virrealy\Api\Action\Session;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Action\RestActionAbstract;
use Virrealy\Api\Repository\SessionRepository;

class GetSessionsAction extends RestActionAbstract
{
	/**
	 * @var SessionRepository
	 */
	private $repository;

	/**
	 * @param Request           $request
	 * @param Response          $response
	 * @param SessionRepository $repository
	 */
	public function __construct(
		Request $request,
		Response $response,
		SessionRepository $repository
	) {
		parent::__construct($request, $response);

		$this->repository = $repository;
	}

	public function __invoke()
	{
		$sessions = $this->repository->findAll();
		if (empty($sessions))
		{
			$this->setResponse(null, 204);

			return;
		}

		$this->setResponse($sessions);
	}
}