<?php

namespace Virrealy\Api\Action;

class HelloAction extends RestActionAbstract
{
	public function __invoke($name)
	{
		$this->setResponse("Hello, $name");
	}
}