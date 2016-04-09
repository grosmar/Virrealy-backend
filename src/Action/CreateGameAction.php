<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\VirrealyRepository;

class CreateGameAction extends RestActionAbstract
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
		$name = (string)$this->request->post('name');
		if (empty($name))
		{
			$this->setBadRequestResponse();

			return;
		}

		$gameId = $this->repository->createGame($name);

		$this->setResponse(
			array(
				'gameId' => $gameId
			),
			201
		);
	}
}