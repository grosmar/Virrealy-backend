<?php

namespace Virrealy\Api\Action\Game;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Action\RestActionAbstract;
use Virrealy\Api\Repository\GameRepository;

class GetGamesAction extends RestActionAbstract
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
		$games = $this->repository->findAll();
		if (empty($games))
		{
			$this->setResponse(null, 204);

			return;
		}

		$formattedGames = array();
		foreach ($games as $game)
		{
			$formattedGames[] = array(
				'gameId' => $game['id'],
				'name'   => $game['name']
			);
		}

		$this->setResponse($formattedGames);
	}
}