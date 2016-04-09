<?php

namespace Virrealy\Api\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use Virrealy\Api\Repository\TestRepository;

class IndexAction extends RestActionAbstract
{
	public function __invoke()
	{
		$this->setResponse('Hello World!');
	}
}