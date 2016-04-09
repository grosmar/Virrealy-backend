<?php

namespace Virrealy\Api\Action\Game;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Action\RestActionAbstract;
use Virrealy\Api\Repository\GameRepository;

class CreateGameAction extends RestActionAbstract
{
	/**
	 * @var GameRepository
	 */
	private $repository;

	/**
	 * @param Request        $request
	 * @param Response       $response
	 * @param GameRepository $repository
	 */
	public function __construct(
		Request $request,
		Response $response,
		GameRepository $repository
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

		$gameId = $this->repository->create($name);

		$this->setResponse(
			array(
				'gameId' => $gameId
			),
			201
		);
	}
}