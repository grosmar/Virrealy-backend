<?php

use Slim\Slim;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Slim(
	array(
		'debug' => true,
		'mode'  => 'dev'
	)
);

// APPLICATION CONFIGURATION
$app->configureMode(
	'prod',
	function () use ($app)
	{
		$app->config(require __DIR__ . '/../app/prod/database_config.php');
	}
);

$app->configureMode(
	'dev',
	function () use ($app)
	{
		$app->config(require __DIR__ . '/../app/dev/database_config.php');
	}
);

// CONTAINER
require_once __DIR__ . '/../app/container.php';

// ROUTING
$app->get('/', $app->container->get('action.index'));
$app->get('/hello/:name', $app->container->get('action.hello'));

$app->run();