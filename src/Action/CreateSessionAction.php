<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\SessionRepository;

class CreateSessionAction extends RestActionAbstract
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
		$gameId = (int)$this->request->post('gameId');
		if (empty($gameId))
		{
			$this->setBadRequestResponse();

			return;
		}

		$sessionId = (int)$this->repository->create($gameId);
		if (empty($sessionId))
		{
			$this->setInternalServerError();

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