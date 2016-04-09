<?php

namespace Virrealy\Api\Repository;

use DateTime;
use PDO;

class SessionRepository extends RepositoryAbstract
{
	/**
	 * @param int $gameId
	 *
	 * @return int
	 */
	public function create($gameId)
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
}