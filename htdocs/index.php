<?php

error_reporting(E_ALL | E_STRICT);
date_default_timezone_set('Europe/Berlin');

use Slim\Slim;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Slim();

// DATABASE CONFIGURATION
$app->config(require __DIR__ . '/../app/database_config.php');

// CONTAINER
require_once __DIR__ . '/../app/container.php';

// ROUTING
$app->get('/sessions', $app->container->get('action.get_sessions'));
$app->post('/sessions', $app->container->get('action.create_session'));
$app->get('/sessions/:sessionId', $app->container->get('action.get_session'));
$app->post('/sessions/:sessionId/stages/:stageId', $app->container->get('action.validate_stage'));

$app->get('/stages', $app->container->get('action.get_stages'));
$app->post('/stages', $app->container->get('action.create_stage'));
$app->get('/stages/:stageId', $app->container->get('action.get_stage'));

$app->get('/games', $app->container->get('action.get_games'));
$app->post('/games', $app->container->get('action.create_game'));
$app->post('/games/:gameId/stages/:stageId', $app->container->get('action.add_stage_to_game'));

$app->run();