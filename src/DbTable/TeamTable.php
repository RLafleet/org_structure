<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class TeamTable
{
    /**
     * Добавляет новую команду.
     *
     * @param string $team_name Название команды.
     * @return void
     * @throws \Exception
     */
    public static function insertTeam(string $team_name): void
    {
        if (empty($team_name)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "INSERT INTO team (team_name) 
                VALUES ('" . $connectionProvider->Quote($team_name) . "')";

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add new team");
        }
    }

    /**
     * Удаляет команду по её ID.
     *
     * @param int $team_id ID команды.
     * @return void
     * @throws \Exception
     */
    public static function deleteTeam(int $team_id): void
    {
        if ($team_id <= 0) {
            throw new \InvalidArgumentException("Invalid team ID");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "DELETE FROM team WHERE team_id = " . $connectionProvider->Quote($team_id);
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to delete team");
        }
    }

    /**
     * Получает список команд для указанного отдела.
     *
     * @param int $department_id ID отдела.
     * @return array
     */
    public static function listTeams(int $department_id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT t.* FROM team t
                JOIN department_team dt ON t.team_id = dt.team_id
                WHERE dt.department_id = " . $connectionProvider->Quote($department_id);
        return $connectionProvider->Fetch($sql);
    }

    /**
     * Находит команду по её ID.
     *
     * @param int $team_id ID команды.
     * @return array|null
     */
    public static function findTeam(int $team_id): ?array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM team WHERE team_id = " . $connectionProvider->Quote($team_id);
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }
}