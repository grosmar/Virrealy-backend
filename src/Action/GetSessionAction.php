<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
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

		$session = $this->repository->getSession($sessionId);

		if (!empty($session))
		{
			$gameId = 0;
			$stages = array();

			foreach ($session as $stage)
			{
				$gameId = $stage['game_id'];

				$stages[] = array(
					'stageId'         => $stage['stage_id'],
					'informationType' => $stage['information_type'],
					'information'     => $stage['information'],
					'validationType'  => $stage['validation_type']
				);
			}

			$this->setResponse(
				array(
					'sessionId' => $sessionId,
					'gameId'    => $gameId,
					'stages'    => $stages
				)
			);

			return;
		}

		$this->setResponse(null, 204);
	}
}