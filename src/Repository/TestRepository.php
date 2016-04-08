<?php

namespace Virrealy\Api\Repository;


class TestRepository extends RepositoryAbstract
{
	public function getAllUser()
	{
		$selectStatement = $this->database
			->select()
			->from('user');

		$statement = $selectStatement->execute();

		return $statement->fetch();
	}
}