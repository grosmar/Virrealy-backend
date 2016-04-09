<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\VirrealyRepository;

class CreateStageAction extends RestActionAbstract
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
		$type           = (string)$this->request->post('stageType');
		$information    = (string)$this->request->post('information');
		$answer         = (string)$this->request->post('answer');
		$validationType = (string)$this->request->post('validationType');

		// TODO: Validation....

		$stageId = $this->repository->createStage($type, $information, $answer, $validationType);

		$this->setResponse(
			array(
				'stageId' => $stageId
			)
		);
	}
}