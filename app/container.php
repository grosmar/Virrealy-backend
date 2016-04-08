<?php

use Slim\Helper\Set;
use Slim\PDO\Database;
use Virrealy\Api\Action\HelloAction;
use Virrealy\Api\Action\IndexAction;
use Virrealy\Api\Repository\TestRepository;

$app->container->singleton(
	'action.index',
	function (Set $container) use ($app)
	{
		return new IndexAction(
			$app->request(), 
			$app->response(), 
			$container->get('repository.test')
		);
	}
);

$app->container->singleton(
	'action.hello',
	function () use ($app)
	{
		return new HelloAction(
			$app->request(), 
			$app->response()
		);
	}
);

$app->container->singleton(
	'repository.test',
	function (Set $container)
	{
		$database = $container->get('connection.database.test');

		return new TestRepository($database);
	}
);

$app->container->singleton(
	'connection.database.test',
	function () use ($app)
	{
		$dsn      = $app->config('database.test.dsn');
		$user     = $app->config('database.test.user');
		$password = $app->config('database.test.password');

		return new Database($dsn, $user, $password);
	}
);