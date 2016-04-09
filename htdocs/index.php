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

$app->post('/session', $app->container->get('action.create_session'));
$app->get('/session/:sessionId', $app->container->get('action.get_session'));
$app->post('/session/:sessionId/stage/:stageId', $app->container->get('action.validate_stage'));
$app->get('/stage/:stageId', $app->container->get('action.get_stage'));

$app->run();