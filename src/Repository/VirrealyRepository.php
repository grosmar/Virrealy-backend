<?php

namespace Virrealy\Api\Repository;

use DateTime;
use PDO;

class VirrealyRepository extends RepositoryAbstract
{
	/**
	 * @param int $gameId
	 *
	 * @return int
	 */
	public function createSession($gameId)
	{
		$now = (new DateTime('now'))->format('Y-m-d H:i:s');

		$insert = $this->database
			->insert(array('game_id', 'created_at'))
			->into('session')
			->values(array($gameId, $now));

		return (int)$insert->execute();
	}

	/**
	 * @param int $sessionId
	 *
	 * @return array
	 */
	public function getSessionStages($sessionId)
	{
		$query = '
			SELECT 
				S.id as session_id,
				S.game_id,
				G.name,
				S.created_at,
				ST.id as stage_id,
				ST.type as type,
				ST.information,
				ST.answer,
				ST.validation_type
			FROM
				session as S 
				INNER JOIN game as G
					ON S.game_id = G.id
				INNER JOIN game_stage GS
					ON GS.game_id = G.id
				INNER JOIN stage ST
					ON GS.stage_id = ST.id
			WHERE
				S.id = :id
		';

		$statement = $this->database->prepare($query);
		$statement->bindValue(':id', $sessionId, PDO::PARAM_INT);
		$statement->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param int $stageId
	 *
	 * @return mixed
	 */
	public function getStage($stageId)
	{
		$select = $this->database
			->select()
			->from('stage')
			->where('id', '=', $stageId);

		$statement = $select->execute();

		return $statement->fetch();
	}

	public function getAllStage()
	{
		$select = $this->database
			->select()
			->from('stage');

		$statement = $select->execute();

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	 * @param string $type
	 * @param string $information
	 * @param string $validationType
	 * @param string $answer
	 *
	 * @return int
	 */
	public function createStage($type, $information, $validationType, $answer)
	{
		$insert = $this->database
			->insert(array('type', 'information', 'answer', 'validation_type'))
			->into('stage')
			->values(array($type, $information, $answer, $validationType));

		return (int)$insert->execute();
	}

	/**
	 * @param string $name
	 *
	 * @return int
	 */
	public function createGame($name)
	{
		$insert = $this->database
			->insert(array('name'))
			->into('game')
			->values(array($name));

		return (int)$insert->execute();
	}

	public function addStageToGame($gameId, $stageId, $order)
	{
		$insert = $this->database
			->insert(array('game_id', 'stage_id', '`order`'))
			->into('game_stage')
			->values(array($gameId, $stageId, $order));

		return (int)$insert->execute();
	}
}