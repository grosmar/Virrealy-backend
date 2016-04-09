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
			$this->setBadRequestResponse();

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
			$this->setBadRequestResponse();

			return;
		}

		$userAnswer            = (string)$this->request->post('answer');
		$correctAnswer         = $currentStage[StageTable::ANSWER];
		$currentValidationType = $currentStage[StageTable::VALIDATION_TYPE];

		$isValid = false;
		switch ($currentValidationType)
		{
			case StageTable::VALIDATION_TYPE_TEXT:
				$isValid = $userAnswer === $correctAnswer;
				break;

			case StageTable::VALIDATION_TYPE_GPS:
				// TODO: GPS validation...
				$isValid = true;
				break;

			case StageTable::VALIDATION_TYPE_NO:
				$isValid = true;
				break;

			default:
				break;
		}

		$this->setResponse($isValid);
	}
}