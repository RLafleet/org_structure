<?php

namespace App\DbTable;
require_once __DIR__ . '/../../public/vendor/autoload.php';

use App\connection\ConnectionProvider;
use Exception;

class BranchDepartment
{
    /**
     * @param int $branchId
     * @param string $departmentName
     * @return void
     * @throws Exception
     */
    public static function insertDepartment(int $branchId, string $departmentName): void
    {
        if (empty($departmentName)) {
            throw new \InvalidArgumentException("Department name cannot be empty");
        }

        $connectionProvider = new ConnectionProvider();

        $sql = "INSERT INTO department (branch_id, department_name) VALUES ('" .
            $connectionProvider->Quote($branchId) . "', '" .
            $connectionProvider->Quote($departmentName) . "')";

        $result = $connectionProvider->RealQuery($sql);
        if (!$result) {
            throw new Exception("Failed to add new department");
        }
    }

    /**
     * @param int $departmentId
     * @return void
     * @throws Exception
     */
    public static function deleteDepartment(int $departmentId): void
    {
        $connectionProvider = new ConnectionProvider();

        $sql = "DELETE FROM department WHERE department_id = '" . $connectionProvider->Quote($departmentId) . "'";
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new Exception("Failed to delete department");
        }
    }

    /**
     * @param int $departmentId
     * @param string $departmentName
     * @return void
     * @throws \Exception
     */
    public static function updateDepartment(int $departmentId, string $departmentName): void
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "UPDATE company_branch SET 
                department_name = '" . $connectionProvider->Quote($departmentName) . "',
                WHERE department_id = '" . $connectionProvider->Quote($departmentId) . "'";
        $result = $connectionProvider->RealQuery($sql);

        if (!$result) {
            throw new \Exception("Failed to update branch");
        }
    }

    /**
     * @return array
     */
    public static function listBranches(): array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM department";
        return $connectionProvider->Fetch($sql);
    }

    /**
     * @param int $id
     * @return array|null
     */
    public static function findDepartment(int $id): ?array
    {
        $connectionProvider = new ConnectionProvider();
        $sql = "SELECT * FROM department WHERE id = '" . $connectionProvider->Quote($id) . "'";
        $result = $connectionProvider->Fetch($sql);

        if (empty($result)) {
            return null;
        }

        return $result;
    }
}
