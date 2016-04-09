<?php

namespace Virrealy\Api\Repository;

use PDO;

class StageRepository extends RepositoryAbstract
{
	/**
	 * @param string $type
	 * @param string $information
	 * @param string $validationType
	 * @param string $answer
	 *
	 * @return int
	 */
	public function create($type, $information, $validationType, $answer)
	{
		$insert = $this->database
			->insert(array('type', 'information', 'answer', 'validation_type'))
			->into('stage')
			->values(array($type, $information, $answer, $validationType));

		return (int)$insert->execute();
	}

	/**
	 * @param int $stageId
	 *
	 * @return mixed
	 */
	public function find($stageId)
	{
		$select = $this->database
			->select()
			->from('stage')
			->where('id', '=', $stageId);

		$statement = $select->execute();

		return $statement->fetch();
	}

	/**
	 * @return array
	 */
	public function findAll()
	{
		$select = $this->database
			->select()
			->from('stage');

		$statement = $select->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}
}