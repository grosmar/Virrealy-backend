<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\VirrealyRepository;

class CreateSessionAction extends RestActionAbstract
{
	/**
	 * @var VirrealyRepository
	 */
	private $repository;

	/**
	 * @param Request            $request
	 * @param Response           $response
	 * @param VirrealyRepository $repository
	 */
	public function __construct(
		Request $request,
		Response $response,
		VirrealyRepository $repository
	) {
		parent::__construct($request, $response);

		$this->repository = $repository;
	}

	public function __invoke()
	{
		$gameId = (int)$this->request->post('gameId');
		if (empty($gameId))
		{
			$this->setResponse(null, 400);

			return;
		}

		$sessionId = (int)$this->repository->createSession($gameId);
		if (empty($sessionId))
		{
			$this->setResponse(null, 500);

			return;
		}

		$this->setResponse(
			array(
				'sessionId' => $sessionId
			),
			201
		);
	}
}