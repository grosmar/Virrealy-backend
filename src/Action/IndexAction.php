<?php

namespace Virrealy\Api\Action;

class IndexAction extends RestActionAbstract
{
	public function __invoke()
	{
		$this->setResponse('Hello World!');
	}
}