<?php

namespace Virrealy\Api\Repository;

use Slim\PDO\Database;

abstract class RepositoryAbstract
{
	/**
	 * @var Database
	 */
	protected $database;

	/**
	 * Constructor.
	 *
	 * @param Database $database
	 */
	public function __construct(Database $database)
	{
		$this->database = $database;
	}
}