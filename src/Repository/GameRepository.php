<?php

namespace Virrealy\Api\Repository;

use PDO;

class GameRepository extends RepositoryAbstract
{
	/**
	 * @param string $name
	 *
	 * @return int
	 */
	public function create($name)
	{
		$insert = $this->database
			->insert(array('name'))
			->into('game')
			->values(array($name));

		return (int)$insert->execute();
	}

	/**
	 * @param int $gameId
	 *
	 * @return mixed
	 */
	public function find($gameId)
	{
		$select = $this->database
			->select()
			->from('game')
			->where('id', '=', $gameId);

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
			->from('game');

		$statement = $select->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param int $gameId
	 * @param int $stageId
	 * @param int $order
	 *
	 * @return int
	 */
	public function addStage($gameId, $stageId, $order)
	{
		$insert = $this->database
			->insert(array('game_id', 'stage_id', '`order`'))
			->into('game_stage')
			->values(array($gameId, $stageId, $order));

		return (int)$insert->execute();
	}
}