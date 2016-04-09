<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\GameRepository;

class AddStageToGameAction extends RestActionAbstract
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

	public function __invoke($gameId, $stageId)
	{
		$gameId  = (int)$gameId;
		$stageId = (int)$stageId;
		$order   = (int)$this->request->get('order');

		// TODO: Check it is exist or not...

		$this->repository->addStage($gameId, $stageId, $order);

		$this->setResponse(null);
	}
}