<?php

use Slim\Helper\Set;
use Slim\PDO\Database;
use Virrealy\Api\Action\Game\AddStageToGameAction;
use Virrealy\Api\Action\Game\CreateGameAction;
use Virrealy\Api\Action\Session\CreateSessionAction;
use Virrealy\Api\Action\Session\GetSessionAction;
use Virrealy\Api\Action\Session\ValidateStageAction;
use Virrealy\Api\Action\Stage\CreateStageAction;
use Virrealy\Api\Action\Stage\GetStageAction;
use Virrealy\Api\Action\Stage\GetStagesAction;
use Virrealy\Api\Repository\GameRepository;
use Virrealy\Api\Repository\StageRepository;
use Virrealy\Api\Repository\SessionRepository;

$app->container->set(
	'action.create_session',
	function (Set $container) use ($app)
	{
		return new CreateSessionAction(
			$app->request(),
			$app->response(),
			$container->get('repository.session')
		);
	}
);

$app->container->set(
	'action.get_session',
	function (Set $container) use ($app)
	{
		return new GetSessionAction(
			$app->request(),
			$app->response(),
			$container->get('repository.session')
		);
	}
);

$app->container->set(
	'action.create_stage',
	function (Set $container) use ($app)
	{
		return new CreateStageAction(
			$app->request(),
			$app->response(),
			$container->get('repository.stage')
		);
	}
);

$app->container->set(
	'action.get_stages',
	function (Set $container) use ($app)
	{
		return new GetStagesAction(
			$app->request(),
			$app->response(),
			$container->get('repository.stage')
		);
	}
);

$app->container->set(
	'action.get_stage',
	function (Set $container) use ($app)
	{
		return new GetStageAction(
			$app->request(),
			$app->response(),
			$container->get('repository.stage')
		);
	}
);

$app->container->set(
	'action.validate_stage',
	function (Set $container) use ($app)
	{
		return new ValidateStageAction(
			$app->request(),
			$app->response(),
			$container->get('repository.session')
		);
	}
);

$app->container->set(
	'action.create_game',
	function (Set $container) use ($app)
	{
		return new CreateGameAction(
			$app->request(),
			$app->response(),
			$container->get('repository.game')
		);
	}
);

$app->container->set(
	'action.add_stage_to_game',
	function (Set $container) use ($app)
	{
		return new AddStageToGameAction(
			$app->request(),
			$app->response(),
			$container->get('repository.game'),
			$container->get('repository.stage')
		);
	}
);

$app->container->singleton(
	'repository.session',
	function (Set $container)
	{
		$database = $container->get('connection.database.virrealy');

		return new SessionRepository($database);
	}
);

$app->container->singleton(
	'repository.stage',
	function (Set $container)
	{
		$database = $container->get('connection.database.virrealy');

		return new StageRepository($database);
	}
);

$app->container->singleton(
	'repository.game',
	function (Set $container)
	{
		$database = $container->get('connection.database.virrealy');

		return new GameRepository($database);
	}
);

$app->container->singleton(
	'connection.database.virrealy',
	function () use ($app)
	{
		$dsn      = $app->config('database.virrealy.dsn');
		$user     = $app->config('database.virrealy.user');
		$password = $app->config('database.virrealy.password');

		return new Database($dsn, $user, $password);
	}
);