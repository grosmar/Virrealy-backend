<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\VirrealyRepository;

class GetStageAction extends RestActionAbstract
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

	public function __invoke($stageId)
	{
		$stageId = (int)$stageId;
		if (empty($stageId))
		{
			$this->setResponse(null, 400);
		}

		$stage = $this->repository->getStage($stageId);
		if (empty($stage))
		{
			$this->setResponse(null, 204);

			return;
		}

		$this->setResponse(
			array(
				'stageId'        => $stage['id'],
				'stageType'      => $stage['type'],
				'information'    => $stage['information'],
				'answer'         => $stage['answer'],
				'validationType' => $stage['validation_type']
			)
		);
	}
}