<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\Table\StageTable;
use Virrealy\Api\Repository\VirrealyRepository;

class ValidateStageAction extends RestActionAbstract
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

	public function __invoke($sessionId, $stageId)
	{
		$sessionId = (int)$sessionId;
		$stageId   = (int)$stageId;

		$stages = $this->repository->getSessionStages($sessionId);
		if (empty($stages))
		{
			$this->setResponse(null, 400);

			return;
		}

		$currentStage = array();
		foreach ($stages as $stage)
		{
			$sessionStageId = $stage['stage_id'];

			if ($sessionStageId == $stageId)
			{
				$currentStage = $stage;
				break;
			}
		}

		if (empty($currentStage))
		{
			$this->setResponse(null, 400);

			return;
		}

		$userAnswer       = (string)$this->request->post('answer');
		$correctAnswer    = $currentStage[StageTable::ANSWER];
		$currentStageType = $currentStage[StageTable::TYPE];

		$isValid = false;
		switch ($currentStageType)
		{
			case StageTable::TYPE_PASSWORD:
				$isValid = $userAnswer === $correctAnswer;
				break;

			case StageTable::TYPE_GPS:
				// TODO: GPS validation...
				$isValid = true;
				break;

			case StageTable::TYPE_PATH_FINDER:
				// TODO: PATH finder validation...
				$isValid = true;
				break;

			case StageTable::TYPE_AUGMENTED_REALITY:
				// TODO: Augmented reality validation...
				$isValid = true;
				break;

			default:
				break;
		}

		if (!$isValid)
		{
			$this->setResponse(false, 200);

			return;
		}

		// TODO: Save current success stage...

		$this->setResponse(true, 200);
	}
}