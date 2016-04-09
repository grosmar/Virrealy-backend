<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\StageRepository;
use Virrealy\Api\Repository\Table\StageTable;

class CreateStageAction extends RestActionAbstract
{
	/**
	 * @var StageRepository
	 */
	private $repository;

	/**
	 * @param Request         $request
	 * @param Response        $response
	 * @param StageRepository $repository
	 */
	public function __construct(
		Request $request,
		Response $response,
		StageRepository $repository
	) {
		parent::__construct($request, $response);

		$this->repository = $repository;
	}

	public function __invoke()
	{
		$type           = (string)$this->request->post('stageType');
		$information    = (string)$this->request->post('information');
		$validationType = (string)$this->request->post('validationType');
		$answer         = (string)$this->request->post('answer');

		if (empty($type) || empty($information) || empty($validationType))
		{
			$this->setBadRequestResponse();

			return;
		}

		$stageTable = new StageTable();

		if (!$stageTable->isValidType($type))
		{
			$this->setBadRequestResponse();

			return;
		}

		if (!$stageTable->isValidValidationType($validationType))
		{
			$this->setBadRequestResponse();

			return;
		}

		$stageId = $this->repository->create($type, $information, $validationType, $answer);

		$this->setResponse(
			array(
				'stageId' => $stageId
			)
		);
	}
}