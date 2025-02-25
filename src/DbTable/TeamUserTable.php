<?php

namespace App\DbTable;
use App\Connection\ConnectionProvider;

require_once __DIR__ . '/../../public/vendor/autoload.php';

class TeamUserTable
{
    /**
     * @param int $team_id
     * @param int $user_id
     * @return void
     * @throws \Exception
     */
    public static function addUserToTeam(int $team_id, int $user_id): void
    {
        if ($team_id <= 0 || $user_id <= 0) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "UPDATE user 
                SET team_id = " . $connectionProvider->Quote($team_id) . "
                WHERE id = " . $connectionProvider->Quote($user_id);

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add user to team");
        }
    }

    /**
     * @param int $team_id
     * @param int $user_id
     * @return void
     * @throws \Exception
     */
    public static function removeUserFromTeam(int $team_id, int $user_id): void
    {
        if ($team_id <= 0 || $user_id <= 0) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "UPDATE user 
                SET team_id = NULL 
                WHERE id = " . $connectionProvider->Quote($user_id) . "
                AND team_id = " . $connectionProvider->Quote($team_id);

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to remove user from team");
        }
    }

    /**
     * @param int $team_id
     * @return array
     */
    public static function getUsersByTeam(int $team_id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM user 
                WHERE team_id = " . $connectionProvider->Quote($team_id);
        return $connectionProvider->Fetch($sql);
    }
}