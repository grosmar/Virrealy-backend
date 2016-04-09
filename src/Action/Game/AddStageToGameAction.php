<?php

namespace Virrealy\Api\Action\Game;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Action\RestActionAbstract;
use Virrealy\Api\Repository\GameRepository;
use Virrealy\Api\Repository\StageRepository;

class AddStageToGameAction extends RestActionAbstract
{
	/**
	 * @var GameRepository
	 */
	private $gameRepository;

	/**
	 * @var StageRepository
	 */
	private $stageRepository;

	/**
	 * @param Request         $request
	 * @param Response        $response
	 * @param GameRepository  $gameRepository
	 * @param StageRepository $stageRepository
	 */
	public function __construct(
		Request $request,
		Response $response,
		GameRepository $gameRepository,
		StageRepository $stageRepository
	) {
		parent::__construct($request, $response);

		$this->gameRepository  = $gameRepository;
		$this->stageRepository = $stageRepository;
	}

	public function __invoke($gameId, $stageId)
	{
		$gameId  = (int)$gameId;
		$stageId = (int)$stageId;
		$order   = (int)$this->request->get('order');

		$game = $this->gameRepository->find($gameId);
		if (empty($game))
		{
			$this->setNotFoundResponse();

			return;
		}

		$stage = $this->stageRepository->find($stageId);
		if (empty($stage))
		{
			$this->setNotFoundResponse();

			return;
		}

		$this->gameRepository->addStage($gameId, $stageId, $order);

		$this->setResponse(null);
	}
}