<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;

class DepartmentTable
{
    /**
     * @param int $branch_id
     * @param string $department_name
     * @return void
     * @throws \Exception
     */
    public static function insertDepartment(int $branch_id, string $department_name): void
    {
        if (empty($branch_id) || empty($department_name)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "INSERT INTO department (branch_id, department_name) 
                VALUES (
                    " . $connectionProvider->Quote($branch_id) . ",
                    '" . $connectionProvider->Quote($department_name) . "'
                )";

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to add new department");
        }
    }

    /**
     * Обновляет информацию об отделе.
     *
     * @param int $department_id ID отдела.
     * @param string $department_name Новое название отдела.
     * @return void
     * @throws \Exception
     */
    public static function updateDepartment(int $department_id, string $department_name): void
    {
        if (empty($department_id) || empty($department_name)) {
            throw new \InvalidArgumentException("Invalid input data");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "UPDATE department SET 
                department_name = '" . $connectionProvider->Quote($department_name) . "' 
                WHERE department_id = " . $connectionProvider->Quote($department_id);

        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to update department");
        }
    }

    /**
     * Удаляет отдел по его ID.
     *
     * @param int $department_id ID отдела.
     * @return void
     * @throws \Exception
     */
    public static function deleteDepartment(int $department_id): void
    {
        if ($department_id <= 0) {
            throw new \InvalidArgumentException("Invalid department ID");
        }

        $connectionProvider = new ConnectionProvider();
        $sql = "DELETE FROM department WHERE department_id = " . $connectionProvider->Quote($department_id);
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to delete department");
        }
    }

    /**
     * Получает список отделов для указанной ветки.
     *
     * @param int $branch_id ID ветки.
     * @return array
     */
    public static function listDepartments(int $branch_id): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM department WHERE branch_id = " . $connectionProvider->Quote($branch_id);
        return $connectionProvider->Fetch($sql);
    }

    /**
     * Находит отдел по его ID.
     *
     * @param int $department_id ID отдела.
     * @return array|null
     */
    public static function findDepartment(int $department_id): ?array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM department WHERE department_id = " . $connectionProvider->Quote($department_id);
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            return null;
        }

        return $result[0];
    }
}