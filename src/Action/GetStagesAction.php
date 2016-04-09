<?php

namespace Virrealy\Api\Action;


use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\VirrealyRepository;

class GetStagesAction extends RestActionAbstract
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
		$stages = $this->repository->getAllStage();
		if (empty($stages))
		{
			$this->setResponse(null, 204);

			return;
		}

		$transformedStages = array();
		foreach ($stages as $stage)
		{
			$transformedStages[] = array(
				'stageId'        => $stage['id'],
				'stageType'      => $stage['type'],
				'information'    => $stage['information'],
				'answer'         => $stage['answer'],
				'validationType' => $stage['validation_type']
			);
		}


		$this->setResponse($transformedStages);
	}
}