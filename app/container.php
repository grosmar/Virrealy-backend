<?php

use Slim\Helper\Set;
use Slim\PDO\Database;
use Virrealy\Api\Action\CreateSessionAction;
use Virrealy\Api\Action\GetSessionAction;
use Virrealy\Api\Action\GetStageAction;
use Virrealy\Api\Action\IndexAction;
use Virrealy\Api\Action\ValidateStageAction;
use Virrealy\Api\Repository\VirrealyRepository;

$app->container->singleton(
	'action.index',
	function () use ($app)
	{
		return new IndexAction(
			$app->request(), 
			$app->response()
		);
	}
);

$app->container->singleton(
	'action.create_session',
	function (Set $container) use ($app)
	{
		return new CreateSessionAction(
			$app->request(),
			$app->response(),
			$container->get('repository.virrealy')
		);
	}
);

$app->container->singleton(
	'action.get_session',
	function (Set $container) use ($app)
	{
		return new GetSessionAction(
			$app->request(),
			$app->response(),
			$container->get('repository.virrealy')
		);
	}
);

$app->container->singleton(
	'action.get_stage',
	function (Set $container) use ($app)
	{
		return new GetStageAction(
			$app->request(),
			$app->response(),
			$container->get('repository.virrealy')
		);
	}
);

$app->container->singleton(
	'action.validate_stage',
	function (Set $container) use ($app)
	{
		return new ValidateStageAction(
			$app->request(),
			$app->response(),
			$container->get('repository.virrealy')
		);
	}
);

$app->container->singleton(
	'repository.virrealy',
	function (Set $container)
	{
		$database = $container->get('connection.database.virrealy');

		return new VirrealyRepository($database);
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