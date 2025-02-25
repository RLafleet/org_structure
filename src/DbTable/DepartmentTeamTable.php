<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class DepartmentTeamTable
{
    /**
     * @param int $department_id ID отдела.
     * @param int $team_id ID команды.
     * @return void
     * @throws \Exception
     */
    public static function addTeamToDepartment(int $department_id, int $team_id): void
    {
        if ($department_id <= 0 || $team_id <= 0) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "INSERT INTO department_team (department_id, team_id) 
                VALUES (
                    " . $connectionProvider->Quote($department_id) . ",
                    " . $connectionProvider->Quote($team_id) . "
                )";

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add team to department");
        }
    }

    /**
     * @param int $department_id ID отдела.
     * @param int $team_id ID команды.
     * @return void
     * @throws \Exception
     */
    public static function removeTeamFromDepartment(int $department_id, int $team_id): void
    {
        if ($department_id <= 0 || $team_id <= 0) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "DELETE FROM department_team 
                WHERE department_id = " . $connectionProvider->Quote($department_id) . "
                AND team_id = " . $connectionProvider->Quote($team_id);

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to remove team from department");
        }
    }

    /**
     * @param int $department_id ID отдела.
     * @return array
     */
    public static function getTeamsByDepartment(int $department_id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT t.* FROM team t
                JOIN department_team dt ON t.team_id = dt.team_id
                WHERE dt.department_id = " . $connectionProvider->Quote($department_id);
        return $connectionProvider->Fetch($sql);
    }
}