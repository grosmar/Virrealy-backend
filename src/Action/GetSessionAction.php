<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\Table\StageTable;
use Virrealy\Api\Repository\VirrealyRepository;

class GetSessionAction extends RestActionAbstract
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

	public function __invoke($sessionId)
	{
		$sessionId = (int)$sessionId;

		$session = $this->repository->getSessionStages($sessionId);
		if (empty($session))
		{
			$this->setResponse(null, 204);

			return;
		}

		$gameId = 0;
		$stages = array();

		foreach ($session as $stage)
		{
			$gameId = $stage['game_id'];

			$stages[] = array(
				'stageId'        => $stage['stage_id'],
				'stageType'      => $stage[StageTable::TYPE],
				'information'    => $stage[StageTable::INFORMATION],
				'answer'         => $stage[StageTable::ANSWER],
				'validationType' => $stage[StageTable::VALIDATION_TYPE]
			);
		}

		$this->setResponse(
			array(
				'sessionId' => $sessionId,
				'gameId'    => $gameId,
				'stages'    => $stages
			)
		);
	}
}