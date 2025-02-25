<?php

namespace App\DbTable;
use App\Connection\ConnectionProvider;

require_once __DIR__ . '/../../public/vendor/autoload.php';

class EmployeeRoleTable
{
    /**
     * @param int $user_id
     * @param string $role_name
     * @param int $accessibility
     * @return void
     * @throws \Exception
     */
    public static function addRoleToUser(int $user_id, string $role_name, int $accessibility): void
    {
        if ($user_id <= 0 || empty($role_name)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "INSERT INTO employee_role (employee_id, role_name, accessibility) 
                VALUES (
                    " . $connectionProvider->Quote($user_id) . ",
                    '" . $connectionProvider->Quote($role_name) . "',
                    " . $connectionProvider->Quote($accessibility) . "
                )";

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add role to user");
        }
    }

    /**
     * @param int $user_id
     * @return array
     */
    public static function getRolesByUser(int $user_id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM employee_role WHERE employee_id = " . $connectionProvider->Quote($user_id);
        return $connectionProvider->Fetch($sql);
    }

    public static function getUserRole(int $user_id): int
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT accessibility FROM employee_role WHERE employee_id = " . $connectionProvider->Quote($user_id);
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            return 0;
        }

        return (int) $result[0]['accessibility'];
    }
}