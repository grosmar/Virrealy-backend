<?php

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Europe/Berlin');

use Slim\Slim;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Slim(
	array(
		'debug' => true,
		'mode'  => 'prod'
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

$app->post('/sessions', $app->container->get('action.create_session'));
$app->get('/sessions/:sessionId', $app->container->get('action.get_session'));
$app->post('/sessions/:sessionId/stages/:stageId', $app->container->get('action.validate_stage'));

$app->post('/stages', $app->container->get('action.create_stage'));
$app->get('/stages/:stageId', $app->container->get('action.get_stage'));

$app->post('/games', $app->container->get('action.create_game'));

$app->run();